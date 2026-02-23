@extends('layouts.app')

@section('title', 'About — NexusAI')
@section('description', 'Learn about NexusAI, our mission to democratize AI-powered customer engagement, and the team behind the platform.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="section-label fade-up">About Us</span>
            <h1 class="page-hero-title fade-up">The Team Behind<br><span class="gradient-text">NexusAI</span></h1>
            <p class="page-hero-subtitle fade-up">We're on a mission to make intelligent customer experiences accessible to
                every business on the planet.</p>
        </div>
    </section>

    {{-- Mission --}}
    <section class="section">
        <div class="container">
            <div class="about-mission fade-up">
                <div class="mission-content">
                    <h2>Our <span class="gradient-text">Mission</span></h2>
                    <p>We believe every business — from a solo founder to a Fortune 500 — deserves access to world-class AI
                        for customer engagement. NexusAI was born from a simple insight: most customer questions are
                        predictable, yet businesses still spend millions on manual support.</p>
                    <p>Our platform bridges that gap. By combining advanced natural language understanding with an elegantly
                        simple interface, we help businesses automate 80% of customer interactions while actually improving
                        satisfaction scores.</p>
                </div>
                <div class="mission-stats">
                    <div class="mission-stat glass-card">
                        <span class="mission-stat-number gradient-text">10K+</span>
                        <span class="mission-stat-label">Businesses Served</span>
                    </div>
                    <div class="mission-stat glass-card">
                        <span class="mission-stat-number gradient-text">50M+</span>
                        <span class="mission-stat-label">Conversations Monthly</span>
                    </div>
                    <div class="mission-stat glass-card">
                        <span class="mission-stat-number gradient-text">150+</span>
                        <span class="mission-stat-label">Countries</span>
                    </div>
                    <div class="mission-stat glass-card">
                        <span class="mission-stat-number gradient-text">99.9%</span>
                        <span class="mission-stat-label">Uptime</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Timeline --}}
    <section class="section about-timeline-section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-label">Our Journey</span>
                <h2 class="section-title">From Idea to <span class="gradient-text">Industry Leader</span></h2>
            </div>
            <div class="timeline">
                <div class="timeline-item fade-up">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content glass-card">
                        <span class="timeline-year">2024</span>
                        <h3>Founded</h3>
                        <p>NexusAI started with 3 AI researchers in a small office, determined to revolutionize customer
                            engagement with conversational AI.</p>
                    </div>
                </div>
                <div class="timeline-item fade-up">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content glass-card">
                        <span class="timeline-year">2024</span>
                        <h3>First 1,000 Customers</h3>
                        <p>Within 6 months, 1,000 businesses were using NexusAI. Product-market fit was undeniable — our
                            retention rate hit 95%.</p>
                    </div>
                </div>
                <div class="timeline-item fade-up">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content glass-card">
                        <span class="timeline-year">2025</span>
                        <h3>Series A — $18M</h3>
                        <p>Led by top-tier VCs, our Series A allowed us to scale the team to 50+ engineers and expand to 30
                            countries.</p>
                    </div>
                </div>
                <div class="timeline-item fade-up">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content glass-card">
                        <span class="timeline-year">2026</span>
                        <h3>10,000+ Businesses</h3>
                        <p>Today, NexusAI powers intelligent conversations for over 10,000 businesses worldwide, handling
                            50M+ messages monthly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team --}}
    <section class="section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-label">Our Team</span>
                <h2 class="section-title">Meet the <span class="gradient-text">People</span></h2>
            </div>
            <div class="team-grid">
                <div class="team-card glass-card fade-up">
                    <div class="team-avatar" style="background: linear-gradient(135deg, #6C5CE7, #00D2FF);">
                        <span>AK</span>
                    </div>
                    <h3>Alex Kim</h3>
                    <span class="team-role">Co-Founder & CEO</span>
                    <p>Former Google AI researcher. 10+ years in NLP and machine learning. Passionate about making AI
                        accessible.</p>
                </div>
                <div class="team-card glass-card fade-up">
                    <div class="team-avatar" style="background: linear-gradient(135deg, #FD79A8, #FDCB6E);">
                        <span>JL</span>
                    </div>
                    <h3>Jordan Lee</h3>
                    <span class="team-role">Co-Founder & CTO</span>
                    <p>Ex-Meta engineering lead. Built systems handling billions of messages. Architecture and scale
                        enthusiast.</p>
                </div>
                <div class="team-card glass-card fade-up">
                    <div class="team-avatar" style="background: linear-gradient(135deg, #00B894, #00D2FF);">
                        <span>MR</span>
                    </div>
                    <h3>Maya Rodriguez</h3>
                    <span class="team-role">VP of Product</span>
                    <p>Product leader from Intercom and Zendesk. Obsessed with creating delightful customer experiences.</p>
                </div>
                <div class="team-card glass-card fade-up">
                    <div class="team-avatar" style="background: linear-gradient(135deg, #E17055, #FDCB6E);">
                        <span>DP</span>
                    </div>
                    <h3>David Park</h3>
                    <span class="team-role">Head of Engineering</span>
                    <p>Former AWS principal engineer. Expert in distributed systems, real-time processing, and cloud
                        infrastructure.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Values --}}
    <section class="section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-label">Our Values</span>
                <h2 class="section-title">What <span class="gradient-text">Drives Us</span></h2>
            </div>
            <div class="values-grid">
                <div class="value-card glass-card fade-up">
                    <div class="value-icon" style="--icon-color: #6C5CE7;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <circle cx="12" cy="12" r="6" />
                            <circle cx="12" cy="12" r="2" />
                        </svg>
                    </div>
                    <h3>Customer Obsession</h3>
                    <p>Every decision starts with "How does this help our customers?" We build what matters, not what's
                        trendy.</p>
                </div>
                <div class="value-card glass-card fade-up">
                    <div class="value-icon" style="--icon-color: #00D2FF;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="20" x2="12" y2="14" />
                            <polyline points="16 16 12 12 8 16" />
                            <path d="M12 12V2" />
                            <polyline points="18 8 12 2 6 8" />
                        </svg>
                    </div>
                    <h3>Ship with Speed</h3>
                    <p>We move fast without breaking things. Weekly releases, continuous improvement, and a bias for action.
                    </p>
                </div>
                <div class="value-card glass-card fade-up">
                    <div class="value-icon" style="--icon-color: #00B894;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <h3>Radical Transparency</h3>
                    <p>Open pricing, honest communication, and no vendor lock-in. Trust is earned through transparency.</p>
                </div>
                <div class="value-card glass-card fade-up">
                    <div class="value-icon" style="--icon-color: #FDCB6E;">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" />
                        </svg>
                    </div>
                    <h3>Innovate Boldly</h3>
                    <p>We push boundaries in AI research while keeping our product grounded in practical value for
                        businesses.</p>
                </div>
            </div>
        </div>
    </section>
@endsection