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
        transition: all 0.2s ease; margin-bottom: 18px;
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
    .policy-section ul { padding-left: 1.25rem; margin-top: 8px; }
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
    hr.policy-divider { border: none; border-top: 1px solid #eee; margin: 1.5rem 0; }
</style>

<div class="policy-header">
    <div class="container">
        <a href="{{ url('/') }}" class="back-btn"><i class="bi bi-arrow-left"></i> Back to Home</a>
        <div class="policy-badge"><i class="bi bi-file-earmark-text-fill"></i> Terms & Conditions</div>
        <h1>Terms &amp; Conditions</h1>
        <p>Please read these terms carefully before using the CaterConnect platform.</p>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="policy-card">

                <div class="toc">
                    <h6><i class="bi bi-list-ul me-1"></i> Table of Contents</h6>
                    <a href="#tc-1">1. Acceptance of Terms</a>
                    <a href="#tc-2">2. User Eligibility</a>
                    <a href="#tc-3">3. Account Responsibilities</a>
                    <a href="#tc-4">4. Booking and Service Agreements</a>
                    <a href="#tc-5">5. Payments and Downpayment Policy</a>
                    <a href="#tc-6">6. Prohibited User Conduct</a>
                    <a href="#tc-7">7. Notifications</a>
                    <a href="#tc-8">8. Account Suspension or Termination</a>
                    <a href="#tc-9">9. Changes to the Terms</a>
                    <a href="#tc-10">10. Governing Law</a>
                </div>

                <p style="font-size:0.92rem;color:#555;line-height:1.75;margin-bottom:1.5rem;">
                    These Terms and Conditions govern the use of the CaterConnect platform — an online marketplace that connects customers with verified catering service providers. By creating an account or using CaterConnect, you agree to comply with and be legally bound by the following terms.
                </p>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-1">
                    <h2>1. Acceptance of Terms</h2>
                    <p>By accessing or registering on CaterConnect, you unconditionally accept and agree to be bound by these Terms and Conditions in their entirety. If you do not agree with any part of these terms, you must immediately cease using the platform.</p>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-2">
                    <h2>2. User Eligibility</h2>
                    <ul>
                        <li>You must be at least <strong>18 years old</strong> to register and use CaterConnect.</li>
                        <li>You must provide accurate, truthful, and complete registration information.</li>
                        <li>You must use the platform for lawful purposes only.</li>
                        <li>CaterConnect reserves the right to suspend or terminate accounts that violate these requirements.</li>
                    </ul>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-3">
                    <h2>3. Account Responsibilities</h2>
                    <ul>
                        <li>Maintain the confidentiality of your username and password at all times.</li>
                        <li>Keep your account information accurate and up to date.</li>
                        <li>You are responsible for all activities conducted through your account, whether or not performed by you personally.</li>
                        <li>Report any suspected unauthorized access to your account to CaterConnect administration immediately.</li>
                        <li>Each individual may maintain only one standard user account. Multiple accounts per person are prohibited.</li>
                    </ul>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-4">
                    <h2>4. Booking and Service Agreements</h2>
                    <p>CaterConnect allows users to browse and book catering services offered by independent catering providers. By making a booking, you agree to:</p>
                    <ul>
                        <li>Provide accurate event details including event date, time, location, estimated guest count, and dietary requirements.</li>
                        <li>Respect the agreed schedule, pricing, and service conditions set by the caterer.</li>
                        <li>Communicate clearly and professionally with the catering provider through the platform.</li>
                    </ul>
                    <p>CaterConnect acts only as a marketplace facilitator and is not directly responsible for the catering services provided by individual caterers.</p>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-5">
                    <h2>5. Payments and Downpayment Policy</h2>
                    <ul>
                        <li>A <strong>50% downpayment</strong> is required to confirm a booking after caterer approval.</li>
                        <li>The downpayment deadline is set by the caterer and must be at minimum <strong>7 days before the event date</strong>.</li>
                        <li>All payments must be processed exclusively through the CaterConnect platform's payment system.</li>
                        <li>Failure to complete the downpayment by the set deadline will result in <strong>automatic booking cancellation</strong>.</li>
                        <li>Cash payments and off-platform transactions are not accepted and carry no protection under this policy.</li>
                        <li>Refunds are subject to the platform's Cancellation and Refund Policy.</li>
                    </ul>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-6">
                    <h2>6. Prohibited User Conduct</h2>
                    <p>You agree not to:</p>
                    <ul>
                        <li>Create fake, duplicate, or impersonating user accounts.</li>
                        <li>Submit false, misleading, or fabricated reviews or booking information.</li>
                        <li>Use the platform for fraudulent, illegal, or unauthorized purposes.</li>
                        <li>Harass, abuse, or threaten catering providers or other users.</li>
                        <li>Attempt to transact with other users outside the CaterConnect platform after initial contact was made through the system.</li>
                        <li>Upload or distribute malicious software, viruses, or harmful code.</li>
                    </ul>
                    <p>Violations may result in account suspension or permanent ban.</p>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-7">
                    <h2>7. Notifications</h2>
                    <p>All platform notifications — including booking updates, downpayment deadlines, and system announcements — are delivered exclusively through the in-platform notification system. Users are responsible for regularly checking their notification panel. CaterConnect shall not be held liable for missed deadlines arising from failure to monitor in-platform notifications.</p>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-8">
                    <h2>8. Account Suspension or Termination</h2>
                    <ul>
                        <li>CaterConnect may suspend or terminate accounts if fraudulent or misleading information is provided.</li>
                        <li>Violations of platform policies may result in immediate account suspension.</li>
                        <li>Detected abuse of the system, including manipulated reviews or unauthorized transactions, will result in account termination.</li>
                    </ul>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-9">
                    <h2>9. Changes to the Terms</h2>
                    <p>CaterConnect reserves the right to update these Terms and Conditions at any time. Continued use of the platform after updates constitutes acceptance of the revised terms. All updates will be communicated via the in-platform notification system.</p>
                </div>

                <hr class="policy-divider">

                <div class="policy-section" id="tc-10">
                    <h2>10. Governing Law</h2>
                    <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of the <strong>Republic of the Philippines</strong>. Any disputes arising under or in connection with these terms shall be subject to the exclusive jurisdiction of the appropriate courts of the Philippines.</p>
                </div>

                <div style="margin-top:2rem;padding:1rem 1.25rem;background:rgba(255,122,0,0.06);border-left:4px solid var(--primary-orange);border-radius:0 10px 10px 0;font-size:0.82rem;color:#555;">
                    <i class="bi bi-info-circle-fill" style="color:var(--primary-orange);"></i>
                    For questions or concerns about these Terms and Conditions, please contact us through the platform's official support channel.
                </div>

            </div>
        </div>
    </div>
</div>
@endsection