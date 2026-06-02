@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Playfair+Display:ital,wght@1,700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-orange: #FF7A00;
        --deep-charcoal: #1a1a1a;
        --pure-white: #ffffff;
        --ui-accent: #f8f9fa;
        --light-gray: #f5f5f5;
        --cream: #fffbf7;
        --accent-light: #FFE8D6;
    }

    html { scroll-behavior: smooth; }
    body { background-color: var(--pure-white); font-family: 'Inter', sans-serif; color: var(--deep-charcoal); line-height: 1.6; }

    /* ── HERO ── */
    .hero-section {
        padding: clamp(3rem, 6vw, 5rem) 0 clamp(2rem, 4vw, 3rem);
        background-color: var(--cream);
    }

    /* Top row: text left, image right */
    .hero-top-row {
        display: flex;
        align-items: center;
        gap: clamp(2rem, 5vw, 4rem);
        margin-bottom: clamp(2rem, 4vw, 3rem);
    }
    .hero-text-col { flex: 1 1 0; min-width: 0; }
    .hero-img-col {
        flex: 0 0 clamp(280px, 40vw, 460px);
        height: clamp(260px, 38vw, 400px);
        border-radius: clamp(20px, 3vw, 32px);
        overflow: hidden;
        box-shadow: clamp(12px, 2vw, 22px) clamp(12px, 2vw, 22px) 0px var(--deep-charcoal);
        position: relative;
    }
    .hero-img-col img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hero-img-col::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(255,122,0,0.15) 0%, transparent 65%);
        pointer-events: none;
    }

    .hero-title-main {
        font-family: 'Montserrat', sans-serif;
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        font-weight: 900;
        line-height: 1.15;
        letter-spacing: -1px;
        text-transform: uppercase;
        color: var(--deep-charcoal);
        margin-bottom: 0.5rem;
    }
    .hero-title-italic {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-weight: 700;
        color: var(--primary-orange);
        text-transform: none;
        letter-spacing: 0;
    }
    .hero-subtitle {
        font-size: clamp(0.9rem, 1.8vw, 1.05rem);
        color: #555;
        line-height: 1.7;
        max-width: 500px;
        font-weight: 500;
        margin-top: 1rem;
        margin-bottom: 0;
    }

    /* ── Smart Budget Matcher — full-width landscape card ── */
    .search-card-under {
        background: var(--pure-white);
        border: 2px solid var(--deep-charcoal);
        border-radius: 20px;
        padding: clamp(1.4rem, 3vw, 2rem) clamp(1.6rem, 3.5vw, 2.4rem);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .matcher-badge-inline {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,122,0,0.1);
        border: 1px solid rgba(255,122,0,0.25);
        border-radius: 50px;
        padding: 5px 14px;
        font-size: 0.68rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 1.2px;
        color: var(--primary-orange);
        margin-bottom: 10px; width: fit-content;
    }
    .search-card-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 1rem; font-weight: 900;
        color: var(--deep-charcoal); margin-bottom: 3px;
    }
    .search-card-subtitle {
        font-size: 0.77rem; color: #888;
        margin-bottom: 18px; line-height: 1.5;
    }

    /* Landscape fields grid */
    .matcher-fields-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr auto;
        gap: 14px;
        align-items: end;
    }
    .matcher-field { display: flex; flex-direction: column; }

    .form-label-small {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.63rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 1.2px;
        color: var(--deep-charcoal);
        margin-bottom: 7px; display: flex; align-items: center; gap: 5px;
    }
    .form-control-custom {
        background-color: var(--light-gray);
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.165,0.84,0.44,1);
        font-weight: 500; width: 100%;
        font-family: 'Inter', sans-serif;
        color: var(--deep-charcoal);
    }
    .form-control-custom::placeholder { color: #aaa; font-weight: 400; }
    .form-control-custom:focus {
        background-color: #fff;
        border-color: var(--primary-orange);
        box-shadow: 0 4px 12px rgba(255,122,0,0.15);
        outline: none;
    }
    .budget-input-group { position: relative; }
    .budget-prefix {
        position: absolute; left: 13px; top: 50%;
        transform: translateY(-50%);
        font-weight: 800; color: var(--primary-orange);
        font-size: 0.93rem; pointer-events: none; z-index: 1;
    }
    .budget-input-group .form-control-custom { padding-left: 27px; }

    .budget-calc-display {
        margin-top: 10px; padding: 9px 13px;
        background: rgba(255,122,0,0.07);
        border-left: 3px solid var(--primary-orange);
        border-radius: 0 8px 8px 0;
        font-size: 0.77rem; color: #555; display: none;
        grid-column: 1 / -1;
    }
    .budget-calc-display.show { display: block; }
    .budget-calc-display strong { color: var(--primary-orange); }

    .btn-match-orange {
        background: var(--primary-orange); color: white;
        font-weight: 800; text-transform: uppercase;
        border-radius: 12px; border: none;
        transition: all 0.3s cubic-bezier(0.165,0.84,0.44,1);
        letter-spacing: 1px; font-size: 0.82rem;
        padding: 12px 22px;
        box-shadow: 0 6px 20px rgba(255,122,0,0.3);
        cursor: pointer; white-space: nowrap;
        display: inline-flex; align-items: center; gap: 7px;
        height: 46px;
    }
    .btn-match-orange:hover {
        background: var(--deep-charcoal);
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(26,26,26,0.2);
    }

    .active-filter-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
    .filter-tag {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,122,0,0.1);
        border: 1px solid rgba(255,122,0,0.25);
        border-radius: 50px; padding: 3px 11px;
        font-size: 0.7rem; font-weight: 700;
        color: var(--primary-orange);
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .results-summary { font-size: 0.8rem; color: #888; margin-top: 10px; }
    .results-summary strong { color: var(--primary-orange); font-size: 1rem; }

    /* Responsive: stack on mobile */
    @media (max-width: 991px) {
        .hero-top-row { flex-direction: column; }
        .hero-img-col { flex: none; width: 100%; height: clamp(220px, 55vw, 340px); }
        .matcher-fields-row {
            grid-template-columns: 1fr 1fr;
        }
        .matcher-fields-row .btn-match-orange { grid-column: 1 / -1; width: 100%; justify-content: center; height: auto; padding: 14px; }
    }
    @media (max-width: 575px) {
        .matcher-fields-row { grid-template-columns: 1fr; }
    }

    /* Testimonials */
    .testimonials-section { background: linear-gradient(135deg, rgba(255,122,0,0.05) 0%, rgba(255,122,0,0.02) 100%); padding: 60px 0; margin-top: 80px; }
    .testimonial-card { background: white; border-radius: 18px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; border-left: 4px solid var(--primary-orange); height: 100%; }
    .testimonial-card:hover { transform: translateY(-6px); box-shadow: 0 10px 28px rgba(255,122,0,0.12); }
    .testimonial-stars { color: var(--primary-orange); font-size: 0.95rem; margin-bottom: 12px; }
    .testimonial-quote { font-size: 0.95rem; color: #333; font-weight: 500; margin-bottom: 16px; line-height: 1.6; font-style: italic; }
    .testimonial-author { font-weight: 700; color: var(--deep-charcoal); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .testimonial-role { font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; }

    /* Event Types */
    .event-types-section { padding: 80px 0; background: white; }
    .event-type-card { background: white; border: 2px solid #eee; border-radius: 18px; padding: clamp(25px, 4vw, 35px); text-align: center; transition: all 0.3s ease; height: 100%; }
    .event-type-card:hover { border-color: var(--primary-orange); transform: translateY(-10px); box-shadow: 0 12px 35px rgba(255,122,0,0.12); }
    .event-type-icon { font-size: clamp(2rem, 5vw, 2.5rem); margin-bottom: 16px; display: block; }
    .event-type-title { font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 800; margin-bottom: 10px; color: var(--deep-charcoal); }

    /* Stats */
    .stats-bar-dark { background: linear-gradient(135deg, var(--deep-charcoal) 0%, #2a2a2a 100%); color: var(--pure-white); padding: 70px 0; margin-top: 100px; position: relative; overflow: hidden; }
    .stats-bar-dark::before { content: ''; position: absolute; top: 0; right: -100px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,122,0,0.1) 0%, transparent 70%); pointer-events: none; }
    .stat-column { transition: transform 0.4s cubic-bezier(0.165,0.84,0.44,1); text-align: center; }
    .stat-column:hover { transform: translateY(-6px); }
    .stat-visual-lead { height: 70px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; }
    .stat-visual-lead h2 { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: clamp(2.2rem, 5vw, 3rem); color: var(--primary-orange); margin: 0; }
    .stat-icon-lead { font-size: clamp(2.2rem, 5vw, 3rem); color: var(--primary-orange); }
    .stat-label-formal { font-size: clamp(0.8rem, 1.5vw, 0.9rem); font-weight: 600; letter-spacing: 0.5px; margin: 0; color: rgba(255,255,255,0.85); line-height: 1.5; }

    /* Trust */
    .trust-section { background: linear-gradient(135deg, var(--cream) 0%, rgba(255,250,245,0.5) 100%); padding: 70px 0; margin-top: 80px; }
    .trust-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 30px; margin-top: 40px; }
    .trust-card { text-align: center; padding: clamp(25px, 4vw, 32px); border-radius: 18px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; }
    .trust-card:hover { transform: translateY(-6px); box-shadow: 0 10px 28px rgba(0,0,0,0.08); }
    .trust-icon { font-size: 2.5rem; margin-bottom: 12px; display: block; }
    .trust-metric { font-family: 'Montserrat', sans-serif; font-size: clamp(1.5rem, 3vw, 1.8rem); font-weight: 900; color: var(--primary-orange); margin-bottom: 6px; }
    .trust-label { font-size: clamp(0.8rem, 1.5vw, 0.9rem); color: #666; font-weight: 600; line-height: 1.5; }

    /* How it works */
    .how-it-works { padding: 80px 0; background: white; }
    .process-step { position: relative; text-align: center; padding: 30px 20px; }
    .step-number { display: inline-flex; align-items: center; justify-content: center; width: clamp(60px, 12vw, 75px); height: clamp(60px, 12vw, 75px); border-radius: 50%; background: var(--primary-orange); color: white; font-family: 'Montserrat', sans-serif; font-size: clamp(1.8rem, 4vw, 2rem); font-weight: 900; margin-bottom: 16px; box-shadow: 0 6px 20px rgba(255,122,0,0.25); }
    .step-icon { font-size: clamp(2rem, 4vw, 2.3rem); color: var(--primary-orange); margin-bottom: 16px; display: block; }
    .step-title { font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 800; margin-bottom: 10px; color: var(--deep-charcoal); }
    .step-description { font-size: 0.9rem; color: #666; line-height: 1.5; }
    .process-connector { position: absolute; top: 60px; right: -50px; width: 100px; height: 3px; background: linear-gradient(90deg, var(--primary-orange) 0%, transparent 100%); display: none; }
    @media (min-width: 992px) { .process-connector { display: block; } .process-step:last-child .process-connector { display: none; } }

    /* Caterer Cards */
    .section-label { font-family: 'Montserrat', sans-serif; font-weight: 900; text-transform: uppercase; letter-spacing: -1px; font-size: clamp(1.2rem, 4vw, 1.8rem); }
    .caterer-card-premium { border: 2px solid #eee; border-radius: 22px; background: var(--pure-white); transition: all 0.4s cubic-bezier(0.165,0.84,0.44,1); overflow: hidden; height: 100%; display: flex; flex-direction: column; }
    .caterer-card-premium:hover { border-color: var(--primary-orange); transform: translateY(-12px); box-shadow: 0 16px 40px rgba(255,122,0,0.12); }
    .price-text { font-family: 'Montserrat', sans-serif; font-weight: 900; color: var(--primary-orange); font-size: clamp(1.1rem, 3vw, 1.3rem); }
    .card-img-container { height: clamp(200px, 35vw, 280px); width: 100%; background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%); position: relative; overflow: hidden; }
    .card-img-container img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
    .caterer-card-premium:hover .card-img-container img { transform: scale(1.06); }
    .card-body { flex: 1; display: flex; flex-direction: column; padding: clamp(1rem, 3vw, 1.5rem); }
    .card-footer-section { margin-top: auto; padding-top: 15px; border-top: 2px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; gap: 12px; }

    .card-verified { position: absolute; top: 14px; left: 14px; background: var(--primary-orange); color: white; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .card-badge { position: absolute; top: 14px; right: 14px; background: rgba(0,0,0,0.7); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.63rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

    .budget-match-badge {
        position: absolute; bottom: 14px; left: 14px;
        display: inline-flex; align-items: center; gap: 4px;
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        color: white; border-radius: 50px;
        padding: 4px 10px; font-size: 0.63rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .partial-match-badge {
        position: absolute; bottom: 14px; left: 14px;
        display: inline-flex; align-items: center; gap: 4px;
        background: linear-gradient(135deg, #FF7A00, #ff9f2f);
        color: white; border-radius: 50px;
        padding: 4px 10px; font-size: 0.63rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .near-match-note {
        display: block; margin-top: 4px;
        font-size: 0.65rem; color: #FF7A00; font-weight: 600;
        line-height: 1.3;
    }

    @keyframes slideInRight { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideInUp    { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 768px) {
        .stats-bar-dark { padding: 50px 0; }
        .trust-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .process-connector { display: none !important; }
    }
    @media (max-width: 576px) { .trust-grid { grid-template-columns: 1fr; } }
</style>

{{-- ═══════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════ --}}
<div class="hero-section">
    <div class="container">

        {{-- TOP ROW: text left | image right --}}
        <div class="hero-top-row">
            <div class="hero-text-col">
                <h1 class="hero-title-main">Book the <span class="hero-title-italic">Perfect</span></h1>
                <h2 class="hero-title-main" style="margin-top:0;">Caterer in Minutes</h2>
                <p class="hero-subtitle">Find trusted catering experts for weddings, corporate events, birthdays, and celebrations. Compare menus, pricing, and reviews — all in one place.</p>
            </div>
            <div class="hero-img-col" style="animation: slideInRight 0.8s ease-out;">
                <img src="{{ asset('images/bg-cater.avif') }}" alt="Professional Catering Services in Cebu">
            </div>
        </div>

        {{-- SMART BUDGET MATCHER — landscape, full-width --}}
        <div class="search-card-under">
            <div class="matcher-badge-inline">
                <i class="bi bi-calculator-fill"></i> Smart Budget Matcher
            </div>
            <div class="search-card-title">Find Caterers Within Your Budget</div>
            <div class="search-card-subtitle">
                Enter your total budget, guest count, and preferences — we'll match you with caterers whose price per guest fits your range.
            </div>

            <form action="{{ route('marketplace') }}" method="GET" id="budgetMatcherForm">
                <div class="matcher-fields-row">

                    {{-- Budget --}}
                    <div class="matcher-field">
                        <label class="form-label-small">
                            <i class="bi bi-cash-coin" style="color:var(--primary-orange);"></i> Total Budget (₱)
                        </label>
                        <div class="budget-input-group">
                            <span class="budget-prefix">₱</span>
                            <input type="number" name="total_budget" id="totalBudgetInput"
                                class="form-control-custom" placeholder="e.g. 50000"
                                value="{{ $totalBudget ?? '' }}" min="0" step="500">
                        </div>
                    </div>

                    {{-- Guests --}}
                    <div class="matcher-field">
                        <label class="form-label-small">
                            <i class="bi bi-people-fill" style="color:var(--primary-orange);"></i> No. of Guests
                        </label>
                        <input type="number" name="guest_count" id="guestCountInput"
                            class="form-control-custom" placeholder="e.g. 100"
                            value="{{ $guestCount ?? '' }}" min="1" step="1">
                    </div>

                    {{-- Specialty --}}
                    <div class="matcher-field">
                        <label class="form-label-small">
                            <i class="bi bi-egg-fried" style="color:var(--primary-orange);"></i> Food Type
                        </label>
                        <input type="text" name="specialty" class="form-control-custom"
                            placeholder="e.g. Filipino, Buffet"
                            value="{{ $specialty ?? '' }}">
                    </div>

                    {{-- Location --}}
                    <div class="matcher-field">
                        <label class="form-label-small">
                            <i class="bi bi-geo-alt-fill" style="color:var(--primary-orange);"></i> Service Area
                        </label>
                        <input type="text" name="location" class="form-control-custom"
                            placeholder="e.g. Cebu City"
                            value="{{ $location ?? '' }}">
                    </div>

                    {{-- Submit --}}
                    <div class="matcher-field">
                        <button type="submit" class="btn-match-orange">
                            <i class="bi bi-search"></i> Find Caterers
                        </button>
                    </div>

                    {{-- Budget calc tip spans all columns --}}
                    <div class="budget-calc-display" id="budgetCalcDisplay">
                        <i class="bi bi-lightning-fill" style="color:var(--primary-orange);"></i>
                        Your budget works out to approximately
                        <strong id="budgetPerGuestText"></strong> per guest.
                        We'll show caterers whose packages match this range.
                    </div>

                </div>
            </form>

            @if(request()->hasAny(['total_budget','guest_count','specialty','location']))
                <div class="active-filter-tags">
                    @if(!empty($totalBudget))
                        <span class="filter-tag"><i class="bi bi-cash-coin"></i> ₱{{ number_format($totalBudget) }}</span>
                    @endif
                    @if(!empty($guestCount))
                        <span class="filter-tag"><i class="bi bi-people-fill"></i> {{ $guestCount }} guests</span>
                    @endif
                    @if(!empty($specialty))
                        <span class="filter-tag"><i class="bi bi-egg-fried"></i> {{ $specialty }}</span>
                    @endif
                    @if(!empty($location))
                        <span class="filter-tag"><i class="bi bi-geo-alt-fill"></i> {{ $location }}</span>
                    @endif
                    <a href="{{ route('marketplace') }}" class="filter-tag"
                       style="background:rgba(231,76,60,0.1);border-color:rgba(231,76,60,0.25);color:#e74c3c;text-decoration:none;">
                        <i class="bi bi-x-circle-fill"></i> Clear
                    </a>
                </div>
                <div class="results-summary">
                    Showing <strong>{{ $caterers->count() }}</strong> caterer{{ $caterers->count() !== 1 ? 's' : '' }}
                    @if(isset($budgetPerGuest) && $budgetPerGuest)
                        — ≈ ₱{{ number_format($budgetPerGuest, 2) }}/guest
                    @endif
                </div>
            @endif
        </div>

    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════════════════ --}}
<div class="testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-uppercase fw-bold text-muted" style="letter-spacing:1.5px;font-size:0.8rem;">What Our Clients Say</p>
            <h2 class="section-label">Real Stories from <span class="hero-title-italic">Happy Clients</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4"><div class="testimonial-card"><div class="testimonial-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><p class="testimonial-quote">"CaterConnect made it so easy to find and compare caterers for our wedding. We saved time and found the perfect match!"</p><p class="testimonial-author"><i class="bi bi-check-circle-fill" style="color:var(--primary-orange);margin-right:4px;"></i>Kristel Ann Tapdasan</p><p class="testimonial-role">Wedding, 150 guests</p></div></div>
            <div class="col-lg-4"><div class="testimonial-card"><div class="testimonial-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><p class="testimonial-quote">"The platform is transparent and hassle-free. We got quotes from multiple caterers in minutes and booked within 24 hours!"</p><p class="testimonial-author"><i class="bi bi-check-circle-fill" style="color:var(--primary-orange);margin-right:4px;"></i>John Clyde Villarico</p><p class="testimonial-role">Corporate Event, 200 guests</p></div></div>
            <div class="col-lg-4"><div class="testimonial-card"><div class="testimonial-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div><p class="testimonial-quote">"As a busy event planner, CaterConnect saves me hours. Everything I need is here!"</p><p class="testimonial-author"><i class="bi bi-check-circle-fill" style="color:var(--primary-orange);margin-right:4px;"></i>Nice Labajo</p><p class="testimonial-role">Event Planner</p></div></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     TRUST
═══════════════════════════════════════════════════════ --}}
<div class="trust-section">
    <div class="container">
        <div class="text-center mb-4">
            <p class="text-uppercase fw-bold text-muted" style="letter-spacing:1.5px;font-size:0.8rem;">Why Choose CaterConnect</p>
            <h2 class="section-label">Trusted by Cebu's <span class="hero-title-italic">Event Experts</span></h2>
        </div>
        <div class="trust-grid">
            <div class="trust-card"><span class="trust-icon"><i class="bi bi-star-fill" style="color:var(--primary-orange);"></i></span><div class="trust-metric">4.9/5</div><div class="trust-label">Average Rating from 1,200+ Events</div></div>
            <div class="trust-card"><span class="trust-icon"><i class="bi bi-patch-check-fill" style="color:var(--primary-orange);"></i></span><div class="trust-metric">100%</div><div class="trust-label">Verified Catering Experts</div></div>
            <div class="trust-card"><span class="trust-icon"><i class="bi bi-shield-check" style="color:var(--primary-orange);"></i></span><div class="trust-metric">50+</div><div class="trust-label">Cuisine Types Available</div></div>
            <div class="trust-card"><span class="trust-icon"><i class="bi bi-geo-alt-fill" style="color:var(--primary-orange);"></i></span><div class="trust-metric">Cebu-Wide</div><div class="trust-label">Coverage Across the Island</div></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     EVENT TYPES
═══════════════════════════════════════════════════════ --}}
<div class="event-types-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-uppercase fw-bold text-muted" style="letter-spacing:1.5px;font-size:0.8rem;">Catering for Every Occasion</p>
            <h2 class="section-label">Event Types We <span class="hero-title-italic">Specialize</span> In</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 col-sm-6"><div class="event-type-card"><span class="event-type-icon"><i class="bi bi-heart-fill"></i></span><h5 class="event-type-title">Wedding</h5><p class="text-muted" style="font-size:0.85rem;">Premium catering for your special day with elegant menus.</p></div></div>
            <div class="col-md-4 col-sm-6"><div class="event-type-card"><span class="event-type-icon"><i class="bi bi-briefcase-fill"></i></span><h5 class="event-type-title">Corporate Events</h5><p class="text-muted" style="font-size:0.85rem;">Professional catering for meetings and conferences.</p></div></div>
            <div class="col-md-4 col-sm-6"><div class="event-type-card"><span class="event-type-icon"><i class="bi bi-cake2-fill"></i></span><h5 class="event-type-title">Birthday Parties</h5><p class="text-muted" style="font-size:0.85rem;">Fun catering options for birthday celebrations.</p></div></div>
            <div class="col-md-4 col-sm-6"><div class="event-type-card"><span class="event-type-icon"><i class="bi bi-balloon-fill"></i></span><h5 class="event-type-title">Party Catering</h5><p class="text-muted" style="font-size:0.85rem;">All types of celebrations from intimate to large.</p></div></div>
            <div class="col-md-4 col-sm-6"><div class="event-type-card"><span class="event-type-icon"><i class="bi bi-mortarboard-fill"></i></span><h5 class="event-type-title">Graduation</h5><p class="text-muted" style="font-size:0.85rem;">Celebrate achievements with memorable catering.</p></div></div>
            <div class="col-md-4 col-sm-6"><div class="event-type-card"><span class="event-type-icon"><i class="bi bi-gift-fill"></i></span><h5 class="event-type-title">Special Events</h5><p class="text-muted" style="font-size:0.85rem;">Anniversaries, debuts, reunions, and more.</p></div></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     HOW IT WORKS
═══════════════════════════════════════════════════════ --}}
<div class="how-it-works">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-uppercase fw-bold text-muted" style="letter-spacing:1.5px;font-size:0.8rem;">Simple Process</p>
            <h2 class="section-label">How <span class="hero-title-italic">CaterConnect</span> Works</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4"><div class="process-step"><span class="step-icon"><i class="bi bi-search"></i></span><div class="step-number">1</div><div class="step-title">Search & Filter</div><div class="step-description">Enter your budget and guest count — we instantly match you with caterers whose prices fit your range.</div><div class="process-connector"></div></div></div>
            <div class="col-md-4"><div class="process-step"><span class="step-icon"><i class="bi bi-bar-chart"></i></span><div class="step-number">2</div><div class="step-title">Compare Options</div><div class="step-description">View verified profiles, menus, pricing ranges, and customer reviews with complete transparency.</div><div class="process-connector"></div></div></div>
            <div class="col-md-4"><div class="process-step"><span class="step-icon"><i class="bi bi-calendar-check"></i></span><div class="step-number">3</div><div class="step-title">Book & Celebrate</div><div class="step-description">Connect with caterers, finalize details, pay your downpayment, and enjoy your perfectly catered event.</div></div></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     STATS
═══════════════════════════════════════════════════════ --}}
<div class="stats-bar-dark">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3"><div class="stat-column"><div class="stat-visual-lead"><h2>1.2K</h2></div><p class="stat-label-formal">Events Successfully Catered</p></div></div>
            <div class="col-6 col-md-3"><div class="stat-column"><div class="stat-visual-lead"><h2>150+</h2></div><p class="stat-label-formal">Verified Professional Caterers</p></div></div>
            <div class="col-6 col-md-3"><div class="stat-column"><div class="stat-visual-lead"><h2>98%</h2></div><p class="stat-label-formal">Customer Satisfaction Rate</p></div></div>
            <div class="col-6 col-md-3"><div class="stat-column"><div class="stat-visual-lead"><i class="bi bi-lightning-fill stat-icon-lead"></i></div><p class="stat-label-formal">24-Hour Response Time</p></div></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     FEATURED CATERERS
═══════════════════════════════════════════════════════ --}}
<section class="container py-5 mt-4" id="featuredCaterers">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-5 gap-3">
        <div>
            <h2 class="section-label mb-2">
                @if(isset($hasAnyFilter) && $hasAnyFilter)
                    Matched <span class="hero-title-italic">Caterers</span>
                @else
                    Featured <span class="hero-title-italic">Caterers</span>
                @endif
            </h2>
            <p class="text-muted small text-uppercase fw-bold" style="letter-spacing:1.2px;margin:0;font-size:0.75rem;">
                @if(isset($budgetPerGuest) && $budgetPerGuest)
                    {{ $caterers->count() }} result{{ $caterers->count() !== 1 ? 's' : '' }} — ≈ ₱{{ number_format($budgetPerGuest, 2) }}/guest
                @else
                    Verified Professionals Ready to Serve
                @endif
            </p>
        </div>
        <a href="{{ url('/caterers') }}" class="btn rounded-pill px-4"
           style="background:var(--primary-orange);color:white;text-decoration:none;font-weight:600;">
            <i class="bi bi-arrow-right"></i> View All
        </a>
    </div>

    <div class="row g-4">
        @forelse($caterers as $caterer)
            <div class="col-md-6 col-lg-4">
                <div class="caterer-card-premium p-3">

                    <div class="card-img-container rounded-3 overflow-hidden mb-3">
                        @if($caterer->profile_picture)
                            <img src="{{ asset('storage/' . $caterer->profile_picture) }}" alt="{{ $caterer->business_name }}">
                        @else
                            <img src="{{ asset('images/logo-placeholder.png') }}" class="opacity-25 p-5" style="object-fit:contain;">
                        @endif

                        @if($caterer->status === 'verified')
                            <div class="card-verified" title="Verified Caterer">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>
                        @endif

                        <div class="card-badge">{{ $caterer->specialty ?? 'Catering' }}</div>

                        @if(isset($hasAnyFilter) && $hasAnyFilter)
                            @if($caterer->match_type === 'budget')
                                <div class="budget-match-badge">
                                    <i class="bi bi-check-circle-fill"></i> Budget Match
                                </div>
                            @elseif($caterer->match_type === 'specialty_location')
                                <div class="partial-match-badge">
                                    <i class="bi bi-geo-alt-fill"></i> Near Match
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="fw-900 text-uppercase mb-2"
                            style="font-family:'Montserrat';letter-spacing:-0.5px;font-size:0.95rem;">
                            {{ $caterer->business_name }}
                        </h5>

                        <div class="mb-3">
                            <p class="text-muted small mb-2" style="font-size:0.8rem;">
                                <i class="bi bi-geo-alt-fill" style="color:var(--primary-orange);"></i>
                                {{ $caterer->location }}
                            </p>
                            @if($caterer->reviews->count() > 0)
                                <div style="font-size:0.8rem;">
                                    <span style="color:var(--primary-orange);">
                                        <i class="bi bi-star-fill"></i>
                                        {{ number_format($caterer->reviews->avg('rating'), 1) }}
                                    </span>
                                    <span class="text-muted">({{ $caterer->reviews->count() }} reviews)</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer-section">
                            <div>
                                <span class="price-text">₱{{ number_format($caterer->min_budget, 0) }}</span>
                                <span class="text-muted" style="font-size:0.82rem;font-weight:600;"> – </span>
                                <span class="price-text">₱{{ number_format($caterer->max_budget, 0) }}</span>
                                <small class="text-muted d-block" style="font-size:0.6rem;font-weight:700;letter-spacing:0.5px;">PER GUEST</small>

                                @if(isset($hasAnyFilter) && $hasAnyFilter && $caterer->match_type === 'specialty_location')
                                    <span class="near-match-note">
                                        <i class="bi bi-info-circle-fill"></i>
                                        Matches specialty/location — budget range differs
                                    </span>
                                @endif
                            </div>
                            <a href="{{ url('/caterer/' . $caterer->id) }}"
                               class="btn btn-dark btn-sm rounded-pill px-3 fw-bold"
                               style="white-space:nowrap;font-size:0.8rem;">DETAILS</a>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                    <p class="text-muted mt-3 fw-bold">No caterers found matching your criteria.</p>
                    <p class="text-muted small">Try adjusting your budget, guest count, or location.</p>
                    <a href="{{ route('marketplace') }}" class="btn btn-sm px-4 rounded-pill mt-2"
                       style="background:var(--primary-orange);color:white;font-weight:700;">Clear Filters</a>
                </div>
            </div>
        @endforelse
    </div>
