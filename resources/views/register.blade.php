@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-orange: #FF7A00;
        --orange-light: #ff9f2f;
        --deep-charcoal: #1a1a1a;
        --charcoal-light: #2c2c2c;
        --pure-white: #ffffff;
        --light-gray: #f5f5f5;
        --error-red: #e74c3c;
        --success-green: #27ae60;
        --border-gray: #e0e0e0;
        --warning-orange: #f39c12;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { width: 100%; overflow-x: hidden; }
    #app, main { padding: 0 !important; margin: 0 !important; width: 100%; }
    body { font-family: 'Inter', sans-serif; }

    @keyframes slideInUp { from { opacity:0; transform:translateY(20px);} to { opacity:1; transform:translateY(0);} }
    @keyframes slideInLeft { from { opacity:0; transform:translateX(-20px);} to { opacity:1; transform:translateX(0);} }
    @keyframes fadeInStagger { from { opacity:0; transform:translateY(10px);} to { opacity:1; transform:translateY(0);} }
    @keyframes checkmark { 0%{transform:scale(0);} 50%{transform:scale(1.2);} 100%{transform:scale(1);} }
    @keyframes spin { to { transform:rotate(360deg); } }

    .register-page-wrapper {
        background: linear-gradient(135deg, var(--deep-charcoal) 0%, var(--charcoal-light) 100%);
        min-height: 100vh; width: 100%;
        display: flex; align-items: center; justify-content: center;
        padding: 30px 20px; position: relative; overflow: hidden;
    }
    .register-page-wrapper::before {
        content: ''; position: absolute; width: 200%; height: 200%; top: -50%; left: -50%;
        background: radial-gradient(circle at 20% 50%, rgba(255,122,0,0.10) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255,159,47,0.08) 0%, transparent 50%);
        pointer-events: none;
    }
    .register-container {
        width: 100%; max-width: 980px; background: var(--pure-white);
        border-radius: 24px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        animation: slideInUp 0.6s ease-out; position: relative; z-index: 1;
    }
    .register-wrapper { display: grid; grid-template-columns: 1fr 1.15fr; min-height: auto; }

    /* LEFT PANEL */
    .register-image-section {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: center;
        padding: 50px 45px; color: white; min-height: 580px;
    }
    .register-image-section::before {
        content: ''; position: absolute; inset: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="dots" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="1200" height="600" fill="url(%23dots)"/></svg>');
        pointer-events: none;
    }
    .register-tagline-content { position: relative; z-index: 2; animation: slideInLeft 0.8s ease-out; }
    .register-tagline-icon { font-size: 3rem; margin-bottom: 16px; display: inline-block; }
    .register-tagline-title { font-family: 'Montserrat', sans-serif; font-size: 2.2rem; font-weight: 900; line-height: 1.2; margin-bottom: 14px; text-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .register-tagline-text { font-size: 0.95rem; opacity: 0.95; line-height: 1.6; margin-bottom: 32px; font-weight: 400; }

    .register-steps { display: flex; flex-direction: column; gap: 14px; }
    .register-step { display: flex; align-items: flex-start; gap: 12px; animation: fadeInStagger 0.6s ease-out backwards; }
    .register-step:nth-child(1) { animation-delay: 0.2s; }
    .register-step:nth-child(2) { animation-delay: 0.35s; }
    .register-step:nth-child(3) { animation-delay: 0.5s; }
    .register-step:nth-child(4) { animation-delay: 0.65s; }
    .step-num { width: 26px; height: 26px; border-radius: 50%; background: rgba(255,255,255,0.25); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; font-family: 'Montserrat', sans-serif; flex-shrink: 0; margin-top: 1px; }
    .step-info { display: flex; flex-direction: column; gap: 2px; }
    .step-label { font-weight: 700; font-size: 0.88rem; line-height: 1.3; }
    .step-desc  { font-size: 0.75rem; opacity: 0.8; font-weight: 400; }

    /* RIGHT FORM */
    .register-form-section {
        padding: 38px 46px; display: flex; flex-direction: column;
        background: var(--pure-white); animation: slideInUp 0.6s ease-out 0.1s backwards;
        max-height: 95vh; overflow-y: auto;
    }
    .register-form-section::-webkit-scrollbar { width: 4px; }
    .register-form-section::-webkit-scrollbar-track { background: #f1f1f1; }
    .register-form-section::-webkit-scrollbar-thumb { background: var(--primary-orange); border-radius: 4px; }

    .register-form-header { margin-bottom: 22px; animation: slideInUp 0.6s ease-out 0.2s backwards; }
    .register-form-title { font-family: 'Montserrat', sans-serif; font-size: 1.95rem; font-weight: 900; color: var(--deep-charcoal); margin-bottom: 5px; letter-spacing: -0.5px; }
    .register-form-title-accent { color: var(--primary-orange); background: linear-gradient(135deg, var(--primary-orange), var(--orange-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .register-form-subtitle { font-size: 0.83rem; color: #888; font-weight: 400; }

    .form-section-label { font-family: 'Montserrat', sans-serif; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: var(--primary-orange); margin: 20px 0 14px 0; display: flex; align-items: center; gap: 10px; }
    .form-section-label::after { content: ''; flex: 1; height: 1px; background: linear-gradient(to right, rgba(255,122,0,0.3), transparent); }
    .form-section-label i { font-size: 0.85rem; }

    .alert-error { display: flex; gap: 12px; padding: 12px 16px; background: #fef2f2; border-left: 4px solid var(--error-red); border-radius: 10px; margin-bottom: 18px; animation: slideInUp 0.4s ease-out; }
    .alert-error i { color: var(--error-red); font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
    .alert-error-message { font-size: 0.8rem; color: #c5453f; padding: 2px 0; }
    .alert-error-message:first-child { font-weight: 700; color: var(--error-red); margin-bottom: 4px; }

    .form-group { margin-bottom: 16px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .form-label { display: block; font-family: 'Montserrat', sans-serif; font-size: 0.67rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.4px; margin-bottom: 7px; color: var(--deep-charcoal); }
    .form-label.required::after { content: ' *'; color: var(--error-red); }
    .form-input-wrapper { position: relative; }

    .form-control-custom { width: 100%; background: var(--light-gray); border: 2px solid transparent; border-radius: 12px; padding: 12px 16px; font-size: 0.92rem; transition: all 0.3s ease-out; font-family: 'Inter', sans-serif; color: var(--deep-charcoal); appearance: none; -webkit-appearance: none; }
    .form-control-custom::placeholder { color: #bbb; }
    .form-control-custom:focus { outline: none; background: var(--pure-white); border-color: var(--primary-orange); box-shadow: 0 6px 20px rgba(255,122,0,0.12); transform: translateY(-1px); }
    .form-control-custom.error  { border-color: var(--error-red);    background: #fff5f5; }
    .form-control-custom.success{ border-color: var(--success-green); background: #f0fdf4; }

    input[type="date"].form-control-custom::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.5; filter: invert(50%); }
    input[type="date"].form-control-custom::-webkit-calendar-picker-indicator:hover { opacity: 0.9; }

    .field-validation { font-size: 0.7rem; margin-top: 5px; display: none; align-items: center; gap: 4px; }
    .field-validation.error   { display: flex; color: var(--error-red); }
    .field-validation.success { display: flex; color: var(--success-green); }
    .field-validation i { font-size: 0.8rem; }

    .age-notice { font-size: 0.68rem; color: #999; margin-top: 5px; display: flex; align-items: center; gap: 5px; }
    .age-notice i { color: var(--primary-orange); font-size: 0.7rem; }

    .password-toggle-btn { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #999; cursor: pointer; font-size: 1rem; transition: color 0.3s; padding: 4px; }
    .password-toggle-btn:hover { color: var(--primary-orange); }
    .has-toggle { padding-right: 42px !important; }

    .password-strength { display: flex; align-items: center; gap: 8px; margin-top: 6px; font-size: 0.7rem; font-weight: 600; }
    .strength-bars { display: flex; gap: 3px; }
    .strength-bar  { width: 28px; height: 4px; background: #e0e0e0; border-radius: 2px; transition: background 0.3s; }
    .strength-bar.weak   { background: var(--error-red); }
    .strength-bar.medium { background: var(--warning-orange); }
    .strength-bar.strong { background: var(--success-green); }

    .password-requirements { background: #f9f9f9; border: 1px solid var(--border-gray); border-radius: 10px; padding: 12px 14px; margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 6px 12px; }
    .requirement { display: flex; align-items: center; gap: 7px; font-size: 0.72rem; color: #888; line-height: 1.3; }
    .requirement i { font-size: 0.75rem; min-width: 13px; }
    .requirement.met { color: var(--success-green); }
    .requirement.met i { color: var(--success-green); }

    .password-match-indicator { display: flex; align-items: center; gap: 6px; margin-top: 5px; font-size: 0.7rem; font-weight: 600; }
    .match-icon { display: inline-flex; align-items: center; justify-content: center; width: 14px; height: 14px; border-radius: 50%; font-size: 0.55rem; }
    .match-icon.match    { background: var(--success-green); color: white; animation: checkmark 0.3s ease-out; }
    .match-icon.no-match { background: var(--error-red); color: white; }

    .terms-agreement-section { margin: 18px 0; padding: 15px 16px; background: #f9f9f9; border-left: 4px solid var(--primary-orange); border-radius: 10px; }
    .agreement-checkbox { display: flex; align-items: flex-start; gap: 10px; cursor: pointer; margin-bottom: 10px; }
    .agreement-checkbox:last-of-type { margin-bottom: 0; }
    .agreement-checkbox input { margin-top: 3px; cursor: pointer; width: 16px; height: 16px; accent-color: var(--primary-orange); flex-shrink: 0; }
    .agreement-text { font-size: 0.78rem; color: #555; line-height: 1.45; }
    .agreement-text a { color: var(--primary-orange); text-decoration: none; font-weight: 600; transition: opacity 0.3s; }
    .agreement-text a:hover { opacity: 0.8; text-decoration: underline; }
    .agreement-error { color: var(--error-red); font-size: 0.73rem; display: none; margin-top: 8px; font-weight: 600; }
    .agreement-error.show { display: block; }

    .btn-register { width: 100%; background: linear-gradient(135deg, var(--primary-orange), var(--orange-light)); color: white; border: none; border-radius: 12px; padding: 14px; font-size: 0.92rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; cursor: pointer; margin-top: 18px; transition: all 0.3s ease-out; font-family: 'Montserrat', sans-serif; box-shadow: 0 8px 25px rgba(255,122,0,0.25); position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-register::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s; }
    .btn-register:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(255,122,0,0.35); }
    .btn-register:hover:not(:disabled)::before { left: 100%; }
    .btn-register:disabled { opacity: 0.75; cursor: not-allowed; }
    .btn-register.loading i { display: none; }
    .btn-spinner { display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.35); border-top-color: white; border-radius: 50%; animation: spin 0.8s linear infinite; }
    .btn-register.loading .btn-spinner { display: inline-block; }

    .security-badge { display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 0.73rem; color: var(--success-green); font-weight: 600; margin-top: 14px; padding: 9px; background: #f0fdf4; border-radius: 10px; border: 1px solid rgba(39,174,96,0.2); }

    .login-redirect-section { text-align: center; margin-top: 18px; padding-top: 18px; border-top: 1px solid var(--border-gray); }
    .login-redirect-text { font-size: 0.83rem; color: #666; margin-bottom: 5px; }
    .login-link { color: var(--primary-orange); text-decoration: none; font-weight: 700; font-size: 0.88rem; transition: all 0.3s; position: relative; }
    .login-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: var(--primary-orange); transition: width 0.3s; }
    .login-link:hover::after { width: 100%; }

    .footer-links { display: flex; justify-content: center; gap: 30px; padding: 18px; border-top: 1px solid var(--border-gray); background: var(--light-gray); font-size: 0.78rem; }
    .footer-links a { color: #666; text-decoration: none; font-weight: 600; transition: color 0.3s; }
    .footer-links a:hover { color: var(--primary-orange); }

    /* ===== MODAL ===== */
    .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); }
    .modal.active { display: flex; align-items: center; justify-content: center; }
    .modal-content { background: var(--pure-white); padding: 0; border-radius: 20px; max-width: 720px; width: 92%; max-height: 85vh; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 25px 70px rgba(0,0,0,0.45); animation: slideInUp 0.3s ease-out; }

    /* Modal Header */
    .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 22px 30px 18px 30px; border-bottom: 2px solid var(--border-gray); flex-shrink: 0; }
    .modal-header-left { display: flex; align-items: center; gap: 12px; }
    .modal-header-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, var(--primary-orange), var(--orange-light)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; flex-shrink: 0; }
    .modal-header h2 { font-family: 'Montserrat', sans-serif; font-size: 1.35rem; font-weight: 900; color: var(--deep-charcoal); margin: 0; }
    .modal-header-sub { font-size: 0.72rem; color: #999; font-weight: 400; margin-top: 2px; }
    .modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #bbb; padding: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; }
    .modal-close:hover { color: var(--error-red); background: #fff0f0; }

    /* Modal Body */
    .modal-body { overflow-y: auto; padding: 24px 30px 30px 30px; flex: 1; }
    .modal-body::-webkit-scrollbar { width: 4px; }
    .modal-body::-webkit-scrollbar-track { background: #f5f5f5; }
    .modal-body::-webkit-scrollbar-thumb { background: var(--primary-orange); border-radius: 4px; }

    .modal-effective-date { display: inline-flex; align-items: center; gap: 6px; background: #fff8f0; border: 1px solid rgba(255,122,0,0.2); border-radius: 8px; padding: 6px 12px; font-size: 0.72rem; color: var(--primary-orange); font-weight: 700; margin-bottom: 18px; }

    /* Policy section heading */
    .policy-section { margin-bottom: 22px; }
    .policy-section-title { font-family: 'Montserrat', sans-serif; font-size: 0.82rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: var(--deep-charcoal); margin-bottom: 10px; padding-bottom: 7px; border-bottom: 2px solid var(--primary-orange); display: flex; align-items: center; gap: 8px; }
    .policy-section-title i { color: var(--primary-orange); font-size: 0.9rem; }
    .policy-text { font-size: 0.84rem; color: #444; line-height: 1.75; margin-bottom: 10px; }
    .policy-list { list-style: none; padding: 0; margin: 8px 0; }
    .policy-list li { font-size: 0.84rem; color: #444; line-height: 1.7; padding: 5px 0 5px 20px; position: relative; border-bottom: 1px solid #f5f5f5; }
    .policy-list li:last-child { border-bottom: none; }
    .policy-list li::before { content: ''; position: absolute; left: 0; top: 13px; width: 7px; height: 7px; border-radius: 50%; background: var(--primary-orange); flex-shrink: 0; }
    .policy-highlight { background: #fff8f0; border-left: 3px solid var(--primary-orange); border-radius: 0 8px 8px 0; padding: 10px 14px; font-size: 0.82rem; color: #555; line-height: 1.65; margin: 10px 0; }
    .policy-highlight strong { color: var(--deep-charcoal); }

    /* Modal Footer */
    .modal-footer { padding: 16px 30px; border-top: 1px solid var(--border-gray); background: #fafafa; flex-shrink: 0; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .modal-footer-note { font-size: 0.72rem; color: #999; }
    .modal-footer-note i { color: var(--primary-orange); }
    .btn-modal-close { background: linear-gradient(135deg, var(--primary-orange), var(--orange-light)); color: white; border: none; border-radius: 10px; padding: 9px 22px; font-size: 0.82rem; font-weight: 700; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: all 0.2s; }
    .btn-modal-close:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,122,0,0.3); }

    @media (max-width: 1024px) { .register-wrapper { grid-template-columns: 1fr; } .register-image-section { display: none; } .register-container { max-width: 500px; } .register-form-section { padding: 35px 32px; max-height: none; } }
    @media (max-width: 600px) { .register-page-wrapper { padding: 16px; } .register-form-section { padding: 28px 20px; } .register-form-title { font-size: 1.7rem; } .form-row { grid-template-columns: 1fr; } .password-requirements { grid-template-columns: 1fr; } .footer-links { gap: 14px; flex-wrap: wrap; } .modal-content { width: 96%; } .modal-header, .modal-body, .modal-footer { padding-left: 18px; padding-right: 18px; } }
</style>

<div class="register-page-wrapper">
    <div class="register-container">
        <div class="register-wrapper">

            {{-- LEFT PANEL --}}
            <div class="register-image-section">
                <div class="register-tagline-content">
                    <i class="bi bi-person-plus-fill register-tagline-icon"></i>
                    <h2 class="register-tagline-title">Join<br>CaterConnect</h2>
                    <p class="register-tagline-text">Start your Cebuano event journey. Access the best local caterers and manage your bookings in one place.</p>
                    <div class="register-steps">
                        <div class="register-step">
                            <div class="step-num">1</div>
                            <div class="step-info"><span class="step-label">Create Your Account</span><span class="step-desc">Fill in your personal details below</span></div>
                        </div>
                        <div class="register-step">
                            <div class="step-num">2</div>
                            <div class="step-info"><span class="step-label">Browse Caterers</span><span class="step-desc">Explore menus, pricing &amp; reviews</span></div>
                        </div>
                        <div class="register-step">
                            <div class="step-num">3</div>
                            <div class="step-info"><span class="step-label">Book Instantly</span><span class="step-desc">Confirm your caterer with a downpayment</span></div>
                        </div>
                        <div class="register-step">
                            <div class="step-num">4</div>
                            <div class="step-info"><span class="step-label">Become a Caterer</span><span class="step-desc">Offer services via your dashboard</span></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT FORM --}}
            <div class="register-form-section">
                <div class="register-form-header">
                    <h1 class="register-form-title">Create <span class="register-form-title-accent">Account</span> 🎉</h1>
                    <p class="register-form-subtitle">Fill in your details to get started — it only takes a minute</p>
                </div>

                @if ($errors->any())
                    <div class="alert-error">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <div class="alert-error-message">Registration failed. Please check the errors below:</div>
                            @foreach ($errors->all() as $error)
                                <div class="alert-error-message">• {{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="POST" id="registerForm">
                    @csrf

                    {{-- SECTION 1: PERSONAL INFORMATION --}}
                    <div class="form-section-label"><i class="bi bi-person-fill"></i> Personal Information</div>

                    <div class="form-group">
                        <label class="form-label required" for="nameInput">Full Name</label>
                        <div class="form-input-wrapper">
                            <input type="text" name="name" id="nameInput"
                                class="form-control-custom @error('name') error @enderror"
                                placeholder="e.g. Benedict Alicante"
                                value="{{ old('name') }}" required autocomplete="name">
                        </div>
                        <div class="field-validation" id="nameValidation"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="emailInput">Email Address</label>
                        <div class="form-input-wrapper">
                            <input type="email" name="email" id="emailInput"
                                class="form-control-custom @error('email') error @enderror"
                                placeholder="e.g. adok@example.com"
                                value="{{ old('email') }}" required autocomplete="email">
                        </div>
                        <div class="field-validation" id="emailValidation"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="dobInput">Date of Birth</label>
                        <div class="form-input-wrapper">
                            <input type="date" name="date_of_birth" id="dobInput"
                                class="form-control-custom @error('date_of_birth') error @enderror"
                                value="{{ old('date_of_birth') }}" required
                                max="{{ now()->subYears(18)->format('Y-m-d') }}">
                        </div>
                        <div class="age-notice"><i class="bi bi-info-circle-fill"></i> You must be at least 18 years old to register.</div>
                        <div class="field-validation" id="dobValidation"></div>
                    </div>

                    {{-- SECTION 2: CONTACT & LOCATION --}}
                    <div class="form-section-label"><i class="bi bi-geo-alt-fill"></i> Contact &amp; Location</div>

                    <div class="form-group">
                        <label class="form-label required" for="addressInput">Address</label>
                        <div class="form-input-wrapper">
                            <input type="text" name="address" id="addressInput"
                                class="form-control-custom @error('address') error @enderror"
                                placeholder="e.g. Brgy. North Poblacion, City of Naga, Cebu"
                                value="{{ old('address') }}" required autocomplete="street-address">
                        </div>
                        <div class="field-validation" id="addressValidation"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="phoneInput">Mobile Number</label>
                        <div class="form-input-wrapper">
                            <input type="tel" name="phone" id="phoneInput"
                                class="form-control-custom @error('phone') error @enderror"
                                placeholder="e.g. 09XX XXX XXXX"
                                value="{{ old('phone') }}" required autocomplete="tel" maxlength="13">
                        </div>
                        <div class="field-validation" id="phoneValidation"></div>
                    </div>

                    {{-- SECTION 3: ACCOUNT CREDENTIALS --}}
                    <div class="form-section-label"><i class="bi bi-shield-lock-fill"></i> Account Credentials</div>

                    <div class="form-group">
                        <label class="form-label required" for="usernameInput">Username</label>
                        <div class="form-input-wrapper">
                            <input type="text" name="username" id="usernameInput"
                                class="form-control-custom @error('username') error @enderror"
                                placeholder="e.g. adok_cater (min. 6 characters)"
                                value="{{ old('username') }}" required autocomplete="username"
                                minlength="6" maxlength="30">
                        </div>
                        <div class="field-validation" id="usernameValidation"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="passwordInput">Password</label>
                        <div class="form-input-wrapper">
                            <input type="password" name="password" id="passwordInput"
                                class="form-control-custom has-toggle @error('password') error @enderror"
                                placeholder="••••••••" required autocomplete="new-password">
                            <button type="button" class="password-toggle-btn" id="passwordToggle" aria-label="Toggle password visibility">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength" id="passwordStrength" style="display:none;">
                            <span class="strength-bars">
                                <div class="strength-bar" id="bar1"></div>
                                <div class="strength-bar" id="bar2"></div>
                                <div class="strength-bar" id="bar3"></div>
                            </span>
                            <span id="strengthText" style="font-size:0.72rem;"></span>
                        </div>
                        <div class="password-requirements">
                            <div class="requirement" id="req-length"><i class="bi bi-circle"></i><span>At least 8 characters</span></div>
                            <div class="requirement" id="req-uppercase"><i class="bi bi-circle"></i><span>One uppercase (A–Z)</span></div>
                            <div class="requirement" id="req-lowercase"><i class="bi bi-circle"></i><span>One lowercase (a–z)</span></div>
                            <div class="requirement" id="req-number"><i class="bi bi-circle"></i><span>One number (0–9)</span></div>
                            <div class="requirement" id="req-special"><i class="bi bi-circle"></i><span>One special character (!@#$%…)</span></div>
                            <div class="requirement" id="req-nospace"><i class="bi bi-circle"></i><span>No blank spaces</span></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="confirmPasswordInput">Confirm Password</label>
                        <div class="form-input-wrapper">
                            <input type="password" name="password_confirmation" id="confirmPasswordInput"
                                class="form-control-custom has-toggle @error('password') error @enderror"
                                placeholder="••••••••" required autocomplete="new-password">
                            <button type="button" class="password-toggle-btn" id="confirmPasswordToggle" aria-label="Toggle confirm password visibility">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="password-match-indicator" id="matchIndicator" style="display:none;">
                            <span class="match-icon" id="matchIcon"></span>
                            <span id="matchText"></span>
                        </div>
                    </div>

                    <div class="terms-agreement-section">
                        <label class="agreement-checkbox">
                            <input type="checkbox" name="terms_agreement" id="termsAgreement" required>
                            <span class="agreement-text">
                                I have read and agree to the
                                <a href="#" onclick="openModal(event,'termsModal')">Terms &amp; Conditions</a>
                                and
                                <a href="#" onclick="openModal(event,'privacyModal')">Privacy Policy</a>
                                of CaterConnect.
                            </span>
                        </label>
                        <div class="agreement-error" id="termsError">
                            <i class="bi bi-exclamation-circle"></i>
                            Please accept the Terms &amp; Conditions and Privacy Policy to continue.
                        </div>
                    </div>

                    <button type="submit" class="btn-register" id="registerBtn">
                        <i class="bi bi-person-check-fill"></i>
                        <span id="btnText">Create My Account</span>
                        <div class="btn-spinner"></div>
                    </button>

                    <div class="security-badge">
                        <i class="bi bi-shield-check"></i>
                        Your data is securely protected by CaterConnect
                    </div>
                </form>

                <div class="login-redirect-section">
                    <p class="login-redirect-text">Already have an account?</p>
                    <a href="{{ route('login') }}" class="login-link">Sign in here →</a>
                </div>
            </div>
        </div>

        <div class="footer-links">
            <a href="#" onclick="openModal(event,'privacyModal')">Privacy Policy</a>
            <a href="#" onclick="openModal(event,'termsModal')">Terms &amp; Conditions</a>
            <a href="#">Help Center</a>
        </div>
    </div>
</div>

{{-- ===== TERMS & CONDITIONS MODAL ===== --}}
<div id="termsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-header-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
                <div>
                    <h2>Terms and Conditions</h2>
                    <div class="modal-header-sub">Last Updated: March 2026 &nbsp;|&nbsp; Version 1.0</div>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('termsModal')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-effective-date"><i class="bi bi-calendar-check"></i> Effective: March 2026</div>

            <p class="policy-text">These Terms and Conditions govern the use of the CaterConnect platform — an online marketplace that connects customers with verified catering service providers. By creating an account or using CaterConnect, you agree to comply with and be legally bound by the following terms.</p>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-check2-circle"></i> 1. Acceptance of Terms</div>
                <p class="policy-text">By accessing or registering on CaterConnect, you unconditionally accept and agree to be bound by these Terms and Conditions in their entirety. If you do not agree with any part of these terms, you must immediately cease using the platform.</p>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-person-check"></i> 2. User Eligibility</div>
                <ul class="policy-list">
                    <li>You must be at least 18 years old to register and use CaterConnect.</li>
                    <li>You must provide accurate, truthful, and complete registration information.</li>
                    <li>You must use the platform for lawful purposes only.</li>
                    <li>CaterConnect reserves the right to suspend or terminate accounts that violate these requirements.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-shield-lock"></i> 3. Account Responsibilities</div>
                <ul class="policy-list">
                    <li>Maintain the confidentiality of your username and password at all times.</li>
                    <li>Keep your account information accurate and up to date.</li>
                    <li>You are responsible for all activities conducted through your account, whether or not performed by you personally.</li>
                    <li>Report any suspected unauthorized access to your account to CaterConnect administration immediately.</li>
                    <li>Each individual may maintain only one standard user account. Multiple accounts per person are prohibited.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-calendar-event"></i> 4. Booking and Service Agreements</div>
                <p class="policy-text">CaterConnect allows users to browse and book catering services offered by independent catering providers. By making a booking, you agree to:</p>
                <ul class="policy-list">
                    <li>Provide accurate event details including event date, time, location, estimated guest count, and dietary requirements.</li>
                    <li>Respect the agreed schedule, pricing, and service conditions set by the caterer.</li>
                    <li>Communicate clearly and professionally with the catering provider through the platform.</li>
                </ul>
                <div class="policy-highlight">CaterConnect acts only as a marketplace facilitator and is <strong>not directly responsible</strong> for the catering services provided by individual caterers.</div>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-credit-card"></i> 5. Payments and Downpayment Policy</div>
                <ul class="policy-list">
                    <li>A <strong>50% downpayment</strong> is required to confirm a booking after caterer approval.</li>
                    <li>The downpayment deadline is set by the caterer and must be at minimum 7 days before the event date.</li>
                    <li>All payments must be processed exclusively through the CaterConnect platform's payment system.</li>
                    <li>Failure to complete the downpayment by the set deadline will result in <strong>automatic booking cancellation</strong>.</li>
                    <li>Cash payments and off-platform transactions are not accepted and carry no protection under this policy.</li>
                    <li>Refunds are subject to the platform's Cancellation and Refund Policy.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-person-x"></i> 6. Prohibited User Conduct</div>
                <p class="policy-text">You agree not to:</p>
                <ul class="policy-list">
                    <li>Create fake, duplicate, or impersonating user accounts.</li>
                    <li>Submit false, misleading, or fabricated reviews or booking information.</li>
                    <li>Use the platform for fraudulent, illegal, or unauthorized purposes.</li>
                    <li>Harass, abuse, or threaten catering providers or other users.</li>
                    <li>Attempt to transact with other users outside the CaterConnect platform after initial contact was made through the system.</li>
                    <li>Upload or distribute malicious software, viruses, or harmful code.</li>
                </ul>
                <p class="policy-text">Violations may result in account suspension or permanent ban.</p>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-bell"></i> 7. Notifications</div>
                <p class="policy-text">All platform notifications — including booking updates, downpayment deadlines, and system announcements — are delivered exclusively through the in-platform notification system. Users are responsible for regularly checking their notification panel. CaterConnect shall not be held liable for missed deadlines arising from failure to monitor in-platform notifications.</p>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-slash-circle"></i> 8. Account Suspension or Termination</div>
                <ul class="policy-list">
                    <li>CaterConnect may suspend or terminate accounts if fraudulent or misleading information is provided.</li>
                    <li>Violations of platform policies may result in immediate account suspension.</li>
                    <li>Detected abuse of the system, including manipulated reviews or unauthorized transactions, will result in account termination.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-arrow-repeat"></i> 9. Changes to the Terms</div>
                <p class="policy-text">CaterConnect reserves the right to update these Terms and Conditions at any time. Continued use of the platform after updates constitutes acceptance of the revised terms. All updates will be communicated via the in-platform notification system.</p>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-geo"></i> 10. Governing Law</div>
                <p class="policy-text">These Terms and Conditions shall be governed by and construed in accordance with the laws of the <strong>Republic of the Philippines</strong>. Any disputes arising under or in connection with these terms shall be subject to the exclusive jurisdiction of the appropriate courts of the Philippines.</p>
            </div>
        </div>
        <div class="modal-footer">
            <span class="modal-footer-note"><i class="bi bi-info-circle"></i> By registering, you agree to these terms.</span>
            <button class="btn-modal-close" onclick="closeModal('termsModal')">I Understand</button>
        </div>
    </div>
</div>

{{-- ===== PRIVACY POLICY MODAL ===== --}}
<div id="privacyModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-header-icon"><i class="bi bi-shield-fill-check"></i></div>
                <div>
                    <h2>Privacy Policy</h2>
                    <div class="modal-header-sub">Last Updated: March 2026 &nbsp;|&nbsp; Version 1.0</div>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('privacyModal')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-effective-date"><i class="bi bi-calendar-check"></i> Effective: March 2026</div>

            <p class="policy-text">CaterConnect values the privacy of its users. This Privacy Policy explains how personal information is collected, used, stored, and protected when using the platform. By registering, you acknowledge and consent to the practices described herein.</p>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-collection"></i> 1. Information We Collect</div>
                <p class="policy-text">When users register or use the platform, CaterConnect collects the following information:</p>
                <ul class="policy-list">
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

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-bullseye"></i> 2. Purpose of Data Collection</div>
                <ul class="policy-list">
                    <li>To create and manage your user account on the platform.</li>
                    <li>To verify user identity and confirm age eligibility (18 years and above).</li>
                    <li>To facilitate catering service bookings between customers and caterers.</li>
                    <li>To deliver in-platform notifications including booking updates and system announcements.</li>
                    <li>To ensure platform security, detect fraud, and prevent unauthorized access.</li>
                    <li>To improve platform functionality and user experience.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-lock-fill"></i> 3. Data Security</div>
                <p class="policy-text">CaterConnect implements the following security measures to protect your personal data:</p>
                <ul class="policy-list">
                    <li>Password encryption using bcrypt hashing — passwords are never stored or transmitted in plain text.</li>
                    <li>TLS (Transport Layer Security) encryption for all data transmitted between users and the platform.</li>
                    <li>AES-256 encryption for sensitive data stored in the database.</li>
                    <li>Restricted administrative access — only authorized personnel may access sensitive user information.</li>
                    <li>Regular system backups stored in encrypted, secure repositories.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-eye"></i> 4. Use of Information by Catering Providers</div>
                <p class="policy-text">Some information may be visible to catering providers solely to facilitate confirmed bookings, including:</p>
                <ul class="policy-list">
                    <li>User name and contact details (as provided during booking).</li>
                    <li>Event details including date, location, and guest count.</li>
                </ul>
                <div class="policy-highlight"><strong>Sensitive information</strong> such as passwords, date of birth, and full address will never be publicly displayed or shared with caterers beyond what is necessary for service delivery.</div>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-share"></i> 5. Data Sharing</div>
                <p class="policy-text">CaterConnect does <strong>not sell, rent, or trade</strong> personal information to third parties. User data may only be shared in the following circumstances:</p>
                <ul class="policy-list">
                    <li>When necessary to complete a confirmed catering service booking.</li>
                    <li>When required by law or by lawful order of legal authorities.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-archive"></i> 6. Data Retention</div>
                <p class="policy-text">User information is stored securely while your account remains active on the platform. Users may request account deletion and data removal by contacting CaterConnect administration through the platform's official support channel. Certain data may be retained for legal compliance or dispute resolution purposes even after account deletion.</p>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-person-gear"></i> 7. Your Rights</div>
                <ul class="policy-list">
                    <li><strong>Right to Access</strong> — you may request a copy of your personal data held by CaterConnect.</li>
                    <li><strong>Right to Correction</strong> — you may request correction of inaccurate or incomplete personal data.</li>
                    <li><strong>Right to Deletion</strong> — you may request deletion of your account and associated personal data.</li>
                    <li>These rights are exercised in accordance with the <strong>Republic Act No. 10173 (Data Privacy Act of 2012)</strong> of the Philippines.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-arrow-repeat"></i> 8. Updates to this Policy</div>
                <p class="policy-text">CaterConnect may update this Privacy Policy periodically to improve security practices and comply with applicable laws. Users will be notified of significant changes through the in-platform notification system.</p>
            </div>
        </div>
        <div class="modal-footer">
            <span class="modal-footer-note"><i class="bi bi-info-circle"></i> Your data is protected under RA 10173 (Data Privacy Act).</span>
            <button class="btn-modal-close" onclick="closeModal('privacyModal')">I Understand</button>
        </div>
    </div>
</div>

<script>
/* ===== MODAL ===== */
function openModal(e, id) {
    e.preventDefault();
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = 'auto';
}
window.addEventListener('click', function(e) {
    ['termsModal','privacyModal'].forEach(function(id){
        if (e.target === document.getElementById(id)) closeModal(id);
    });
});
document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') ['termsModal','privacyModal'].forEach(closeModal);
});

/* ===== VALIDATION HELPERS ===== */
function showValidation(fieldId, msg, valid) {
    var inp = document.getElementById(fieldId + 'Input');
    var box = document.getElementById(fieldId + 'Validation');
    if (!inp || !box) return;
    inp.classList.toggle('error',  !valid);
    inp.classList.toggle('success', valid);
    box.className = 'field-validation ' + (valid ? 'success' : 'error');
    box.innerHTML = '<i class="bi bi-' + (valid ? 'check-circle-fill' : 'exclamation-circle-fill') + '"></i><span>' + msg + '</span>';
}
function clearValidation(fieldId) {
    var inp = document.getElementById(fieldId + 'Input');
    var box = document.getElementById(fieldId + 'Validation');
    if (!inp || !box) return;
    inp.classList.remove('error','success');
    box.className = 'field-validation'; box.innerHTML = '';
}

/* ===== FULL NAME ===== */
var nameInput = document.getElementById('nameInput');
if (nameInput) {
    nameInput.addEventListener('blur', function(){
        var v = this.value.trim();
        if (v.length < 3) showValidation('name','Please enter your full name (at least 3 characters).',false);
        else if (v.split(' ').filter(Boolean).length < 2) showValidation('name','Please enter both first and last name.',false);
        else showValidation('name','Name looks good!',true);
    });
    nameInput.addEventListener('input', function(){ if (this.classList.contains('success')) clearValidation('name'); });
}

/* ===== EMAIL ===== */
var emailInput = document.getElementById('emailInput');
function validateEmail(e) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e); }
if (emailInput) {
    emailInput.addEventListener('blur', function(){
        var v = this.value.trim();
        if (!v) return;
        if (!validateEmail(v)) showValidation('email','Please enter a valid email address (e.g. adok@example.com).',false);
        else showValidation('email','Email address is valid.',true);
    });
    emailInput.addEventListener('input', function(){ if (this.classList.contains('success')) clearValidation('email'); });
}

/* ===== DATE OF BIRTH ===== */
var dobInput = document.getElementById('dobInput');
if (dobInput) {
    dobInput.addEventListener('change', function(){
        var dob = new Date(this.value), today = new Date();
        var age = today.getFullYear() - dob.getFullYear();
        var m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
        if (isNaN(age) || age < 0 || age > 100) showValidation('dob','Please enter a valid date of birth.',false);
        else if (age < 18) showValidation('dob','You must be at least 18 years old to register.',false);
        else showValidation('dob','Age verified — you are ' + age + ' years old.',true);
    });
}

/* ===== ADDRESS ===== */
var addressInput = document.getElementById('addressInput');
if (addressInput) {
    addressInput.addEventListener('blur', function(){
        var v = this.value.trim();
        if (v.length < 10) showValidation('address','Please enter your complete address.',false);
        else showValidation('address','Address recorded.',true);
    });
    addressInput.addEventListener('input', function(){ if (this.classList.contains('success')) clearValidation('address'); });
}

/* ===== MOBILE NUMBER ===== */
var phoneInput = document.getElementById('phoneInput');
function validatePhone(p) { return /^(\+63|0)[0-9]{10}$/.test(p.replace(/[\s\-]/g,'')); }
if (phoneInput) {
    phoneInput.addEventListener('blur', function(){
        if (!this.value) return;
        if (!validatePhone(this.value)) showValidation('phone','Enter a valid Philippine mobile number (e.g. 09XX XXX XXXX).',false);
        else showValidation('phone','Mobile number is valid.',true);
    });
    phoneInput.addEventListener('input', function(){
        this.value = this.value.replace(/[^0-9+\s\-]/g,'');
        if (this.classList.contains('success')) clearValidation('phone');
    });
}

/* ===== USERNAME ===== */
var usernameInput = document.getElementById('usernameInput');
var forbiddenUsernames = ['admin','caterconnect','root','superuser','moderator','support'];
function validateUsername(u) { return /^[a-zA-Z0-9_]{6,30}$/.test(u); }
if (usernameInput) {
    usernameInput.addEventListener('blur', function(){
        var u = this.value.trim();
        if (u.length < 6) showValidation('username','Username must be at least 6 characters.',false);
        else if (!validateUsername(u)) showValidation('username','Only letters, numbers, and underscores are allowed.',false);
        else if (forbiddenUsernames.includes(u.toLowerCase())) showValidation('username','This username is not allowed. Please choose another.',false);
        else showValidation('username','Username is available.',true);
    });
    usernameInput.addEventListener('input', function(){ if (this.classList.contains('success')) clearValidation('username'); });
}

/* ===== PASSWORD TOGGLE ===== */
function initToggle(btnId, inputId) {
    var btn = document.getElementById(btnId), inp = document.getElementById(inputId);
    if (!btn || !inp) return;
    btn.addEventListener('click', function(e){
        e.preventDefault();
        var show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        this.innerHTML = show ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
    });
}
initToggle('passwordToggle','passwordInput');
initToggle('confirmPasswordToggle','confirmPasswordInput');

/* ===== PASSWORD STRENGTH ===== */
var passwordInput = document.getElementById('passwordInput');
var confirmPasswordInput = document.getElementById('confirmPasswordInput');
var passwordStrength = document.getElementById('passwordStrength');
var strengthText = document.getElementById('strengthText');
var matchIndicator = document.getElementById('matchIndicator');
var matchIcon = document.getElementById('matchIcon');
var matchText = document.getElementById('matchText');

function updateReq(id, met) {
    var el = document.getElementById(id);
    if (!el) return;
    el.classList.toggle('met', met);
    el.querySelector('i').className = met ? 'bi bi-check-circle-fill' : 'bi bi-circle';
}
function checkPasswordStrength(pw) {
    var hasLength  = pw.length >= 8,
        hasUpper   = /[A-Z]/.test(pw),
        hasLower   = /[a-z]/.test(pw),
        hasNumber  = /[0-9]/.test(pw),
        hasSpecial = /[!@#$%^&*()\-_=+\[\]{};':"\\|,.<>\/?`~]/.test(pw),
        hasNoSpace = !/\s/.test(pw) && pw.length > 0;
    updateReq('req-length',hasLength); updateReq('req-uppercase',hasUpper);
    updateReq('req-lowercase',hasLower); updateReq('req-number',hasNumber);
    updateReq('req-special',hasSpecial); updateReq('req-nospace',hasNoSpace);
    var score = [hasLength,hasUpper,hasLower,hasNumber,hasSpecial,hasNoSpace].filter(Boolean).length;
    ['bar1','bar2','bar3'].forEach(function(id){ document.getElementById(id).className='strength-bar'; });
    if (pw.length === 0) { passwordStrength.style.display='none'; return false; }
    passwordStrength.style.display='flex';
    if (score<=2) { document.getElementById('bar1').classList.add('weak'); strengthText.textContent='Weak'; strengthText.style.color='#e74c3c'; }
    else if (score<=4) { document.getElementById('bar1').classList.add('medium'); document.getElementById('bar2').classList.add('medium'); strengthText.textContent='Medium'; strengthText.style.color='#f39c12'; }
    else { ['bar1','bar2','bar3'].forEach(function(id){ document.getElementById(id).classList.add('strong'); }); strengthText.textContent='Strong'; strengthText.style.color='#27ae60'; }
    return hasLength && hasUpper && hasLower && hasNumber && hasSpecial && hasNoSpace;
}
function checkPasswordMatch() {
    if (!confirmPasswordInput.value) { matchIndicator.style.display='none'; return; }
    matchIndicator.style.display='flex';
    var match = passwordInput.value === confirmPasswordInput.value && passwordInput.value.length > 0;
    matchIcon.className = 'match-icon ' + (match?'match':'no-match');
    matchIcon.innerHTML = match?'✓':'✕';
    matchText.textContent = match?'Passwords match':'Passwords do not match';
    matchText.style.color = match?'#27ae60':'#e74c3c';
    confirmPasswordInput.classList.toggle('error',!match);
    confirmPasswordInput.classList.toggle('success',match);
}
if (passwordInput) {
    passwordInput.addEventListener('input', function(){
        checkPasswordStrength(this.value); checkPasswordMatch();
        var un = usernameInput ? usernameInput.value.trim().toLowerCase() : '';
        if (un.length >= 3 && this.value.toLowerCase().includes(un)) this.classList.add('error');
    });
}
if (confirmPasswordInput) { confirmPasswordInput.addEventListener('input', checkPasswordMatch); }

/* ===== TERMS ===== */
var termsAgreement = document.getElementById('termsAgreement');
var termsError = document.getElementById('termsError');
if (termsAgreement) {
    termsAgreement.addEventListener('change', function(){ if (this.checked) termsError.classList.remove('show'); });
}

/* ===== FORM SUBMIT ===== */
var registerForm = document.getElementById('registerForm');
var registerBtn = document.getElementById('registerBtn');
var btnText = document.getElementById('btnText');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault(); var valid = true;
        if (!termsAgreement.checked) { termsError.classList.add('show'); termsAgreement.focus(); valid = false; }
        if (emailInput && emailInput.value && !validateEmail(emailInput.value.trim())) { showValidation('email','Please enter a valid email address.',false); valid = false; }
        if (dobInput && dobInput.value) {
            var dob=new Date(dobInput.value),today=new Date(),age=today.getFullYear()-dob.getFullYear(),mo=today.getMonth()-dob.getMonth();
            if (mo<0||(mo===0&&today.getDate()<dob.getDate())) age--;
            if (age<18) { showValidation('dob','You must be at least 18 years old.',false); valid=false; }
        }
        var pw = passwordInput ? passwordInput.value : '';
        if (!checkPasswordStrength(pw)) { passwordInput.classList.add('error'); valid=false; }
        if (usernameInput && pw.toLowerCase().includes(usernameInput.value.trim().toLowerCase()) && usernameInput.value.trim().length>=3) { valid=false; }
        if (passwordInput && confirmPasswordInput && passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.classList.add('error');
            matchIndicator.style.display='flex'; matchIcon.className='match-icon no-match'; matchIcon.innerHTML='✕';
            matchText.textContent='Passwords do not match.'; matchText.style.color='#e74c3c'; valid=false;
        }
        if (!valid) return false;
        registerBtn.classList.add('loading'); registerBtn.disabled=true; btnText.textContent='Creating Account...';
        setTimeout(function(){ registerForm.submit(); }, 400);
    });
}
</script>

@endsection