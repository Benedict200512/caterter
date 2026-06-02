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
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { width: 100%; overflow-x: hidden; }
    #app, main { padding: 0 !important; margin: 0 !important; width: 100%; }
    body { font-family: 'Inter', sans-serif; }

    @keyframes slideInUp   { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
    @keyframes slideInLeft { from{opacity:0;transform:translateX(-20px);} to{opacity:1;transform:translateX(0);} }
    @keyframes fadeInStagger { from{opacity:0;transform:translateY(10px);} to{opacity:1;transform:translateY(0);} }
    @keyframes spin { to{transform:rotate(360deg);} }

    /* PAGE WRAPPER */
    .edit-page-wrapper {
        background: linear-gradient(135deg, var(--deep-charcoal) 0%, var(--charcoal-light) 100%);
        min-height: 100vh; width: 100%;
        display: flex; align-items: center; justify-content: center;
        padding: 30px 20px; position: relative; overflow: hidden;
    }
    .edit-page-wrapper::before {
        content: ''; position: absolute; width: 200%; height: 200%; top: -50%; left: -50%;
        background: radial-gradient(circle at 20% 50%, rgba(255,122,0,0.10) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(255,159,47,0.08) 0%, transparent 50%);
        pointer-events: none;
    }

    /* MAIN CONTAINER */
    .edit-container {
        width: 100%; max-width: 980px; background: var(--pure-white);
        border-radius: 24px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        animation: slideInUp 0.6s ease-out; position: relative; z-index: 1;
    }
    .edit-wrapper { display: grid; grid-template-columns: 1fr 1.1fr; min-height: auto; }

    /* LEFT PANEL */
    .edit-image-section {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%);
        position: relative; overflow: hidden;
        display: flex; flex-direction: column; justify-content: center;
        padding: 45px; color: white; min-height: 520px;
    }
    .edit-image-section::before {
        content: ''; position: absolute; inset: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="dots" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="1200" height="600" fill="url(%23dots)"/></svg>');
        pointer-events: none;
    }
    .edit-panel-content { position: relative; z-index: 2; animation: slideInLeft 0.8s ease-out; }
    .edit-panel-icon { font-size: 3rem; margin-bottom: 16px; display: inline-block; }
    .edit-panel-title { font-family: 'Montserrat', sans-serif; font-size: 2.1rem; font-weight: 900; line-height: 1.2; margin-bottom: 14px; text-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .edit-panel-text  { font-size: 0.93rem; opacity: 0.95; line-height: 1.65; margin-bottom: 28px; font-weight: 400; }

    /* Current Profile Preview on left panel */
    .current-profile-card {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 16px; padding: 18px;
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 22px;
    }
    .current-profile-avatar {
        width: 60px; height: 60px; border-radius: 12px;
        object-fit: cover; border: 2px solid rgba(255,255,255,0.4);
        flex-shrink: 0;
    }
    .current-profile-info { flex: 1; min-width: 0; }
    .current-profile-name { font-family: 'Montserrat', sans-serif; font-weight: 800; font-size: 0.95rem; line-height: 1.2; margin-bottom: 3px; }
    .current-profile-meta { font-size: 0.75rem; opacity: 0.8; }

    .edit-features { display: flex; flex-direction: column; gap: 13px; }
    .edit-feature { display: flex; align-items: flex-start; gap: 12px; font-size: 0.88rem; animation: fadeInStagger 0.6s ease-out backwards; }
    .edit-feature:nth-child(1){animation-delay:0.2s;} .edit-feature:nth-child(2){animation-delay:0.3s;}
    .edit-feature:nth-child(3){animation-delay:0.4s;} .edit-feature:nth-child(4){animation-delay:0.5s;}
    .edit-feature:nth-child(5){animation-delay:0.6s;} .edit-feature:nth-child(6){animation-delay:0.7s;}
    .edit-feature i { font-size: 1.1rem; color: white; flex-shrink: 0; margin-top: 1px; }
    .feature-info { display: flex; flex-direction: column; gap: 1px; }
    .feature-label { font-weight: 700; line-height: 1.3; }
    .feature-desc  { font-size: 0.75rem; opacity: 0.8; font-weight: 400; }

    .admin-notice {
        margin-top: 22px; padding: 13px 15px;
        background: rgba(255,255,255,0.15);
        border-radius: 12px; border: 1px solid rgba(255,255,255,0.25);
        font-size: 0.78rem; line-height: 1.55;
        display: flex; align-items: flex-start; gap: 10px;
    }
    .admin-notice i { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

    /* RIGHT FORM */
    .edit-form-section {
        padding: 38px 46px; display: flex; flex-direction: column;
        background: var(--pure-white); animation: slideInUp 0.6s ease-out 0.1s backwards;
        max-height: 95vh; overflow-y: auto;
    }
    .edit-form-section::-webkit-scrollbar { width: 4px; }
    .edit-form-section::-webkit-scrollbar-track { background: #f1f1f1; }
    .edit-form-section::-webkit-scrollbar-thumb { background: var(--primary-orange); border-radius: 4px; }

    .edit-form-header { margin-bottom: 22px; }
    .edit-form-title { font-family: 'Montserrat', sans-serif; font-size: 1.9rem; font-weight: 900; color: var(--deep-charcoal); margin-bottom: 5px; letter-spacing: -0.5px; }
    .edit-form-title-accent { color: var(--primary-orange); background: linear-gradient(135deg, var(--primary-orange), var(--orange-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .edit-form-subtitle { font-size: 0.83rem; color: #888; font-weight: 400; }

    /* Section labels */
    .form-section-label {
        font-family: 'Montserrat', sans-serif; font-size: 0.72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 1.5px; color: var(--primary-orange);
        margin: 20px 0 14px 0; display: flex; align-items: center; gap: 10px;
    }
    .form-section-label::after { content: ''; flex: 1; height: 1px; background: linear-gradient(to right, rgba(255,122,0,0.3), transparent); }
    .form-section-label i { font-size: 0.85rem; }

    /* Alerts */
    .alert-success { display: flex; gap: 12px; padding: 12px 16px; background: #f0fdf4; border-left: 4px solid var(--success-green); border-radius: 10px; margin-bottom: 18px; }
    .alert-success i { color: var(--success-green); font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
    .alert-success-message { font-size: 0.82rem; color: #166534; font-weight: 600; }

    .alert-error { display: flex; gap: 12px; padding: 12px 16px; background: #fef2f2; border-left: 4px solid var(--error-red); border-radius: 10px; margin-bottom: 18px; }
    .alert-error i { color: var(--error-red); font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
    .alert-error-message { font-size: 0.8rem; color: #c5453f; padding: 2px 0; }
    .alert-error-message:first-child { font-weight: 700; color: var(--error-red); margin-bottom: 4px; }

    /* Form elements */
    .form-group  { margin-bottom: 16px; }
    .form-row    { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .form-label  { display: block; font-family: 'Montserrat', sans-serif; font-size: 0.67rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.4px; margin-bottom: 7px; color: var(--deep-charcoal); }
    .form-label.required::after { content: ' *'; color: var(--error-red); }

    .input-peso-wrapper { position: relative; }
    .input-peso-prefix { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 0.92rem; font-weight: 700; color: var(--primary-orange); pointer-events: none; z-index: 1; }
    .input-peso-wrapper .form-control-custom { padding-left: 30px; }

    .form-control-custom {
        width: 100%; background: var(--light-gray); border: 2px solid transparent;
        border-radius: 12px; padding: 12px 16px; font-size: 0.92rem;
        transition: all 0.3s ease-out; font-family: 'Inter', sans-serif; color: var(--deep-charcoal);
        appearance: none; -webkit-appearance: none;
    }
    .form-control-custom::placeholder { color: #bbb; }
    .form-control-custom:focus { outline: none; background: var(--pure-white); border-color: var(--primary-orange); box-shadow: 0 6px 20px rgba(255,122,0,0.12); transform: translateY(-1px); }
    .form-control-custom.is-error   { border-color: var(--error-red);    background: #fff5f5; }
    .form-control-custom.is-success { border-color: var(--success-green); background: #f0fdf4; }
    textarea.form-control-custom { resize: vertical; min-height: 110px; }

    /* Budget range preview */
    .budget-range-preview {
        display: none; margin-top: 10px; padding: 11px 15px;
        background: #fff8f0; border-left: 4px solid var(--primary-orange);
        border-radius: 0 10px 10px 0; font-size: 0.8rem; color: #555; line-height: 1.55;
    }
    .budget-range-preview.show { display: block; }
    .budget-range-preview.error-state { background: #fff5f5; border-left-color: var(--error-red); color: var(--error-red); }
    .budget-range-preview strong { color: var(--primary-orange); }
    .budget-range-preview.error-state strong { color: var(--error-red); }

    /* Image preview */
    .image-preview-wrapper {
        display: none; margin-top: 10px;
        border-radius: 12px; overflow: hidden;
        border: 2px solid rgba(39,174,96,0.3);
        background: #f0fdf4; padding: 8px;
        align-items: center; gap: 12px;
    }
    .image-preview-wrapper.show { display: flex; }
    .image-preview-thumb { width: 64px; height: 64px; border-radius: 10px; object-fit: cover; flex-shrink: 0; border: 1px solid rgba(39,174,96,0.2); }
    .image-preview-info { flex: 1; min-width: 0; }
    .image-preview-name { font-size: 0.78rem; font-weight: 700; color: var(--success-green); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .image-preview-size { font-size: 0.68rem; color: #888; margin-top: 2px; }
    .image-remove-btn { background: none; border: none; color: var(--error-red); cursor: pointer; font-size: 1rem; padding: 4px; flex-shrink: 0; }

    /* Current image display */
    .current-image-display {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 14px; background: #f9f9f9;
        border-radius: 12px; border: 1px solid var(--border-gray);
        margin-bottom: 12px;
    }
    .current-image-display img { width: 52px; height: 52px; border-radius: 10px; object-fit: cover; border: 1px solid var(--border-gray); }
    .current-image-label { font-size: 0.75rem; color: #888; font-weight: 600; font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 0.8px; }
    .current-image-name  { font-size: 0.82rem; color: var(--deep-charcoal); font-weight: 600; margin-top: 1px; }

    /* File upload */
    .file-upload-input {
        width: 100%; background: var(--light-gray); border: 2px dashed var(--border-gray);
        border-radius: 12px; padding: 12px 16px; font-size: 0.88rem;
        transition: all 0.3s ease-out; font-family: 'Inter', sans-serif; color: var(--deep-charcoal);
        cursor: pointer;
    }
    .file-upload-input:hover, .file-upload-input:focus { outline: none; border-color: var(--primary-orange); background: #fff8f0; }
    .file-upload-input.has-file { border-color: var(--success-green); border-style: solid; background: #f0fdf4; }
    .file-hint { font-size: 0.68rem; color: #999; display: flex; align-items: center; gap: 5px; margin-top: 6px; }
    .file-hint i { color: var(--primary-orange); font-size: 0.72rem; }

    /* Field validation */
    .field-validation { font-size: 0.7rem; margin-top: 5px; display: none; align-items: center; gap: 4px; }
    .field-validation.error   { display: flex; color: var(--error-red); }
    .field-validation.success { display: flex; color: var(--success-green); }
    .field-validation i { font-size: 0.8rem; }

    /* Submit button */
    .btn-save {
        width: 100%; background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
        color: white; border: none; border-radius: 12px; padding: 14px;
        font-size: 0.92rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;
        cursor: pointer; margin-top: 18px; transition: all 0.3s ease-out;
        font-family: 'Montserrat', sans-serif; box-shadow: 0 8px 25px rgba(255,122,0,0.25);
        position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-save::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s; }
    .btn-save:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(255,122,0,0.35); }
    .btn-save:hover:not(:disabled)::before { left: 100%; }
    .btn-save:disabled { opacity: 0.75; cursor: not-allowed; }
    .btn-spinner { display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.35); border-top-color: white; border-radius: 50%; animation: spin 0.8s linear infinite; }
    .btn-save.loading .btn-spinner { display: inline-block; }
    .btn-save.loading i { display: none; }

    .security-badge { display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 0.73rem; color: var(--success-green); font-weight: 600; margin-top: 14px; padding: 9px; background: #f0fdf4; border-radius: 10px; border: 1px solid rgba(39,174,96,0.2); }

    .back-section { text-align: center; margin-top: 18px; padding-top: 18px; border-top: 1px solid var(--border-gray); }
    .back-text { font-size: 0.83rem; color: #666; margin-bottom: 5px; }
    .back-link { color: var(--primary-orange); text-decoration: none; font-weight: 700; font-size: 0.88rem; transition: all 0.3s; position: relative; }
    .back-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: var(--primary-orange); transition: width 0.3s; }
    .back-link:hover::after { width: 100%; }

    .footer-links { display: flex; justify-content: center; gap: 30px; padding: 18px; border-top: 1px solid var(--border-gray); background: var(--light-gray); font-size: 0.78rem; }
    .footer-links a { color: #666; text-decoration: none; font-weight: 600; transition: color 0.3s; }
    .footer-links a:hover { color: var(--primary-orange); }

    @media (max-width: 1024px) {
        .edit-wrapper { grid-template-columns: 1fr; }
        .edit-image-section { display: none; }
        .edit-container { max-width: 520px; }
        .edit-form-section { padding: 35px 32px; max-height: none; }
    }
    @media (max-width: 600px) {
        .edit-page-wrapper { padding: 16px; }
        .edit-form-section { padding: 28px 20px; }
        .edit-form-title { font-size: 1.7rem; }
        .form-row { grid-template-columns: 1fr; }
        .footer-links { gap: 14px; flex-wrap: wrap; }
    }
</style>

<div class="edit-page-wrapper">
    <div class="edit-container">
        <div class="edit-wrapper">

            {{-- LEFT PANEL --}}
            <div class="edit-image-section">
                <div class="edit-panel-content">
                    <i class="bi bi-pencil-square edit-panel-icon"></i>
                    <h2 class="edit-panel-title">Edit Your<br>Business Profile</h2>
                    <p class="edit-panel-text">
                        Keep your listing accurate and up-to-date so customers can find and book you with confidence.
                    </p>

                    {{-- Current Profile Card --}}
                    <div class="current-profile-card">
                        <img src="{{ asset('storage/' . $caterer->profile_picture) }}" class="current-profile-avatar" alt="Profile">
                        <div class="current-profile-info">
                            <div class="current-profile-name">{{ $caterer->business_name }}</div>
                            <div class="current-profile-meta">{{ $caterer->location }}</div>
                            <div class="current-profile-meta" style="margin-top:3px; opacity:0.7;">
                                ₱{{ number_format($caterer->min_budget ?? $caterer->price_per_guest) }} – ₱{{ number_format($caterer->max_budget ?? $caterer->price_per_guest) }} per guest
                            </div>
                        </div>
                    </div>

                    <div class="edit-features">
                        <div class="edit-feature">
                            <i class="bi bi-shop-window"></i>
                            <div class="feature-info">
                                <span class="feature-label">Business Name</span>
                                <span class="feature-desc">Your public listing name</span>
                            </div>
                        </div>
                        <div class="edit-feature">
                            <i class="bi bi-telephone-fill"></i>
                            <div class="feature-info">
                                <span class="feature-label">Contact Number</span>
                                <span class="feature-desc">How customers reach you</span>
                            </div>
                        </div>
                        <div class="edit-feature">
                            <i class="bi bi-cash-coin"></i>
                            <div class="feature-info">
                                <span class="feature-label">Starting &amp; Maximum Price</span>
                                <span class="feature-desc">Your per-guest price range</span>
                            </div>
                        </div>
                        <div class="edit-feature">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div class="feature-info">
                                <span class="feature-label">Service Area</span>
                                <span class="feature-desc">Where you cater events</span>
                            </div>
                        </div>
                        <div class="edit-feature">
                            <i class="bi bi-card-text"></i>
                            <div class="feature-info">
                                <span class="feature-label">Specialty &amp; Description</span>
                                <span class="feature-desc">Your menus and what you offer</span>
                            </div>
                        </div>
                        <div class="edit-feature">
                            <i class="bi bi-image-fill"></i>
                            <div class="feature-info">
                                <span class="feature-label">Profile Photo / Logo</span>
                                <span class="feature-desc">First impression in the directory</span>
                            </div>
                        </div>
                    </div>

                    <div class="admin-notice">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Permits and verification status are managed by CaterConnect administrators and cannot be changed here.</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT FORM --}}
            <div class="edit-form-section">
                <div class="edit-form-header">
                    <h1 class="edit-form-title">Edit <span class="edit-form-title-accent">Business Profile</span> ✏️</h1>
                    <p class="edit-form-subtitle">Changes reflect instantly on your public marketplace listing</p>
                </div>

                {{-- Success message --}}
                @if (session('success'))
                    <div class="alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <div class="alert-success-message">{{ session('success') }}</div>
                    </div>
                @endif

                {{-- Error messages --}}
                @if ($errors->any())
                    <div class="alert-error">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <div class="alert-error-message">Please fix the errors below before saving:</div>
                            @foreach ($errors->all() as $error)
                                <div class="alert-error-message">• {{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form action="{{ route('caterer.update') }}" method="POST" enctype="multipart/form-data" id="editCatererForm">
                    @csrf
                    @method('PUT')

                    {{-- SECTION 1: BUSINESS INFORMATION --}}
                    <div class="form-section-label"><i class="bi bi-shop"></i> Business Information</div>

                    {{-- Business Name --}}
                    <div class="form-group">
                        <label class="form-label required" for="businessNameInput">Business Name</label>
                        <input type="text" name="business_name" id="businessNameInput"
                            class="form-control-custom @error('business_name') is-error @enderror"
                            placeholder="e.g. Adok's Catering Services"
                            value="{{ old('business_name', $caterer->business_name) }}" required>
                        <div class="field-validation" id="businessNameValidation"></div>
                    </div>

                    {{-- Contact Number --}}
                    <div class="form-group">
                        <label class="form-label required" for="contactInput">Catering Contact Number</label>
                        <input type="tel" name="contact_number" id="contactInput"
                            class="form-control-custom @error('contact_number') is-error @enderror"
                            placeholder="e.g. 09XX XXX XXXX"
                            value="{{ old('contact_number', $caterer->contact_number) }}"
                            required maxlength="13">
                        <div class="field-validation" id="contactValidation"></div>
                    </div>

                    {{-- Service Area --}}
                    <div class="form-group">
                        <label class="form-label required" for="serviceAreaInput">Service Area Coverage</label>
                        <input type="text" name="location" id="serviceAreaInput"
                            class="form-control-custom @error('location') is-error @enderror"
                            placeholder="e.g. Cebu City, Mandaue City, Talisay City"
                            value="{{ old('location', $caterer->location) }}" required>
                        <div class="field-validation" id="serviceAreaValidation"></div>
                    </div>

                    {{-- Specialty / Description --}}
                    <div class="form-group">
                        <label class="form-label required" for="specialtyInput">Specialty / Menu &amp; Service Description</label>
                        <textarea name="specialty" id="specialtyInput"
                            class="form-control-custom @error('specialty') is-error @enderror"
                            placeholder="e.g. Filipino buffet, lechon, pasta stations — describe your specialties and what you offer"
                            required>{{ old('specialty', $caterer->specialty) }}</textarea>
                        <div class="field-validation" id="specialtyValidation"></div>
                    </div>

                    {{-- SECTION 2: PRICING --}}
                    <div class="form-section-label"><i class="bi bi-cash-coin"></i> Package Pricing per Guest</div>

                    <div class="form-row">
                        {{-- Starting Price --}}
                        <div class="form-group">
                            <label class="form-label required" for="minBudgetInput">Starting Price per Guest (₱)</label>
                            <div class="input-peso-wrapper">
                                <span class="input-peso-prefix">₱</span>
                                <input type="number" name="min_budget" id="minBudgetInput"
                                    class="form-control-custom @error('min_budget') is-error @enderror"
                                    placeholder="e.g. 250"
                                    value="{{ old('min_budget', $caterer->min_budget ?? $caterer->price_per_guest) }}"
                                    min="0" step="50" required>
                            </div>
                            <div style="font-size:0.67rem;color:#999;margin-top:5px;line-height:1.4;">Lowest price for your basic package.</div>
                            <div class="field-validation" id="minBudgetValidation"></div>
                        </div>

                        {{-- Maximum Price --}}
                        <div class="form-group">
                            <label class="form-label required" for="maxBudgetInput">Maximum Price per Guest (₱)</label>
                            <div class="input-peso-wrapper">
                                <span class="input-peso-prefix">₱</span>
                                <input type="number" name="max_budget" id="maxBudgetInput"
                                    class="form-control-custom @error('max_budget') is-error @enderror"
                                    placeholder="e.g. 1200"
                                    value="{{ old('max_budget', $caterer->max_budget ?? $caterer->price_per_guest) }}"
                                    min="0" step="50" required>
                            </div>
                            <div style="font-size:0.67rem;color:#999;margin-top:5px;line-height:1.4;">Highest price for your premium package.</div>
                            <div class="field-validation" id="maxBudgetValidation"></div>
                        </div>
                    </div>

                    {{-- Budget Range Live Preview --}}
                    <div class="budget-range-preview" id="budgetRangePreview">
                        <i class="bi bi-calculator-fill" style="color:var(--primary-orange);margin-right:6px;"></i>
                        Your catering accepts budgets of <strong id="budgetRangeText"></strong> per guest.
                        Customers searching within this range will see your listing.
                    </div>

                    {{-- SECTION 3: PROFILE BRANDING --}}
                    <div class="form-section-label" style="margin-top:20px;"><i class="bi bi-image-fill"></i> Profile Branding</div>

                    {{-- Current Image --}}
                    <div class="current-image-display">
                        <img src="{{ asset('storage/' . $caterer->profile_picture) }}" alt="Current Profile">
                        <div>
                            <div class="current-image-label">Current Profile Photo</div>
                            <div class="current-image-name">{{ basename($caterer->profile_picture) }}</div>
                        </div>
                    </div>

                    {{-- Upload New Image --}}
                    <div class="form-group">
                        <label class="form-label" for="profilePictureInput">Upload New Photo or Logo <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#aaa;">(optional)</span></label>
                        <input type="file" name="profile_picture" id="profilePictureInput"
                            class="file-upload-input @error('profile_picture') is-error @enderror"
                            accept=".jpg,.jpeg,.png">
                        <div class="file-hint">
                            <i class="bi bi-info-circle-fill"></i>
                            Leave blank to keep your current photo. Accepted: JPG, PNG (max 3MB). Recommended: square 1:1 ratio.
                        </div>
                        {{-- Live image preview --}}
                        <div class="image-preview-wrapper" id="imagePreviewWrapper">
                            <img src="" alt="Preview" class="image-preview-thumb" id="imagePreviewThumb">
                            <div class="image-preview-info">
                                <div class="image-preview-name" id="imagePreviewName"></div>
                                <div class="image-preview-size" id="imagePreviewSize"></div>
                            </div>
                            <button type="button" class="image-remove-btn" id="imageRemoveBtn" title="Remove">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        </div>
                    </div>

                    {{-- SAVE BUTTON --}}
                    <button type="submit" class="btn-save" id="saveBtn">
                        <i class="bi bi-check-circle-fill"></i>
                        <span id="btnText">Save Changes</span>
                        <div class="btn-spinner"></div>
                    </button>

                    <div class="security-badge">
                        <i class="bi bi-shield-check"></i>
                        Permits and verification status are managed by administrators
                    </div>
                </form>

                <div class="back-section">
                    <p class="back-text">Done editing?</p>
                    <a href="{{ route('dashboard') }}" class="back-link">← Back to Dashboard</a>
                </div>
            </div>
        </div>

        <div class="footer-links">
            <a href="{{ route('dashboard') }}"><i class="bi bi-grid-fill" style="margin-right:4px;"></i>Dashboard</a>
            <a href="#"><i class="bi bi-question-circle" style="margin-right:4px;"></i>Help Center</a>
        </div>
    </div>
</div>

<script>
/* ── VALIDATION HELPERS ─────────────────────────────── */
function showV(id, msg, valid) {
    var inp = document.getElementById(id + 'Input');
    var box = document.getElementById(id + 'Validation');
    if (!inp || !box) return;
    inp.classList.toggle('is-error',   !valid);
    inp.classList.toggle('is-success',  valid);
    box.className = 'field-validation ' + (valid ? 'success' : 'error');
    box.innerHTML = '<i class="bi bi-' + (valid ? 'check-circle-fill' : 'exclamation-circle-fill') + '"></i><span>' + msg + '</span>';
}
function clearV(id) {
    var inp = document.getElementById(id + 'Input');
    var box = document.getElementById(id + 'Validation');
    if (!inp || !box) return;
    inp.classList.remove('is-error','is-success');
    box.className = 'field-validation'; box.innerHTML = '';
}

/* ── BUSINESS NAME ──────────────────────────────────── */
var bnInput = document.getElementById('businessNameInput');
if (bnInput) {
    bnInput.addEventListener('blur', function() {
        if (this.value.trim().length < 3) showV('businessName','Please enter a valid business name.',false);
        else showV('businessName','Looks good!',true);
    });
    bnInput.addEventListener('input', function() { if (this.classList.contains('is-success')) clearV('businessName'); });
}

/* ── CONTACT NUMBER ─────────────────────────────────── */
var ctInput = document.getElementById('contactInput');
function isValidPhone(p) { return /^(\+63|0)[0-9]{10}$/.test(p.replace(/[\s\-]/g,'')); }
if (ctInput) {
    ctInput.addEventListener('blur', function() {
        if (!this.value) return;
        if (!isValidPhone(this.value)) showV('contact','Enter a valid Philippine mobile number (e.g. 09XX XXX XXXX).',false);
        else showV('contact','Contact number is valid.',true);
    });
    ctInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9+\s\-]/g,'');
        if (this.classList.contains('is-success')) clearV('contact');
    });
}

/* ── SERVICE AREA ───────────────────────────────────── */
var saInput = document.getElementById('serviceAreaInput');
if (saInput) {
    saInput.addEventListener('blur', function() {
        if (this.value.trim().length < 3) showV('serviceArea','Please enter your service area coverage.',false);
        else showV('serviceArea','Service area saved.',true);
    });
    saInput.addEventListener('input', function() { if (this.classList.contains('is-success')) clearV('serviceArea'); });
}

/* ── SPECIALTY ──────────────────────────────────────── */
var spInput = document.getElementById('specialtyInput');
if (spInput) {
    spInput.addEventListener('blur', function() {
        if (this.value.trim().length < 20) showV('specialty','Please provide a more detailed description (at least 20 characters).',false);
        else showV('specialty','Description looks good!',true);
    });
    spInput.addEventListener('input', function() { if (this.classList.contains('is-success')) clearV('specialty'); });
}

/* ── BUDGET RANGE PREVIEW ───────────────────────────── */
var minInput   = document.getElementById('minBudgetInput');
var maxInput   = document.getElementById('maxBudgetInput');
var preview    = document.getElementById('budgetRangePreview');

function updateBudget() {
    var min = parseFloat(minInput ? minInput.value : 0);
    var max = parseFloat(maxInput ? maxInput.value : 0);
    if (min > 0 || max > 0) {
        preview.classList.add('show');
        if (min > 0 && max > 0 && min > max) {
            preview.classList.add('error-state');
            preview.innerHTML = '<i class="bi bi-exclamation-triangle-fill" style="margin-right:6px;"></i><strong>Starting price cannot exceed maximum price.</strong> Please correct your values.';
            if (minInput) minInput.classList.add('is-error');
            if (maxInput) maxInput.classList.add('is-error');
        } else {
            preview.classList.remove('error-state');
            if (minInput) { minInput.classList.remove('is-error'); if (min > 0) minInput.classList.add('is-success'); }
            if (maxInput) { maxInput.classList.remove('is-error'); if (max > 0) maxInput.classList.add('is-success'); }
            var minStr = min > 0 ? '₱' + min.toLocaleString('en-PH') : '—';
            var maxStr = max > 0 ? '₱' + max.toLocaleString('en-PH') : '—';
            preview.innerHTML =
                '<i class="bi bi-calculator-fill" style="color:var(--primary-orange);margin-right:6px;"></i>' +
                'Your catering accepts budgets of <strong>' + minStr + ' – ' + maxStr + '</strong> per guest. ' +
                'Customers searching within this range will see your listing.';
        }
    } else {
        preview.classList.remove('show','error-state');
    }
}
if (minInput) minInput.addEventListener('input', updateBudget);
if (maxInput) maxInput.addEventListener('input', updateBudget);
updateBudget(); // Run on load to show existing values

/* ── IMAGE PREVIEW ──────────────────────────────────── */
var profileInput   = document.getElementById('profilePictureInput');
var previewWrapper = document.getElementById('imagePreviewWrapper');
var previewThumb   = document.getElementById('imagePreviewThumb');
var previewName    = document.getElementById('imagePreviewName');
var previewSize    = document.getElementById('imagePreviewSize');
var removeBtn      = document.getElementById('imageRemoveBtn');

function formatBytes(b) {
    if (b < 1024) return b + ' B';
    if (b < 1048576) return (b/1024).toFixed(1) + ' KB';
    return (b/1048576).toFixed(1) + ' MB';
}

if (profileInput) {
    profileInput.addEventListener('change', function() {
        var file = this.files && this.files[0];
        if (!file) { previewWrapper.classList.remove('show'); return; }
        if (file.size > 3 * 1024 * 1024) {
            alert('File is too large. Maximum size is 3MB.');
            this.value = ''; previewWrapper.classList.remove('show'); return;
        }
        if (!file.type.match(/image\/(jpeg|png)/)) {
            alert('Only JPG and PNG images are accepted.');
            this.value = ''; previewWrapper.classList.remove('show'); return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            previewThumb.src = e.target.result;
            previewName.textContent = file.name;
            previewSize.textContent = formatBytes(file.size);
            previewWrapper.classList.add('show');
            profileInput.classList.add('has-file');
        };
        reader.readAsDataURL(file);
    });
}
if (removeBtn) {
    removeBtn.addEventListener('click', function() {
        if (profileInput) { profileInput.value = ''; profileInput.classList.remove('has-file'); }
        previewWrapper.classList.remove('show');
        previewThumb.src = '';
    });
}

/* ── FORM SUBMIT ────────────────────────────────────── */
var editForm = document.getElementById('editCatererForm');
var saveBtn  = document.getElementById('saveBtn');
var btnText  = document.getElementById('btnText');

if (editForm) {
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        var valid = true;

        if (bnInput && bnInput.value.trim().length < 3)          { showV('businessName','Please enter a valid business name.',false); valid = false; }
        if (ctInput && ctInput.value && !isValidPhone(ctInput.value)) { showV('contact','Please enter a valid Philippine mobile number.',false); valid = false; }
        if (saInput && saInput.value.trim().length < 3)          { showV('serviceArea','Please enter your service area coverage.',false); valid = false; }
        if (spInput && spInput.value.trim().length < 20)         { showV('specialty','Please provide a more detailed description.',false); valid = false; }

        var min = parseFloat(minInput ? minInput.value : 0);
        var max = parseFloat(maxInput ? maxInput.value : 0);
        if (!min || min <= 0) { showV('minBudget','Please enter your starting price per guest.',false); valid = false; }
        if (!max || max <= 0) { showV('maxBudget','Please enter your maximum price per guest.',false); valid = false; }
        if (min > 0 && max > 0 && min > max) { showV('maxBudget','Maximum price must be ≥ starting price.',false); valid = false; }

        if (!valid) { window.scrollTo({ top: 0, behavior: 'smooth' }); return false; }

        saveBtn.classList.add('loading');
        saveBtn.disabled = true;
        btnText.textContent = 'Saving Changes...';
        setTimeout(function() { editForm.submit(); }, 400);
    });
}
</script>

@endsection