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

    @keyframes slideInUp   { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
    @keyframes slideInLeft { from{opacity:0;transform:translateX(-20px);} to{opacity:1;transform:translateX(0);} }
    @keyframes fadeInStagger { from{opacity:0;transform:translateY(10px);} to{opacity:1;transform:translateY(0);} }
    @keyframes spin { to{transform:rotate(360deg);} }

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
    .register-wrapper { display: grid; grid-template-columns: 1fr 1.1fr; min-height: auto; }

    /* LEFT PANEL */
    .register-image-section {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: center;
        padding: 45px; color: white; min-height: 520px;
    }
    .register-image-section::before {
        content: ''; position: absolute; inset: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="dots" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="1200" height="600" fill="url(%23dots)"/></svg>');
        pointer-events: none;
    }
    .register-tagline-content { position: relative; z-index: 2; animation: slideInLeft 0.8s ease-out; }
    .register-tagline-icon { font-size: 3rem; margin-bottom: 16px; display: inline-block; }
    .register-tagline-title { font-family: 'Montserrat', sans-serif; font-size: 2.1rem; font-weight: 900; line-height: 1.2; margin-bottom: 14px; text-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .register-tagline-text { font-size: 0.93rem; opacity: 0.95; line-height: 1.65; margin-bottom: 28px; font-weight: 400; }

    .register-features { display: flex; flex-direction: column; gap: 13px; }
    .register-feature { display: flex; align-items: flex-start; gap: 12px; font-size: 0.88rem; animation: fadeInStagger 0.6s ease-out backwards; }
    .register-feature:nth-child(1){animation-delay:0.2s;} .register-feature:nth-child(2){animation-delay:0.3s;}
    .register-feature:nth-child(3){animation-delay:0.4s;} .register-feature:nth-child(4){animation-delay:0.5s;}
    .register-feature:nth-child(5){animation-delay:0.6s;} .register-feature:nth-child(6){animation-delay:0.7s;}
    .register-feature i { font-size: 1.1rem; color: white; flex-shrink: 0; margin-top: 1px; }
    .feature-info { display: flex; flex-direction: column; gap: 1px; }
    .feature-label { font-weight: 700; line-height: 1.3; }
    .feature-desc  { font-size: 0.75rem; opacity: 0.8; font-weight: 400; }

    .pending-notice {
        margin-top: 26px; padding: 13px 15px;
        background: rgba(255,255,255,0.15);
        border-radius: 12px; border: 1px solid rgba(255,255,255,0.25);
        font-size: 0.78rem; line-height: 1.55;
        display: flex; align-items: flex-start; gap: 10px;
    }
    .pending-notice i { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

    /* RIGHT FORM */
    .register-form-section {
        padding: 38px 46px; display: flex; flex-direction: column;
        background: var(--pure-white); animation: slideInUp 0.6s ease-out 0.1s backwards;
        max-height: 95vh; overflow-y: auto;
    }
    .register-form-section::-webkit-scrollbar { width: 4px; }
    .register-form-section::-webkit-scrollbar-track { background: #f1f1f1; }
    .register-form-section::-webkit-scrollbar-thumb { background: var(--primary-orange); border-radius: 4px; }

    .register-form-header { margin-bottom: 22px; }
    .register-form-title { font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: var(--deep-charcoal); margin-bottom: 5px; letter-spacing: -0.5px; }
    .register-form-title-accent { color: var(--primary-orange); background: linear-gradient(135deg, var(--primary-orange), var(--orange-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .register-form-subtitle { font-size: 0.83rem; color: #888; font-weight: 400; }

    .form-section-label {
        font-family: 'Montserrat', sans-serif; font-size: 0.72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 1.5px; color: var(--primary-orange);
        margin: 20px 0 14px 0; display: flex; align-items: center; gap: 10px;
    }
    .form-section-label::after { content: ''; flex: 1; height: 1px; background: linear-gradient(to right, rgba(255,122,0,0.3), transparent); }
    .form-section-label i { font-size: 0.85rem; }

    .alert-error { display: flex; gap: 12px; padding: 12px 16px; background: #fef2f2; border-left: 4px solid var(--error-red); border-radius: 10px; margin-bottom: 18px; }
    .alert-error i { color: var(--error-red); font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
    .alert-error-message { font-size: 0.8rem; color: #c5453f; padding: 2px 0; }
    .alert-error-message:first-child { font-weight: 700; color: var(--error-red); margin-bottom: 4px; }

    .form-group  { margin-bottom: 16px; }
    .form-row    { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .form-label  { display: block; font-family: 'Montserrat', sans-serif; font-size: 0.67rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.4px; margin-bottom: 7px; color: var(--deep-charcoal); }
    .form-label.required::after { content: ' *'; color: var(--error-red); }
    .form-input-wrapper { position: relative; }

    /* peso prefix on number inputs */
    .input-peso-wrapper { position: relative; }
    .input-peso-prefix {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        font-size: 0.92rem; font-weight: 700; color: var(--primary-orange);
        pointer-events: none; z-index: 1;
    }
    .input-peso-wrapper .form-control-custom { padding-left: 30px; }

    .form-control-custom {
        width: 100%; background: var(--light-gray); border: 2px solid transparent;
        border-radius: 12px; padding: 12px 16px; font-size: 0.92rem;
        transition: all 0.3s ease-out; font-family: 'Inter', sans-serif; color: var(--deep-charcoal);
        appearance: none; -webkit-appearance: none;
    }
    .form-control-custom::placeholder { color: #bbb; }
    .form-control-custom:focus { outline: none; background: var(--pure-white); border-color: var(--primary-orange); box-shadow: 0 6px 20px rgba(255,122,0,0.12); transform: translateY(-1px); }
    .form-control-custom.error  { border-color: var(--error-red);    background: #fff5f5; }
    .form-control-custom.success{ border-color: var(--success-green); background: #f0fdf4; }
    textarea.form-control-custom { resize: vertical; min-height: 100px; }

    /* Budget range preview box */
    .budget-range-preview {
        display: none;
        margin-top: 10px;
        padding: 11px 15px;
        background: #fff8f0;
        border-left: 4px solid var(--primary-orange);
        border-radius: 0 10px 10px 0;
        font-size: 0.8rem; color: #555; line-height: 1.55;
    }
    .budget-range-preview.show { display: block; }
    .budget-range-preview.error-state {
        background: #fff5f5; border-left-color: var(--error-red); color: var(--error-red);
    }
    .budget-range-preview strong { color: var(--primary-orange); }
    .budget-range-preview.error-state strong { color: var(--error-red); }

    /* File upload */
    .file-upload-wrapper { position: relative; display: flex; flex-direction: column; gap: 8px; }
    .file-upload-input {
        width: 100%; background: var(--light-gray); border: 2px dashed var(--border-gray);
        border-radius: 12px; padding: 14px 16px; font-size: 0.88rem;
        transition: all 0.3s ease-out; font-family: 'Inter', sans-serif; color: var(--deep-charcoal);
        cursor: pointer;
    }
    .file-upload-input:hover, .file-upload-input:focus { outline: none; border-color: var(--primary-orange); background: #fff8f0; }
    .file-upload-input.has-file { border-color: var(--success-green); border-style: solid; background: #f0fdf4; }
    .file-hint { font-size: 0.68rem; color: #999; display: flex; align-items: center; gap: 5px; }
    .file-hint i { color: var(--primary-orange); font-size: 0.72rem; }
    .file-preview { display: none; align-items: center; gap: 8px; padding: 8px 12px; background: #f0fdf4; border: 1px solid rgba(39,174,96,0.3); border-radius: 8px; font-size: 0.78rem; color: var(--success-green); font-weight: 600; }
    .file-preview.show { display: flex; }
    .file-preview i { font-size: 0.9rem; }
    .file-remove { margin-left: auto; background: none; border: none; color: var(--error-red); cursor: pointer; font-size: 0.9rem; padding: 0 2px; }

    .field-validation { font-size: 0.7rem; margin-top: 5px; display: none; align-items: center; gap: 4px; }
    .field-validation.error   { display: flex; color: var(--error-red); }
    .field-validation.success { display: flex; color: var(--success-green); }
    .field-validation i { font-size: 0.8rem; }

    .terms-agreement-section { margin: 18px 0; padding: 15px 16px; background: #f9f9f9; border-left: 4px solid var(--primary-orange); border-radius: 10px; }
    .agreement-checkbox { display: flex; align-items: flex-start; gap: 10px; cursor: pointer; margin-bottom: 10px; }
    .agreement-checkbox:last-of-type { margin-bottom: 0; }
    .agreement-checkbox input { margin-top: 3px; cursor: pointer; width: 16px; height: 16px; accent-color: var(--primary-orange); flex-shrink: 0; }
    .agreement-text { font-size: 0.78rem; color: #555; line-height: 1.45; }
    .agreement-text a { color: var(--primary-orange); text-decoration: none; font-weight: 600; }
    .agreement-text a:hover { opacity: 0.8; text-decoration: underline; }
    .agreement-error { color: var(--error-red); font-size: 0.73rem; display: none; margin-top: 8px; font-weight: 600; }
    .agreement-error.show { display: block; }

    .btn-register {
        width: 100%; background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
        color: white; border: none; border-radius: 12px; padding: 14px;
        font-size: 0.92rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;
        cursor: pointer; margin-top: 18px; transition: all 0.3s ease-out;
        font-family: 'Montserrat', sans-serif; box-shadow: 0 8px 25px rgba(255,122,0,0.25);
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-register::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s; }
    .btn-register:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(255,122,0,0.35); }
    .btn-register:hover:not(:disabled)::before { left: 100%; }
    .btn-register:disabled { opacity: 0.75; cursor: not-allowed; }
    .btn-register.loading i { display: none; }
    .btn-spinner { display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.35); border-top-color: white; border-radius: 50%; animation: spin 0.8s linear infinite; }
    .btn-register.loading .btn-spinner { display: inline-block; }

    .security-badge { display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 0.73rem; color: var(--success-green); font-weight: 600; margin-top: 14px; padding: 9px; background: #f0fdf4; border-radius: 10px; border: 1px solid rgba(39,174,96,0.2); }

    .back-section { text-align: center; margin-top: 18px; padding-top: 18px; border-top: 1px solid var(--border-gray); }
    .back-text { font-size: 0.83rem; color: #666; margin-bottom: 5px; }
    .back-link { color: var(--primary-orange); text-decoration: none; font-weight: 700; font-size: 0.88rem; transition: all 0.3s; position: relative; }
    .back-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: var(--primary-orange); transition: width 0.3s; }
    .back-link:hover::after { width: 100%; }

    .footer-links { display: flex; justify-content: center; gap: 30px; padding: 18px; border-top: 1px solid var(--border-gray); background: var(--light-gray); font-size: 0.78rem; }
    .footer-links a { color: #666; text-decoration: none; font-weight: 600; transition: color 0.3s; }
    .footer-links a:hover { color: var(--primary-orange); }

    /* MODAL */
    .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); }
    .modal.active { display: flex; align-items: center; justify-content: center; }
    .modal-content { background: var(--pure-white); padding: 0; border-radius: 20px; max-width: 720px; width: 92%; max-height: 85vh; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 25px 70px rgba(0,0,0,0.45); animation: slideInUp 0.3s ease-out; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 22px 30px 18px 30px; border-bottom: 2px solid var(--border-gray); flex-shrink: 0; }
    .modal-header-left { display: flex; align-items: center; gap: 12px; }
    .modal-header-icon { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, var(--primary-orange), var(--orange-light)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.1rem; flex-shrink: 0; }
    .modal-header h2 { font-family: 'Montserrat', sans-serif; font-size: 1.35rem; font-weight: 900; color: var(--deep-charcoal); margin: 0; }
    .modal-header-sub { font-size: 0.72rem; color: #999; margin-top: 2px; }
    .modal-close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #bbb; padding: 4px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 8px; transition: all 0.2s; }
    .modal-close:hover { color: var(--error-red); background: #fff0f0; }
    .modal-body { overflow-y: auto; padding: 24px 30px 30px 30px; flex: 1; }
    .modal-body::-webkit-scrollbar { width: 4px; }
    .modal-body::-webkit-scrollbar-thumb { background: var(--primary-orange); border-radius: 4px; }
    .modal-effective-date { display: inline-flex; align-items: center; gap: 6px; background: #fff8f0; border: 1px solid rgba(255,122,0,0.2); border-radius: 8px; padding: 6px 12px; font-size: 0.72rem; color: var(--primary-orange); font-weight: 700; margin-bottom: 18px; }
    .policy-section { margin-bottom: 22px; }
    .policy-section-title { font-family: 'Montserrat', sans-serif; font-size: 0.82rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: var(--deep-charcoal); margin-bottom: 10px; padding-bottom: 7px; border-bottom: 2px solid var(--primary-orange); display: flex; align-items: center; gap: 8px; }
    .policy-section-title i { color: var(--primary-orange); }
    .policy-text { font-size: 0.84rem; color: #444; line-height: 1.75; margin-bottom: 10px; }
    .policy-list { list-style: none; padding: 0; margin: 8px 0; }
    .policy-list li { font-size: 0.84rem; color: #444; line-height: 1.7; padding: 5px 0 5px 20px; position: relative; border-bottom: 1px solid #f5f5f5; }
    .policy-list li:last-child { border-bottom: none; }
    .policy-list li::before { content: ''; position: absolute; left: 0; top: 13px; width: 7px; height: 7px; border-radius: 50%; background: var(--primary-orange); }
    .policy-highlight { background: #fff8f0; border-left: 3px solid var(--primary-orange); border-radius: 0 8px 8px 0; padding: 10px 14px; font-size: 0.82rem; color: #555; line-height: 1.65; margin: 10px 0; }
    .policy-highlight strong { color: var(--deep-charcoal); }
    .modal-footer { padding: 16px 30px; border-top: 1px solid var(--border-gray); background: #fafafa; flex-shrink: 0; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .modal-footer-note { font-size: 0.72rem; color: #999; }
    .modal-footer-note i { color: var(--primary-orange); }
    .btn-modal-close { background: linear-gradient(135deg, var(--primary-orange), var(--orange-light)); color: white; border: none; border-radius: 10px; padding: 9px 22px; font-size: 0.82rem; font-weight: 700; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: all 0.2s; }
    .btn-modal-close:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,122,0,0.3); }

    @media (max-width: 1024px) { .register-wrapper{grid-template-columns:1fr;} .register-image-section{display:none;} .register-container{max-width:520px;} .register-form-section{padding:35px 32px;max-height:none;} }
    @media (max-width: 600px) { .register-page-wrapper{padding:16px;} .register-form-section{padding:28px 20px;} .register-form-title{font-size:1.7rem;} .form-row{grid-template-columns:1fr;} .footer-links{gap:14px;flex-wrap:wrap;} .modal-content{width:96%;} .modal-header,.modal-body,.modal-footer{padding-left:18px;padding-right:18px;} }
</style>

<div class="register-page-wrapper">
    <div class="register-container">
        <div class="register-wrapper">

            {{-- LEFT PANEL --}}
            <div class="register-image-section">
                <div class="register-tagline-content">
                    <i class="bi bi-shop register-tagline-icon"></i>
                    <h2 class="register-tagline-title">Become a<br>Caterer</h2>
                    <p class="register-tagline-text">
                        List your catering business on CaterConnect and connect with customers looking for great food at their events.
                    </p>

                    <div class="register-features">
                        <div class="register-feature">
                            <i class="bi bi-patch-check-fill"></i>
                            <div class="feature-info">
                                <span class="feature-label">Business Name</span>
                                <span class="feature-desc">Your official catering business name</span>
                            </div>
                        </div>
                        <div class="register-feature">
                            <i class="bi bi-cash-coin"></i>
                            <div class="feature-info">
                                <span class="feature-label">Starting &amp; Maximum Price</span>
                                <span class="feature-desc">Set your price range per guest</span>
                            </div>
                        </div>
                        <div class="register-feature">
                            <i class="bi bi-file-earmark-text-fill"></i>
                            <div class="feature-info">
                                <span class="feature-label">Business Permit / DTI</span>
                                <span class="feature-desc">Government-issued registration</span>
                            </div>
                        </div>
                        <div class="register-feature">
                            <i class="bi bi-heart-pulse-fill"></i>
                            <div class="feature-info">
                                <span class="feature-label">Sanitary Permit</span>
                                <span class="feature-desc">Local health office certification</span>
                            </div>
                        </div>
                        <div class="register-feature">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div class="feature-info">
                                <span class="feature-label">Service Area &amp; Menu</span>
                                <span class="feature-desc">Where you serve and what you offer</span>
                            </div>
                        </div>
                        <div class="register-feature">
                            <i class="bi bi-person-badge-fill"></i>
                            <div class="feature-info">
                                <span class="feature-label">Valid Government ID</span>
                                <span class="feature-desc">PhilSys, Passport, Driver's License, etc.</span>
                            </div>
                        </div>
                    </div>

                    <div class="pending-notice">
                        <i class="bi bi-hourglass-split"></i>
                        <span>After submission, your documents will be reviewed by CaterConnect admin within <strong>3–5 business days</strong>. You will be notified once your caterer profile is approved.</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT FORM --}}
            <div class="register-form-section">
                <div class="register-form-header">
                    <h1 class="register-form-title">Caterer <span class="register-form-title-accent">Registration</span> 🍽️</h1>
                    <p class="register-form-subtitle">Complete all fields below — your application will be reviewed by our admin team</p>
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

                <form action="{{ url('/become-caterer') }}" method="POST" enctype="multipart/form-data" id="catererForm">
                    @csrf

                    {{-- SECTION 1: BUSINESS INFORMATION --}}
                    <div class="form-section-label"><i class="bi bi-shop"></i> Business Information</div>

                    {{-- Business Name --}}
                    <div class="form-group">
                        <label class="form-label required" for="businessNameInput">Business Name</label>
                        <div class="form-input-wrapper">
                            <input type="text" name="business_name" id="businessNameInput"
                                class="form-control-custom @error('business_name') error @enderror"
                                placeholder="e.g. Adok's Catering Services"
                                value="{{ old('business_name') }}" required>
                        </div>
                        <div class="field-validation" id="businessNameValidation"></div>
                    </div>

                    {{-- Contact Number --}}
                    <div class="form-group">
                        <label class="form-label required" for="contactInput">Catering Contact Number</label>
                        <div class="form-input-wrapper">
                            <input type="tel" name="contact_number" id="contactInput"
                                class="form-control-custom @error('contact_number') error @enderror"
                                placeholder="e.g. 09XX XXX XXXX"
                                value="{{ old('contact_number') }}" required maxlength="13">
                        </div>
                        <div class="field-validation" id="contactValidation"></div>
                    </div>

                    {{-- Service Area --}}
                    <div class="form-group">
                        <label class="form-label required" for="serviceAreaInput">Service Area Coverage</label>
                        <div class="form-input-wrapper">
                            <input type="text" name="location" id="serviceAreaInput"
                                class="form-control-custom @error('location') error @enderror"
                                placeholder="e.g. Cebu City, Mandaue City, Talisay City"
                                value="{{ old('location') }}" required>
                        </div>
                        <div class="field-validation" id="serviceAreaValidation"></div>
                    </div>

                    {{-- Specialty / Sample Menu --}}
                    <div class="form-group">
                        <label class="form-label required" for="specialtyInput">Specialty / Sample Menu or Service Description</label>
                        <div class="form-input-wrapper">
                            <textarea name="specialty" id="specialtyInput"
                                class="form-control-custom @error('specialty') error @enderror"
                                placeholder="e.g. Filipino buffet, lechon, pasta stations, live cooking stations — describe what you offer and your specialties"
                                required>{{ old('specialty') }}</textarea>
                        </div>
                        <div class="field-validation" id="specialtyValidation"></div>
                    </div>

                    {{-- ══════════════════════════════════════════════ --}}
                    {{-- SECTION 2: PRICING (Budget Matcher Fields)    --}}
                    {{-- ══════════════════════════════════════════════ --}}
                    <div class="form-section-label"><i class="bi bi-cash-coin"></i> Package Pricing per Guest</div>

                    <div class="form-row">

                        {{-- Starting Price per Guest --}}
                        <div class="form-group">
                            <label class="form-label required" for="minBudgetInput">Starting Price per Guest (₱)</label>
                            <div class="input-peso-wrapper">
                                <span class="input-peso-prefix">₱</span>
                                <input type="number" name="min_budget" id="minBudgetInput"
                                    class="form-control-custom @error('min_budget') error @enderror"
                                    placeholder="e.g. 250"
                                    value="{{ old('min_budget') }}"
                                    min="0" step="50" required>
                            </div>
                            <div style="font-size:0.67rem;color:#999;margin-top:5px;line-height:1.4;">
                                Lowest price per person for your basic package or menu.
                            </div>
                            <div class="field-validation" id="minBudgetValidation"></div>
                        </div>

                        {{-- Maximum Price per Guest --}}
                        <div class="form-group">
                            <label class="form-label required" for="maxBudgetInput">Maximum Price per Guest (₱)</label>
                            <div class="input-peso-wrapper">
                                <span class="input-peso-prefix">₱</span>
                                <input type="number" name="max_budget" id="maxBudgetInput"
                                    class="form-control-custom @error('max_budget') error @enderror"
                                    placeholder="e.g. 1200"
                                    value="{{ old('max_budget') }}"
                                    min="0" step="50" required>
                            </div>
                            <div style="font-size:0.67rem;color:#999;margin-top:5px;line-height:1.4;">
                                Highest price per person for your premium package or menu.
                            </div>
                            <div class="field-validation" id="maxBudgetValidation"></div>
                        </div>

                    </div>

                    {{-- Live Budget Range Preview --}}
                    <div class="budget-range-preview" id="budgetRangePreview">
                        <i class="bi bi-calculator-fill" style="color:var(--primary-orange);margin-right:6px;"></i>
                        Your catering accepts budgets of <strong id="budgetRangeText"></strong> per guest.
                        Customers searching within this range will see your listing in the Budget Matcher results.
                    </div>

                    {{-- SECTION 3: DOCUMENTS --}}
                    <div class="form-section-label" style="margin-top:20px;"><i class="bi bi-file-earmark-check-fill"></i> Required Documents</div>

                    {{-- Business Permit or DTI --}}
                    <div class="form-group">
                        <label class="form-label required">Business Permit or DTI Registration</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="business_permit" id="businessPermitInput"
                                class="file-upload-input @error('business_permit') error @enderror"
                                accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="file-hint">
                                <i class="bi bi-info-circle-fill"></i>
                                Upload your LGU Business Permit or DTI Certificate of Registration. Accepted: JPG, PNG, PDF (max 5MB)
                            </div>
                            <div class="file-preview" id="businessPermitPreview">
                                <i class="bi bi-file-earmark-check-fill"></i>
                                <span id="businessPermitName"></span>
                                <button type="button" class="file-remove" onclick="removeFile('businessPermitInput','businessPermitPreview')"><i class="bi bi-x-circle-fill"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- Sanitary Permit --}}
                    <div class="form-group">
                        <label class="form-label required">Sanitary Permit</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="sanitary_permit" id="sanitaryPermitInput"
                                class="file-upload-input @error('sanitary_permit') error @enderror"
                                accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="file-hint">
                                <i class="bi bi-info-circle-fill"></i>
                                Upload your valid Sanitary Permit issued by the local health office. Accepted: JPG, PNG, PDF (max 5MB)
                            </div>
                            <div class="file-preview" id="sanitaryPermitPreview">
                                <i class="bi bi-file-earmark-check-fill"></i>
                                <span id="sanitaryPermitName"></span>
                                <button type="button" class="file-remove" onclick="removeFile('sanitaryPermitInput','sanitaryPermitPreview')"><i class="bi bi-x-circle-fill"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- Government ID --}}
                    <div class="form-group">
                        <label class="form-label required">Valid Government-Issued ID</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="government_id" id="governmentIdInput"
                                class="file-upload-input @error('government_id') error @enderror"
                                accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="file-hint">
                                <i class="bi bi-info-circle-fill"></i>
                                Accepted IDs: PhilSys, Passport, Driver's License, PRC ID, Voter's ID. Accepted: JPG, PNG, PDF (max 5MB)
                            </div>
                            <div class="file-preview" id="governmentIdPreview">
                                <i class="bi bi-file-earmark-check-fill"></i>
                                <span id="governmentIdName"></span>
                                <button type="button" class="file-remove" onclick="removeFile('governmentIdInput','governmentIdPreview')"><i class="bi bi-x-circle-fill"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 4: PROFILE --}}
                    <div class="form-section-label"><i class="bi bi-image-fill"></i> Business Profile</div>

                    {{-- Profile Photo / Logo --}}
                    <div class="form-group">
                        <label class="form-label required">Profile Photo or Business Logo</label>
                        <div class="file-upload-wrapper">
                            <input type="file" name="profile_picture" id="profilePictureInput"
                                class="file-upload-input @error('profile_picture') error @enderror"
                                accept=".jpg,.jpeg,.png" required>
                            <div class="file-hint">
                                <i class="bi bi-info-circle-fill"></i>
                                Upload a clear photo of you or your business logo. This appears on your public caterer listing. Accepted: JPG, PNG (max 3MB)
                            </div>
                            <div class="file-preview" id="profilePicturePreview">
                                <i class="bi bi-image-fill"></i>
                                <span id="profilePictureName"></span>
                                <button type="button" class="file-remove" onclick="removeFile('profilePictureInput','profilePicturePreview')"><i class="bi bi-x-circle-fill"></i></button>
                            </div>
                        </div>
                    </div>

                    {{-- CATERER AGREEMENT --}}
                    <div class="terms-agreement-section">
                        <label class="agreement-checkbox">
                            <input type="checkbox" name="caterer_agreement" id="catererAgreement" required>
                            <span class="agreement-text">
                                I confirm that all submitted information and documents are accurate and valid. I agree to the
                                <a href="#" onclick="openModal(event,'catererTermsModal')">Caterer Terms &amp; Conditions</a>
                                and understand that my application is subject to review and approval by CaterConnect administration.
                            </span>
                        </label>
                        <div class="agreement-error" id="agreementError">
                            <i class="bi bi-exclamation-circle"></i>
                            Please confirm that your information is accurate and agree to the terms.
                        </div>
                    </div>

                    <button type="submit" class="btn-register" id="submitBtn">
                        <i class="bi bi-send-fill"></i>
                        <span id="btnText">Submit Application</span>
                        <div class="btn-spinner"></div>
                    </button>

                    <div class="security-badge">
                        <i class="bi bi-shield-check"></i>
                        Your documents are stored securely and used only for verification purposes
                    </div>
                </form>

                <div class="back-section">
                    <p class="back-text">Changed your mind?</p>
                    <a href="{{ route('dashboard') }}" class="back-link">← Back to Dashboard</a>
                </div>
            </div>
        </div>

        <div class="footer-links">
            <a href="#" onclick="openModal(event,'catererTermsModal')">Caterer Terms</a>
            <a href="#">Help Center</a>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
    </div>
</div>

{{-- CATERER TERMS MODAL --}}
<div id="catererTermsModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-header-icon"><i class="bi bi-shop"></i></div>
                <div>
                    <h2>Caterer Agreement</h2>
                    <div class="modal-header-sub">Last Updated: March 2026 &nbsp;|&nbsp; Version 1.0</div>
                </div>
            </div>
            <button class="modal-close" onclick="closeModal('catererTermsModal')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body">
            <div class="modal-effective-date"><i class="bi bi-calendar-check"></i> Effective: March 2026</div>
            <p class="policy-text">This Caterer User Agreement is entered into between the registered Caterer and CaterConnect upon the activation of the caterer profile through the "Become a Caterer" registration process. By submitting this application, the Caterer acknowledges having read, understood, and agreed to the following terms.</p>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-clipboard-check"></i> Article 1 — Caterer Obligations</div>
                <ul class="policy-list">
                    <li>Provide accurate, complete, and truthful information in the Catering Business Registration form, including business name, business permit or DTI registration, sanitary permit, government-issued ID, contact number, service area, sample menu or service description, and profile photo or logo.</li>
                    <li>Set an accurate Starting Price and Maximum Price per guest that reflects the actual range of packages and menus offered. Misleading pricing information is a violation of this agreement.</li>
                    <li>Keep the caterer profile, menus, pricing, and availability information up to date at all times.</li>
                    <li>Disclose all applicable fees, additional charges, and service conditions clearly in listings before customers submit booking requests.</li>
                    <li>Respond to customer booking requests within twenty-four (24) hours of receipt.</li>
                    <li>Upon approving a booking, set a fair downpayment deadline of at minimum seven (7) days before the event date.</li>
                    <li>Honor all confirmed bookings — defined as bookings where the customer has completed the required 50% downpayment.</li>
                    <li>Deliver all catering services to the standards and specifications agreed upon at the time of booking confirmation.</li>
                    <li>Ensure all food prepared and served complies with applicable food safety, hygiene, and health regulations.</li>
                    <li>Mark bookings as "Completed" on the platform promptly after successful event delivery.</li>
                    <li>Resolve customer complaints professionally, in good faith, and in a timely manner.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-hand-thumbs-up"></i> Article 2 — Caterer Rights</div>
                <ul class="policy-list">
                    <li>Right to create and manage a professional catering business profile on the CaterConnect marketplace upon successful verification.</li>
                    <li>Right to set and update Starting Price and Maximum Price per guest to reflect current package offerings.</li>
                    <li>Right to approve or decline customer booking requests at their discretion, within the 24-hour response window.</li>
                    <li>Right to set the downpayment payment deadline within the bounds established in the platform policy.</li>
                    <li>Right to receive full payment for completed services following event completion and booking closure on the platform.</li>
                    <li>Right to respond professionally to customer reviews through the platform's official response feature.</li>
                    <li>Right to report customer misconduct or fraudulent activity to CaterConnect for investigation.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-exclamation-triangle"></i> Article 3 — Caterer Acknowledgments</div>
                <ul class="policy-list">
                    <li>All catering services are provided directly by the Caterer. CaterConnect bears no responsibility for the quality, safety, timeliness, or delivery of such services.</li>
                    <li>CaterConnect charges a platform service fee on transactions facilitated through the platform.</li>
                    <li>The Starting Price and Maximum Price per guest set by the Caterer are used by CaterConnect's Budget Matcher feature to connect the caterer with customers whose event budgets fall within the specified range.</li>
                    <li>If a customer does not complete the downpayment by the set deadline, the system will automatically cancel the booking.</li>
                    <li>Violation of this Agreement may result in account suspension, removal of the caterer profile, or permanent termination.</li>
                </ul>
            </div>

            <div class="policy-section">
                <div class="policy-section-title"><i class="bi bi-hourglass-split"></i> Article 4 — Verification Process</div>
                <p class="policy-text">Upon submission, the Caterer account will be placed in "Pending Verification" status. The submitted documents will be reviewed within 3 to 5 business days. Upon approval, the caterer profile is activated and a "Verified Caterer" badge is displayed on the public listing.</p>
                <div class="policy-highlight"><strong>Important:</strong> Submitting falsified, expired, or fraudulent documents will result in immediate application rejection and may result in a permanent account ban.</div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="modal-footer-note"><i class="bi bi-info-circle"></i> By submitting, you agree to this Caterer Agreement.</span>
            <button class="btn-modal-close" onclick="closeModal('catererTermsModal')">I Understand</button>
        </div>
    </div>
</div>

<script>
/* MODAL */
function openModal(e, id) { e.preventDefault(); document.getElementById(id).classList.add('active'); document.body.style.overflow = 'hidden'; }
function closeModal(id)   { document.getElementById(id).classList.remove('active'); document.body.style.overflow = 'auto'; }
window.addEventListener('click', function(e) { if (e.target === document.getElementById('catererTermsModal')) closeModal('catererTermsModal'); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal('catererTermsModal'); });

/* FILE UPLOADS */
function initFileUpload(inputId, previewId, nameId) {
    var input = document.getElementById(inputId);
    var preview = document.getElementById(previewId);
    var nameEl  = document.getElementById(nameId);
    if (!input) return;
    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var file = this.files[0];
            var maxMB = inputId === 'profilePictureInput' ? 3 : 5;
            if (file.size > maxMB * 1024 * 1024) { alert('File is too large. Maximum size is ' + maxMB + 'MB.'); this.value = ''; return; }
            nameEl.textContent = file.name;
            preview.classList.add('show');
            this.classList.add('has-file');
        }
    });
}
function removeFile(inputId, previewId) {
    var inp = document.getElementById(inputId);
    var prev = document.getElementById(previewId);
    if (inp)  { inp.value = ''; inp.classList.remove('has-file'); }
    if (prev) { prev.classList.remove('show'); }
}
initFileUpload('businessPermitInput', 'businessPermitPreview', 'businessPermitName');
initFileUpload('sanitaryPermitInput', 'sanitaryPermitPreview', 'sanitaryPermitName');
initFileUpload('governmentIdInput',   'governmentIdPreview',   'governmentIdName');
initFileUpload('profilePictureInput', 'profilePicturePreview', 'profilePictureName');

/* VALIDATION HELPERS */
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

/* BUSINESS NAME */
var businessNameInput = document.getElementById('businessNameInput');
if (businessNameInput) {
    businessNameInput.addEventListener('blur', function(){ var v = this.value.trim(); if (v.length < 3) showValidation('businessName','Please enter a valid business name.',false); else showValidation('businessName','Business name looks good!',true); });
    businessNameInput.addEventListener('input', function(){ if (this.classList.contains('success')) clearValidation('businessName'); });
}

/* CONTACT */
var contactInput = document.getElementById('contactInput');
function validatePhone(p) { return /^(\+63|0)[0-9]{10}$/.test(p.replace(/[\s\-]/g,'')); }
if (contactInput) {
    contactInput.addEventListener('blur', function(){ if (!this.value) return; if (!validatePhone(this.value)) showValidation('contact','Enter a valid Philippine mobile number (e.g. 09XX XXX XXXX).',false); else showValidation('contact','Contact number is valid.',true); });
    contactInput.addEventListener('input', function(){ this.value = this.value.replace(/[^0-9+\s\-]/g,''); if (this.classList.contains('success')) clearValidation('contact'); });
}

/* SERVICE AREA */
var serviceAreaInput = document.getElementById('serviceAreaInput');
if (serviceAreaInput) {
    serviceAreaInput.addEventListener('blur', function(){ var v = this.value.trim(); if (v.length < 3) showValidation('serviceArea','Please enter your service area coverage.',false); else showValidation('serviceArea','Service area recorded.',true); });
    serviceAreaInput.addEventListener('input', function(){ if (this.classList.contains('success')) clearValidation('serviceArea'); });
}

/* SPECIALTY */
var specialtyInput = document.getElementById('specialtyInput');
if (specialtyInput) {
    specialtyInput.addEventListener('blur', function(){ var v = this.value.trim(); if (v.length < 20) showValidation('specialty','Please provide a more detailed description (at least 20 characters).',false); else showValidation('specialty','Service description looks good!',true); });
    specialtyInput.addEventListener('input', function(){ if (this.classList.contains('success')) clearValidation('specialty'); });
}

/* BUDGET RANGE LIVE PREVIEW */
var minBudgetInput    = document.getElementById('minBudgetInput');
var maxBudgetInput    = document.getElementById('maxBudgetInput');
var budgetRangePreview = document.getElementById('budgetRangePreview');
var budgetRangeText   = document.getElementById('budgetRangeText');

function updateBudgetPreview() {
    var min = parseFloat(minBudgetInput ? minBudgetInput.value : 0);
    var max = parseFloat(maxBudgetInput ? maxBudgetInput.value : 0);

    if (min > 0 || max > 0) {
        budgetRangePreview.classList.add('show');

        if (min > 0 && max > 0 && min > max) {
            // Error state
            budgetRangePreview.classList.add('error-state');
            budgetRangePreview.innerHTML = '<i class="bi bi-exclamation-triangle-fill" style="margin-right:6px;"></i> <strong>Starting price cannot be higher than Maximum price.</strong> Please correct your values.';
            if (minBudgetInput) minBudgetInput.classList.add('error');
            if (maxBudgetInput) maxBudgetInput.classList.add('error');
        } else {
            // Normal state
            budgetRangePreview.classList.remove('error-state');
            if (minBudgetInput) { minBudgetInput.classList.remove('error'); if (min > 0) minBudgetInput.classList.add('success'); }
            if (maxBudgetInput) { maxBudgetInput.classList.remove('error'); if (max > 0) maxBudgetInput.classList.add('success'); }

            var minStr = min > 0 ? '₱' + min.toLocaleString('en-PH') : '—';
            var maxStr = max > 0 ? '₱' + max.toLocaleString('en-PH') : '—';

            budgetRangePreview.innerHTML =
                '<i class="bi bi-calculator-fill" style="color:var(--primary-orange);margin-right:6px;"></i>' +
                'Your catering accepts budgets of <strong>' + minStr + ' – ' + maxStr + '</strong> per guest. ' +
                'Customers searching within this range will see your listing in the Budget Matcher results.';
        }
    } else {
        budgetRangePreview.classList.remove('show','error-state');
    }
}

if (minBudgetInput) minBudgetInput.addEventListener('input', updateBudgetPreview);
if (maxBudgetInput) maxBudgetInput.addEventListener('input', updateBudgetPreview);

/* AGREEMENT */
var catererAgreement = document.getElementById('catererAgreement');
var agreementError   = document.getElementById('agreementError');
if (catererAgreement) { catererAgreement.addEventListener('change', function(){ if (this.checked) agreementError.classList.remove('show'); }); }

/* FORM SUBMIT */
var catererForm = document.getElementById('catererForm');
var submitBtn   = document.getElementById('submitBtn');
var btnText     = document.getElementById('btnText');

if (catererForm) {
    catererForm.addEventListener('submit', function(e) {
        e.preventDefault();
        var valid = true;

        if (!catererAgreement.checked) { agreementError.classList.add('show'); catererAgreement.focus(); valid = false; }
        if (businessNameInput && businessNameInput.value.trim().length < 3) { showValidation('businessName','Please enter a valid business name.',false); valid = false; }
        if (contactInput && contactInput.value && !validatePhone(contactInput.value)) { showValidation('contact','Please enter a valid Philippine mobile number.',false); valid = false; }
        if (serviceAreaInput && serviceAreaInput.value.trim().length < 3) { showValidation('serviceArea','Please enter your service area coverage.',false); valid = false; }
        if (specialtyInput && specialtyInput.value.trim().length < 20) { showValidation('specialty','Please provide a more detailed service description.',false); valid = false; }

        // Budget validation
        var min = parseFloat(minBudgetInput ? minBudgetInput.value : 0);
        var max = parseFloat(maxBudgetInput ? maxBudgetInput.value : 0);
        if (!min || min <= 0) { showValidation('minBudget','Please enter your starting price per guest.',false); valid = false; }
        if (!max || max <= 0) { showValidation('maxBudget','Please enter your maximum price per guest.',false); valid = false; }
        if (min > 0 && max > 0 && min > max) { showValidation('maxBudget','Maximum price must be greater than or equal to the starting price.',false); valid = false; }

        // File uploads
        ['businessPermitInput','sanitaryPermitInput','governmentIdInput','profilePictureInput'].forEach(function(id) {
            var inp = document.getElementById(id);
            if (inp && inp.files.length === 0) { inp.style.borderColor = '#e74c3c'; valid = false; }
        });

        if (!valid) { window.scrollTo({ top: 0, behavior: 'smooth' }); return false; }

        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        btnText.textContent = 'Submitting Application...';
        setTimeout(function(){ catererForm.submit(); }, 400);
    });
}
</script>

@endsection