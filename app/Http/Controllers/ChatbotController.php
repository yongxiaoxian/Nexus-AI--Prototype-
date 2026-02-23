<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatbotController extends Controller
{
    private string $baseUrl;
    private string $reactModel;
    private string $visionModel;
    private int $maxIterations;
    private int $timeout;

    private function getSystemPrompt(): string
    {
        $today = date('l, F j, Y'); // e.g. "Thursday, February 13, 2026"
        $time = date('g:i A');       // e.g. "11:48 PM"

        return <<<PROMPT
You are NexusAI, an intelligent AI assistant built by the NexusAI team. You are helpful, professional, and concise.

Current date and time: {$today}, {$time}.

Guidelines:
- Respond naturally and helpfully to user questions.
- Use clear formatting: short paragraphs, bullet points when listing items.
- Do not use emojis. Keep a professional tone.
- If you don't know something, say so honestly.
- Always use the current date provided above when answering date-related questions. Never guess or use your training data for the current date.
- If the user's message includes an [Image Analysis Result], incorporate it naturally into your response alongside any other information.

Confidence Assessment -- FOLLOW THIS STRICTLY, DO NOT MAKE ASSUMPTIONS:
Before answering any factual question, assess your confidence:
- If you are CONFIDENT the answer is accurate and up-to-date, respond directly.
- If the question involves current events, real-time data, recent news, specific prices, stock market, live statistics, weather, anything time-sensitive or anything you are UNSURE with, you MUST call the web_search tool. NEVER answer such questions from your training data alone and make assumptions.
- Simple greetings, math, general knowledge, and creative tasks do NOT need web search.

Tool Usage:
- You have ONE tool available: web_search. Use it whenever you are unsure of the user's request or need up-to-date or real-time information.
- When you use search results, incorporate the information naturally. Do NOT add source links -- the system handles that automatically.
PROMPT;
    }

    /** Tools always available (web_search) */
    private array $baseTools = [
        [
            'type' => 'function',
            'function' => [
                'name' => 'web_search',
                'description' => 'Search the web for real-time or current information. Use when you need up-to-date data, are unsure about facts, or the question involves recent events, news, prices, weather, or time-sensitive topics.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'query' => [
                            'type' => 'string',
                            'description' => 'The search query to look up on the web.',
                        ],
                    ],
                    'required' => ['query'],
                ],
            ],
        ],
    ];

    // Collected during the ReAct loop
    private array $searchSources = [];

    public function __construct()
    {
        $this->baseUrl = config('ollama.base_url');
        $this->reactModel = config('ollama.react_model');
        $this->visionModel = config('ollama.vision_model');
        $this->maxIterations = config('ollama.max_tool_iterations');
        $this->timeout = config('ollama.timeout');
    }

    /**
     * Main chat endpoint -- ReAct agent loop with SSE streaming final response.
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'image' => 'nullable|string',
        ]);

        $userMessage = trim($request->input('message'));
        $imageBase64 = $request->input('image');

        error_log('========================================');
        error_log('[>>] New chat request received');
        error_log('    Message: ' . mb_strimwidth($userMessage, 0, 80, '...'));
        error_log('    Image attached: ' . ($imageBase64 ? 'Yes' : 'No'));

        // Retrieve conversation history from session
        $history = session('chat_history', []);

        // --- Pre-process image BEFORE the ReAct loop ---
        // This ensures the model already has image context and only needs to decide about web_search.
        $imageDescription = null;
        if ($imageBase64) {
            error_log("[VISION] Pre-processing image with Vision Agent ({$this->visionModel})...");
            $imageDescription = $this->callVisionAgent($imageBase64, 'Analyze this image thoroughly', $userMessage);
            error_log('[OK] Vision Agent responded (' . strlen($imageDescription) . ' chars)');
        }

        // Build the user message entry with image analysis baked in
        $userContent = $userMessage;
        if ($imageDescription) {
            $userContent .= "\n\n[Image Analysis Result: The user attached an image. Here is what the image contains: {$imageDescription}]";
        }
        $userEntry = ['role' => 'user', 'content' => $userContent];
        $history[] = $userEntry;

        // Build full messages array with system prompt
        $messages = array_merge(
            [['role' => 'system', 'content' => $this->getSystemPrompt()]],
            $history
        );

        // ReAct loop only uses web_search now (image already handled above)
        $tools = $this->baseTools;

        // --- ReAct Agent Loop (non-streaming, tool-calling phase) ---
        $iteration = 0;
        $finalMessages = $messages;
        $this->searchSources = [];

        while ($iteration < $this->maxIterations) {
            $iteration++;

            error_log("[REACT] Iteration {$iteration}: Waking up model ({$this->reactModel})...");

            $response = $this->callOllama(
                model: $this->reactModel,
                messages: $finalMessages,
                tools: $tools,
                stream: false
            );

            if ($response === null) {
                error_log('[!!] Failed to connect to Ollama.');
                return $this->errorResponse('Failed to connect to the AI service.');
            }

            error_log('[OK] Model responded.');

            $assistantMessage = $response['message'] ?? [];
            $toolCalls = $assistantMessage['tool_calls'] ?? [];

            if (empty($toolCalls)) {
                error_log('[--] No tool calls -- model produced a direct answer.');
                break;
            }

            error_log('[TOOL] Tool call(s) detected: ' . count($toolCalls));

            // Model wants to call tool(s)
            $finalMessages[] = $assistantMessage;

            foreach ($toolCalls as $toolCall) {
                $functionName = $toolCall['function']['name'] ?? '';
                $args = $toolCall['function']['arguments'] ?? [];

                if ($functionName === 'web_search') {
                    $query = $args['query'] ?? $userMessage;
                    error_log("[SEARCH] Searching web for: \"{$query}\"...");
                    $searchResult = $this->performWebSearch($query);
                    error_log('[OK] Web search completed (' . strlen($searchResult) . ' chars, ' . count($this->searchSources) . ' sources)');

                    $finalMessages[] = [
                        'role' => 'tool',
                        'content' => $searchResult,
                    ];

                } else {
                    error_log("[!!] Unknown tool called: {$functionName}");
                    $finalMessages[] = [
                        'role' => 'tool',
                        'content' => 'Tool not available.',
                    ];
                }
            }
        }

        // --- Streaming Phase ---
        error_log('[STREAM] Streaming final response to browser...');
        return $this->streamResponse($finalMessages, $history, $this->searchSources);
    }

    /**
     * Stream the final AI response as Server-Sent Events.
     * After streaming completes, sends source references if any.
     */
    private function streamResponse(array $messages, array $history, array $sources): StreamedResponse
    {
        return new StreamedResponse(function () use ($messages, $history, $sources) {
            $url = $this->baseUrl . '/api/chat';

            $payload = [
                'model' => $this->reactModel,
                'messages' => $messages,
                'stream' => true,
            ];

            $fullResponse = '';

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_RETURNTRANSFER => false,
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_WRITEFUNCTION => function ($ch, $data) use (&$fullResponse) {
                    $lines = explode("\n", trim($data));
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (empty($line))
                            continue;

                        $json = json_decode($line, true);
                        if ($json === null)
                            continue;

                        $content = $json['message']['content'] ?? '';
                        $done = $json['done'] ?? false;

                        if ($content !== '') {
                            $fullResponse .= $content;
                            echo "data: " . json_encode(['token' => $content]) . "\n\n";
                            if (ob_get_level())
                                ob_flush();
                            flush();
                        }

                        if ($done) {
                            echo "data: " . json_encode(['done' => true]) . "\n\n";
                            if (ob_get_level())
                                ob_flush();
                            flush();
                        }
                    }

                    return strlen($data);
                },
            ]);

            curl_exec($ch);

            $curlError = curl_error($ch);
            if ($curlError) {
                echo "data: " . json_encode(['error' => 'Connection lost: ' . $curlError]) . "\n\n";
                if (ob_get_level())
                    ob_flush();
                flush();
            }

            curl_close($ch);

            // Send source references if we used web search
            if (!empty($sources)) {
                echo "data: " . json_encode(['sources' => $sources]) . "\n\n";
                if (ob_get_level())
                    ob_flush();
                flush();
            }

            // Save conversation to session
            if ($fullResponse !== '') {
                $history[] = ['role' => 'assistant', 'content' => $fullResponse];
            }
            session(['chat_history' => $history]);

        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Call Ollama's chat API.
     */
    private function callOllama(string $model, array $messages, array $tools = [], bool $stream = false): ?array
    {
        $payload = [
            'model' => $model,
            'messages' => $messages,
            'stream' => $stream,
        ];

        if (!empty($tools)) {
            $payload['tools'] = $tools;
        }

        try {
            $response = Http::timeout($this->timeout)
                ->post($this->baseUrl . '/api/chat', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Call the Vision agent to analyze an image.
     */
    private function callVisionAgent(string $imageBase64, string $reason, string $userMessage): string
    {
        $cleanBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $imageBase64);

        $messages = [
            [
                'role' => 'system',
                'content' => 'You are a vision analysis assistant. Describe images accurately and concisely. Focus on the key elements, text, objects, colors, and context visible in the image. Provide your analysis as a clear, structured description.',
            ],
            [
                'role' => 'user',
                'content' => "Analyze this image. Context: {$reason}\nUser's message: {$userMessage}",
                'images' => [$cleanBase64],
            ],
        ];

        $response = $this->callOllama(
            model: $this->visionModel,
            messages: $messages,
            stream: false
        );

        if ($response === null) {
            return 'Unable to analyze the image at this time.';
        }

        return $response['message']['content'] ?? 'No analysis available.';
    }

    /**
     * Perform a web search using DuckDuckGo HTML scraping.
     * Returns formatted search results and saves source URLs.
     */
    private function performWebSearch(string $query): string
    {
        $maxResults = config('ollama.search_max_results', 3);
        $contentLimit = config('ollama.search_content_limit', 2000);

        // Search DuckDuckGo HTML version
        $searchUrl = 'https://html.duckduckgo.com/html/?q=' . urlencode($query);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $searchUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml',
                'Accept-Language: en-US,en;q=0.9',
            ],
        ]);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$html || $httpCode !== 200) {
            error_log('[!!] DuckDuckGo search failed (HTTP ' . $httpCode . ')');
            return 'Web search is temporarily unavailable.';
        }

        // Parse search results from HTML
        $results = $this->parseDuckDuckGoResults($html, $maxResults);

        if (empty($results)) {
            error_log('[--] No search results found.');
            return 'No relevant search results found for this query.';
        }

        error_log('[OK] Parsed ' . count($results) . ' search results.');

        // Fetch page content for top results
        $formattedResults = '';
        $sourceIndex = 1;

        foreach ($results as $result) {
            $title = $result['title'];
            $url = $result['url'];
            $snippet = $result['snippet'];

            // Save source for reference footer
            $this->searchSources[] = [
                'index' => $sourceIndex,
                'title' => $title,
                'url' => $url,
            ];

            // Try to fetch page content for richer context (top 2 only)
            $pageContent = '';
            if ($sourceIndex <= 2) {
                $pageContent = $this->fetchPageContent($url, $contentLimit);
            }

            $formattedResults .= "--- Source {$sourceIndex}: {$title} ---\n";
            $formattedResults .= "URL: {$url}\n";
            if ($pageContent) {
                $formattedResults .= "Content: {$pageContent}\n\n";
            } else {
                $formattedResults .= "Summary: {$snippet}\n\n";
            }

            $sourceIndex++;
        }

        return "Web search results for \"{$query}\":\n\n" . $formattedResults;
    }

    /**
     * Parse DuckDuckGo HTML search results page.
     */
    private function parseDuckDuckGoResults(string $html, int $maxResults): array
    {
        $results = [];
        $seenUrls = [];

        // Suppress libxml errors for messy HTML
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        $xpath = new \DOMXPath($doc);

        // DuckDuckGo HTML results are in .result elements
        $resultNodes = $xpath->query('//div[contains(@class, "result")]');

        foreach ($resultNodes as $node) {
            if (count($results) >= $maxResults)
                break;

            // Get the link
            $linkNodes = $xpath->query('.//a[contains(@class, "result__a")]', $node);
            if ($linkNodes->length === 0)
                continue;

            $linkNode = $linkNodes->item(0);
            $title = trim($linkNode->textContent);
            $url = $linkNode->getAttribute('href');

            // Clean DuckDuckGo redirect URLs
            // URLs come as: //duckduckgo.com/l/?uddg=https%3A%2F%2Factual-site.com&rut=...
            if (str_contains($url, 'duckduckgo.com')) {
                if (preg_match('/[?&]uddg=([^&]+)/', $url, $matches)) {
                    $url = urldecode($matches[1]);
                } else {
                    continue; // Skip internal DDG links
                }
            }

            // Filter out DuckDuckGo ad/tracking URLs
            if (
                str_contains($url, 'duckduckgo.com/y.js') ||
                str_contains($url, 'duckduckgo.com/l/') ||
                str_contains($url, 'ad_provider') ||
                str_contains($url, 'bing.com/aclick')
            ) {
                continue;
            }

            // Handle protocol-relative URLs
            if (str_starts_with($url, '//')) {
                $url = 'https:' . $url;
            }

            error_log("    [SOURCE] {$title} => {$url}");

            // Skip non-http URLs
            if (!str_starts_with($url, 'http'))
                continue;

            // Get snippet
            $snippetNodes = $xpath->query('.//a[contains(@class, "result__snippet")]', $node);
            $snippet = $snippetNodes->length > 0 ? trim($snippetNodes->item(0)->textContent) : '';

            if (empty($title) || empty($url))
                continue;

            // Deduplicate by URL
            if (in_array($url, $seenUrls))
                continue;
            $seenUrls[] = $url;

            $results[] = [
                'title' => $title,
                'url' => $url,
                'snippet' => $snippet,
            ];
        }

        return $results;
    }

    /**
     * Fetch a web page and extract clean text content.
     */
    private function fetchPageContent(string $url, int $charLimit): string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept: text/html',
                'Accept-Language: en-US,en;q=0.9',
            ],
        ]);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$html || $httpCode !== 200) {
            return '';
        }

        // Strip script and style tags first
        $html = preg_replace('/<script\b[^>]*>[\s\S]*?<\/script>/i', '', $html);
        $html = preg_replace('/<style\b[^>]*>[\s\S]*?<\/style>/i', '', $html);
        $html = preg_replace('/<nav\b[^>]*>[\s\S]*?<\/nav>/i', '', $html);
        $html = preg_replace('/<footer\b[^>]*>[\s\S]*?<\/footer>/i', '', $html);
        $html = preg_replace('/<header\b[^>]*>[\s\S]*?<\/header>/i', '', $html);

        // Get text content
        $text = strip_tags($html);

        // Clean whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        // Truncate to limit
        if (mb_strlen($text) > $charLimit) {
            $text = mb_substr($text, 0, $charLimit) . '...';
        }

        return $text;
    }

    /**
     * OCR Product Scan endpoint — analyze product image with web-based RAG.
     *
     * Pipeline:
     *   1. Quick Vision scan → extract product name/keywords
     *   2. Web search → fetch current product info via DuckDuckGo
     *   3. Enriched Vision call → image + web context → structured JSON
     */
    public function ocrAnalyze(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $imageBase64 = $request->input('image');
        $cleanBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $imageBase64);

        // ── Pass 1: Quick identification ──────────────────────────
        error_log('[OCR] Pass 1: Quick product identification...');

        $identifyMessages = [
            [
                'role' => 'system',
                'content' => 'You are a product identification AI. Look at the image and identify the product. Respond with ONLY the COMPLETE and SPECIFIC product name. Include the brand, product line, model number, and variant. Examples of good answers: "ASUS ROG STRIX GeForce RTX 4090 OC", "Samsung Galaxy S24 Ultra 512GB", "Sony WH-1000XM5 Wireless Headphones", "Logitech G Pro X Superlight 2". Do NOT simplify or shorten the name. Read all visible text, logos, and branding on the product and packaging. If you cannot identify it, describe it in 5 words or fewer.',
            ],
            [
                'role' => 'user',
                'content' => 'What is the FULL, COMPLETE product name? Include the brand/manufacturer, product line, model, and any variant info visible on the product or packaging. Reply with only the product name.',
                'images' => [$cleanBase64],
            ],
        ];

        $identifyResponse = $this->callOllama(
            model: $this->visionModel,
            messages: $identifyMessages,
            stream: false
        );

        $productKeywords = 'unknown product';
        if ($identifyResponse) {
            $productKeywords = trim($identifyResponse['message']['content'] ?? 'unknown product');
            // Clean up: remove quotes, periods, etc.
            $productKeywords = trim($productKeywords, "\"'.!\n");
        }

        error_log('[OCR] Identified as: ' . $productKeywords);

        // ── Pass 2: Web search for product info ───────────────────
        error_log('[OCR] Pass 2: Web search for "' . $productKeywords . '"...');

        $webContext = '';
        if (strtolower($productKeywords) !== 'unknown product') {
            $searchQuery = $productKeywords . ' product specifications details';
            $webContext = $this->ocrWebSearch($searchQuery);
            error_log('[OCR] Web context gathered: ' . strlen($webContext) . ' chars');
        }

        // ── Pass 3: Enriched extraction ───────────────────────────
        error_log('[OCR] Pass 3: Enriched extraction with web context...');

        $systemPrompt = 'You are a product identification AI. Analyze the image and extract product information. You MUST respond with ONLY a valid JSON object, no other text. The JSON must have these exact keys: "product_name", "description", "category", "brand", "condition".

Rules for each field:
- "product_name": Use the FULL, COMPLETE, SPECIFIC product name. Include the brand, product line, model, and variant. Example: "ASUS ROG STRIX GeForce RTX 4090 OC" NOT just "NVIDIA RTX 4090". If a product is made by a partner/third-party (like ASUS, MSI, Gigabyte for GPU cards), use THEIR full product name, not the chip manufacturer\'s generic name.
- "brand": The company that MAKES and SELLS this specific product. For partner/AIB products, this is the partner brand (e.g. "ASUS ROG" for an ROG-branded GPU, "Corsair" for Corsair RAM), NOT the chip/component manufacturer. If the brand has a sub-brand or product line (like ROG, TUF, STRIX), include it (e.g. "ASUS ROG").
- "description": 2-4 detailed sentences covering key specs, features, and what makes this specific model notable.
- "category": Product category (e.g. "Graphics Card", "Smartphone", "Headphones").
- "condition": One of: "New", "Like New", "Used", "Refurbished", "For Parts".';

        $userPrompt = 'Analyze this product image and extract the product details as JSON.';

        if ($webContext) {
            $systemPrompt .= "\n\nIMPORTANT: You have web search results with CURRENT, ACCURATE product data. STRICTLY follow these rules:\n1. For product_name: Use the MOST SPECIFIC and COMPLETE name found in the web results. Include partner brand, product line, and model variant.\n2. For brand: Use the partner/seller brand from web results, NOT the chip manufacturer. Example: brand should be 'ASUS ROG' not 'NVIDIA' for an ROG graphics card.\n3. For description: Combine web specs with what you see in the image. Mention key specs like performance figures, memory, dimensions, etc.\n4. Only use visual analysis for condition assessment.";

            $userPrompt .= "\n\nWeb search results about this product:\n" . $webContext;
        }

        $messages = [
            [
                'role' => 'system',
                'content' => $systemPrompt,
            ],
            [
                'role' => 'user',
                'content' => $userPrompt,
                'images' => [$cleanBase64],
            ],
        ];

        $response = $this->callOllama(
            model: $this->visionModel,
            messages: $messages,
            stream: false
        );

        if ($response === null) {
            return response()->json(['error' => 'Failed to analyze image. Please try again.'], 500);
        }

        $content = $response['message']['content'] ?? '';
        error_log('[OCR] Raw response: ' . $content);

        // Extract JSON from the response (handle markdown code blocks)
        $jsonContent = $content;
        if (preg_match('/```(?:json)?\s*([\s\S]*?)```/', $content, $matches)) {
            $jsonContent = trim($matches[1]);
        }

        $data = json_decode($jsonContent, true);

        if (!$data || !is_array($data)) {
            // Fallback: try to extract meaningful text as description
            error_log('[OCR] Failed to parse JSON, using fallback');
            $data = [
                'product_name' => $productKeywords !== 'unknown product' ? $productKeywords : 'Unknown Product',
                'description' => $content,
                'category' => 'General',
                'brand' => 'Unknown',
                'condition' => 'Used',
            ];
        }

        // Ensure all required keys exist
        $result = [
            'product_name' => $data['product_name'] ?? 'Unknown Product',
            'description' => $data['description'] ?? '',
            'category' => $data['category'] ?? 'General',
            'brand' => $data['brand'] ?? 'Unknown',
            'condition' => $data['condition'] ?? 'Used',
            'web_enhanced' => !empty($webContext),
        ];

        error_log('[OK] OCR analysis complete: ' . $result['product_name'] . ($result['web_enhanced'] ? ' (web-enhanced)' : ''));

        return response()->json($result);
    }

    /**
     * Perform a web search for OCR product enrichment (no source tracking).
     * Returns formatted search results as a string.
     */
    private function ocrWebSearch(string $query): string
    {
        $maxResults = 3;
        $contentLimit = config('ollama.search_content_limit', 2000);

        // Search DuckDuckGo HTML version
        $searchUrl = 'https://html.duckduckgo.com/html/?q=' . urlencode($query);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $searchUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml',
                'Accept-Language: en-US,en;q=0.9',
            ],
        ]);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$html || $httpCode !== 200) {
            error_log('[!!] OCR web search failed (HTTP ' . $httpCode . ')');
            return '';
        }

        $results = $this->parseDuckDuckGoResults($html, $maxResults);

        if (empty($results)) {
            error_log('[--] No OCR search results found.');
            return '';
        }

        error_log('[OK] OCR parsed ' . count($results) . ' search results.');

        // Fetch page content for top 2 results
        $formattedResults = '';
        $idx = 1;

        foreach ($results as $result) {
            $title = $result['title'];
            $url = $result['url'];
            $snippet = $result['snippet'];

            $pageContent = '';
            if ($idx <= 2) {
                $pageContent = $this->fetchPageContent($url, $contentLimit);
            }

            $formattedResults .= "--- Source {$idx}: {$title} ---\n";
            $formattedResults .= "URL: {$url}\n";
            if ($pageContent) {
                $formattedResults .= "Content: {$pageContent}\n\n";
            } else {
                $formattedResults .= "Summary: {$snippet}\n\n";
            }

            $idx++;
        }

        return $formattedResults;
    }

    /**
     * Return a JSON error response.
     */
    private function errorResponse(string $message): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => $message], 500);
    }
}
