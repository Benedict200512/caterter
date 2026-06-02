@extends('layouts.app')
@section('hide_navbar')@endsection
@section('hide_footer')@endsection

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --orange:     #FF7A00;
        --orange-lt:  #ff9f2f;
        --charcoal:   #f5f6fa;
        --surface:    #ffffff;
        --surface2:   #f9fafb;
        --surface3:   #f0f2f5;
        --border:     rgba(0,0,0,0.08);
        --border-md:  rgba(0,0,0,0.14);
        --text:       #1a1a2e;
        --text-muted: rgba(0,0,0,0.45);
        --text-dim:   rgba(0,0,0,0.28);
        --green:      #059669;
        --red:        #dc2626;
        --blue:       #2563eb;
        --radius:     12px;
        --sidebar-w:  220px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--charcoal);
        font-family: 'Inter', sans-serif;
        color: var(--text);
        padding-top: 0 !important;
        overflow-x: hidden;
    }

    .ds-shell { display: flex; min-height: 100vh; }

    /* ─── SIDEBAR ─── */
    .ds-sidebar {
        width: var(--sidebar-w);
        flex-shrink: 0;
        background: var(--surface);
        display: flex;
        flex-direction: column;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        border-right: 1px solid var(--border);
        box-shadow: 2px 0 12px rgba(0,0,0,0.05);
    }
    .ds-sidebar::-webkit-scrollbar { width: 3px; }
    .ds-sidebar::-webkit-scrollbar-thumb { background: var(--border-md); }

    .sb-brand {
        padding: 18px 18px 14px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 9px;
    }
    .sb-brand-icon {
        width: 28px; height: 28px;
        background: var(--orange);
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .sb-brand-icon i { color: white; font-size: 0.85rem; }
    .sb-brand-name {
        font-family: 'Montserrat', sans-serif;
        font-weight: 900;
        font-size: 0.95rem;
        color: var(--text);
        text-decoration: none;
        letter-spacing: 0.3px;
    }
    .sb-brand-name span { color: var(--orange); }

    .sb-user {
        padding: 13px 18px;
        display: flex; align-items: center; gap: 10px;
        border-bottom: 1px solid var(--border);
        background: rgba(255,122,0,0.03);
    }
    .sb-avatar {
        width: 34px; height: 34px;
        border-radius: 9px;
        background: var(--orange);
        color: white;
        font-weight: 800; font-size: 0.9rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .sb-user-name  { font-size: 0.83rem; font-weight: 600; color: var(--text); line-height: 1.3; }
    .sb-user-email { font-size: 0.68rem; color: var(--text-muted); }

    .sb-nav { padding: 8px 0; flex: 1; }
    .sb-section-label {
        font-size: 0.58rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.5px;
        color: var(--text-dim);
        padding: 9px 18px 4px;
    }
    .sb-link {
        display: flex; align-items: center; gap: 9px;
        padding: 9px 18px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.82rem; font-weight: 500;
        transition: all 0.15s;
        position: relative;
        border: none; background: transparent;
        width: 100%; text-align: left; cursor: pointer;
    }
    .sb-link i { font-size: 0.9rem; width: 17px; text-align: center; flex-shrink: 0; }
    .sb-link:hover { color: var(--text); background: rgba(0,0,0,0.04); }
    .sb-link.active { color: var(--orange); background: rgba(255,122,0,0.07); }
    .sb-link.active::before {
        content: '';
        position: absolute; left: 0; top: 0; bottom: 0;
        width: 3px; background: var(--orange);
        border-radius: 0 2px 2px 0;
    }
    .sb-link.active i { color: var(--orange); }
    .sb-badge {
        margin-left: auto;
        background: var(--orange); color: white;
        border-radius: 20px; padding: 1px 7px;
        font-size: 0.63rem; font-weight: 800;
    }
    .sb-cta {
        margin: 8px 14px 14px;
        padding: 13px;
        background: rgba(255,122,0,0.06);
        border: 1px solid rgba(255,122,0,0.18);
        border-radius: var(--radius);
    }
    .sb-cta-label { font-size: 0.58rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-dim); margin-bottom: 2px; }
    .sb-cta-title { font-size: 0.8rem; font-weight: 700; color: var(--text); margin-bottom: 9px; }
    .sb-cta-btn {
        display: block; width: 100%; padding: 7px;
        background: var(--orange);
        border: none;
        border-radius: 8px;
        color: white; font-size: 0.76rem; font-weight: 600;
        text-align: center; text-decoration: none;
        transition: all 0.18s; cursor: pointer;
    }
    .sb-cta-btn:hover { background: var(--orange-lt); color: white; text-decoration: none; }

    /* ─── MAIN ─── */
    .ds-main { flex: 1; min-width: 0; background: var(--charcoal); }
    .ds-content { padding: 26px 28px; }

    /* ─── PAGE HEADER ─── */
    .page-header { margin-bottom: 20px; display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 10px; }
    .page-header h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.65rem; font-weight: 900;
        color: var(--text); margin-bottom: 3px; line-height: 1.2;
    }
    .page-header h1 span { color: var(--orange); }
    .page-header p { color: var(--text-muted); font-size: 0.86rem; margin: 0; }
    .acct-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 13px;
        background: rgba(5,150,105,0.08);
        color: var(--green);
        border: 1px solid rgba(5,150,105,0.18);
        border-radius: 20px; font-size: 0.73rem; font-weight: 700; flex-shrink: 0;
    }

    /* ─── STAT CARDS ─── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 11px; margin-bottom: 16px;
    }
    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 17px;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .stat-card:hover { border-color: rgba(255,122,0,0.3); box-shadow: 0 4px 16px rgba(255,122,0,0.08); }
    .stat-label {
        font-size: 0.63rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: var(--text-muted); margin-bottom: 6px;
    }
    .stat-value {
        font-family: 'Montserrat', sans-serif;
        font-size: 2rem; font-weight: 900;
        color: var(--text); line-height: 1; margin-bottom: 4px;
    }
    .stat-sub { font-size: 0.7rem; color: var(--text-muted); }

    /* ─── DEADLINE ALERT ─── */
    .deadline-alert {
        background: rgba(255,122,0,0.05);
        border: 1px solid rgba(255,122,0,0.2);
        border-left: 3px solid var(--orange);
        border-radius: 0 10px 10px 0;
        padding: 11px 15px;
        font-size: 0.82rem;
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 14px; color: var(--text);
    }
    .deadline-alert i { color: var(--orange); font-size: 0.95rem; flex-shrink: 0; }
    .deadline-alert a { color: var(--orange); font-weight: 700; text-decoration: none; }
    .deadline-pay-btn {
        margin-left: auto; flex-shrink: 0;
        padding: 5px 13px;
        background: var(--orange); color: white;
        border: none; border-radius: 7px;
        font-size: 0.76rem; font-weight: 700;
        text-decoration: none; transition: background 0.2s; cursor: pointer;
        display: inline-flex; align-items: center;
    }
    .deadline-pay-btn:hover { background: var(--orange-lt); color: black; text-decoration: none; }

    /* ─── SECTION CARD ─── */
    .sec-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 14px; overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.05);
    }
    .sec-card-hdr {
        padding: 13px 18px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        background: #fafbfc;
    }
    .sec-card-title {
        font-size: 0.88rem; font-weight: 700;
        color: var(--text);
        display: flex; align-items: center; gap: 7px; margin: 0;
    }
    .sec-card-title i { color: var(--orange); font-size: 0.88rem; }
    .sec-card-body { padding: 18px; }

    /* ─── JOURNEY ─── */
    .journey-wrap {
        display: flex; justify-content: space-between;
        align-items: flex-start; gap: 4px; position: relative;
    }
    .journey-line {
        position: absolute; top: 20px; left: 22px; right: 22px;
        height: 2px; background: var(--border); z-index: 0;
    }
    .journey-step { flex: 1; text-align: center; position: relative; z-index: 1; }
    .journey-circle {
        width: 40px; height: 40px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 6px; border: 2px solid transparent;
    }
    .journey-circle.done { background: var(--orange); border-color: var(--orange); color: white; }
    .journey-circle.done i { font-size: 0.95rem; }
    .journey-circle.undone { background: var(--surface3); border-color: var(--border-md); color: var(--text-muted); }
    .journey-circle.undone i { font-size: 0.8rem; }
    .journey-label { font-size: 0.68rem; font-weight: 600; margin: 0; }
    .journey-label.done  { color: var(--text); }
    .journey-label.undone { color: var(--text-muted); }

    /* ─── TABS ─── */
    .booking-tab-btn {
        border: 1px solid var(--border-md);
        outline: none; box-shadow: none;
        background: var(--surface3); color: var(--text-muted);
        font-weight: 600; font-size: 0.76rem;
        padding: 5px 12px; border-radius: 50px;
        cursor: pointer; transition: all 0.15s; font-family: 'Inter', sans-serif;
    }
    .booking-tab-btn:hover { background: rgba(0,0,0,0.08); color: var(--text); }
    .booking-tab-btn.active { background: var(--orange) !important; color: white !important; border-color: var(--orange) !important; }

    /* ─── TABLE ─── */
    .bk-table { width: 100%; border-collapse: collapse; }
    .bk-table th {
        padding: 8px 11px;
        font-size: 0.65rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.7px;
        color: var(--text-muted); border-bottom: 1px solid var(--border);
        white-space: nowrap; background: #f9fafb;
    }
    .booking-row { border-bottom: 1px solid var(--border); transition: background 0.1s; }
    .booking-row:hover { background: rgba(255,122,0,0.025); }
    .booking-row:last-child { border-bottom: none; }
    .booking-row td { padding: 10px 11px; vertical-align: middle; font-size: 0.82rem; color: var(--text); }
    .caterer-init {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--orange); color: white;
        font-weight: 800; font-size: 0.85rem;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    /* ─── STATUS PILLS ─── */
    .st-pill {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 3px 9px; border-radius: 50px;
        font-size: 0.63rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.5px;
        font-family: 'Montserrat', sans-serif;
    }

    /* ─── ACTION BUTTONS ─── */
    .action-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 9px; border-radius: 7px;
        font-size: 0.7rem; font-weight: 700;
        border: 1px solid transparent; cursor: pointer;
        text-decoration: none; transition: opacity 0.15s;
        font-family: 'Inter', sans-serif; white-space: nowrap;
    }
    .action-btn:hover { opacity: 0.8; text-decoration: none; }
    .btn-pay    { background: var(--orange); color: white; border-color: var(--orange); }
    .btn-view   { background: var(--surface3); color: var(--text); border-color: var(--border-md); }
    .btn-rate   { background: rgba(245,158,11,0.1); color: #d97706; border-color: rgba(245,158,11,0.25); }
    .btn-cancel { background: rgba(220,38,38,0.07); color: #dc2626; border-color: rgba(220,38,38,0.18); }
    .btn-verify { background: rgba(37,99,235,0.07); color: var(--blue); border-color: rgba(37,99,235,0.18); pointer-events: none; }
    .btn-secure { background: rgba(5,150,105,0.07); color: var(--green); border-color: rgba(5,150,105,0.18); pointer-events: none; }

    /* ─── SPOTLIGHT ─── */
    .spotlight-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 14px;
        display: flex; align-items: center; gap: 14px; padding: 16px 18px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.05);
    }
    .spotlight-init {
        width: 44px; height: 44px; border-radius: 50%;
        background: var(--orange); color: white;
        font-weight: 900; font-size: 1.05rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-family: 'Montserrat', sans-serif;
    }
    .spotlight-meta-label { font-size: 0.56rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-dim); margin-bottom: 2px; }
    .spotlight-name { font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 900; color: var(--text); margin-bottom: 4px; }
    .spotlight-tags { display: flex; align-items: center; gap: 9px; flex-wrap: wrap; }
    .sp-tag { font-size: 0.7rem; color: var(--text-muted); display: flex; align-items: center; gap: 3px; }
    .sp-tag i { color: var(--orange); font-size: 0.68rem; }
    .sp-verified {
        display: inline-flex; align-items: center; gap: 3px;
        background: rgba(5,150,105,0.08); color: var(--green);
        border-radius: 20px; padding: 2px 7px;
        font-size: 0.6rem; font-weight: 800;
        font-family: 'Montserrat', sans-serif; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .spotlight-pricing { margin-left: auto; text-align: right; flex-shrink: 0; }
    .sp-price-label { font-size: 0.6rem; color: var(--text-muted); margin-bottom: 1px; }
    .sp-price { font-family: 'Montserrat', sans-serif; font-size: 1.15rem; font-weight: 900; color: var(--orange); }
    .sp-price-unit { font-size: 0.68rem; color: var(--text-muted); }
    .spotlight-book-btn {
        flex-shrink: 0; padding: 8px 16px;
        background: var(--surface3); border: 1px solid var(--border-md);
        border-radius: 9px; color: var(--text);
        font-size: 0.8rem; font-weight: 700;
        text-decoration: none; transition: all 0.15s; cursor: pointer; white-space: nowrap;
    }
    .spotlight-book-btn:hover { background: var(--orange); border-color: var(--orange); color: white; text-decoration: none; }

    /* ─── REC HEADER ─── */
    .rec-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 13px; }
    .rec-title { font-size: 0.9rem; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 6px; }
    .rec-title i { color: var(--orange); }
    .rec-view-all { font-size: 0.78rem; color: var(--orange); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 3px; transition: opacity 0.15s; }
    .rec-view-all:hover { opacity: 0.72; text-decoration: none; color: var(--orange); }

    /* ─── CATERER CARDS ─── */
    .caterer-rec-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden;
        transition: all 0.2s; height: 100%;
        box-shadow: 0 1px 6px rgba(0,0,0,0.05);
    }
    .caterer-rec-card:hover { border-color: var(--orange); transform: translateY(-3px); box-shadow: 0 8px 24px rgba(255,122,0,0.1); }
    .caterer-rec-img { height: 115px; width: 100%; object-fit: cover; display: block; }
    .caterer-rec-img-placeholder {
        height: 115px; background: var(--surface3);
        display: flex; align-items: center; justify-content: center;
        color: var(--text-dim); font-size: 1.9rem;
    }
    .rec-card-body { padding: 12px 13px; }
    .rec-card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 3px; gap: 6px; }
    .rec-card-name { font-size: 0.86rem; font-weight: 700; color: var(--text); line-height: 1.3; }
    .rec-card-spec { font-size: 0.71rem; color: var(--text-muted); margin-bottom: 5px; }
    .rec-rating {
        flex-shrink: 0; display: flex; align-items: center; gap: 3px;
        background: rgba(255,122,0,0.1); padding: 2px 7px; border-radius: 6px;
        font-size: 0.7rem; font-weight: 700; color: #c2610a;
    }
    .rec-location { font-size: 0.7rem; color: var(--text-muted); display: flex; align-items: center; gap: 3px; margin-bottom: 9px; }
    .rec-location i { color: var(--orange); font-size: 0.68rem; }
    .rec-price-box { background: var(--surface3); border-radius: 7px; padding: 6px 9px; margin-bottom: 9px; }
    .rec-price-label { font-size: 0.57rem; color: var(--text-dim); font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 2px; }
    .rec-book-btn {
        display: block; width: 100%; padding: 7px;
        background: var(--surface3); border: 1px solid var(--border-md);
        border-radius: 7px; color: var(--text);
        font-size: 0.78rem; font-weight: 700;
        text-align: center; text-decoration: none;
        transition: all 0.15s; cursor: pointer; font-family: 'Inter', sans-serif;
    }
    .rec-book-btn:hover { background: var(--orange); border-color: var(--orange); color: white; text-decoration: none; }

    /* ─── EMPTY ─── */
    .empty-box {
        text-align: center; padding: 30px 16px;
        background: var(--surface3);
        border: 1px dashed var(--border-md);
        border-radius: var(--radius);
    }
    .empty-box i { font-size: 1.5rem; color: var(--text-dim); display: block; margin-bottom: 8px; }
    .empty-box p { color: var(--text-muted); font-size: 0.86rem; margin-bottom: 13px; }

    /* ─── MODALS (light) ─── */
    .modal-content { background: var(--surface) !important; border: 1px solid var(--border-md) !important; color: var(--text); }
    .modal-header { border-color: var(--border) !important; background: #fafbfc; }
    .modal-footer { border-color: var(--border) !important; background: #fafbfc; }
    .modal-title  { color: var(--text) !important; }
    .modal-body .form-control { background: var(--surface3) !important; border-color: var(--border-md) !important; color: var(--text) !important; }
    .modal-body .form-control::placeholder { color: var(--text-dim); }
    .btn-close-dark { filter: none; opacity: 0.5; }

    /* ─── SUCCESS ALERT ─── */
    .ds-success {
        background: rgba(5,150,105,0.06); border: 1px solid rgba(5,150,105,0.18);
        border-left: 3px solid var(--green); color: var(--green);
        border-radius: 0 9px 9px 0; padding: 10px 15px;
        font-size: 0.84rem; margin-bottom: 14px;
        display: flex; align-items: center; gap: 9px;
    }

    /* ─── MOBILE BOTTOM NAV ─── */
    .mobile-btm-nav {
        display: none; position: fixed;
        bottom: 0; left: 0; right: 0;
        background: var(--surface); border-top: 1px solid var(--border);
        padding: 5px 0; z-index: 200;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.07);
    }

    /* ─── NOTIFICATION BELL ─── */
    #notifDropdown::-webkit-scrollbar { width: 4px; }
    #notifDropdown::-webkit-scrollbar-thumb { background: var(--border-md); border-radius: 3px; }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 991px) {
        .ds-sidebar { display: none; }
        .mobile-btm-nav { display: block; }
        .ds-content { padding: 16px 14px 88px; }
        .stat-grid { grid-template-columns: repeat(2, 1fr); gap: 9px; }
    }
    @media (max-width: 576px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
        .stat-value { font-size: 1.7rem; }
    }

    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: var(--charcoal); }
    ::-webkit-scrollbar-thumb { background: var(--border-md); border-radius: 3px; }
    #noFilterResults i { font-size: 1.3rem; opacity: 0.3; }
