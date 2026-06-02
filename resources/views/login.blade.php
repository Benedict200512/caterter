@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@1,700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-orange: #FF7A00;
        --orange-light: #ff9f2f;
        --deep-charcoal: #1a1a1a;
        --charcoal-light: #2c2c2c;
        --pure-white: #ffffff;
        --ui-accent: #f8f9fa;
        --light-gray: #f5f5f5;
        --error-red: #e74c3c;
        --success-green: #27ae60;
        --border-gray: #e0e0e0;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        width: 100%;
        overflow-x: hidden;
    }

    #app, main {
        padding: 0 !important;
        margin: 0 !important;
        width: 100%;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    /* ===== ANIMATIONS (Removed floating effects) ===== */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInStagger {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== BACKGROUND ===== */
    .back-home-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 999px;
    background: var(--light-gray);
    border: 1px solid var(--border-gray);
    color: #666;
    text-decoration: none;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 16px;
    transition: all 0.2s ease;
}
.back-home-btn:hover {
    border-color: var(--primary-orange);
    color: var(--primary-orange);
}
    .login-page-wrapper {
        background: linear-gradient(135deg, var(--deep-charcoal) 0%, var(--charcoal-light) 100%);
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 20px;
        position: relative;
        overflow: hidden;
    }

    .login-page-wrapper::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        top: -50%;
        left: -50%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255, 122, 0, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 159, 47, 0.08) 0%, transparent 50%);
        pointer-events: none;
    }



    /* ===== LOGIN CONTAINER ===== */
    .login-container {
        width: 100%;
        max-width: 950px;
        background: var(--pure-white);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        animation: slideInUp 0.6s ease-out;
        position: relative;
        z-index: 1;
    }

    .login-wrapper {
        display: grid;
        grid-template-columns: 1fr 1.1fr;
        min-height: auto;
    }

    /* ===== LEFT SIDE: IMAGE + TAGLINE ===== */
    .login-image-section {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--orange-light) 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 45px;
        color: white;
        min-height: 520px;
    }

    .login-image-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><pattern id="dots" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="1200" height="600" fill="url(%23dots)"/></svg>');
        pointer-events: none;
        animation: slideInLeft 0.6s ease-out;
    }

    .login-image-section::after {
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        top: -30px;
        right: -60px;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="100" cy="100" r="90" fill="rgba(255,255,255,0.08)"/><text x="100" y="110" font-size="80" text-anchor="middle">🍽️</text></svg>');
        background-size: contain;
        background-repeat: no-repeat;
        opacity: 0.15;
        pointer-events: none;
    }

    .login-tagline-content {
        position: relative;
        z-index: 2;
        animation: slideInLeft 0.8s ease-out;
    }

    .login-tagline-icon {
        font-size: 3rem;
        margin-bottom: 16px;
        display: inline-block;
    }

    .login-tagline-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 2.2rem;
        font-weight: 900;
        line-height: 1.2;
        margin-bottom: 14px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .login-tagline-text {
        font-size: 0.95rem;
        opacity: 0.95;
        line-height: 1.6;
        margin-bottom: 28px;
        font-weight: 400;
    }

    /* Features list */
    .login-features {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .login-feature {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        animation: fadeInStagger 0.6s ease-out backwards;
    }

    .login-feature:nth-child(1) { animation-delay: 0.2s; }
    .login-feature:nth-child(2) { animation-delay: 0.3s; }
    .login-feature:nth-child(3) { animation-delay: 0.4s; }

    .login-feature i {
        font-size: 1.2rem;
        color: white;
        flex-shrink: 0;
    }

    /* ===== RIGHT SIDE: FORM ===== */
    .login-form-section {
        padding: 40px 45px;
        display: flex;
        flex-direction: column;
        background: var(--pure-white);
        animation: slideInUp 0.6s ease-out 0.1s backwards;
        min-height: 520px;
        justify-content: flex-start;
    }

    .login-form-header {
        margin-bottom: 25px;
        animation: slideInUp 0.6s ease-out 0.2s backwards;
    }

    .login-form-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 2rem;
        font-weight: 900;
        color: var(--deep-charcoal);
        margin-bottom: 6px;
        letter-spacing: -0.5px;
    }

    .login-form-title-accent {
        color: var(--primary-orange);
        background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .login-form-subtitle {
        font-size: 0.85rem;
        color: #888;
        font-weight: 400;
    }

    /* ===== ERROR ALERT ===== */
    .alert-error {
        display: flex;
        gap: 12px;
        padding: 12px 16px;
        background: #fef2f2;
        border-left: 4px solid var(--error-red);
        border-radius: 10px;
        margin-bottom: 20px;
        animation: slideInUp 0.4s ease-out;
    }

    .alert-error i {
        color: var(--error-red);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .alert-error-title {
        font-weight: 700;
        color: var(--error-red);
        margin-bottom: 4px;
        font-size: 0.8rem;
    }

    .alert-error-message {
        font-size: 0.75rem;
        color: #c5453f;
    }

    /* ===== FORM ELEMENTS ===== */
    .form-group {
        margin-bottom: 18px;
        animation: fadeInStagger 0.6s ease-out backwards;
    }

    .form-group:nth-child(1) { animation-delay: 0.3s; }
    .form-group:nth-child(2) { animation-delay: 0.4s; }

    .form-label {
        display: block;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 8px;
        color: var(--deep-charcoal);
    }

    .form-input-wrapper {
        position: relative;
    }

    .form-control-custom {
        width: 100%;
        background: var(--light-gray);
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 13px 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease-out;
        font-family: 'Inter', sans-serif;
        color: var(--deep-charcoal);
    }

    .form-control-custom::placeholder {
        color: #bbb;
    }

    .form-control-custom:focus {
        outline: none;
        background: var(--pure-white);
        border-color: var(--primary-orange);
        box-shadow: 0 6px 20px rgba(255, 122, 0, 0.12);
        transform: translateY(-1px);
    }

    .form-control-custom.error {
        border-color: var(--error-red);
        background: #fff5f5;
    }

    /* Password strength indicator */
    .password-strength {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .strength-bars {
        display: flex;
        gap: 3px;
    }

    .strength-bar {
        width: 6px;
        height: 3px;
        background: #e0e0e0;
        border-radius: 2px;
        transition: background 0.3s;
    }

    .strength-bar.weak { background: var(--error-red); }
    .strength-bar.medium { background: #f39c12; }
    .strength-bar.strong { background: var(--success-green); }

    .password-toggle-btn {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 1rem;
        transition: color 0.3s;
        padding: 4px;
    }

    .password-toggle-btn:hover {
        color: var(--primary-orange);
    }

    .forgot-password-link {
        text-align: right;
        margin-top: 8px;
    }

    .forgot-password-link a {
        font-size: 0.75rem;
        color: var(--primary-orange);
        text-decoration: none;
        font-weight: 600;
        transition: opacity 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .forgot-password-link a:hover {
        opacity: 0.8;
    }

    /* ===== BUTTONS ===== */
    .btn-login {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-orange), var(--orange-light));
        color: white;
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-size: 0.95rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        margin-top: 20px;
        transition: all 0.3s ease-out;
        font-family: 'Montserrat', sans-serif;
        box-shadow: 0 8px 25px rgba(255, 122, 0, 0.25);
        position: relative;
        overflow: hidden;
        animation: fadeInStagger 0.6s ease-out 0.5s backwards;
    }

    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(255, 122, 0, 0.35);
    }

    .btn-login:hover::before {
        left: 100%;
    }

    .btn-login:active {
        transform: translateY(-1px);
    }

    .btn-login.loading {
        opacity: 0.8;
        cursor: not-allowed;
    }

    .btn-login.loading::after {
        content: '';
        position: absolute;
        width: 14px;
        height: 14px;
        top: 50%;
        right: 18px;
        margin-top: -7px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ===== SECURITY BADGE ===== */
    .security-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 0.75rem;
        color: var(--success-green);
        font-weight: 600;
        margin-top: 16px;
        padding: 10px;
        background: #f0fdf4;
        border-radius: 10px;
        border: 1px solid rgba(39, 174, 96, 0.2);
        animation: fadeInStagger 0.6s ease-out 0.6s backwards;
    }

    .security-badge i {
        font-size: 0.9rem;
    }

    /* ===== DIVIDER ===== */
    .divider-section {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 22px 0;
        animation: fadeInStagger 0.6s ease-out 0.7s backwards;
    }

    .divider-line {
        flex: 1;
        height: 1px;
        background: var(--border-gray);
    }

    .divider-text {
        font-size: 0.7rem;
        color: #bbb;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ===== SOCIAL LOGIN ===== */
    .social-login-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        animation: fadeInStagger 0.6s ease-out 0.8s backwards;
    }

    .btn-social {
        border: 2px solid var(--border-gray);
        background: white;
        border-radius: 10px;
        padding: 12px 12px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease-out;
        font-family: 'Montserrat', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .btn-social::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--light-gray);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s;
        z-index: -1;
    }

    .btn-social:hover::before {
        transform: scaleX(1);
    }

    .btn-social:hover {
        border-color: var(--primary-orange);
        color: var(--primary-orange);
        transform: translateY(-1px);
    }

    .btn-social i {
        font-size: 1rem;
    }

    .btn-social.google:hover {
        background: white;
        border-color: #4285f4;
        color: #4285f4;
    }

    .btn-social.facebook:hover {
        background: white;
        border-color: #1877f2;
        color: #1877f2;
    }

    /* ===== SIGNUP SECTION ===== */
    .signup-section {
        text-align: center;
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid var(--border-gray);
        animation: fadeInStagger 0.6s ease-out 0.9s backwards;
    }

    .signup-text {
        font-size: 0.85rem;
        color: #666;
    }

    .signup-link {
        color: var(--primary-orange);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s;
        position: relative;
    }

    .signup-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--primary-orange);
        transition: width 0.3s;
    }

    .signup-link:hover::after {
        width: 100%;
    }

    /* ===== FOOTER LINKS ===== */
    .footer-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        padding: 14px;
        border-top: 1px solid var(--border-gray);
        background: var(--light-gray);
        font-size: 0.75rem;
        color: #999;
    }

    .footer-links a {
        color: #666;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-links a:hover {
        color: var(--primary-orange);
    }

    .footer-copyright {
        text-align: center;
        font-size: 0.7rem;
        color: #999;
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 1024px) {
        .login-wrapper {
            grid-template-columns: 1fr;
        }

        .login-image-section {
            display: none;
        }

        .login-container {
            max-width: 480px;
        }

        .login-form-section {
            padding: 35px 32px;
            min-height: auto;
        }
    }

    @media (max-width: 768px) {
        .login-page-wrapper {
            padding: 20px 16px;
        }

        .login-form-section {
            padding: 32px 22px;
        }

        .login-form-title {
            font-size: 1.8rem;
        }

        .social-login-buttons {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .login-form-title {
            font-size: 1.6rem;
        }

        .login-form-section {
            padding: 24px 18px;
        }

        .form-label {
            font-size: 0.6rem;
        }

        .btn-login {
            padding: 12px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="login-page-wrapper">
    <div class="login-container">
        <div class="login-wrapper">
            <!-- LEFT SIDE: Orange Panel with Features -->
            <div class="login-image-section">
                <div class="login-tagline-content">
                    <i class="bi bi-cup-hot login-tagline-icon"></i>
                    <h2 class="login-tagline-title">Trusted Catering Made Easy</h2>
                    <p class="login-tagline-text">Book verified caterers for weddings, corporate events, birthdays, and celebrations across Cebu.</p>
                    
                    <div class="login-features">
                        <div class="login-feature">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>100+ Verified Caterers</span>
                        </div>
                        <div class="login-feature">
                            <i class="bi bi-star-fill"></i>
                            <span>4.9/5 Average Rating</span>
                        </div>
                        <div class="login-feature">
                            <i class="bi bi-lightning-fill"></i>
                            <span>Fast Booking Process</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Login Form -->
            <div class="login-form-section">
                <div class="login-form-header">
                    <a href="{{ url('/') }}" class="back-home-btn">
    <i class="bi bi-arrow-left"></i> Back to Home
</a>
                    <h1 class="login-form-title">Welcome <span class="login-form-title-accent">Back</span> 👋</h1>
                    <p class="login-form-subtitle">Sign in to manage your catering bookings and events</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert-error">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div class="alert-error-content">
                            <div class="alert-error-title">Login Failed</div>
                            @foreach ($errors->all() as $error)
                                <div class="alert-error-message">{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ url('/login') }}" method="POST" id="loginForm">
                    @csrf

                    <!-- Email Input -->
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="form-input-wrapper">
                            <input 
                                type="email" 
                                name="email" 
                                class="form-control-custom @error('email') error @enderror" 
                                placeholder="your@email.com" 
                                value="{{ old('email') }}" 
                                required
                                autocomplete="email"
                            >
                        </div>
                    </div>

                    <!-- Password Input with Toggle -->
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="form-input-wrapper">
                            <input 
                                type="password" 
                                name="password" 
                                id="passwordInput" 
                                class="form-control-custom @error('password') error @enderror" 
                                placeholder="Enter your password" 
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="password-toggle-btn" id="passwordToggle">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="password-strength" id="passwordStrength" style="display: none;">
                            <span class="strength-bars">
                                <div class="strength-bar"></div>
                                <div class="strength-bar"></div>
                                <div class="strength-bar"></div>
                            </span>
                            <span id="strengthText"></span>
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="forgot-password-link">
                            <a href="{{ url('/forgot-password') }}">
                                <i class="bi bi-question-circle"></i>
                                Forgot password?
                            </a>
                        </div>
                    </div>

                    <!-- Sign In Button -->
                    <button type="submit" class="btn-login" id="loginBtn">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span id="btnText">Sign In</span>
                    </button>

                    <!-- Security Badge -->
                    <div class="security-badge">
                        <i class="bi bi-shield-check"></i>
                        Your login is securely encrypted
                    </div>
                </form>

                <!-- Divider -->
                <div class="divider-section">
                    <div class="divider-line"></div>
                    <span class="divider-text">OR</span>
                    <div class="divider-line"></div>
                </div>

                <!-- Social Login Buttons -->
                <div class="social-login-buttons">
                    <button type="button" class="btn-social google" onclick="handleGoogleLogin()">
                        <i class="bi bi-google"></i>
                        <span>Google</span>
                    </button>
                    <button type="button" class="btn-social facebook" onclick="handleFacebookLogin()">
                        <i class="bi bi-facebook"></i>
                        <span>Facebook</span>
                    </button>
                </div>

                <!-- Signup Section -->
                <div class="signup-section">
                    <p class="signup-text">
                        New to CaterConnect? 
                        <a href="{{ url('/register') }}" class="signup-link">Create an account</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Links -->
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Help Center</a>
            <span class="footer-copyright">© 2026 CaterConnect. All rights reserved.</span>
        </div>
    </div>
</div>

<script>
    // ===== PASSWORD TOGGLE & STRENGTH INDICATOR =====
    const passwordInput = document.getElementById('passwordInput');
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordStrength = document.getElementById('passwordStrength');
    const strengthBars = document.querySelectorAll('.strength-bar');
    const strengthText = document.getElementById('strengthText');

    // Toggle Password Visibility
    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', function(e) {
            e.preventDefault();
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            this.innerHTML = isPassword 
                ? '<i class="bi bi-eye-slash"></i>' 
                : '<i class="bi bi-eye"></i>';
        });

        // Password Strength Indicator
        passwordInput.addEventListener('input', function(e) {
            const password = e.target.value;
            
            if (password.length === 0) {
                passwordStrength.style.display = 'none';
                return;
            }

            passwordStrength.style.display = 'flex';

            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Reset bars
            strengthBars.forEach(bar => {
                bar.classList.remove('weak', 'medium', 'strong');
            });

            if (strength < 2) {
                for (let i = 0; i < 1; i++) strengthBars[i].classList.add('weak');
                strengthText.textContent = 'Weak';
                strengthText.style.color = '#e74c3c';
            } else if (strength < 4) {
                for (let i = 0; i < 2; i++) strengthBars[i].classList.add('medium');
                strengthText.textContent = 'Medium';
                strengthText.style.color = '#f39c12';
            } else {
                for (let i = 0; i < 3; i++) strengthBars[i].classList.add('strong');
                strengthText.textContent = 'Strong';
                strengthText.style.color = '#27ae60';
            }
        });
    }

    // ===== FORM SUBMISSION WITH LOADING STATE =====
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = document.getElementById('btnText');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            loginBtn.classList.add('loading');
            btnText.textContent = 'Signing in...';
            loginBtn.disabled = true;
        });
    }

    // ===== SOCIAL LOGIN HANDLERS =====
    function handleGoogleLogin() {
        alert('🔐 Google login integration coming soon!\n\nThis will securely connect your Google account.');
    }

    function handleFacebookLogin() {
        alert('🔐 Facebook login integration coming soon!\n\nThis will securely connect your Facebook account.');
    }

    // ===== PREVENT MULTIPLE SUBMISSIONS =====
    if (loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            if (this.disabled) {
                e.preventDefault();
            }
        });
    }

    // ===== FORM VALIDATION =====
    const emailInput = document.querySelector('input[name="email"]');

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            if (this.value && !validateEmail(this.value)) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
    }

    // ===== PAGE LOAD ANIMATION RESET =====
    window.addEventListener('load', function() {
        document.body.style.opacity = '1';
    });
</script>

@endsection