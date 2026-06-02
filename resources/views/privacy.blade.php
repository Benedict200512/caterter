@extends('layouts.app')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-orange: #FF7A00;
        --deep-charcoal: #1a1a1a;
        --light-gray: #f5f5f5;
    }
    .policy-header {
        background: linear-gradient(135deg, var(--deep-charcoal) 0%, #2a2a2a 100%);
        color: white; padding: 60px 0; margin-bottom: 40px; position: relative; overflow: hidden;
    }
    .policy-header::before {
        content: ''; position: absolute; top: 0; right: -100px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,122,0,0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .policy-header h1 {
        font-family: 'Montserrat', sans-serif; font-weight: 900;
        font-size: clamp(1.8rem, 4vw, 2.8rem); margin-bottom: 8px;
    }
    .policy-header p { font-size: 0.95rem; opacity: 0.8; margin: 0; }
    .back-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px; border-radius: 999px;
        background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2);
        color: white; text-decoration: none; font-size: 0.78rem;
        font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        transition: all 0.2s ease; margin-bottom: 18px; display: inline-flex;
    }
    .back-btn:hover { background: rgba(255,255,255,0.22); color: white; }
    .policy-card {
        background: white; border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        padding: clamp(1.5rem, 4vw, 3rem); margin-bottom: 40px;
    }
    .policy-section { margin-bottom: 2rem; }
    .policy-section h2 {
        font-family: 'Montserrat', sans-serif; font-weight: 800;
        font-size: 1rem; text-transform: uppercase; letter-spacing: 0.5px;
        color: var(--primary-orange); margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .policy-section h2::before {
        content: ''; width: 4px; height: 18px;
        background: var(--primary-orange); border-radius: 2px; flex-shrink: 0;
    }
    .policy-section p, .policy-section li {
        font-size: 0.92rem; color: #444; line-height: 1.75;
    }
    .policy-section ul {
        padding-left: 1.25rem; margin-top: 8px;
    }
    .policy-section ul li { margin-bottom: 6px; }
    .policy-section ul li::marker { color: var(--primary-orange); }
    .policy-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,122,0,0.1); border: 1px solid rgba(255,122,0,0.25);
        border-radius: 50px; padding: 5px 14px;
        font-size: 0.68rem; font-weight: 800; text-transform: uppercase;
        letter-spacing: 1px; color: var(--primary-orange); margin-bottom: 12px;
    }
    .toc {
        background: var(--light-gray); border-radius: 14px;
        padding: 1.25rem 1.5rem; margin-bottom: 2rem;
    }
    .toc h6 {
        font-family: 'Montserrat', sans-serif; font-weight: 800;
        font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px;
        color: var(--deep-charcoal); margin-bottom: 10px;
    }
    .toc a {
        display: block; font-size: 0.83rem; color: #555;
        text-decoration: none; padding: 3px 0; font-weight: 500;
        transition: color 0.2s;
    }
    .toc a:hover { color: var(--primary-orange); }
    .toc a::before { content: '→ '; color: var(--primary-orange); }
    hr.policy-divider {
        border: none; border-top: 1px solid #eee; margin: 1.5rem 0;
    }
</style>