</style>


<div class="ds-shell">

    {{-- ═══ SIDEBAR ═══ --}}
    <aside class="ds-sidebar">
        <div class="sb-brand">
            <div class="sb-brand-icon"><i class="bi bi-grid-fill"></i></div>
            <a class="sb-brand-name" href="{{ url('/') }}">Cater<span>Connect</span></a>
        </div>

        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div style="min-width:0;">
                <div class="sb-user-name">{{ $user->name }}</div>
                <div class="sb-user-email">{{ $user->email }}</div>
            </div>
        </div>

        <nav class="sb-nav">
            <div class="sb-section-label">Main</div>
            <a href="{{ url('/dashboard') }}" class="sb-link active">
                <i class="bi bi-grid-fill"></i> Overview
            </a>
            <a href="#bookings" class="sb-link">
                <i class="bi bi-calendar-check"></i> My bookings
                @php $pendingNav = $bookings->where('status','pending')->count() + $bookings->where('status','confirmed')->count(); @endphp
                @if($pendingNav > 0)
                    <span class="sb-badge">{{ $pendingNav }}</span>
                @endif
            </a>
            <a href="{{ route('caterers.index') }}" class="sb-link">
                <i class="bi bi-shop"></i> Browse caterers
            </a>
            <a href="{{ url('/') }}" class="sb-link">
                <i class="bi bi-house-door-fill"></i> View Marketplace
            </a>

            <div class="sb-section-label" style="margin-top:6px;">Support</div>
            <a href="#" class="sb-link">
                <i class="bi bi-question-circle"></i> Help &amp; support
            </a>
            <a href="#" class="sb-link">
                <i class="bi bi-file-text"></i> Terms &amp; privacy
            </a>
            <a href="#" class="sb-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>

        @if($user->role !== 'caterer')
        <div class="sb-cta">
            <div class="sb-cta-label">Ready to earn?</div>
            <div class="sb-cta-title">Become a caterer</div>
            <a href="{{ url('/become-caterer') }}" class="sb-cta-btn">
                <i class="bi bi-rocket me-1"></i> Get started
            </a>
        </div>
        @endif
    </aside>

    {{-- ═══ MAIN ═══ --}}
    <div class="ds-main">
        <div class="ds-content">

            <div class="page-header">
                <div>
                    <h1>Booking <span>hub</span></h1>
                    <p>Welcome back, <strong style="color:var(--text);">{{ explode(' ', $user->name)[0] }}</strong>! Here's your event overview.</p>
                </div>

                <div class="d-flex align-items-center gap-3">
                    {{-- Notification Bell --}}
                    <div style="position:relative;">
                        <button onclick="toggleNotifDropdown()" style="width:42px;height:42px;border-radius:50%;background:var(--surface);border:1px solid var(--border);color:var(--text-muted);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;position:relative;box-shadow:0 1px 4px rgba(0,0,0,0.07);"
                                onmouseover="this.style.borderColor='var(--orange)';this.style.color='var(--orange)'"
                                onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-muted)'">
                            <i class="bi bi-bell-fill" style="font-size:1rem;"></i>
                            @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                            @if($unreadCount > 0)
                                <span style="position:absolute;top:6px;right:6px;width:8px;height:8px;border-radius:50%;background:var(--orange);border:2px solid var(--surface);"></span>
                            @endif
                        </button>

                        {{-- Dropdown --}}
                        <div id="notifDropdown" style="display:none;position:absolute;top:52px;right:0;width:320px;background:var(--surface);border:1px solid var(--border-md);border-radius:var(--radius);box-shadow:0 16px 48px rgba(0,0,0,0.12);z-index:999;overflow:hidden;">
                            <div style="padding:14px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:#fafbfc;">
                                <span style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:.8rem;color:var(--text);text-transform:uppercase;letter-spacing:.5px;">Notifications</span>
                                @if($unreadCount > 0)
                                    <a href="{{ route('notifications.markAllRead') }}" style="font-size:.68rem;font-weight:700;color:var(--orange);text-decoration:none;">Mark all read</a>
                                @endif
                            </div>

                            <div style="max-height:340px;overflow-y:auto;">
                                @forelse(Auth::user()->notifications->take(10) as $notif)
                                    @php
                                        $isUnread = is_null($notif->read_at);
                                        $typeColor = match($notif->data['type'] ?? 'info') {
                                            'success' => '#059669',
                                            'danger'  => '#dc2626',
                                            'warning' => '#d97706',
                                            default   => '#2563eb',
                                        };
                                    @endphp
                                    <a href="{{ route('notifications.read', $notif->id) }}"
                                       style="display:flex;align-items:flex-start;gap:12px;padding:13px 16px;border-bottom:1px solid var(--border);text-decoration:none;transition:background .15s;background:{{ $isUnread ? 'rgba(255,122,0,0.04)' : 'transparent' }};"
                                       onmouseover="this.style.background='rgba(0,0,0,0.03)'"
                                       onmouseout="this.style.background='{{ $isUnread ? 'rgba(255,122,0,0.04)' : 'transparent' }}'">
                                        <div style="width:34px;height:34px;border-radius:50%;background:{{ $typeColor }}18;border:1px solid {{ $typeColor }}30;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                                            <i class="bi bi-{{ match($notif->data['type'] ?? 'info') { 'success' => 'check-circle-fill', 'danger' => 'x-circle-fill', 'warning' => 'exclamation-triangle-fill', default => 'info-circle-fill' } }}" style="color:{{ $typeColor }};font-size:.78rem;"></i>
                                        </div>
                                        <div style="flex:1;min-width:0;">
                                            <div style="font-size:.78rem;font-weight:{{ $isUnread ? '700' : '500' }};color:var(--text);margin-bottom:2px;line-height:1.4;">{{ $notif->data['title'] ?? 'Notification' }}</div>
                                            <div style="font-size:.7rem;color:var(--text-muted);line-height:1.45;">{{ Str::limit($notif->data['message'] ?? '', 70) }}</div>
                                            <div style="font-size:.62rem;color:var(--text-muted);margin-top:4px;">{{ $notif->created_at->diffForHumans() }}</div>
                                        </div>
                                        @if($isUnread)
                                            <div style="width:7px;height:7px;border-radius:50%;background:var(--orange);flex-shrink:0;margin-top:6px;"></div>
                                        @endif
                                    </a>
                                @empty
                                    <div style="text-align:center;padding:32px 20px;">
                                        <i class="bi bi-bell-slash" style="font-size:1.8rem;display:block;margin-bottom:8px;color:var(--text-dim);"></i>
                                        <div style="font-size:.78rem;font-weight:600;color:var(--text-muted);">No notifications yet</div>
                                    </div>
                                @endforelse
                            </div>

                            @if(Auth::user()->notifications->count() > 10)
                                <div style="padding:10px 16px;border-top:1px solid var(--border);text-align:center;background:#fafbfc;">
                                    <span style="font-size:.72rem;color:var(--text-muted);">Showing latest 10 notifications</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <span class="acct-badge">
                        <i class="bi bi-patch-check-fill"></i> Account active
                    </span>
                </div>
            </div>

            @if(session('success'))
                <div class="ds-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill" style="flex-shrink:0;"></i>
                    <div style="flex:1;"><strong>Success!</strong> {{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:0.62rem;"></button>
                </div>
            @endif

            {{-- ── STAT CARDS ── --}}
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-label">Total bookings</div>
                    <div class="stat-value">{{ $bookings->count() }}</div>
                    <div class="stat-sub">All time</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Confirmed</div>
                    <div class="stat-value" style="color:var(--orange);">{{ $bookings->where('status','confirmed')->count() }}</div>
                    <div class="stat-sub">Upcoming events</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Completed</div>
                    <div class="stat-value">{{ $bookings->where('status','completed')->count() }}</div>
                    <div class="stat-sub">Events done</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Reviews left</div>
                    <div class="stat-value">{{ $bookings->whereNotNull('review')->count() }}</div>
                    <div class="stat-sub">Feedback given</div>
                </div>
            </div>

            {{-- ── DOWNPAYMENT DEADLINE ALERTS ── --}}
            @php
                $pendingDeadlines = $bookings->where('status','confirmed')
                    ->filter(function($b) {
                        return $b->downpayment_deadline &&
                               \Carbon\Carbon::parse($b->downpayment_deadline)->isFuture() &&
                               \Carbon\Carbon::parse($b->downpayment_deadline)->diffInDays(now()) <= 3;
                    });
            @endphp
            @if($pendingDeadlines->count() > 0)
                @foreach($pendingDeadlines as $dl)
                    <div class="deadline-alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div style="flex:1;">
                            <strong>Downpayment due soon!</strong>
                            Your booking with <strong>{{ $dl->catererProfile->business_name }}</strong>
                            requires payment by <strong>{{ \Carbon\Carbon::parse($dl->downpayment_deadline)->format('M d, Y') }}</strong>
                            — {{ now()->diffInDays(\Carbon\Carbon::parse($dl->downpayment_deadline)) }} days left.
                        </div>
                        <a href="{{ route('bookings.show', $dl->id) }}" class="deadline-pay-btn">Pay now</a>
                    </div>
                @endforeach
            @endif

            {{-- ── BOOKING JOURNEY ── --}}
            <div class="sec-card">
                <div class="sec-card-hdr">
                    <h5 class="sec-card-title">
                        <i class="bi bi-circle-half"></i> Booking journey
                    </h5>
                </div>
                <div class="sec-card-body">
                    @php
                        $journeySteps = [
                            ['title'=>'Browse', 'icon'=>'bi-search',       'done'=>true],
                            ['title'=>'Book',   'icon'=>'bi-calendar-plus','done'=>$bookings->count()>0],
                            ['title'=>'Confirm','icon'=>'bi-check-circle', 'done'=>$bookings->where('status','confirmed')->count()>0 || $bookings->where('status','completed')->count()>0],
                            ['title'=>'Event',  'icon'=>'bi-people',       'done'=>$bookings->where('status','completed')->count()>0],
                            ['title'=>'Review', 'icon'=>'bi-star',         'done'=>$bookings->whereNotNull('review')->count()>0],
                        ];
                    @endphp
                    <div class="journey-wrap">
                        <div class="journey-line"></div>
                        @foreach($journeySteps as $step)
                            <div class="journey-step">
                                <div class="journey-circle {{ $step['done'] ? 'done' : 'undone' }}">
                                    @if($step['done'])
                                        <i class="bi bi-check-lg"></i>
                                    @else
                                        <i class="{{ $step['icon'] }}"></i>
                                    @endif
                                </div>
                                <p class="journey-label {{ $step['done'] ? 'done' : 'undone' }}">{{ $step['title'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── MY BOOKINGS ── --}}
            <div id="bookings" class="sec-card">
                <div class="sec-card-hdr">
                    <h5 class="sec-card-title">
                        <i class="bi bi-calendar-check"></i> My bookings
                    </h5>
                    @php
                        $pendingCount   = $bookings->where('status','pending')->count();
                        $confirmedCount = $bookings->where('status','confirmed')->count();
                    @endphp
                    <div class="d-flex gap-2">
                        @if($pendingCount > 0)
                            <span style="background:rgba(217,119,6,0.1);color:#d97706;border:1px solid rgba(217,119,6,0.2);padding:2px 10px;border-radius:20px;font-size:0.68rem;font-weight:700;">
                                {{ $pendingCount }} Pending
                            </span>
                        @endif
                        @if($confirmedCount > 0)
                            <span style="background:rgba(5,150,105,0.08);color:var(--green);border:1px solid rgba(5,150,105,0.18);padding:2px 10px;border-radius:20px;font-size:0.68rem;font-weight:700;">
                                {{ $confirmedCount }} Confirmed
                            </span>
                        @endif
                    </div>
                </div>

                <div class="sec-card-body">
                    @php
                        $pendingCount    = $bookings->where('status', 'pending')->count();
                        $confirmedCount  = $bookings->where('status', 'confirmed')->count();
                        $awaitingCount   = $bookings->where('status', 'awaiting_payment')->count();
                        $paidCount       = $bookings->where('status', 'paid')->count();
                        $completedCount  = $bookings->where('status', 'completed')->count();
                    @endphp

                    <div class="d-flex flex-wrap gap-2 mb-3" id="bookingTabs">
                        <button class="booking-tab-btn active" data-filter="all">All ({{ $bookings->count() }})</button>
                        <button class="booking-tab-btn" data-filter="pending">Pending ({{ $pendingCount }})</button>
                        <button class="booking-tab-btn" data-filter="confirmed">Pay Now ({{ $confirmedCount }})</button>
                        @if($awaitingCount > 0)
                            <button class="booking-tab-btn" data-filter="awaiting_payment">Under Review ({{ $awaitingCount }})</button>
                        @endif
                        <button class="booking-tab-btn" data-filter="paid">Paid ({{ $paidCount }})</button>
                        <button class="booking-tab-btn" data-filter="completed">Completed ({{ $completedCount }})</button>
                    </div>

                    <div class="table-responsive">
                        <table class="bk-table">
                            <thead>
                                <tr>
                                    <th>Caterer</th>
                                    <th>Event date</th>
                                    <th>Guests</th>
                                    <th>Deadline</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr class="booking-row" data-status="{{ $booking->status }}">
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="caterer-init">
                                                    {{ strtoupper(substr($booking->catererProfile->business_name ?? 'C', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div style="font-weight:700;font-size:0.84rem;color:var(--text);">
                                                        {{ Str::limit($booking->catererProfile->business_name ?? 'N/A', 18) }}
                                                    </div>
                                                    <small style="color:var(--text-muted);font-size:0.7rem;">
                                                        {{ $booking->event_type_label ?? ucfirst($booking->event_type ?? '—') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight:600;font-size:0.82rem;">
                                                {{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}
                                            </div>
                                            <small style="color:var(--text-muted);font-size:0.68rem;">
                                                {{ \Carbon\Carbon::parse($booking->event_date)->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td>
                                            <span style="font-weight:600;font-size:0.82rem;">{{ $booking->pax ?? '—' }}</span>
                                            <small style="color:var(--text-muted);display:block;font-size:0.68rem;">pax</small>
                                        </td>
                                        <td>
                                            @if($booking->downpayment_deadline && $booking->status === 'confirmed')
                                                @php $daysLeft = now()->diffInDays(\Carbon\Carbon::parse($booking->downpayment_deadline), false); @endphp
                                                <span style="font-weight:600;font-size:0.79rem;color:{{ $daysLeft <= 2 ? 'var(--red)' : ($daysLeft <= 5 ? '#d97706' : 'var(--text)') }};">
                                                    {{ \Carbon\Carbon::parse($booking->downpayment_deadline)->format('M d, Y') }}
                                                </span>
                                                <small style="color:{{ $daysLeft <= 2 ? 'var(--red)' : 'var(--text-muted)' }};font-size:0.67rem;display:block;">
                                                    {{ $daysLeft > 0 ? $daysLeft . 'd left' : 'Overdue' }}
                                                </small>
                                            @else
                                                <span style="color:var(--text-muted);">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php $sc = $booking->status_color; @endphp
                                            <span class="st-pill" style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                                                <i class="bi bi-{{ $sc['icon'] }}" style="font-size:0.6rem;"></i>
                                                {{ $booking->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-1 justify-content-end flex-wrap">
                                                @if($booking->status === 'completed' && !$booking->review)
                                                    <button class="action-btn btn-rate"
                                                            data-bs-toggle="modal" data-bs-target="#reviewModal{{ $booking->id }}">
                                                        <i class="bi bi-star-fill"></i> Rate
                                                    </button>
                                                @endif
                                                @if($booking->status === 'confirmed' && in_array($booking->payment_status, ['unpaid', 'rejected']))
                                                    <a href="{{ route('bookings.show', $booking->id) }}" class="action-btn btn-pay">
                                                        <i class="bi bi-credit-card"></i> Pay Now
                                                    </a>
                                                @endif
                                                @if($booking->status === 'awaiting_payment')
                                                    <span class="action-btn btn-verify">
                                                        <i class="bi bi-hourglass-split"></i> Verifying
                                                    </span>
                                                @endif
                                                @if($booking->status === 'paid')
                                                    <span class="action-btn btn-secure">
                                                        <i class="bi bi-patch-check-fill"></i> Secured
                                                    </span>
                                                @endif
                                                <a href="{{ route('bookings.show', $booking->id) }}" class="action-btn btn-view">
                                                    <i class="bi bi-chat"></i> View
                                                </a>
                                                @if(in_array($booking->status, ['pending', 'confirmed']))
                                                    <button class="action-btn btn-cancel"
                                                            onclick="if(confirm('Cancel this booking?')) document.getElementById('cancelForm{{ $booking->id }}').submit()">
                                                        <i class="bi bi-x-circle"></i> Cancel
                                                    </button>
                                                    <form id="cancelForm{{ $booking->id }}" action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display:none;">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="cancellation_reason" value="Cancelled by customer from dashboard">
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="padding:32px 16px;">
                                            <div class="empty-box">
                                                <i class="bi bi-calendar-x"></i>
                                                <p>No bookings yet.</p>
                                                <a href="{{ route('caterers.index') }}" class="action-btn btn-pay" style="display:inline-flex;">
                                                    <i class="bi bi-search"></i> Find a caterer
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div id="noFilterResults" class="d-none text-center py-4">
                        <i class="bi bi-funnel" style="color:var(--text-muted);display:block;margin-bottom:8px;"></i>
                        <p style="color:var(--text-muted);font-size:0.84rem;margin:0;">No bookings match this filter.</p>
                    </div>
                </div>
            </div>

            {{-- ── SPOTLIGHT ── --}}
            @isset($topPerformer)
            <div class="spotlight-card">
                <div class="spotlight-init">{{ strtoupper(substr($topPerformer->business_name, 0, 1)) }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="spotlight-meta-label">Platform star</div>
                    <div class="spotlight-name">{{ $topPerformer->business_name }}</div>
                    <div class="spotlight-tags">
                        <span class="sp-tag"><i class="bi bi-star-fill"></i> {{ number_format((float)($topPerformer->average_rating ?? 0), 1) }}</span>
                        <span class="sp-verified"><i class="bi bi-patch-check-fill"></i> Verified caterer</span>
                        <span class="sp-tag"><i class="bi bi-geo-alt-fill"></i> {{ $topPerformer->location }}</span>
                    </div>
                </div>
                <div class="spotlight-pricing">
                    <div class="sp-price-label">From</div>
                    <div class="sp-price">₱{{ number_format($topPerformer->min_budget ?? $topPerformer->price_per_guest ?? 0, 0) }}</div>
                    <div class="sp-price-unit">/guest</div>
                </div>
                <a href="{{ route('caterer.details', $topPerformer->id) }}" class="spotlight-book-btn">Book now</a>
            </div>
            @endisset

            {{-- ── RECOMMENDED CATERERS ── --}}
            <div class="rec-header">
                <div class="rec-title"><i class="bi bi-stars"></i> Recommended caterers</div>
                <a href="{{ route('caterers.index') }}" class="rec-view-all">View all <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="row g-3 mb-4">
                @forelse($recommendedCaterers ?? [] as $rec)
                    <div class="col-md-4">
                        <div class="caterer-rec-card">
                            @if($rec->profile_picture)
                                <img src="{{ asset('storage/' . $rec->profile_picture) }}"
                                     alt="{{ $rec->business_name }}" class="caterer-rec-img">
                            @else
                                <div class="caterer-rec-img-placeholder">
                                    <i class="bi bi-building"></i>
                                </div>
                            @endif
                            <div class="rec-card-body">
                                <div class="rec-card-top">
                                    <div>
                                        <div class="rec-card-name">
                                            {{ $rec->business_name }}
                                            @if($rec->status === 'verified')
                                                <i class="bi bi-patch-check-fill" style="color:var(--green);font-size:0.72rem;"></i>
                                            @endif
                                        </div>
                                        <div class="rec-card-spec">{{ $rec->specialty ?? 'Catering Services' }}</div>
                                    </div>
                                    <div class="rec-rating">
                                        <i class="bi bi-star-fill" style="font-size:0.65rem;"></i>
                                        {{ number_format((float)($rec->average_rating ?? 0), 1) }}
                                    </div>
                                </div>
                                @if($rec->location)
                                    <div class="rec-location">
                                        <i class="bi bi-geo-alt-fill"></i> {{ $rec->location }}
                                    </div>
                                @endif
                                <div class="rec-price-box">
                                    <div class="rec-price-label">Per guest</div>
                                    <div style="display:flex;align-items:baseline;gap:4px;flex-wrap:wrap;">
                                        <span style="font-size:0.86rem;font-weight:700;color:var(--orange);">₱{{ number_format((int)($rec->min_budget ?? $rec->price_per_guest ?? 0), 0) }}</span>
                                        <span style="color:var(--text-muted);font-size:0.78rem;">–</span>
                                        <span style="font-size:0.86rem;font-weight:700;color:var(--text);">₱{{ number_format((int)($rec->max_budget ?? $rec->price_per_guest ?? 0), 0) }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('caterer.details', $rec->id) }}" class="rec-book-btn">
                                    Book now <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-box">
                            <i class="bi bi-inbox"></i>
                            <p>Browse our top caterers to see recommendations here!</p>
                            <a href="{{ route('caterers.index') }}" class="action-btn btn-pay" style="display:inline-flex;">
                                <i class="bi bi-search"></i> Browse caterers
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

{{-- ── REVIEW MODALS ── --}}
@foreach($bookings as $booking)
    @if($booking->status === 'completed' && !$booking->review)
        <div class="modal fade" id="reviewModal{{ $booking->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('reviews.store') }}" method="POST" class="modal-content" style="border-radius:13px;">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    <input type="hidden" name="caterer_profile_id" value="{{ $booking->caterer_profile_id }}">
                    <div class="modal-header" style="padding:16px 20px 13px;">
                        <div>
                            <h5 class="modal-title" style="font-family:'Montserrat',sans-serif;font-weight:900;font-size:0.92rem;">
                                <i class="bi bi-star-fill me-2" style="color:var(--orange);"></i>
                                Rate {{ $booking->catererProfile->business_name }}
                            </h5>
                            <div style="font-size:0.68rem;color:var(--text-muted);margin-top:2px;">
                                Event on {{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding:16px 20px;">
                        <div class="mb-3 text-center">
                            <label class="d-block mb-2" style="font-size:0.7rem;font-weight:700;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);">Your Rating</label>
                            <div class="d-flex justify-content-center gap-2" id="starRow{{ $booking->id }}">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="bi bi-star star-btn" data-val="{{ $s }}" data-target="rating{{ $booking->id }}"
                                       style="font-size:1.7rem;cursor:pointer;color:rgba(0,0,0,0.15);transition:color .12s;"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating{{ $booking->id }}" required>
                        </div>
                        <div>
                            <label class="form-label" style="font-size:0.7rem;font-weight:700;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:1px;color:var(--text-muted);">Your Review</label>
                            <textarea name="comment" rows="3" class="form-control rounded-3"
                                      placeholder="Share your experience with this caterer…"
                                      style="font-size:0.85rem;resize:none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="padding:12px 20px;">
                        <button type="button" class="btn btn-sm rounded-pill px-4 fw-bold"
                                style="background:var(--surface3);color:var(--text);border:1px solid var(--border-md);"
                                data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm rounded-pill px-4 fw-bold"
                                style="background:var(--orange);color:white;border:none;">
                            <i class="bi bi-send-fill me-1"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endforeach

{{-- ── MOBILE BOTTOM NAV ── --}}
<nav class="mobile-btm-nav d-lg-none">
    <div class="container-fluid px-3">
        <div class="d-flex justify-content-around w-100">
            <a href="{{ url('/dashboard') }}" class="nav-link text-center py-1 text-warning" style="flex:1;">
                <i class="bi bi-grid-fill" style="font-size:1.15rem;display:block;"></i>
                <small style="font-size:0.62rem;">Home</small>
            </a>
            <a href="#bookings" class="nav-link text-center py-1" style="flex:1;color:var(--text-muted);">
                <i class="bi bi-calendar-check" style="font-size:1.15rem;display:block;"></i>
                <small style="font-size:0.62rem;">Bookings</small>
            </a>
            <a href="{{ route('caterers.index') }}" class="nav-link text-center py-1" style="flex:1;color:var(--text-muted);">
                <i class="bi bi-shop" style="font-size:1.15rem;display:block;"></i>
                <small style="font-size:0.62rem;">Browse</small>
            </a>
            <a href="#" class="nav-link text-center py-1" style="flex:1;color:var(--text-muted);">
                <i class="bi bi-person-fill" style="font-size:1.15rem;display:block;"></i>
                <small style="font-size:0.62rem;">Profile</small>
            </a>
        </div>
    </div>
</nav>

<script>
    // ── Booking tab filter ──
    document.querySelectorAll('.booking-tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.booking-tab-btn').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            var filter = this.getAttribute('data-filter');
            var rows   = document.querySelectorAll('.booking-row');
            var count  = 0;
            rows.forEach(function(row) {
                if (filter === 'all' || row.getAttribute('data-status') === filter) { row.style.display = ''; count++; }
                else { row.style.display = 'none'; }
            });
            var nr = document.getElementById('noFilterResults');
            if (nr) nr.classList.toggle('d-none', count > 0);
        });
    });

    // ── Star rating in review modals ──
    document.querySelectorAll('.star-btn').forEach(function(star) {
        star.addEventListener('click', function() {
            var val    = parseInt(this.dataset.val);
            var target = this.dataset.target;
            var input  = document.getElementById(target);
            if (input) input.value = val;
            var row = this.closest('[id^="starRow"]');
            if (row) {
                row.querySelectorAll('.star-btn').forEach(function(s, i) {
                    s.classList.toggle('bi-star-fill', i < val);
                    s.classList.toggle('bi-star', i >= val);
                    s.style.color = i < val ? '#FF7A00' : 'rgba(0,0,0,0.15)';
                });
            }
        });
        star.addEventListener('mouseenter', function() {
            var val = parseInt(this.dataset.val);
            var row = this.closest('[id^="starRow"]');
            if (row) {
                row.querySelectorAll('.star-btn').forEach(function(s, i) {
                    s.style.color = i < val ? '#FF7A00' : 'rgba(0,0,0,0.15)';
                });
            }
        });
        star.addEventListener('mouseleave', function() {
            var row    = this.closest('[id^="starRow"]');
            var target = this.dataset.target;
            var input  = document.getElementById(target);
            var current = input ? parseInt(input.value) || 0 : 0;
            if (row) {
                row.querySelectorAll('.star-btn').forEach(function(s, i) {
                    s.style.color = i < current ? '#FF7A00' : 'rgba(0,0,0,0.15)';
                });
            }
        });
    });

    // ── Notification dropdown toggle ──
    function toggleNotifDropdown() {
        var d = document.getElementById('notifDropdown');
        d.style.display = d.style.display === 'none' ? 'block' : 'none';
    }
    document.addEventListener('click', function(e) {
        var dropdown = document.getElementById('notifDropdown');
        if (!dropdown) return;
        if (!e.target.closest('#notifDropdown') && !e.target.closest('button[onclick="toggleNotifDropdown()"]')) {
            dropdown.style.display = 'none';
        }
    });
</script>

@endsection