</section>

<script>
/* Live budget-per-guest calculator */
(function () {
    var budgetInput = document.getElementById('totalBudgetInput');
    var guestInput  = document.getElementById('guestCountInput');
    var calcDisplay = document.getElementById('budgetCalcDisplay');
    var calcText    = document.getElementById('budgetPerGuestText');

    function update() {
        var budget = parseFloat(budgetInput ? budgetInput.value : 0);
        var guests = parseInt(guestInput   ? guestInput.value  : 0);
        if (budget > 0 && guests > 0) {
            calcText.textContent = '₱' + (budget / guests).toLocaleString('en-PH', {
                minimumFractionDigits: 2, maximumFractionDigits: 2
            });
            calcDisplay.classList.add('show');
        } else {
            calcDisplay.classList.remove('show');
        }
    }

    if (budgetInput) budgetInput.addEventListener('input', update);
    if (guestInput)  guestInput.addEventListener('input',  update);
    update();
})();

/* Auto-scroll to results when filters are active */
(function () {
    var hasFilters = {{ isset($hasAnyFilter) && $hasAnyFilter ? 'true' : 'false' }};
    if (hasFilters) {
        var target = document.getElementById('featuredCaterers');
        if (target) {
            setTimeout(function () {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        }
    }
})();

/* Append anchor to form action on submit */
(function () {
    var form = document.getElementById('budgetMatcherForm');
    if (form) {
        form.addEventListener('submit', function () {
            this.action = this.action.split('#')[0] + '#featuredCaterers';
        });
    }
})();
</script>

@endsection