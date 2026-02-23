@extends('layouts.app')

@section('title', 'Contact — NexusAI')
@section('description', 'Get in touch with the NexusAI team. We\'d love to hear from you — whether it\'s a question, feedback, or a partnership inquiry.')

@section('content')
    <section class="page-hero">
        <div class="container">
            <span class="section-label fade-up">Contact</span>
            <h1 class="page-hero-title fade-up">Let's <span class="gradient-text">Talk</span></h1>
            <p class="page-hero-subtitle fade-up">Have a question, partnership inquiry, or just want to say hello? We'd love
                to hear from you.</p>
        </div>
    </section>

    <section class="section contact-section">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-form-wrapper glass-card fade-up">
                    <h2>Send Us a Message</h2>
                    <form class="contact-form" id="contactForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="john@company.com" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select a topic</option>
                                <option value="general">General Inquiry</option>
                                <option value="sales">Sales & Pricing</option>
                                <option value="support">Technical Support</option>
                                <option value="partnership">Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Tell us how we can help..."
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" id="contactSubmit">
                            Send Message
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13" />
                                <polygon points="22 2 15 22 11 13 2 9 22 2" />
                            </svg>
                        </button>
                    </form>
                    <div class="form-success" id="formSuccess" style="display: none;">
                        <div class="success-icon">✓</div>
                        <h3>Message Sent!</h3>
                        <p>Thank you for reaching out. We'll get back to you within 24 hours.</p>
                    </div>
                </div>

                <div class="contact-info fade-up">
                    <div class="contact-info-card glass-card">
                        <div class="contact-info-icon" style="--icon-color: #6C5CE7;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                        <h3>Email Us</h3>
                        <p>hello@nexusai.com</p>
                        <span class="contact-response">Response within 24 hours</span>
                    </div>
                    <div class="contact-info-card glass-card">
                        <div class="contact-info-icon" style="--icon-color: #00D2FF;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <h3>Visit Us</h3>
                        <p>100 AI Boulevard, Suite 500<br>San Francisco, CA 94105</p>
                    </div>
                    <div class="contact-info-card glass-card">
                        <div class="contact-info-icon" style="--icon-color: #00B894;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </div>
                        <h3>Call Us</h3>
                        <p>+1 (555) 123-4567</p>
                        <span class="contact-response">Mon–Fri, 9 AM – 6 PM EST</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection