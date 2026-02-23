<?php

return [
    'base_url' => env('OLLAMA_BASE_URL', 'http://localhost:11434'),
    'react_model' => env('OLLAMA_REACT_MODEL', 'granite4:tiny-h'),
    'vision_model' => env('OLLAMA_VISION_MODEL', 'gemma3:12b'),
    'max_tool_iterations' => (int) env('OLLAMA_MAX_TOOL_ITERATIONS', 5),
    'timeout' => (int) env('OLLAMA_TIMEOUT', 120),
    'search_max_results' => (int) env('OLLAMA_SEARCH_MAX_RESULTS', 3),
    'search_content_limit' => (int) env('OLLAMA_SEARCH_CONTENT_LIMIT', 2000),
];
