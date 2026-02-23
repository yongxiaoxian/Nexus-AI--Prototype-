<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NexusAI — Intelligent Chatbot Platform')</title>
    <meta name="description"
        content="@yield('description', 'NexusAI is an AI-powered chatbot platform that helps businesses automate customer engagement, boost conversions, and deliver 24/7 support.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- Navigation --}}
    <nav class="navbar" id="navbar">
        <div class="container nav-container">
            <a href="{{ route('home') }}" class="nav-logo">
                <span class="logo-icon">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <defs>
                            <linearGradient id="logoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#6C5CE7" />
                                <stop offset="100%" style="stop-color:#00D2FF" />
                            </linearGradient>
                        </defs>
                        <rect width="32" height="32" rx="8" fill="url(#logoGrad)" />
                        <path d="M10 12h12M10 16h8M10 20h10" stroke="white" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </span>
                <span class="logo-text">Nexus<span class="logo-highlight">AI</span></span>
            </a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}"
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('features') }}"
                        class="nav-link {{ request()->routeIs('features') ? 'active' : '' }}">Features</a></li>
                <li><a href="{{ route('pricing') }}"
                        class="nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}">Pricing</a></li>
                <li><a href="{{ route('about') }}"
                        class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('contact') }}"
                        class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                <li class="nav-dropdown-wrap">
                    <a href="#" class="nav-link btn-nav-cta" id="demoDropdownTrigger">Try Demo
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:4px">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </a>
                    <div class="nav-dropdown" id="demoDropdown">
                        <a href="{{ route('demo') }}" class="nav-dropdown-item">
                            <div class="nav-dropdown-icon" style="--icon-color:#6C5CE7">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="nav-dropdown-title">AI Chatbot</span>
                                <span class="nav-dropdown-desc">Chat with our AI assistant</span>
                            </div>
                        </a>
                        <a href="{{ route('demo.ocr') }}" class="nav-dropdown-item">
                            <div class="nav-dropdown-icon" style="--icon-color:#00B894">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                            </div>
                            <div>
                                <span class="nav-dropdown-title">OCR Product Scan</span>
                                <span class="nav-dropdown-desc">Extract product info from images</span>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    @if(!request()->routeIs('demo') && !request()->routeIs('demo.ocr'))
        <footer class="footer">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-brand">
                        <a href="{{ route('home') }}" class="nav-logo">
                            <span class="logo-icon">
                                <svg width="28" height="28" viewBox="0 0 32 32" fill="none">
                                    <rect width="32" height="32" rx="8" fill="url(#logoGrad)" />
                                    <path d="M10 12h12M10 16h8M10 20h10" stroke="white" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </span>
                            <span class="logo-text">Nexus<span class="logo-highlight">AI</span></span>
                        </a>
                        <p class="footer-tagline">Empowering businesses with intelligent AI conversations. Available 24/7,
                            in every language, on every channel.</p>
                    </div>
                    <div class="footer-links">
                        <h4>Product</h4>
                        <ul>
                            <li><a href="{{ route('features') }}">Features</a></li>
                            <li><a href="{{ route('pricing') }}">Pricing</a></li>
                            <li><a href="{{ route('demo') }}">AI Chatbot Demo</a></li>
                            <li><a href="{{ route('demo.ocr') }}">OCR Product Scan</a></li>
                        </ul>
                    </div>
                    <div class="footer-links">
                        <h4>Company</h4>
                        <ul>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="footer-links">
                        <h4>Connect</h4>
                        <ul>
                            <li><a href="#">Twitter / X</a></li>
                            <li><a href="#">LinkedIn</a></li>
                            <li><a href="#">GitHub</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} NexusAI. All rights reserved.</p>
                </div>
            </div>
        </footer>
    @endif

    {{-- Floating Chat Widget (on all pages except demo) --}}
    @if(!request()->routeIs('demo') && !request()->routeIs('demo.ocr'))
        <div class="chat-widget" id="chatWidget">
            <button class="chat-widget-trigger" id="chatTrigger" aria-label="Open chat">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <span class="chat-widget-pulse"></span>
            </button>
            <div class="chat-widget-panel" id="chatPanel">
                <div class="chat-widget-header">
                    <div class="chat-header-info">
                        <div class="chat-avatar">
                            <svg width="20" height="20" viewBox="0 0 32 32" fill="none">
                                <rect width="32" height="32" rx="8" fill="url(#logoGrad)" />
                                <path d="M10 12h12M10 16h8M10 20h10" stroke="white" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div>
                            <span class="chat-header-name">NexusAI Bot</span>
                            <span class="chat-header-status">Online</span>
                        </div>
                    </div>
                    <button class="chat-close" id="chatClose" aria-label="Close chat">&times;</button>
                </div>
                <div class="chat-widget-messages" id="widgetMessages">
                    <div class="chat-message bot">
                        <div class="chat-bubble">Hi there! I'm NexusAI's assistant. Ask me anything about our platform!
                        </div>
                    </div>
                </div>
                <form class="chat-widget-input" id="widgetForm">
                    <input type="text" id="widgetInput" placeholder="Type a message..." autocomplete="off">
                    <button type="submit" aria-label="Send">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @endif
</body>

</html>