<div class="policy-header">
    <div class="container">
        <a href="{{ url('/') }}" class="back-btn"><i class="bi bi-arrow-left"></i> Back to Home</a>
        <div class="policy-badge"><i class="bi bi-shield-lock-fill"></i> Privacy Policy</div>
        <h1>Privacy Policy</h1>
        <p>How CaterConnect collects, uses, and protects your personal information.</p>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="policy-card">

                <div class="toc">
                    <h6><i class="bi bi-list-ul me-1"></i> Table of Contents</h6>
                    <a href="#pp-1">1. Information We Collect</a>
                    <a href="#pp-2">2. Purpose of Data Collection</a>
                    <a href="#pp-3">3. Data Security</a>
                    <a href="#pp-4">4. Use of Information by Catering Providers</a>
                    <a href="#pp-5">5. Data Sharing</a>
                    <a href="#pp-6">6. Data Retention</a>
                    <a href="#pp-7">7. Your Rights</a>
                    <a href="#pp-8">8. Updates to this Policy</a>
                </div>

                <p style="font-size:0.92rem;color:#555;line-height:1.75;margin-bottom:1.5rem;">
                    CaterConnect values the privacy of its users. This Privacy Policy explains how personal information is collected, used, stored, and protected when using the platform. By registering, you acknowledge and consent to the practices described herein.
                </p>

                <hr class="policy-divider">

                <div class="policy-section" id="pp-1">
                    <h2>1. Information We Collect</h2>
                    <p>When users register or use the platform, CaterConnect collects the following information:</p>
                    <ul>
                        <li><strong>Full Name</strong> — for account identification and booking records.</li>
                        <li><strong>Email Address</strong> — for account credential and identity reference.</li>
                        <li><strong>Date of Birth</strong> — for age verification (must be 18 years or older).</li>
                        <li><strong>Address</strong> — for location-based caterer matching and service area reference.</li>
                        <li><strong>Mobile Number</strong> — for account security and identity reference.</li>
                        <li><strong>Username</strong> — unique platform display name.</li>
                        <li><strong>Password</strong> — stored in encrypted form only (bcrypt hashing); never stored in plain text.</li>
                        <li><strong>Booking Details</strong> — event date, time, location, guest count, and selected catering services.</li>
                    </ul>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="pp-2">
                    <h2>2. Purpose of Data Collection</h2>
                    <ul>
                        <li>To create and manage your user account on the platform.</li>
                        <li>To verify user identity and confirm age eligibility (18 years and above).</li>
                        <li>To facilitate catering service bookings between customers and caterers.</li>
                        <li>To deliver in-platform notifications including booking updates and system announcements.</li>
                        <li>To ensure platform security, detect fraud, and prevent unauthorized access.</li>
                        <li>To improve platform functionality and user experience.</li>
                    </ul>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="pp-3">
                    <h2>3. Data Security</h2>
                    <p>CaterConnect implements the following security measures to protect your personal data:</p>
                    <ul>
                        <li>Password encryption using <strong>bcrypt hashing</strong> — passwords are never stored or transmitted in plain text.</li>
                        <li><strong>TLS (Transport Layer Security)</strong> encryption for all data transmitted between users and the platform.</li>
                        <li><strong>AES-256 encryption</strong> for sensitive data stored in the database.</li>
                        <li>Restricted administrative access — only authorized personnel may access sensitive user information.</li>
                        <li>Regular system backups stored in encrypted, secure repositories.</li>
                    </ul>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="pp-4">
                    <h2>4. Use of Information by Catering Providers</h2>
                    <p>Some information may be visible to catering providers solely to facilitate confirmed bookings, including:</p>
                    <ul>
                        <li>User name and contact details (as provided during booking).</li>
                        <li>Event details including date, location, and guest count.</li>
                    </ul>
                    <p>Sensitive information such as passwords, date of birth, and full address will never be publicly displayed or shared with caterers beyond what is necessary for service delivery.</p>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="pp-5">
                    <h2>5. Data Sharing</h2>
                    <p>CaterConnect does not sell, rent, or trade personal information to third parties. User data may only be shared in the following circumstances:</p>
                    <ul>
                        <li>When necessary to complete a confirmed catering service booking.</li>
                        <li>When required by law or by lawful order of legal authorities.</li>
                    </ul>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="pp-6">
                    <h2>6. Data Retention</h2>
                    <p>User information is stored securely while your account remains active on the platform. Users may request account deletion and data removal by contacting CaterConnect administration through the platform's official support channel. Certain data may be retained for legal compliance or dispute resolution purposes even after account deletion.</p>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="pp-7">
                    <h2>7. Your Rights</h2>
                    <ul>
                        <li><strong>Right to Access</strong> — you may request a copy of your personal data held by CaterConnect.</li>
                        <li><strong>Right to Correction</strong> — you may request correction of inaccurate or incomplete personal data.</li>
                        <li><strong>Right to Deletion</strong> — you may request deletion of your account and associated personal data.</li>
                    </ul>
                    <p>These rights are exercised in accordance with <strong>Republic Act No. 10173 (Data Privacy Act of 2012)</strong> of the Philippines.</p>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="pp-8">
                    <h2>8. Updates to this Policy</h2>
                    <p>CaterConnect may update this Privacy Policy periodically to improve security practices and comply with applicable laws. Users will be notified of significant changes through the in-platform notification system.</p>
                </div>

                <div style="margin-top:2rem;padding:1rem 1.25rem;background:rgba(255,122,0,0.06);border-left:4px solid var(--primary-orange);border-radius:0 10px 10px 0;font-size:0.82rem;color:#555;">
                    <i class="bi bi-info-circle-fill" style="color:var(--primary-orange);"></i>
                    For questions or concerns about this Privacy Policy, please contact us through the platform's official support channel.
                </div>

            </div>
        </div>
    </div>
</div>
@endsection