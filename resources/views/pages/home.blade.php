@extends('layouts.app')

@section('title', 'NexusAI — Intelligent AI Chatbot for Your Business')
@section('description', 'NexusAI delivers AI-powered chatbot solutions that automate customer support, boost engagement, and drive conversions 24/7.')

@section('content')
    {{-- Hero Section --}}
    <section class="hero">
        <div class="hero-bg-effects">
            <div class="hero-orb hero-orb-1"></div>
            <div class="hero-orb hero-orb-2"></div>
            <div class="hero-orb hero-orb-3"></div>
            <div class="hero-grid-pattern"></div>
        </div>
        <div class="container hero-content">
            <div class="hero-badge fade-up">
                <span class="badge-dot"></span>
                Trusted by 10,000+ businesses worldwide
            </div>
            <h1 class="hero-title fade-up">
                Your Customers Deserve<br>
                <span class="gradient-text">Intelligent Conversations</span>
            </h1>
            <p class="hero-subtitle fade-up">
                Deploy an AI-powered chatbot that understands your customers, answers instantly,
                and never sleeps. Reduce support costs by 60% while boosting satisfaction.
            </p>
            <div class="hero-actions fade-up">
                <a href="{{ route('demo') }}" class="btn btn-primary btn-lg">
                    Try Live Demo
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
                <a href="{{ route('features') }}" class="btn btn-outline btn-lg">
                    Explore Features
                </a>
            </div>
            <div class="hero-stats fade-up">
                <div class="stat">
                    <span class="stat-number">10M+</span>
                    <span class="stat-label">Conversations Handled</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <span class="stat-number">99.9%</span>
                    <span class="stat-label">Uptime SLA</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat">
                    <span class="stat-number">
                        < 1s</span>
                            <span class="stat-label">Response Time</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Preview --}}
    <section class="section features-preview">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-label">Why NexusAI</span>
                <h2 class="section-title">Everything You Need to<br><span class="gradient-text">Delight Your
                        Customers</span></h2>
                <p class="section-subtitle">Our AI chatbot platform combines cutting-edge technology with elegant
                    simplicity.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card glass-card fade-up">
                    <div class="feature-icon" style="--icon-color: #6C5CE7;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a10 10 0 1 0 10 10H12V2z" />
                            <path d="M20 12a8 8 0 0 0-8-8v8h8z" />
                        </svg>
                    </div>
                    <h3>Smart Analytics</h3>
                    <p>Deep insights into customer behavior, satisfaction trends, and conversation metrics in real-time.</p>
                </div>
                <div class="feature-card glass-card fade-up">
                    <div class="feature-icon" style="--icon-color: #00D2FF;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                    </div>
                    <h3>Natural Conversations</h3>
                    <p>Advanced NLU engine that understands context, intent, and sentiment for human-like interactions.</p>
                </div>
                <div class="feature-card glass-card fade-up">
                    <div class="feature-icon" style="--icon-color: #FD79A8;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" />
                            <line x1="8" y1="21" x2="16" y2="21" />
                            <line x1="12" y1="17" x2="12" y2="21" />
                        </svg>
                    </div>
                    <h3>Omnichannel</h3>
                    <p>Deploy on your website, mobile app, WhatsApp, Slack, Messenger — all from one dashboard.</p>
                </div>
                <div class="feature-card glass-card fade-up">
                    <div class="feature-icon" style="--icon-color: #FDCB6E;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <h3>Enterprise Security</h3>
                    <p>SOC 2 Type II certified, GDPR compliant, end-to-end encryption. Your data is always safe.</p>
                </div>
                <div class="feature-card glass-card fade-up">
                    <div class="feature-icon" style="--icon-color: #00B894;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="16 18 22 12 16 6" />
                            <polyline points="8 6 2 12 8 18" />
                        </svg>
                    </div>
                    <h3>Easy Integration</h3>
                    <p>One line of code, REST API, or webhooks. Integrate in minutes, not months.</p>
                </div>
                <div class="feature-card glass-card fade-up">
                    <div class="feature-icon" style="--icon-color: #E17055;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                    </div>
                    <h3>Fully Customizable</h3>
                    <p>Tailor the chatbot's personality, appearance, and knowledge base to match your brand perfectly.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Social Proof / Testimonials --}}
    <section class="section testimonials-section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-label">Testimonials</span>
                <h2 class="section-title">Loved by Teams <span class="gradient-text">Everywhere</span></h2>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card glass-card fade-up">
                    <div class="testimonial-stars">★★★★★</div>
                    <p>"NexusAI reduced our support ticket volume by 73%. The AI actually understands context — it's not
                        just keyword matching."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar" style="background: linear-gradient(135deg, #6C5CE7, #00D2FF);">SC</div>
                        <div>
                            <strong>Sarah Chen</strong>
                            <span>VP of Support, TechFlow Inc.</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card glass-card fade-up">
                    <div class="testimonial-stars">★★★★★</div>
                    <p>"Setup took 15 minutes. Within a week, the bot was handling 80% of queries autonomously. The ROI is
                        incredible."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar" style="background: linear-gradient(135deg, #FD79A8, #FDCB6E);">MR</div>
                        <div>
                            <strong>Marcus Rivera</strong>
                            <span>CTO, GrowthStack</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card glass-card fade-up">
                    <div class="testimonial-stars">★★★★★</div>
                    <p>"Our customer satisfaction scores went from 3.2 to 4.8 after deploying NexusAI. Our customers love
                        the instant responses."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar" style="background: linear-gradient(135deg, #00B894, #00D2FF);">EP</div>
                        <div>
                            <strong>Emily Park</strong>
                            <span>Head of CX, RetailPlus</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="section cta-section">
        <div class="container">
            <div class="cta-card fade-up">
                <div class="cta-bg-effects">
                    <div class="cta-orb cta-orb-1"></div>
                    <div class="cta-orb cta-orb-2"></div>
                </div>
                <h2>Ready to Transform Your Customer Experience?</h2>
                <p>Join 10,000+ businesses already using NexusAI to delight their customers.</p>
                <div class="cta-actions">
                    <a href="{{ route('demo') }}" class="btn btn-primary btn-lg">Start Free Trial</a>
                    <a href="{{ route('contact') }}" class="btn btn-ghost btn-lg">Talk to Sales</a>
                </div>
            </div>
        </div>
    </section>
@endsection