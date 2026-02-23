# NexusAI — AI-Powered Chatbot & OCR Product Scanner

A full-stack AI assistant platform built with **Laravel 12** and **Ollama**, featuring a real-time chatbot with web search capabilities, image analysis, and an OCR Product Scanner with web-based RAG (Retrieval-Augmented Generation).

> **100% local AI** — No paid API keys required. Runs entirely on Ollama models.

---

## Table of Contents

- [Features](#features)
- [Architecture Overview](#architecture-overview)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [API Endpoints](#api-endpoints)
- [How It Works](#how-it-works)
- [Customization](#customization)
- [Troubleshooting](#troubleshooting)

---

## Features

### AI Chatbot
- **ReAct Agent Loop** — Multi-step reasoning with tool calling (Observe → Think → Act)
- **Real-Time Streaming** — Server-Sent Events (SSE) for token-by-token response streaming
- **Web Search RAG** — DuckDuckGo HTML scraping with page content extraction for real-time information
- **Image Analysis** — Upload images for vision-based analysis using a multimodal model
- **Source Citations** — Auto-generated clickable source links from web searches
- **Conversation History** — Maintains chat context across messages per session
- **Confidence Assessment** — AI auto-evaluates whether to use web search vs. internal knowledge

### OCR Product Scanner
- **3-Pass RAG Pipeline**:
  1. Quick Vision scan to identify the product
  2. Web search to fetch current specifications and details
  3. Enriched extraction combining image + web context
- **Drag-and-Drop Upload** — Full drag-and-drop zone with file browser fallback
- **Auto-Fill Product Form** — AI extracts: product name, description, category, brand, condition
- **Web-Enhanced Results** — Green badge indicator when web search improved accuracy
- **Copy as JSON** — One-click export of all product data
- **Partner Brand Detection** — Distinguishes manufacturer vs. AIB/partner brands (e.g., "ASUS ROG" not just "NVIDIA")

### Marketing Website
- **7 Pages** — Home, Features, Pricing, About, Contact, Demo (Chatbot), Demo (OCR)
- **Dark Theme** — Premium glassmorphism design with gradient accents
- **Fully Responsive** — Mobile-first layout with adaptive navigation
- **Floating Chat Widget** — Available on all non-demo pages
- **Demo Dropdown** — Navbar dropdown for choosing between Chatbot and OCR demos
- **Toast Notifications** — Non-intrusive feedback system replacing browser alerts

---

## Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│                     Browser (Frontend)                  │
│  ┌──────────────┐  ┌──────────────┐  ┌───────────────┐  │
│  │  Chat Widget │  │  Demo Chat   │  │  OCR Scanner  │  │
│  └──────┬───────┘  └───────┬──────┘  └────────┬──────┘  │
│         │ SSE              │ SSE              │ JSON    │
└─────────┼──────────────────┼──────────────────┼─────────┘
          │                  │                  │
┌─────────▼──────────────────▼──────────────────▼───────────┐
│                   Laravel Backend                         │
│  ┌─────────────────────────────────────────────────────┐  │
│  │              ChatbotController                      │  │
│  │  ┌───────────────────┐  ┌────────────────────────┐  │  │
│  │  │  ReAct Agent Loop │  │  OCR 3-Pass Pipeline   │  │  │
│  │  │  (chat endpoint)  │  │  (ocrAnalyze endpoint) │  │  │
│  │  └─────┬──────┬──────┘  └──┬──────┬──────────────┘  │  │
│  │        │      │            │      │                 │  │
│  │   ┌────▼──┐ ┌─▼────────┐ ┌─▼──────▼───┐             │  │
│  │   │Ollama │ │DuckDuckGo│ │Vision+Web  │             │  │
│  │   │ Chat  │ │ Scraper  │ │  Combined  │             │  │
│  │   └───────┘ └──────────┘ └────────────┘             │  │
│  └─────────────────────────────────────────────────────┘  │
└──────────────────────────┬────────────────────────────────┘
                           │
┌──────────────────────────▼───────────────────────────────┐
│                    Ollama Server                         │
│  ┌─────────────────┐  ┌──────────────────┐               │
│  │  ReAct Model    │  │  Vision Model    │               │
│  │  (granite4:tiny)│  │  (gemma3:12b)    │               │
│  └─────────────────┘  └──────────────────┘               │
└──────────────────────────────────────────────────────────┘
```

---

## Tech Stack

| Layer      | Technology                                           |
|------------|------------------------------------------------------|
| Backend    | PHP 8.2+, Laravel 12                                 |
| AI Runtime | Ollama (local inference)                             |
| ReAct Model| `granite4:tiny-h` (tool-calling / reasoning)         |
| Vision Model| `gemma3:12b` (multimodal / image analysis)          |
| Frontend   | Vanilla JS, CSS (custom design system)               |
| Build Tool | Vite 7.x with Laravel Vite Plugin                    |
| Web Search | DuckDuckGo HTML scraping (no API key needed)         |
| Streaming  | Server-Sent Events (SSE)                             |
| Server     | XAMPP / Apache (or `php artisan serve`)              |

---

## Prerequisites

1. **PHP 8.2+** with cURL extension enabled
2. **Composer** (PHP dependency manager)
3. **Node.js 18+** and npm
4. **Ollama** installed and running — [Install Ollama](https://ollama.com/download)

### Required Ollama Models

Pull the required models before starting:

```bash
# ReAct / reasoning model (for chatbot tool-calling)
ollama pull granite4:tiny-h

# Vision / multimodal model (for image analysis + OCR)
ollama pull gemma3:12b
```

> You can substitute different models via the `.env` file. Any model that supports tool calling works for the ReAct model. Any multimodal model works for vision.

---

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd chatbot
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Ollama (in `.env`)

Add these lines to your `.env` file:

```env
OLLAMA_BASE_URL=http://localhost:11434
OLLAMA_REACT_MODEL=granite4:tiny-h
OLLAMA_VISION_MODEL=gemma3:12b
OLLAMA_TIMEOUT=120
OLLAMA_MAX_TOOL_ITERATIONS=5
OLLAMA_SEARCH_MAX_RESULTS=3
OLLAMA_SEARCH_CONTENT_LIMIT=2000
```

### 5. Database setup

```bash
php artisan migrate
```

### 6. Build frontend assets

```bash
npm run build
```

### 7. Start the application

**Option A — One-command dev mode** (recommended):
```bash
composer dev
```
This starts the PHP server, queue worker, log viewer, and Vite dev server concurrently.

**Option B — Manual start:**
```bash
php artisan serve
```
Then visit `http://localhost:8000`.

> Make sure Ollama is running (`ollama serve`) before using the chat or OCR features.

---

## Configuration

All Ollama settings live in `config/ollama.php` and are driven by environment variables:

| Variable | Default | Description |
|----------|---------|-------------|
| `OLLAMA_BASE_URL` | `http://localhost:11434` | Ollama server URL |
| `OLLAMA_REACT_MODEL` | `granite4:tiny-h` | Model for reasoning & tool-calling |
| `OLLAMA_VISION_MODEL` | `gemma3:12b` | Model for image analysis & OCR |
| `OLLAMA_TIMEOUT` | `120` | Request timeout in seconds |
| `OLLAMA_MAX_TOOL_ITERATIONS` | `5` | Max ReAct loop iterations per request |
| `OLLAMA_SEARCH_MAX_RESULTS` | `3` | Number of web search results to fetch |
| `OLLAMA_SEARCH_CONTENT_LIMIT` | `2000` | Max characters to extract per page |

---

## Usage

### AI Chatbot Demo (`/demo`)

1. Navigate to `/demo` or click **Try Demo → AI Chatbot** in the navbar
2. Type a message or click a suggestion card
3. The AI responds with streaming text
4. Upload an image using the attachment button for visual analysis
5. Ask time-sensitive questions — the AI auto-searches the web when needed

### OCR Product Scanner (`/demo/ocr`)

1. Navigate to `/demo/ocr` or click **Try Demo → OCR Product Scan** in the navbar
2. Drag and drop a product image (or click to browse)
3. Preview the image and click **Confirm & Analyze**
4. The 3-pass pipeline runs:
   - Vision model identifies the product
   - Web search gathers current specs
   - Final extraction produces structured data
5. Review and edit the auto-filled fields
6. Click **Copy as JSON** to export the data

### Floating Chat Widget

Available on all marketing pages (Home, Features, Pricing, About, Contact). Click the chat bubble in the bottom-right corner to open.

---

## Project Structure

```
chatbot/
├── app/
│   └── Http/Controllers/
│       ├── ChatbotController.php    # AI logic: ReAct loop, streaming, web search, OCR
│       └── PageController.php       # Static page routing
├── config/
│   └── ollama.php                   # Ollama configuration
├── resources/
│   ├── css/
│   │   └── app.css                  # Complete design system (~2900 lines)
│   ├── js/
│   │   └── app.js                   # Frontend logic (~740 lines)
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php        # Main layout (nav, footer, chat widget)
│       └── pages/
│           ├── home.blade.php       # Landing page
│           ├── features.blade.php   # Features showcase
│           ├── pricing.blade.php    # Pricing plans
│           ├── about.blade.php      # About page
│           ├── contact.blade.php    # Contact form
│           ├── demo.blade.php       # AI Chatbot demo
│           └── ocr.blade.php        # OCR Product Scanner
├── routes/
│   └── web.php                      # Route definitions
├── public/
│   └── build/                       # Compiled Vite assets
├── .env                             # Environment configuration
├── composer.json                    # PHP dependencies
├── package.json                     # Node dependencies
└── vite.config.js                   # Vite build configuration
```

---

## API Endpoints

### `POST /api/chat`

AI chatbot endpoint with SSE streaming.

**Request:**
```json
{
  "message": "What's the weather like today?",
  "history": [
    { "role": "user", "content": "Hello" },
    { "role": "assistant", "content": "Hi! How can I help?" }
  ],
  "image": "data:image/jpeg;base64,..."
}
```

**Response:** Server-Sent Events stream
```
data: {"content": "The"}
data: {"content": " weather"}
data: {"content": " today"}
data: {"sources": [{"index": 1, "title": "Weather.com", "url": "..."}]}
data: [DONE]
```

---

### `POST /api/ocr`

OCR product analysis with web-enhanced RAG.

**Request:**
```json
{
  "image": "data:image/jpeg;base64,..."
}
```

**Response:**
```json
{
  "product_name": "ASUS ROG ASTRAL GeForce RTX 5090 OC",
  "description": "The ROG ASTRAL RTX 5090 features 32GB GDDR7...",
  "category": "Graphics Card",
  "brand": "ASUS ROG",
  "condition": "New",
  "web_enhanced": true
}
```

---

## How It Works

### ReAct Agent Loop (Chatbot)

The chatbot uses a **ReAct (Reasoning + Acting)** agent pattern:

```
User Message
    │
    ▼
┌─────────────────────┐
│ Check for image      │──── Yes ──→ Vision Agent analyzes image
│ attachment?          │             Result injected into message
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ Call ReAct Model     │◄────────────────────────┐
│ with tools           │                         │
└──────────┬──────────┘                         │
           │                                     │
     ┌─────▼─────┐                               │
     │ Tool call? │── Yes ──→ Execute web_search  │
     └─────┬─────┘           Return results ──────┘
           │ No
           ▼
┌─────────────────────┐
│ Stream final response│
│ via SSE              │
└─────────────────────┘
```

The loop runs up to `OLLAMA_MAX_TOOL_ITERATIONS` times (default: 5) before forcing a final answer.

### OCR 3-Pass Pipeline

```
Product Image
    │
    ▼
┌──────────────────────────┐
│ Pass 1: Quick Identify    │  Vision model extracts product name
│ "ASUS ROG ASTRAL RTX 5090"│  (reads text, logos, branding)
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────┐
│ Pass 2: Web Search        │  DuckDuckGo search → page scraping
│ Fetches specs, features   │  (top 2 results fetched in full)
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────┐
│ Pass 3: Enriched Extract  │  Vision model + web context →
│ Structured JSON output    │  accurate, detailed product data
└──────────────────────────┘
```

### Web Search RAG

Web search works by:
1. Querying DuckDuckGo's HTML search page
2. Parsing result titles, URLs, and snippets from the HTML
3. Fetching full page content for the top 2 results
4. Stripping HTML tags/scripts to extract clean text
5. Injecting the search context into the model's prompt

No API keys or external services are required — just raw HTML scraping.

---

## Customization

### Changing AI Models

Update your `.env` to use different Ollama models:

```env
# Use a larger model for better reasoning
OLLAMA_REACT_MODEL=qwen2.5:14b

# Use a different vision model
OLLAMA_VISION_MODEL=llava:13b
```

**Requirements:**
- ReAct model must support **tool calling** (function calling)
- Vision model must support **image inputs** (multimodal)

### Adjusting Web Search

```env
# Fetch more search results (slower but more context)
OLLAMA_SEARCH_MAX_RESULTS=5

# Extract more content per page
OLLAMA_SEARCH_CONTENT_LIMIT=4000
```

### Modifying the System Prompt

Edit the `getSystemPrompt()` method in `ChatbotController.php` to change the AI's personality, guidelines, or behavior rules.

### Adding New Pages

1. Add a route in `routes/web.php`
2. Add a controller method in `PageController.php`
3. Create a Blade template in `resources/views/pages/`
4. Run `npm run build` to recompile assets

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Chat returns "Failed to get response" | Ensure Ollama is running: `ollama serve` |
| Vision/OCR not working | Verify vision model is pulled: `ollama list` |
| Web search fails | Check internet connectivity and cURL extension |
| Styles not loading | Run `npm run build` to compile assets |
| Slow responses | Use smaller models or increase `OLLAMA_TIMEOUT` |
| OCR returns "Unknown Product" | Try a clearer image with visible branding/text |
| CSRF token mismatch | Clear browser cache or check `SESSION_DRIVER` in `.env` |

### Viewing Logs

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# PHP error log (includes [OCR] and [OK] tags)
# Check your php.ini for error_log location
```

---

## License

This project is open-source under the [MIT License](LICENSE).
