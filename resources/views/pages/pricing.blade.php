@extends('layouts.app')

@section('title', 'Pricing — NexusAI')
@section('description', 'Simple, transparent pricing for NexusAI. Start free and scale as you grow.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="section-label fade-up">Pricing</span>
            <h1 class="page-hero-title fade-up">Simple, Transparent<br><span class="gradient-text">Pricing</span></h1>
            <p class="page-hero-subtitle fade-up">Start free, upgrade as you grow. No hidden fees, no surprises.</p>
        </div>
    </section>

    <section class="section pricing-section">
        <div class="container">
            <div class="pricing-grid">
                {{-- Starter --}}
                <div class="pricing-card glass-card fade-up">
                    <div class="pricing-header">
                        <span class="pricing-plan-name">Starter</span>
                        <div class="pricing-amount">
                            <span class="pricing-currency">$</span>
                            <span class="pricing-value">0</span>
                            <span class="pricing-period">/month</span>
                        </div>
                        <p class="pricing-desc">Perfect for exploring and small projects.</p>
                    </div>
                    <ul class="pricing-features">
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            1,000 messages / month
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            1 chatbot
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Website widget
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Basic analytics
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Community support
                        </li>
                        <li class="disabled">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                            Custom branding
                        </li>
                        <li class="disabled">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                            API access
                        </li>
                    </ul>
                    <a href="{{ route('demo') }}" class="btn btn-outline btn-block">Get Started Free</a>
                </div>

                {{-- Pro (Featured) --}}
                <div class="pricing-card pricing-featured glass-card fade-up">
                    <div class="pricing-badge">Most Popular</div>
                    <div class="pricing-header">
                        <span class="pricing-plan-name">Pro</span>
                        <div class="pricing-amount">
                            <span class="pricing-currency">$</span>
                            <span class="pricing-value">49</span>
                            <span class="pricing-period">/month</span>
                        </div>
                        <p class="pricing-desc">Best for growing businesses.</p>
                    </div>
                    <ul class="pricing-features">
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            50,000 messages / month
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            5 chatbots
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            All channels (web, WhatsApp, Slack…)
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Advanced analytics & reports
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Custom branding
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            REST API access
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Priority email support
                        </li>
                    </ul>
                    <a href="{{ route('demo') }}" class="btn btn-primary btn-block">Start 14-Day Trial</a>
                </div>

                {{-- Enterprise --}}
                <div class="pricing-card glass-card fade-up">
                    <div class="pricing-header">
                        <span class="pricing-plan-name">Enterprise</span>
                        <div class="pricing-amount">
                            <span class="pricing-value" style="font-size: 2.2rem;">Custom</span>
                        </div>
                        <p class="pricing-desc">Tailored for large organizations.</p>
                    </div>
                    <ul class="pricing-features">
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Unlimited messages
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Unlimited chatbots
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            All channels + custom integrations
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            Dedicated account manager
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            99.99% SLA guarantee
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            SSO & advanced security
                        </li>
                        <li>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00B894" stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                            24/7 phone & chat support
                        </li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-outline btn-block">Contact Sales</a>
                </div>
            </div>

            {{-- FAQ --}}
            <div class="pricing-faq fade-up">
                <h2 class="section-title">Frequently Asked <span class="gradient-text">Questions</span></h2>
                <div class="faq-grid">
                    <div class="faq-item glass-card">
                        <h3>Can I switch plans anytime?</h3>
                        <p>Absolutely! Upgrade or downgrade your plan at any time. Changes take effect at the start of your
                            next billing cycle.</p>
                    </div>
                    <div class="faq-item glass-card">
                        <h3>What happens if I exceed my message limit?</h3>
                        <p>We'll notify you when you reach 80% of your limit. You can upgrade your plan or purchase
                            additional messages ($0.002/message).</p>
                    </div>
                    <div class="faq-item glass-card">
                        <h3>Is the free plan really free?</h3>
                        <p>Yes! No credit card required. The Starter plan is free forever with 1,000 messages per month.
                            Perfect for personal projects and testing.</p>
                    </div>
                    <div class="faq-item glass-card">
                        <h3>Do you offer annual billing?</h3>
                        <p>Yes, annual billing saves you 20%. That brings the Pro plan down to just $39/month when billed
                            annually.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection