@extends('layouts.app')
@section('hide_navbar')@endsection

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
    }

    html { scroll-behavior: smooth; }
    body { background-color: var(--pure-white); font-family: 'Inter', sans-serif; color: var(--deep-charcoal); line-height: 1.6; }

    /* PAGE HEADER */
    .page-header-content a:hover {
    background: rgba(255,255,255,0.22) !important;
    transform: translateY(-1px);
}
    .page-header { background: linear-gradient(135deg, var(--deep-charcoal) 0%, #2a2a2a 100%); color: white; padding: 60px 0; margin-bottom: 40px; position: relative; overflow: hidden; }
    .page-header::before { content: ''; position: absolute; top: 0; right: -100px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,122,0,0.1) 0%, transparent 70%); pointer-events: none; }
    .page-header-content { position: relative; z-index: 1; }
    .page-header h1 { font-family: 'Montserrat', sans-serif; font-size: clamp(2rem, 5vw, 3rem); font-weight: 900; margin-bottom: 10px; }
    .page-header p { font-size: clamp(0.95rem, 2vw, 1.1rem); opacity: 0.9; margin: 0; }

    /* FILTERS */
    .filters-section { background: white; border-radius: 20px; padding: clamp(1.5rem, 3vw, 2rem); box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 40px; }
    .filter-title { font-family: 'Montserrat', sans-serif; font-size: 0.9rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--deep-charcoal); margin-bottom: 20px; }
    .filter-group { margin-bottom: 20px; }
    .filter-group:last-child { margin-bottom: 0; }
    .filter-label { font-family: 'Montserrat', sans-serif; font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: var(--deep-charcoal); margin-bottom: 8px; display: block; }
    .filter-input { background-color: var(--light-gray); border: 2px solid transparent; border-radius: 12px; padding: 11px 14px; font-size: 0.88rem; transition: all 0.3s ease; width: 100%; font-weight: 500; appearance: none; -webkit-appearance: none; }
    .filter-input:focus { background-color: white; border-color: var(--primary-orange); box-shadow: 0 4px 12px rgba(255,122,0,0.15); outline: none; }

    /* Budget input with ₱ prefix */
    .budget-input-wrap { position: relative; }
    .budget-prefix-sym { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); font-weight: 800; color: var(--primary-orange); font-size: 0.9rem; pointer-events: none; z-index: 1; }
    .budget-input-wrap .filter-input { padding-left: 26px; }

    .filter-buttons { display: flex; flex-direction: column; gap: 6px; }
    .btn-filter { padding: 10px 14px; border: 2px solid var(--light-gray); border-radius: 10px; background: white; color: var(--deep-charcoal); font-weight: 600; font-size: 0.82rem; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; text-align: left; }
    .btn-filter:hover { border-color: var(--primary-orange); color: var(--primary-orange); }
    .btn-filter.active { background: var(--primary-orange); border-color: var(--primary-orange); color: white; }

    .btn-search { background: var(--primary-orange); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; cursor: pointer; transition: all 0.3s ease; width: 100%; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 6px; }
    .btn-search:hover { background: var(--deep-charcoal); transform: translateY(-2px); }
    .btn-reset { background: white; color: var(--deep-charcoal); border: 2px solid var(--light-gray); padding: 11px 24px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; width: 100%; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; font-size: 0.82rem; display: flex; align-items: center; justify-content: center; gap: 6px; }
    .btn-reset:hover { border-color: var(--primary-orange); color: var(--primary-orange); }

    /* Budget Matcher hint */
    .budget-hint { font-size: 0.68rem; color: #999; margin-top: 5px; line-height: 1.4; display: flex; align-items: flex-start; gap: 4px; }
    .budget-hint i { color: var(--primary-orange); flex-shrink: 0; margin-top: 1px; }
    .budget-calc-pill { display: none; margin-top: 8px; padding: 6px 10px; background: rgba(255,122,0,0.08); border-left: 3px solid var(--primary-orange); border-radius: 0 8px 8px 0; font-size: 0.72rem; color: #555; }
    .budget-calc-pill.show { display: block; }
    .budget-calc-pill strong { color: var(--primary-orange); }

    /* Active filter tags */
    .active-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
    .active-tag { display: inline-flex; align-items: center; gap: 5px; background: rgba(255,122,0,0.1); border: 1px solid rgba(255,122,0,0.25); border-radius: 50px; padding: 3px 10px; font-size: 0.7rem; font-weight: 700; color: var(--primary-orange); text-transform: uppercase; }

    /* RESULTS HEADER */
    .results-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 14px; }
    .results-title { font-family: 'Montserrat', sans-serif; font-size: clamp(1.3rem, 4vw, 1.8rem); font-weight: 900; text-transform: uppercase; letter-spacing: -1px; margin: 0; }
    .results-count { background: var(--primary-orange); color: white; padding: 7px 16px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; white-space: nowrap; }
    .sort-select { padding: 10px 14px; border: 2px solid var(--light-gray); border-radius: 12px; background: white; color: var(--deep-charcoal); font-weight: 500; cursor: pointer; transition: all 0.3s ease; font-size: 0.85rem; appearance: none; -webkit-appearance: none; }
    .sort-select:hover { border-color: var(--primary-orange); }

    /* CATERER CARD */
    .caterer-card { border: 2px solid #eee; border-radius: 22px; background: white; transition: all 0.4s cubic-bezier(0.165,0.84,0.44,1); overflow: hidden; height: 100%; display: flex; flex-direction: column; }
    .caterer-card:hover { border-color: var(--primary-orange); transform: translateY(-12px); box-shadow: 0 16px 40px rgba(255,122,0,0.12); }
    .card-image-wrapper { height: clamp(200px, 35vw, 260px); width: 100%; background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%); position: relative; overflow: hidden; }
    .card-image-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
    .caterer-card:hover .card-image-wrapper img { transform: scale(1.06); }
    .card-badge { position: absolute; top: 14px; right: 14px; background: rgba(0,0,0,0.7); color: white; padding: 6px 14px; border-radius: 20px; font-size: 0.63rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .card-verified { position: absolute; top: 14px; left: 14px; background: var(--primary-orange); color: white; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }

    .card-body { flex: 1; display: flex; flex-direction: column; padding: clamp(1rem, 3vw, 1.4rem); }
    .card-title { font-family: 'Montserrat', sans-serif; font-weight: 900; text-transform: uppercase; font-size: 0.93rem; margin-bottom: 8px; color: var(--deep-charcoal); letter-spacing: -0.5px; }
    .card-location { font-size: 0.82rem; color: #666; margin-bottom: 10px; }
    .card-location i { color: var(--primary-orange); margin-right: 4px; }
    .card-rating { font-size: 0.8rem; margin-bottom: 12px; }
    .card-rating i { color: var(--primary-orange); }
    .card-description { font-size: 0.8rem; color: #666; line-height: 1.45; margin-bottom: 14px; flex: 1; }

    .card-footer { margin-top: auto; padding-top: 14px; border-top: 2px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    .price-section { display: flex; flex-direction: column; }
    .price-range { font-family: 'Montserrat', sans-serif; font-weight: 900; color: var(--primary-orange); font-size: clamp(0.95rem, 2vw, 1.1rem); line-height: 1.2; }
    .price-label { font-size: 0.58rem; color: #999; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 2px; }

    .btn-details { background: var(--deep-charcoal); color: white; border: none; padding: 10px 16px; border-radius: 10px; font-weight: 700; font-size: 0.75rem; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
    .btn-details:hover { background: var(--primary-orange); color: white; transform: translateY(-2px); }

    /* Budget match badge */
    .budget-match-badge { position: absolute; bottom: 14px; left: 14px; display: inline-flex; align-items: center; gap: 4px; background: linear-gradient(135deg, #27ae60, #2ecc71); color: white; border-radius: 50px; padding: 4px 10px; font-size: 0.63rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 80px 40px; }
    .empty-state-icon { font-size: 4rem; color: #ddd; margin-bottom: 20px; }
    .empty-state-title { font-family: 'Montserrat', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--deep-charcoal); margin-bottom: 10px; }
    .empty-state-text { color: #999; font-size: 1rem; margin-bottom: 30px; }

    /* PAGINATION */
    .pagination-wrapper { display: flex; justify-content: center; margin-top: 50px; gap: 8px; flex-wrap: wrap; }
    .pagination-link { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 2px solid var(--light-gray); border-radius: 8px; color: var(--deep-charcoal); cursor: pointer; transition: all 0.3s ease; font-weight: 600; text-decoration: none; font-size: 0.9rem; }
    .pagination-link:hover { border-color: var(--primary-orange); color: var(--primary-orange); }
    .pagination-link.active { background: var(--primary-orange); border-color: var(--primary-orange); color: white; }

    @media (max-width: 768px) {
        .filters-section { padding: 1rem; }
        .results-header { flex-direction: column; align-items: flex-start; }
        .card-footer { flex-direction: column; gap: 8px; }
        .btn-details { width: 100%; justify-content: center; }
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="container">
        <div class="page-header-content">
            {{-- Back buttons --}}
            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:18px;">
                <a href="{{ url('/') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:999px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);color:white;text-decoration:none;font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;transition:all 0.2s ease;">
                    <i class="bi bi-house-fill"></i> Marketplace
                </a>
                @auth
                    <a href="{{ url('/dashboard') }}" style="display:inline-flex;align-items:center;gap:6px;padding:7px 16px;border-radius:999px;background:rgba(255,122,0,0.2);border:1px solid rgba(255,122,0,0.4);color:white;text-decoration:none;font-size:0.78rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;transition:all 0.2s ease;">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                @endauth
            </div>
            <h1>All Professional Caterers</h1>
            <p>Browse and discover the best catering experts across Cebu</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row g-4">

        {{-- ══════════════════════════════════ --}}
        {{-- SIDEBAR FILTERS                   --}}
        {{-- ══════════════════════════════════ --}}
        <div class="col-lg-3">
            <div class="filters-section">
                <h5 class="filter-title"><i class="bi bi-funnel"></i> Filter Results</h5>

                <form id="filterForm" action="{{ route('caterers.index') }}" method="GET">

                    {{-- Search by Name --}}
                    <div class="filter-group">
                        <label class="filter-label">Business Name</label>
                        <input type="text" name="search" class="filter-input"
                            placeholder="Search caterer..."
                            value="{{ request('search') }}">
                    </div>

                    {{-- Specialty / Food Type --}}
<div class="filter-group">
    <label class="filter-label">Food Type / Specialty</label>
    <input type="text" name="specialty" class="filter-input"
        placeholder="e.g. Filipino, Buffet, BBQ..."
        value="{{ request('specialty') }}">
</div>

                    {{-- Location --}}
                    <div class="filter-group">
                        <label class="filter-label">Location</label>
                        <input type="text" name="location" class="filter-input"
                            placeholder="City, area..."
                            value="{{ request('location') }}">
                    </div>

                    {{-- ── BUDGET MATCHER ── --}}
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="bi bi-calculator-fill" style="color:var(--primary-orange);"></i>
                            Budget Matcher
                        </label>

                        {{-- Total Budget --}}
                        <label class="filter-label" style="font-size:0.65rem;margin-bottom:5px;color:#888;">Total Event Budget (₱)</label>
                        <div class="budget-input-wrap" style="margin-bottom:8px;">
                            <span class="budget-prefix-sym">₱</span>
                            <input type="number" name="total_budget" id="totalBudgetFilter"
                                class="filter-input"
                                placeholder="e.g. 50000"
                                value="{{ request('total_budget') }}"
                                min="0" step="500">
                        </div>

                        {{-- Guest Count --}}
                        <label class="filter-label" style="font-size:0.65rem;margin-bottom:5px;color:#888;">Number of Guests</label>
                        <input type="number" name="guest_count" id="guestCountFilter"
                            class="filter-input"
                            placeholder="e.g. 100"
                            value="{{ request('guest_count') }}"
                            min="1" step="1">

                        {{-- Live calculator hint --}}
                        <div class="budget-calc-pill" id="budgetCalcPill">
                            ≈ <strong id="perGuestCalc"></strong> per guest
                        </div>

                        <div class="budget-hint">
                            <i class="bi bi-info-circle-fill"></i>
                            We'll show caterers whose price range matches your budget per guest.
                        </div>
                    </div>

                    {{-- Minimum Rating --}}
                    <div class="filter-group">
                        <label class="filter-label">Minimum Rating</label>
                        <select name="rating" class="filter-input">
                            <option value="">All Ratings</option>
                            <option value="4.5" {{ request('rating') == '4.5' ? 'selected' : '' }}>4.5+ Stars</option>
                            <option value="4"   {{ request('rating') == '4'   ? 'selected' : '' }}>4+ Stars</option>
                            <option value="3.5" {{ request('rating') == '3.5' ? 'selected' : '' }}>3.5+ Stars</option>
                            <option value="3"   {{ request('rating') == '3'   ? 'selected' : '' }}>3+ Stars</option>
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <button type="submit" class="btn-search">
                        <i class="bi bi-search"></i> Search
                    </button>
                    <a href="{{ route('caterers.index') }}" class="btn-reset">
                        <i class="bi bi-arrow-clockwise"></i> Reset Filters
                    </a>

                </form>
            </div>
        </div>

        {{-- ══════════════════════════════════ --}}
        {{-- CATERERS GRID                     --}}
        {{-- ══════════════════════════════════ --}}
        <div class="col-lg-9">

            {{-- Active filter tags --}}
            @if(request()->hasAny(['search','specialty','location','total_budget','guest_count','rating']))
                <div class="active-tags">
                    @if(request('search'))
                        <span class="active-tag"><i class="bi bi-search"></i> {{ request('search') }}</span>
                    @endif
                    @if(request('specialty'))
                        <span class="active-tag"><i class="bi bi-calendar-event"></i> {{ request('specialty') }}</span>
                    @endif
                    @if(request('location'))
                        <span class="active-tag"><i class="bi bi-geo-alt-fill"></i> {{ request('location') }}</span>
                    @endif
                    @if(request('total_budget') && request('guest_count'))
                        <span class="active-tag">
                            <i class="bi bi-calculator-fill"></i>
                            ₱{{ number_format(request('total_budget') / request('guest_count'), 2) }}/guest
                        </span>
                    @endif
                    @if(request('rating'))
                        <span class="active-tag"><i class="bi bi-star-fill"></i> {{ request('rating') }}+ Stars</span>
                    @endif
                </div>
            @endif

            {{-- Results Header --}}
            <div class="results-header">
                <h2 class="results-title">
                    @if(request()->hasAny(['search','specialty','location','total_budget','guest_count','rating']))
                        Matched Caterers
                    @else
                        All Caterers
                    @endif
                </h2>
                <span class="results-count">{{ $caterers->total() }} Caterer{{ $caterers->total() !== 1 ? 's' : '' }}</span>
                <select class="sort-select" id="sortSelect">
                    <option value="latest"     {{ request('sort') == 'latest'     ? 'selected' : '' }}>Latest</option>
                    <option value="rating"     {{ request('sort') == 'rating'     ? 'selected' : '' }}>Highest Rated</option>
                    <option value="price-low"  {{ request('sort') == 'price-low'  ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price-high" {{ request('sort') == 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>

            {{-- Caterers Grid --}}
            <div class="row g-4">
                @forelse($caterers as $caterer)
                    <div class="col-md-6">
                        <div class="caterer-card">

                            {{-- Image --}}
                            <div class="card-image-wrapper">
                                @if($caterer->profile_picture)
                                    <img src="{{ asset('storage/' . $caterer->profile_picture) }}" alt="{{ $caterer->business_name }}">
                                @else
                                    <img src="{{ asset('images/logo-placeholder.png') }}" style="object-fit:contain;opacity:0.3;">
                                @endif

                                {{-- Verified badge --}}
                                @if($caterer->status === 'verified')
                                    <div class="card-verified" title="Verified Caterer">
                                        <i class="bi bi-patch-check-fill"></i>
                                    </div>
                                @endif

                                {{-- Specialty badge --}}
                                <div class="card-badge">{{ $caterer->specialty ?? 'Catering' }}</div>

                                {{-- Budget match badge (only when budget filter is active) --}}
                                @if(request('total_budget') && request('guest_count'))
                                    <div class="budget-match-badge">
                                        <i class="bi bi-check-circle-fill"></i> Budget Match
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="card-body">
                                <h3 class="card-title">{{ $caterer->business_name }}</h3>

                                <div class="card-location">
                                    <i class="bi bi-geo-alt-fill"></i>{{ $caterer->location ?? 'Cebu' }}
                                </div>

                                {{-- Rating --}}
                                @php
                                    $avg = $caterer->reviews->avg('rating') ?? 0;
                                    $count = $caterer->reviews->count();
                                @endphp
                                @if($count > 0)
                                    <div class="card-rating">
                                        <i class="bi bi-star-fill"></i>
                                        <span style="color:var(--primary-orange);font-weight:700;">{{ number_format($avg, 1) }}</span>
                                        <span style="color:#999;">({{ $count }} review{{ $count !== 1 ? 's' : '' }})</span>
                                    </div>
                                @else
                                    <div class="card-rating" style="color:#bbb;font-size:0.78rem;">No ratings yet</div>
                                @endif

                                {{-- Description --}}
                                <div class="card-description">
                                    {{ Str::limit($caterer->specialty ?? 'Professional catering services for all occasions.', 90) }}
                                </div>

                                {{-- Footer: price range + details button --}}
                                <div class="card-footer">
                                    <div class="price-section">
                                        {{-- Show min_budget – max_budget range --}}
                                        @if($caterer->min_budget > 0 && $caterer->max_budget > 0)
                                            <span class="price-range">
                                                ₱{{ number_format($caterer->min_budget, 0) }}
                                                <span style="font-size:0.8rem;font-weight:600;color:#aaa;"> – </span>
                                                ₱{{ number_format($caterer->max_budget, 0) }}
                                            </span>
                                        @elseif($caterer->min_budget > 0)
                                            <span class="price-range">From ₱{{ number_format($caterer->min_budget, 0) }}</span>
                                        @else
                                            <span class="price-range" style="color:#bbb;font-size:0.85rem;">Contact for price</span>
                                        @endif
                                        <span class="price-label">Per Guest</span>
                                    </div>
                                    <a href="{{ url('/caterer/' . $caterer->id) }}" class="btn-details">
                                        <i class="bi bi-arrow-right"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="bi bi-search"></i></div>
                            <h3 class="empty-state-title">No Caterers Found</h3>
                            <p class="empty-state-text">Try adjusting your budget, guest count, or location filters.</p>
                            <a href="{{ route('caterers.index') }}" class="btn-search" style="display:inline-flex;width:auto;padding:12px 32px;">
                                View All Caterers
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($caterers->hasPages())
                <div class="pagination-wrapper">
                    @if($caterers->onFirstPage())
                        <span class="pagination-link" style="opacity:0.4;">← Prev</span>
                    @else
                        <a href="{{ $caterers->previousPageUrl() }}" class="pagination-link">← Prev</a>
                    @endif

                    @foreach($caterers->getUrlRange(1, $caterers->lastPage()) as $page => $url)
                        @if($page == $caterers->currentPage())
                            <span class="pagination-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($caterers->hasMorePages())
                        <a href="{{ $caterers->nextPageUrl() }}" class="pagination-link">Next →</a>
                    @else
                        <span class="pagination-link" style="opacity:0.4;">Next →</span>
                    @endif
                </div>
            @endif

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── SPECIALTY FILTER BUTTONS ── */
    var filterButtons = document.querySelectorAll('.btn-filter');
    var specialtyInput = document.getElementById('specialtyValue');

    filterButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterButtons.forEach(function (b) { b.classList.remove('active'); });
            this.classList.add('active');
            specialtyInput.value = this.dataset.value;
        });
    });

    /* ── SORT SELECT ── */
    var sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            var params = new URLSearchParams(window.location.search);
            params.set('sort', this.value);
            window.location.href = '{{ route("caterers.index") }}?' + params.toString();
        });
    }

    /* ── LIVE BUDGET PER GUEST CALCULATOR ── */
    var budgetInput = document.getElementById('totalBudgetFilter');
    var guestInput  = document.getElementById('guestCountFilter');
    var calcPill    = document.getElementById('budgetCalcPill');
    var calcText    = document.getElementById('perGuestCalc');

    function updateCalc() {
        var b = parseFloat(budgetInput ? budgetInput.value : 0);
        var g = parseInt(guestInput  ? guestInput.value  : 0);
        if (b > 0 && g > 0) {
            var perGuest = b / g;
            calcText.textContent = '₱' + perGuest.toLocaleString('en-PH', {
                minimumFractionDigits: 2, maximumFractionDigits: 2
            });
            calcPill.classList.add('show');
        } else {
            calcPill.classList.remove('show');
        }
    }

    if (budgetInput) budgetInput.addEventListener('input', updateCalc);
    if (guestInput)  guestInput.addEventListener('input',  updateCalc);
    updateCalc(); // run on load if values exist

});
</script>

@endsection