@extends('layouts.app')

@section('title', 'Features — NexusAI')
@section('description', 'Discover the powerful features of NexusAI: natural language understanding, omnichannel deployment, advanced analytics, and more.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="section-label fade-up">Features</span>
            <h1 class="page-hero-title fade-up">Powerful Features for<br><span class="gradient-text">Modern
                    Businesses</span></h1>
            <p class="page-hero-subtitle fade-up">Everything you need to build, deploy, and scale intelligent conversational
                experiences.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="feature-showcase">
                {{-- Feature 1 --}}
                <div class="feature-row fade-up">
                    <div class="feature-row-content">
                        <div class="feature-row-icon" style="--icon-color: #6C5CE7;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M9 12l2 2 4-4" />
                            </svg>
                        </div>
                        <h2>Natural Language Understanding</h2>
                        <p>Our advanced NLU engine goes beyond simple keyword matching. It understands context, intent,
                            sentiment, and even sarcasm — delivering genuinely helpful responses every time.</p>
                        <ul class="feature-list">
                            <li>Multi-language support (50+ languages)</li>
                            <li>Context-aware conversation memory</li>
                            <li>Sentiment analysis and escalation triggers</li>
                            <li>Entity extraction and slot filling</li>
                        </ul>
                    </div>
                    <div class="feature-row-visual glass-card">
                        <div class="mock-chat">
                            <div class="mock-msg user">What's the status of order #4521?</div>
                            <div class="mock-msg bot">Your order #4521 shipped yesterday via FedEx. Expected delivery:
                                Tomorrow by 5 PM. Would you like the tracking link?</div>
                            <div class="mock-msg user">Yes please!</div>
                            <div class="mock-msg bot">Here you go: <span
                                    style="color: var(--accent-primary);">track.fedex.com/4521</span></div>
                        </div>
                    </div>
                </div>

                {{-- Feature 2 --}}
                <div class="feature-row feature-row-reverse fade-up">
                    <div class="feature-row-content">
                        <div class="feature-row-icon" style="--icon-color: #00D2FF;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2" />
                                <line x1="8" y1="21" x2="16" y2="21" />
                                <line x1="12" y1="17" x2="12" y2="21" />
                            </svg>
                        </div>
                        <h2>Omnichannel Deployment</h2>
                        <p>Meet your customers where they are. Deploy your AI chatbot across every channel from a single
                            dashboard — no duplicate setups, no fragmented conversations.</p>
                        <ul class="feature-list">
                            <li>Website widget (one-line embed)</li>
                            <li>WhatsApp, Messenger, Telegram</li>
                            <li>Slack & Microsoft Teams</li>
                            <li>iOS & Android SDK</li>
                        </ul>
                    </div>
                    <div class="feature-row-visual glass-card">
                        <div class="channel-grid">
                            <div class="channel-item"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        stroke="#00D2FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="2" y1="12" x2="22" y2="12" />
                                        <path
                                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                                    </svg></span> Website</div>
                            <div class="channel-item"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        stroke="#00B894" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                    </svg></span> WhatsApp</div>
                            <div class="channel-item"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        stroke="#6C5CE7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="5" y="2" width="14" height="20" rx="2" ry="2" />
                                        <line x1="12" y1="18" x2="12.01" y2="18" />
                                    </svg></span> Messenger</div>
                            <div class="channel-item active"><span><svg width="22" height="22" viewBox="0 0 24 24"
                                        fill="none" stroke="#FD79A8" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z" />
                                        <path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z" />
                                        <path
                                            d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z" />
                                        <path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z" />
                                        <path
                                            d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z" />
                                        <path
                                            d="M14 20.5c0-.83.67-1.5 1.5-1.5H17c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-1.5c-.83 0-1.5-.67-1.5-1.5z" />
                                        <path
                                            d="M10 9.5C10 10.33 9.33 11 8.5 11h-5C2.67 11 2 10.33 2 9.5S2.67 8 3.5 8h5c.83 0 1.5.67 1.5 1.5z" />
                                        <path d="M8.5 5H10V3.5c0-.83-.67-1.5-1.5-1.5S7 2.67 7 3.5 7.67 5 8.5 5z" />
                                    </svg></span> Slack</div>
                            <div class="channel-item"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        stroke="#FDCB6E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="22" y1="2" x2="11" y2="13" />
                                        <polygon points="22 2 15 22 11 13 2 9 22 2" />
                                    </svg></span> Telegram</div>
                            <div class="channel-item"><span><svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        stroke="#E17055" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg></span> Email</div>
                        </div>
                    </div>
                </div>

                {{-- Feature 3 --}}
                <div class="feature-row fade-up">
                    <div class="feature-row-content">
                        <div class="feature-row-icon" style="--icon-color: #FDCB6E;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2a10 10 0 1 0 10 10H12V2z" />
                                <path d="M20 12a8 8 0 0 0-8-8v8h8z" />
                            </svg>
                        </div>
                        <h2>Advanced Analytics</h2>
                        <p>Turn every conversation into actionable insights. Track performance, identify trends, and
                            continuously improve your chatbot's effectiveness with real-time dashboards.</p>
                        <ul class="feature-list">
                            <li>Real-time conversation monitoring</li>
                            <li>Customer satisfaction scoring (CSAT)</li>
                            <li>Topic clustering and trend detection</li>
                            <li>Export reports (PDF, CSV, API)</li>
                        </ul>
                    </div>
                    <div class="feature-row-visual glass-card">
                        <div class="mock-analytics">
                            <div class="analytics-bar">
                                <div class="bar-label">Resolved</div>
                                <div class="bar-track">
                                    <div class="bar-fill"
                                        style="width: 87%; background: linear-gradient(90deg, #00B894, #00D2FF);"></div>
                                </div>
                                <span class="bar-value">87%</span>
                            </div>
                            <div class="analytics-bar">
                                <div class="bar-label">Satisfaction</div>
                                <div class="bar-track">
                                    <div class="bar-fill"
                                        style="width: 94%; background: linear-gradient(90deg, #6C5CE7, #A29BFE);"></div>
                                </div>
                                <span class="bar-value">4.7/5</span>
                            </div>
                            <div class="analytics-bar">
                                <div class="bar-label">Avg Response</div>
                                <div class="bar-track">
                                    <div class="bar-fill"
                                        style="width: 40%; background: linear-gradient(90deg, #FDCB6E, #E17055);"></div>
                                </div>
                                <span class="bar-value">0.8s</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Feature 4 --}}
                <div class="feature-row feature-row-reverse fade-up">
                    <div class="feature-row-content">
                        <div class="feature-row-icon" style="--icon-color: #FD79A8;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <h2>Enterprise-Grade Security</h2>
                        <p>Your data security is our top priority. We're built with enterprise compliance standards from the
                            ground up, so you can deploy with absolute confidence.</p>
                        <ul class="feature-list">
                            <li>SOC 2 Type II certified</li>
                            <li>GDPR & CCPA compliant</li>
                            <li>End-to-end encryption (AES-256)</li>
                            <li>Role-based access control (RBAC)</li>
                        </ul>
                    </div>
                    <div class="feature-row-visual glass-card">
                        <div class="security-badges">
                            <div class="security-badge">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#FD79A8"
                                    stroke-width="1.5">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <path d="M9 12l2 2 4-4" />
                                </svg>
                                <span>SOC 2</span>
                            </div>
                            <div class="security-badge">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#6C5CE7"
                                    stroke-width="1.5">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                                <span>GDPR</span>
                            </div>
                            <div class="security-badge">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#00D2FF"
                                    stroke-width="1.5">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    <circle cx="12" cy="16" r="1" />
                                </svg>
                                <span>AES-256</span>
                            </div>
                            <div class="security-badge">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#00B894"
                                    stroke-width="1.5">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <span>RBAC</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="section cta-section">
        <div class="container">
            <div class="cta-card fade-up">
                <div class="cta-bg-effects">
                    <div class="cta-orb cta-orb-1"></div>
                    <div class="cta-orb cta-orb-2"></div>
                </div>
                <h2>See It in Action</h2>
                <p>Try our interactive demo and experience the power of NexusAI firsthand.</p>
                <a href="{{ route('demo') }}" class="btn btn-primary btn-lg">Launch Demo</a>
            </div>
        </div>
    </section>
@endsection