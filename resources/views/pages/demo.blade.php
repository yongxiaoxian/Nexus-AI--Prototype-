@extends('layouts.app')

@section('title', 'Live Demo — NexusAI')
@section('description', 'Try NexusAI\'s AI chatbot demo. Experience intelligent conversations, instant responses, and natural language understanding — live.')

@section('content')
    <section class="demo-section">
        <div class="demo-fullpage">
            {{-- Chat Header --}}
            <div class="demo-chat-header">
                <div class="chat-header-info">
                    <div class="chat-avatar">
                        <svg width="24" height="24" viewBox="0 0 32 32" fill="none">
                            <defs>
                                <linearGradient id="demLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#6C5CE7" />
                                    <stop offset="100%" style="stop-color:#00D2FF" />
                                </linearGradient>
                            </defs>
                            <rect width="32" height="32" rx="8" fill="url(#demLogoGrad)" />
                            <path d="M10 12h12M10 16h8M10 20h10" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div>
                        <span class="chat-header-name">NexusAI Bot</span>
                        <span class="chat-header-status"><span class="status-dot"></span> Online</span>
                    </div>
                </div>
                <div class="demo-header-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="16" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                    Simulated Demo
                </div>
            </div>

            {{-- Chat Messages Area --}}
            <div class="demo-chat-scroll">
                <div class="demo-chat-messages" id="demoMessages">

                    {{-- Welcome Screen (centered, disappears on first message) --}}
                    <div class="demo-welcome" id="demoWelcome">
                        <div class="demo-welcome-logo">
                            <svg width="48" height="48" viewBox="0 0 32 32" fill="none">
                                <defs>
                                    <linearGradient id="welcomeLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:#6C5CE7" />
                                        <stop offset="100%" style="stop-color:#00D2FF" />
                                    </linearGradient>
                                </defs>
                                <rect width="32" height="32" rx="8" fill="url(#welcomeLogoGrad)" />
                                <path d="M10 12h12M10 16h8M10 20h10" stroke="white" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <h1 class="demo-welcome-title">How can I help you <span class="gradient-text">today?</span></h1>
                        <p class="demo-welcome-desc">Experience NexusAI in action. Ask about our platform, pricing,
                            features, or
                            just have a conversation.</p>

                        {{-- 3x2 Suggestion Grid --}}
                        <div class="demo-suggestions-grid">
                            <button class="suggestion-card" data-message="What's trending in tech news today?">
                                <div class="suggestion-card-icon" style="--icon-color: #FDCB6E;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                    </svg>
                                </div>
                                <div class="suggestion-card-text">
                                    <span class="suggestion-card-title">Trending News</span>
                                    <span class="suggestion-card-desc">Latest headlines in tech and science</span>
                                </div>
                            </button>
                            <button class="suggestion-card" data-message="How is the NVIDIA stock doing today?">
                                <div class="suggestion-card-icon" style="--icon-color: #00B894;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17" />
                                        <polyline points="16 7 22 7 22 13" />
                                    </svg>
                                </div>
                                <div class="suggestion-card-text">
                                    <span class="suggestion-card-title">Stock Market</span>
                                    <span class="suggestion-card-desc">Real-time prices and market updates</span>
                                </div>
                            </button>
                            <button class="suggestion-card"
                                data-message="Write a Python function to find all prime numbers up to N">
                                <div class="suggestion-card-icon" style="--icon-color: #6C5CE7;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="16 18 22 12 16 6" />
                                        <polyline points="8 6 2 12 8 18" />
                                    </svg>
                                </div>
                                <div class="suggestion-card-text">
                                    <span class="suggestion-card-title">Code Helper</span>
                                    <span class="suggestion-card-desc">Get help writing and debugging code</span>
                                </div>
                            </button>
                            <button class="suggestion-card"
                                data-message="Help me write a professional email declining a meeting politely">
                                <div class="suggestion-card-icon" style="--icon-color: #00D2FF;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="17" y1="10" x2="3" y2="10" />
                                        <line x1="21" y1="6" x2="3" y2="6" />
                                        <line x1="21" y1="14" x2="3" y2="14" />
                                        <line x1="17" y1="18" x2="3" y2="18" />
                                    </svg>
                                </div>
                                <div class="suggestion-card-text">
                                    <span class="suggestion-card-title">Writing Assistant</span>
                                    <span class="suggestion-card-desc">Draft emails, essays, and more</span>
                                </div>
                            </button>
                            <button class="suggestion-card" data-message="Explain quantum computing in simple terms">
                                <div class="suggestion-card-icon" style="--icon-color: #FD79A8;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                    </svg>
                                </div>
                                <div class="suggestion-card-text">
                                    <span class="suggestion-card-title">Explain a Topic</span>
                                    <span class="suggestion-card-desc">Break down complex subjects simply</span>
                                </div>
                            </button>
                            <button class="suggestion-card"
                                data-message="What are the best places to visit in Japan during spring?">
                                <div class="suggestion-card-icon" style="--icon-color: #E17055;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="10" r="3" />
                                        <path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 7 8 11.7z" />
                                    </svg>
                                </div>
                                <div class="suggestion-card-text">
                                    <span class="suggestion-card-title">Travel Guide</span>
                                    <span class="suggestion-card-desc">Discover destinations and travel tips</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Drag-and-Drop Overlay --}}
            <div class="demo-drop-overlay" id="demoDropOverlay">
                <div class="demo-drop-content">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="17 8 12 3 7 8" />
                        <line x1="12" y1="3" x2="12" y2="15" />
                    </svg>
                    <span>Drop image here</span>
                </div>
            </div>

            {{-- Image Preview --}}
            <div class="demo-image-preview" id="demoImagePreview" style="display:none;">
                <div class="preview-thumb-wrap">
                    <img id="previewThumb" src="" alt="Preview">
                    <button type="button" class="preview-remove" id="previewRemove"
                        aria-label="Remove image">&times;</button>
                </div>
            </div>

            {{-- Chat Input --}}
            <form class="demo-chat-input" id="demoForm">
                <input type="file" id="demoFileInput" accept="image/jpeg,image/png,image/gif,image/webp"
                    style="display:none;">
                <button type="button" class="demo-upload-btn" id="demoUploadBtn" aria-label="Upload image">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48" />
                    </svg>
                </button>
                <input type="text" id="demoInput" placeholder="Type your message here..." autocomplete="off">
                <button type="submit" class="demo-send-btn" aria-label="Send message">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
    </section>
@endsection