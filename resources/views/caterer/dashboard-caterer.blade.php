@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --orange: #FF7A00;
        --charcoal: #1a1a1a;
        --bg-main: #0f0f0f;
        --bg-card: #1a1a1a;
        --bg-card2: #222222;
        --border: #2a2a2a;
        --text-primary: #f9fafb;
        --text-muted: #6b7280;
        --text-sub: #4b5563;
        --green: #10b981;
        --red: #ef4444;
        --radius: 14px;
    }

    body { padding-top: 0 !important; margin: 0; background: var(--bg-main); color: var(--text-primary); }

    /* ── Layout ── */
    .dash-wrap { display: flex; min-height: 100vh; font-family: 'Inter', sans-serif; }

    /* ── Sidebar ── */
    .dash-sidebar {
        width: 215px; min-width: 215px;
        background: #161616;
        border-right: 1px solid var(--border);
        position: sticky; top: 0; height: 100vh;
        overflow-y: auto; display: flex; flex-direction: column;
    }
    .sidebar-inner { padding: 1.25rem 0.9rem; display: flex; flex-direction: column; height: 100%; gap: 2px; }

    .sidebar-brand {
        display: flex; align-items: center; gap: 10px;
        padding: 0.4rem 0.5rem 1.2rem;
        border-bottom: 1px solid var(--border); margin-bottom: 1rem;
    }
    .brand-icon {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #FF7A00, #ff9d42);
        border-radius: 10px; display: flex; align-items: center; justify-content: center;
        font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 0.72rem;
        color: white; flex-shrink: 0; box-shadow: 0 4px 12px rgba(255,122,0,0.3);
    }
    .brand-name { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 0.95rem; color: var(--text-primary); display: block; line-height: 1.2; }
    .brand-name span { color: var(--orange); }
    .brand-role { font-size: 0.68rem; color: var(--text-sub); font-weight: 500; }

    /* User card in sidebar */
    .sidebar-user-card {
        background: var(--bg-card2); border: 1px solid var(--border);
        border-radius: 12px; padding: 12px; margin-bottom: 1rem;
        display: flex; align-items: center; gap: 10px;
    }
    .sidebar-avatar {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        background: linear-gradient(135deg, #FF7A00, #ff9d42);
        display: flex; align-items: center; justify-content: center;
        font-weight: 900; font-size: 1rem; color: white;
    }
    .sidebar-user-name { font-weight: 700; font-size: 0.85rem; color: var(--text-primary); }
    .sidebar-user-email { font-size: 0.68rem; color: var(--text-muted); }

    .nav-section-label {
        font-size: 0.63rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.1em; color: var(--text-sub);
        padding: 0 0.4rem; margin: 0.6rem 0 0.3rem; display: block;
    }
    .sidebar-nav { display: flex; flex-direction: column; gap: 1px; }
    .sidebar-link {
        display: flex; align-items: center; gap: 9px;
        padding: 8px 10px; border-radius: 8px;
        color: var(--text-muted); text-decoration: none;
        font-size: 0.83rem; font-weight: 500; transition: all 0.15s ease;
        border: none; background: transparent; cursor: pointer; width: 100%; text-align: left;
    }
    .sidebar-link i { font-size: 0.9rem; flex-shrink: 0; }
    .sidebar-link span { flex: 1; }
    .sidebar-link:hover { background: #1f1f1f; color: var(--text-primary); }
    .sidebar-link.active { background: rgba(255,122,0,0.12); color: var(--orange); }
    .sidebar-link.active i { color: var(--orange); }

    /* Become a caterer promo card */
    .sidebar-promo {
        background: var(--bg-card2); border: 1px solid var(--border);
        border-radius: 12px; padding: 14px; margin-top: auto; margin-bottom: 0.75rem;
    }
    .sidebar-promo-label { font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-sub); margin-bottom: 4px; }
    .sidebar-promo-title { font-weight: 700; font-size: 0.85rem; color: var(--text-primary); margin-bottom: 8px; }
    .sidebar-promo-btn {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        width: 100%; padding: 7px; border-radius: 8px;
        background: var(--bg-card); border: 1px solid var(--border);
        color: var(--text-primary); font-size: 0.78rem; font-weight: 600;
        cursor: pointer; text-decoration: none; transition: all 0.15s;
    }
    .sidebar-promo-btn:hover { border-color: var(--orange); color: var(--orange); }

    /* ── Main ── */
    .dash-main { flex: 1; padding: 1.75rem 2rem 3rem; overflow-x: hidden; background: var(--bg-main); }

    /* Topbar */
    .dash-topbar { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 12px; }
    .topbar-title { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 2rem; color: var(--text-primary); margin: 0 0 4px; }
    .topbar-title span { color: var(--orange); }
    .topbar-sub { font-size: 0.875rem; color: var(--text-muted); margin: 0; }
    .topbar-sub strong { color: var(--text-primary); }
    .account-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px; border-radius: 999px;
        font-size: 0.82rem; font-weight: 700;
    }
    .account-badge.verified { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #34d399; }
    .account-badge.pending  { background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.25); color: #fbbf24; }

    /* ── Stat Cards ── */
    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 1.25rem; }
    .stat-card {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 1.1rem 1.25rem;
    }
    .stat-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--text-sub); margin: 0 0 8px; }
    .stat-num { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 2rem; color: var(--text-primary); margin: 0 0 4px; line-height: 1; }
    .stat-num.orange { color: var(--orange); }
    .stat-sub-text { font-size: 0.72rem; color: var(--text-sub); }

    /* ── Dark section cards ── */
    .section-card {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); overflow: hidden; margin-bottom: 1.25rem;
    }
    .section-card-body { padding: 1.5rem; }
    .section-title {
        font-weight: 700; font-size: 1rem; color: var(--text-primary);
        display: flex; align-items: center; gap: 8px; margin: 0 0 2px;
    }
    .section-title i { color: var(--orange); }
    .section-sub { font-size: 0.8rem; color: var(--text-muted); margin: 0; }

    /* Journey steps */
    .journey-wrap { position: relative; display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-top: 1.5rem; }
    .journey-line { position: absolute; top: 24px; left: 0; right: 0; height: 2px; background: var(--border); z-index: 0; }
    .journey-step { flex: 1; text-align: center; position: relative; z-index: 1; }
    .journey-circle {
        width: 48px; height: 48px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1.1rem; margin: 0 auto;
        border: 2px solid var(--border); transition: all 0.2s;
    }
    .journey-circle.done { background: var(--orange); border-color: var(--orange); color: white; }
    .journey-circle.todo { background: var(--bg-card2); color: var(--text-sub); }
    .journey-label { font-size: 0.75rem; font-weight: 600; margin-top: 8px; color: var(--text-muted); }
    .journey-label.done { color: var(--text-primary); }
    .journey-start { font-size: 0.68rem; color: var(--orange); margin-top: 2px; display: block; text-decoration: none; }

    /* Booking tabs */
    .booking-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 1.25rem; }
    .booking-tab-btn {
        border: 1px solid var(--border); outline: none;
        background: var(--bg-card2); color: var(--text-muted);
        font-weight: 600; font-size: 0.78rem;
        padding: 5px 14px; border-radius: 999px;
        cursor: pointer; transition: all 0.15s ease;
    }
    .booking-tab-btn:hover { border-color: #444; color: var(--text-primary); }
    .booking-tab-btn.active { background: var(--orange) !important; color: white !important; border-color: var(--orange) !important; }

    /* Tables */
    .dark-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }
    .dark-table thead th {
        font-size: 0.67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.07em; color: var(--text-sub);
        padding: 10px 12px; border-bottom: 1px solid var(--border);
        background: #161616;
    }
    .dark-table tbody td { padding: 12px 12px; border-bottom: 1px solid #1f1f1f; vertical-align: middle; color: var(--text-primary); }
    .dark-table tbody tr:last-child td { border-bottom: none; }
    .dark-table tbody tr:hover td { background: #1f1f1f; }

    .user-cell { display: flex; align-items: center; gap: 9px; }
    .row-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg, #FF7A00, #ff9d42);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.85rem; color: white; flex-shrink: 0;
    }
    .cell-name { font-weight: 600; font-size: 0.85rem; color: var(--text-primary); margin: 0 0 1px; }
    .cell-sub  { font-size: 0.72rem; color: var(--text-sub); margin: 0; }

    /* Status pills */
    .status-pill {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 11px; border-radius: 999px;
        font-size: 0.67rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.04em;
        font-family: 'Montserrat', sans-serif;
    }
    .s-pending   { background: rgba(245,158,11,0.12); color: #fbbf24; border: 1px solid rgba(245,158,11,0.25); }
    .s-confirmed { background: rgba(16,185,129,0.12); color: #34d399; border: 1px solid rgba(16,185,129,0.25); }
    .s-awaiting  { background: rgba(59,130,246,0.12); color: #60a5fa; border: 1px solid rgba(59,130,246,0.25); }
    .s-paid      { background: rgba(139,92,246,0.12); color: #a78bfa; border: 1px solid rgba(139,92,246,0.25); }
    .s-completed { background: rgba(16,185,129,0.12); color: #34d399; border: 1px solid rgba(16,185,129,0.25); }
    .s-cancelled { background: rgba(239,68,68,0.12);  color: #f87171; border: 1px solid rgba(239,68,68,0.25); }

    /* Action buttons */
    .btn-dark-sm {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 12px; border-radius: 8px;
        background: var(--bg-card2); border: 1px solid var(--border);
        color: var(--text-primary); font-size: 0.75rem; font-weight: 600;
        text-decoration: none; cursor: pointer; transition: all 0.15s;
    }
    .btn-dark-sm:hover { border-color: var(--orange); color: var(--orange); }
    .btn-orange-sm {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 12px; border-radius: 8px;
        background: rgba(255,122,0,0.1); border: 1px solid rgba(255,122,0,0.25);
        color: var(--orange); font-size: 0.75rem; font-weight: 600;
        text-decoration: none; cursor: pointer; transition: all 0.15s;
    }
    .btn-orange-sm:hover { background: var(--orange); color: white; }
    .btn-receipt {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 12px; border-radius: 8px;
        background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.25);
        color: #60a5fa; font-size: 0.75rem; font-weight: 600;
        text-decoration: none; transition: all 0.15s;
    }
    .btn-receipt:hover { background: #3b82f6; color: white; }

    /* Tab nav for menu/packages */
    .section-tab-nav { display: flex; gap: 4px; border-bottom: 1px solid var(--border); margin-bottom: 1.5rem; flex-wrap: wrap; }
    .section-tab {
        border: none; background: transparent;
        padding: 10px 16px; font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
        color: var(--text-sub); cursor: pointer;
        border-bottom: 2px solid transparent; margin-bottom: -1px;
        transition: all 0.2s;
    }
    .section-tab:hover { color: var(--text-primary); }
    .section-tab.active { color: var(--orange); border-bottom-color: var(--orange); }

    /* Menu & package cards */
    .cat-filter { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 1.25rem; }
    .cat-btn {
        padding: 5px 14px; border: 1px solid var(--border);
        border-radius: 999px; background: var(--bg-card2); color: var(--text-muted);
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s;
    }
    .cat-btn:hover, .cat-btn.active { border-color: var(--orange); background: var(--orange); color: white; }
    .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 14px; }
    .menu-card {
        background: var(--bg-card2); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 16px;
        transition: all 0.2s ease; position: relative;
    }
    .menu-card:hover { border-color: var(--orange); transform: translateY(-2px); }
    .menu-card.unavailable { opacity: 0.5; }
    .menu-card-category { font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: var(--orange); margin-bottom: 5px; }
    .menu-card-name { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 0.9rem; text-transform: uppercase; color: var(--text-primary); margin-bottom: 5px; }
    .menu-card-desc { font-size: 0.75rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 10px; min-height: 32px; }
    .menu-card-price { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.2rem; color: var(--orange); margin-bottom: 12px; }
    .menu-card-footer { display: flex; justify-content: space-between; align-items: center; gap: 8px; padding-top: 10px; border-top: 1px solid var(--border); }

    .packages-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px; }
    .pkg-card { background: var(--bg-card2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; transition: all 0.2s; display: flex; flex-direction: column; }
    .pkg-card:hover { border-color: var(--orange); transform: translateY(-3px); }
    .pkg-card.unavailable { opacity: 0.5; }
    .pkg-card-header { background: #111; padding: 18px 18px 14px; position: relative; overflow: hidden; border-bottom: 1px solid var(--border); }
    .pkg-card-header::before { content: ''; position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; border-radius: 50%; background: rgba(255,122,0,0.1); }
    .pkg-card-name { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 0.9rem; text-transform: uppercase; color: var(--text-primary); margin-bottom: 5px; position: relative; z-index: 1; }
    .pkg-card-price { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.5rem; color: var(--orange); line-height: 1; position: relative; z-index: 1; }
    .pkg-card-price-unit { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-sub); margin-top: 2px; }
    .pkg-card-pax { font-size: 0.68rem; color: var(--text-muted); font-weight: 600; margin-top: 4px; position: relative; z-index: 1; }
    .pkg-card-body { padding: 14px 18px; flex: 1; }
    .pkg-card-desc { font-size: 0.78rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 10px; }
    .pkg-inclusions-title { font-family: 'Montserrat', sans-serif; font-size: 0.58rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: var(--orange); margin-bottom: 7px; }
    .pkg-inclusion-item { display: flex; align-items: center; gap: 7px; font-size: 0.75rem; color: var(--text-primary); margin-bottom: 4px; }
    .pkg-inclusion-item i { color: var(--green); font-size: 0.78rem; flex-shrink: 0; }
    .pkg-card-footer { padding: 10px 18px 14px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; gap: 8px; }

    .avail-pill { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 999px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .avail-pill.available { background: rgba(16,185,129,0.12); color: #34d399; }
    .avail-pill.unavailable { background: rgba(239,68,68,0.1); color: #f87171; }

    .btn-edit-sm {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 11px; background: var(--bg-card); border: 1px solid var(--border);
        color: var(--text-primary); border-radius: 7px; font-size: 0.7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.4px; text-decoration: none; transition: all 0.2s;
    }
    .btn-edit-sm:hover { background: var(--orange); border-color: var(--orange); color: white; }
    .btn-del-sm {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px; background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2);
        color: #f87171; border-radius: 7px; font-size: 0.7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.4px; cursor: pointer; transition: all 0.2s;
    }
    .btn-del-sm:hover { background: var(--red); color: white; }
    .btn-add-main {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--orange); color: white; border: none;
        border-radius: 10px; padding: 9px 18px; font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px;
        text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 12px rgba(255,122,0,0.25);
    }
    .btn-add-main:hover { background: #e06900; color: white; transform: translateY(-1px); }

    .summary-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 1.1rem; }
    .summary-pill {
        display: flex; align-items: center; gap: 7px;
        background: var(--bg-card2); border: 1px solid var(--border);
        border-radius: 9px; padding: 7px 14px; font-size: 0.75rem; color: var(--text-muted);
    }
    .summary-pill strong { font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 0.95rem; color: var(--orange); }

    .empty-state {
        text-align: center; padding: 40px 24px;
        background: var(--bg-card2); border-radius: var(--radius);
        border: 1px dashed var(--border);
    }
    .empty-state i { font-size: 2.2rem; color: var(--border); display: block; margin-bottom: 10px; }
    .empty-state h4 { font-family: 'Montserrat', sans-serif; font-weight: 800; text-transform: uppercase; color: var(--text-primary); margin-bottom: 5px; font-size: 0.95rem; }
    .empty-state p { font-size: 0.82rem; color: var(--text-muted); margin-bottom: 18px; }

    /* Reviews */
    .review-card {
        background: var(--bg-card2); border: 1px solid var(--border);
        border-left: 3px solid var(--orange); border-radius: var(--radius); padding: 1.25rem;
    }
    .review-reply {
        padding: 10px 13px; background: rgba(255,122,0,0.06);
        border-left: 2px solid var(--orange); border-radius: 0 8px 8px 0; margin-bottom: 8px;
    }
    .reply-label { font-family: 'Montserrat', sans-serif; font-size: 0.58rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--orange); margin-bottom: 3px; }
    .reply-text { font-size: 0.82rem; color: var(--text-primary); line-height: 1.5; margin: 0; font-style: italic; }
    .textarea-dark {
        width: 100%; background: var(--bg-card); border: 1px solid var(--border);
        color: var(--text-primary); border-radius: 8px; padding: 10px 13px;
        font-size: 0.82rem; resize: none; outline: none; font-family: 'Inter', sans-serif;
    }
    .textarea-dark::placeholder { color: var(--text-sub); }
    .textarea-dark:focus { border-color: var(--orange); }

    /* Pending alert */
    .pending-alert {
        background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2);
        border-left: 3px solid #f59e0b; border-radius: var(--radius);
        padding: 1.1rem 1.25rem; margin-bottom: 1.25rem;
        display: flex; gap: 12px; align-items: flex-start;
    }
    .pending-alert-icon { font-size: 1.5rem; flex-shrink: 0; }
    .pending-alert h6 { font-weight: 700; color: #fbbf24; margin: 0 0 3px; font-size: 0.95rem; }
    .pending-alert p { font-size: 0.82rem; color: var(--text-muted); margin: 0; }

    /* Success flash */
    .success-flash {
        background: rgba(16,185,129,0.08); border: 1px solid rgba(16,185,129,0.2);
        border-left: 3px solid #10b981; border-radius: var(--radius);
        padding: 10px 16px; margin-bottom: 1rem; font-size: 0.85rem;
        color: #34d399; display: flex; align-items: center; gap: 8px;
    }

    /* Mobile bottom nav */
    .mobile-bottom-nav {
        position: fixed; bottom: 0; left: 0; right: 0;
        background: #161616; border-top: 1px solid var(--border);
        padding: 8px 0; z-index: 100; display: none;
    }
    @media (max-width: 991px) {
        .dash-sidebar { display: none; }
        .mobile-bottom-nav { display: block; }
        .dash-main { padding: 1rem 1rem 5rem; }
        .stats-grid { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .topbar-title { font-size: 1.5rem; }
    }
    html { scroll-behavior: smooth; }
</style>

<div class="dash-wrap">

    {{-- ── Sidebar ── --}}
    <aside class="dash-sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-brand">
                <div class="brand-icon">CC</div>
                <div>
                    <div class="brand-name">Cater<span>Connect</span></div>
                    <div class="brand-role">Caterer panel</div>
                </div>
            </div>

            <div class="sidebar-user-card">
    <div class="sidebar-avatar">
        {{ strtoupper(substr(Auth::user()->catererProfile?->business_name ?? Auth::user()->name, 0, 1)) }}
    </div>
    <div>
        <div class="sidebar-user-name">
            {{ Str::limit(Auth::user()->catererProfile?->business_name ?? Auth::user()->name, 40) }}
        </div>
        <div class="sidebar-user-email">
            {{ Str::limit(Auth::user()->email, 22) }}
        </div>
    </div>
</div>

            <span class="nav-section-label">Main</span>
            <nav class="sidebar-nav">
                <a class="sidebar-link active" href="{{ url('/dashboard') }}">
                    <i class="bi bi-grid-fill"></i><span>Overview</span>
                </a>
                <a class="sidebar-link" href="#bookings">
                    <i class="bi bi-calendar-check"></i><span>My bookings</span>
                </a>
                <button class="sidebar-link" onclick="switchSection('menus');scrollTo('menu-section')">
                    <i class="bi bi-card-list"></i><span>Menus</span>
                </button>
                <button class="sidebar-link" onclick="switchSection('packages');scrollTo('menu-section')">
                    <i class="bi bi-box-seam"></i><span>Packages</span>
                </button>
                <a class="sidebar-link" href="#reviews">
                    <i class="bi bi-star-fill"></i><span>Reviews</span>
                </a>
                <a class="sidebar-link" href="{{ route('caterer.edit') }}">
                    <i class="bi bi-shop"></i><span>Business profile</span>
                </a>
            </nav>

            <span class="nav-section-label" style="margin-top:1rem;">Support</span>
            <nav class="sidebar-nav">
                <a class="sidebar-link" href="#">
                    <i class="bi bi-question-circle"></i><span>Help & support</span>
                </a>
                <a class="sidebar-link" href="#">
                    <i class="bi bi-file-text"></i><span>Terms & privacy</span>
                </a>
                <a class="sidebar-link" href="#" 
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="bi bi-box-arrow-right"></i><span>Logout</span>
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
            </nav>

        </div>
    </aside>

     {{-- ── Main ── --}}
    <div class="dash-main">

        {{-- Topbar --}}
<div class="dash-topbar">
    <div>
        <h1 class="topbar-title">Business <span>hub</span></h1>
        <p class="topbar-sub">Welcome back, <strong>{{ explode(' ', Auth::user()->name)[0] }}</strong>! Here's your catering business overview.</p>
    </div>
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">

        {{-- Notification Bell --}}
        <div style="position:relative;">
            <button onclick="toggleNotifDropdown()" style="width:42px;height:42px;border-radius:50%;background:var(--bg-card2);border:1px solid var(--border);color:var(--text-muted);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;position:relative;"
                    onmouseover="this.style.borderColor='var(--orange)';this.style.color='var(--orange)'"
                    onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-muted)'">
                <i class="bi bi-bell-fill" style="font-size:1rem;"></i>
                @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                @if($unreadCount > 0)
                    <span style="position:absolute;top:6px;right:6px;width:8px;height:8px;border-radius:50%;background:var(--orange);border:2px solid #161616;"></span>
                @endif
            </button>

            {{-- Dropdown --}}
            <div id="notifDropdown" style="display:none;position:absolute;top:52px;right:0;width:320px;background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 20px 60px rgba(0,0,0,.4);z-index:999;overflow:hidden;">
                <div style="padding:14px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:.8rem;color:var(--text-primary);text-transform:uppercase;letter-spacing:.5px;">Notifications</span>
                    @if($unreadCount > 0)
                        <a href="{{ route('notifications.markAllRead') }}" style="font-size:.68rem;font-weight:700;color:var(--orange);text-decoration:none;">Mark all read</a>
                    @endif
                </div>

                <div style="max-height:340px;overflow-y:auto;">
                    @forelse(Auth::user()->notifications->take(10) as $notif)
                        @php
                            $isUnread = is_null($notif->read_at);
                            $typeColor = match($notif->data['type'] ?? 'info') {
                                'success' => '#10b981',
                                'danger'  => '#ef4444',
                                'warning' => '#f59e0b',
                                default   => '#3b82f6',
                            };
                        @endphp
                        <a href="{{ route('notifications.read', $notif->id) }}"
                           style="display:flex;align-items:flex-start;gap:12px;padding:13px 16px;border-bottom:1px solid var(--border);text-decoration:none;transition:background .15s;background:{{ $isUnread ? 'rgba(255,122,0,0.04)' : 'transparent' }};"
                           onmouseover="this.style.background='#1f1f1f'"
                           onmouseout="this.style.background='{{ $isUnread ? 'rgba(255, 255, 255, 0.04)' : 'transparent' }}'">
                            <div style="width:34px;height:34px;border-radius:50%;background:{{ $typeColor }}18;border:1px solid {{ $typeColor }}30;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
                                <i class="bi bi-{{ match($notif->data['type'] ?? 'info') { 'success' => 'check-circle-fill', 'danger' => 'x-circle-fill', 'warning' => 'exclamation-triangle-fill', default => 'info-circle-fill' } }}" style="color:{{ $typeColor }};font-size:.78rem;"></i>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:.78rem;font-weight:{{ $isUnread ? '700' : '500' }};color:#fff;{{ $isUnread ? 'var(--text-primary)' : 'var(--text-muted)' }};margin-bottom:2px;line-height:1.4;">{{ $notif->data['title'] ?? 'Notification' }}</div>
                                <div style="font-size:.7rem;color:#fff;opacity:0.75;line-height:1.45;">{{ Str::limit($notif->data['message'] ?? '', 70) }}</div>
                                <div style="font-size:.62rem;color:#fff;opacity:0.75;margin-top:4px;">{{ $notif->created_at->diffForHumans() }}</div>
                            </div>
                            @if($isUnread)
                                <div style="width:7px;height:7px;border-radius:50%;background:var(--orange);flex-shrink:0;margin-top:6px;"></div>
                            @endif
                        </a>
                    @empty
                        <div style="text-align:center;padding:32px 20px;color:var(--text-sub);">
                            <i class="bi bi-bell-slash" style="font-size:1.8rem;display:block;margin-bottom:8px;opacity:.3;"></i>
                            <div style="font-size:.78rem;font-weight:600;">No notifications yet</div>
                        </div>
                    @endforelse
                </div>

                @if(Auth::user()->notifications->count() > 10)
                    <div style="padding:10px 16px;border-top:1px solid var(--border);text-align:center;">
                        <span style="font-size:.72rem;color:var(--text-sub);">Showing latest 10 notifications</span>
                    </div>
                @endif
            </div>
        </div>

        @php $isVerified = ($catererProfile->status ?? 'pending') === 'verified'; @endphp
        <span class="account-badge {{ $isVerified ? 'verified' : 'pending' }}">
            <i class="bi bi-circle-fill" style="font-size:0.5rem;"></i>
            {{ $isVerified ? 'Account active' : 'Pending verification' }}
        </span>
    </div>
</div>

        {{-- Alerts --}}
        @if(!$isVerified)
            <div class="pending-alert">
                <div class="pending-alert-icon">⏳</div>
                <div>
                    <h6>Verification Pending</h6>
                    <p>Your business permits are under review. Most features will be available once verified. This typically takes 1–2 business days.</p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="success-flash">
                <i class="bi bi-check-circle-fill"></i>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        <div style="{{ !$isVerified ? 'filter:blur(4px);pointer-events:none;opacity:0.6;' : '' }}">

            {{-- ── Stats ── --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <p class="stat-label">Total Bookings</p>
                    <h2 class="stat-num">{{ $bookings->count() }}</h2>
                    <span class="stat-sub-text">All time inquiries</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Confirmed</p>
                    <h2 class="stat-num orange">{{ $bookings->where('status','confirmed')->count() }}</h2>
                    <span class="stat-sub-text">Upcoming events</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Completed</p>
                    <h2 class="stat-num">{{ $bookings->where('status','completed')->count() }}</h2>
                    <span class="stat-sub-text">Events done</span>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Avg Rating</p>
                    <h2 class="stat-num">{{ number_format((float)($catererProfile->reviews_avg_rating ?? 0), 1) }}</h2>
                    <span class="stat-sub-text">Customer satisfaction</span>
                </div>
            </div>

            {{-- ── Business Journey ── --}}
            <div class="section-card">
                <div class="section-card-body">
                    <h5 class="section-title"><i class="bi bi-diagram-3"></i> Your Business Journey</h5>
                    @php
                        $steps = [
                            ['num'=>1,'icon'=>'bi-card-list',       'title'=>'Add Menus',       'done'=>$menus->count()>0,                                'section'=>'menus'],
                            ['num'=>2,'icon'=>'bi-box-seam',        'title'=>'Create Packages', 'done'=>$packages->count()>0,                            'section'=>'packages'],
                            ['num'=>3,'icon'=>'bi-calendar-check',  'title'=>'Get Bookings',    'done'=>$bookings->count()>0,                            'section'=>null],
                            ['num'=>4,'icon'=>'bi-patch-check',     'title'=>'Complete Events', 'done'=>$bookings->where('status','completed')->count()>0,'section'=>null],
                            ['num'=>5,'icon'=>'bi-star',            'title'=>'Earn Reviews',    'done'=>$bookings->whereNotNull('review')->count()>0,     'section'=>null],
                        ];
                    @endphp
                    <div class="journey-wrap">
                        <div class="journey-line"></div>
                        @foreach($steps as $step)
                            <div class="journey-step">
                                <div class="journey-circle {{ $step['done'] ? 'done' : 'todo' }}">
                                    @if($step['done'])
                                        <i class="bi bi-check-lg" style="font-size:1.1rem;"></i>
                                    @else
                                        <i class="bi {{ $step['icon'] }}" style="font-size:1rem;"></i>
                                    @endif
                                </div>
                                <div class="journey-label {{ $step['done'] ? 'done' : '' }}">
                                    {{ $step['title'] }}
                                    @if(!$step['done'] && $step['section'])
                                        <a href="#menu-section" onclick="event.preventDefault();switchSection('{{ $step['section'] }}')" class="journey-start">Start →</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── My Bookings ── --}}
            <div id="bookings" class="section-card">
                <div class="section-card-body">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.1rem;flex-wrap:wrap;gap:8px;">
                        <div>
                            <h5 class="section-title"><i class="bi bi-calendar-check"></i> My Bookings</h5>
                        </div>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            @php
                                $pending   = $bookings->where('status','pending')->count();
                                $confirmed = $bookings->where('status','confirmed')->count();
                                $awaiting  = $bookings->where('status','awaiting_payment')->count();
                                $paid      = $bookings->where('status','paid')->count();
                                $completed = $bookings->where('status','completed')->count();
                            @endphp
                            @if($pending > 0)
                                <span class="status-pill s-pending">{{ $pending }} Pending</span>
                            @endif
                            @if($confirmed > 0)
                                <span class="status-pill s-confirmed">{{ $confirmed }} Confirmed</span>
                            @endif
                        </div>
                    </div>

                    <div class="booking-tabs" id="bookingTabs">
                        <button class="booking-tab-btn active" data-filter="all">All ({{ $bookings->count() }})</button>
                        <button class="booking-tab-btn" data-filter="pending">Pending ({{ $pending }})</button>
                        <button class="booking-tab-btn" data-filter="confirmed">Confirmed ({{ $confirmed }})</button>
                        @if($awaiting > 0)
                            <button class="booking-tab-btn" data-filter="awaiting_payment">Awaiting Payment ({{ $awaiting }})</button>
                        @endif
                        @if($paid > 0)
                            <button class="booking-tab-btn" data-filter="paid">Paid ({{ $paid }})</button>
                        @endif
                        <button class="booking-tab-btn" data-filter="completed">Completed ({{ $completed }})</button>
                    </div>

                    <div style="overflow-x:auto;">
                        <table class="dark-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Event Date</th>
                                    <th>Guests</th>
                                    <th style="text-align:center;">Rating</th>
                                    <th>Status</th>
                                    <th style="text-align:right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr class="booking-row" data-status="{{ $booking->status }}">
                                        <td>
                                            <div class="user-cell">
                                                <div class="row-avatar">{{ strtoupper(substr($booking->user->name ?? 'G', 0, 1)) }}</div>
                                                <div>
                                                    <p class="cell-name">{{ $booking->user->name ?? 'Guest' }}</p>
                                                    <p class="cell-sub">{{ Str::limit($booking->user->email ?? '', 22) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="cell-name">{{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}</p>
                                            <p class="cell-sub">{{ \Carbon\Carbon::parse($booking->event_date)->diffForHumans() }}</p>
                                        </td>
                                        <td>
                                            <p class="cell-name">{{ $booking->pax ?? '—' }}</p>
                                            <p class="cell-sub">pax</p>
                                        </td>
                                        <td style="text-align:center;">
                                            @php $rating = $booking->review?->rating ?? 0; @endphp
                                            @if($rating > 0)
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $rating ? '-fill' : '' }}" style="color:var(--orange);font-size:0.75rem;"></i>
                                                @endfor
                                            @else
                                                <span style="color:var(--text-sub);">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php $sc = $booking->status_color; @endphp
                                            <span style="display:inline-flex;align-items:center;gap:4px;padding:4px 11px;border-radius:999px;font-size:.67rem;font-weight:800;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:.4px;background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                                                <i class="bi bi-{{ $sc['icon'] }}" style="font-size:.67rem;"></i>
                                                {{ $booking->status_label }}
                                            </span>
                                        </td>
                                        <td style="text-align:right;">
                                            <div style="display:flex;gap:5px;justify-content:flex-end;flex-wrap:wrap;">
                                                @if($booking->payment_receipt_path)
                                                    <a href="{{ asset('storage/' . $booking->payment_receipt_path) }}" target="_blank" class="btn-receipt">
                                                        <i class="bi bi-eye"></i> Receipt
                                                    </a>
                                                @endif
                                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn-dark-sm">
                                                    <i class="bi bi-chat"></i> View
                                                </a>
                                                @if($booking->status === 'pending')
                                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn-orange-sm">
                                                        <i class="bi bi-hourglass-split"></i> Action
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center;padding:3rem;color:var(--text-sub);">
                                            <i class="bi bi-inbox" style="font-size:1.75rem;display:block;margin-bottom:8px;opacity:0.4;"></i>
                                            No bookings yet. Your inquiries will appear here!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div id="noFilterResults" class="d-none" style="text-align:center;padding:2rem;color:var(--text-sub);">
                        <i class="bi bi-funnel" style="font-size:1.3rem;display:block;margin-bottom:6px;"></i>
                        No bookings match this filter.
                    </div>
                </div>
            </div>

            {{-- ── Menu & Packages ── --}}
            <div id="menu-section" class="section-card">
                <div class="section-card-body">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:8px;">
                        <h5 class="section-title"><i class="bi bi-grid-1x2"></i> Menu & Package Management</h5>
                    </div>

                    <div class="section-tab-nav">
                        <button class="section-tab active" id="tab-menus" onclick="switchSection('menus')">
                            <i class="bi bi-card-list me-1"></i> Menus
                            <span style="background:var(--orange);color:white;font-size:0.6rem;padding:2px 7px;border-radius:999px;margin-left:4px;">{{ $menus->count() }}</span>
                        </button>
                        <button class="section-tab" id="tab-packages" onclick="switchSection('packages')">
                            <i class="bi bi-box-seam me-1"></i> Packages
                            <span style="background:#7c3aed;color:white;font-size:0.6rem;padding:2px 7px;border-radius:999px;margin-left:4px;">{{ $packages->count() }}</span>
                        </button>
                    </div>

                    {{-- Menus --}}
                    <div id="panel-menus">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;margin-bottom:1rem;">
                            <div>
                                <p style="font-weight:700;font-size:0.9rem;color:var(--text-primary);margin:0 0 2px;">{{ $catererProfile->business_name }} — Menu Items</p>
                                <p style="font-size:0.77rem;color:var(--text-muted);margin:0;">Add dishes, drinks, and food items customers can see.</p>
                            </div>
                            <a href="{{ route('caterer.menus.create') }}" class="btn-add-main"><i class="bi bi-plus-lg"></i> Add Menu Item</a>
                        </div>
                        @if($menus->count() > 0)
                            <div class="summary-bar">
                                <div class="summary-pill">Total: <strong>{{ $menus->count() }}</strong></div>
                                <div class="summary-pill">Available: <strong style="color:#34d399;">{{ $menus->where('is_available',true)->count() }}</strong></div>
                                <div class="summary-pill">Hidden: <strong style="color:#f87171;">{{ $menus->where('is_available',false)->count() }}</strong></div>
                            </div>
                            @php $categories = $menus->pluck('category')->filter()->unique()->values(); @endphp
                            @if($categories->count() > 0)
                                <div class="cat-filter">
                                    <button class="cat-btn active" data-cat="all">All</button>
                                    @foreach($categories as $cat)
                                        <button class="cat-btn" data-cat="{{ $cat }}">{{ $cat }}</button>
                                    @endforeach
                                </div>
                            @endif
                            <div class="menu-grid" id="menuGrid">
                                @foreach($menus as $menu)
                                    <div class="menu-card {{ !$menu->is_available ? 'unavailable' : '' }}" data-category="{{ $menu->category ?? '' }}">
                                        <div class="menu-card-category">{{ $menu->category ?: 'Uncategorized' }}</div>
                                        <div class="menu-card-name">{{ $menu->name }}</div>
                                        <div class="menu-card-desc">{{ $menu->description ?: '—' }}</div>
                                        <div class="menu-card-price">₱{{ number_format($menu->price, 2) }}</div>
                                        <div class="menu-card-footer">
                                            <span class="avail-pill {{ $menu->is_available ? 'available' : 'unavailable' }}">
                                                <i class="bi bi-circle-fill" style="font-size:0.35rem;"></i>
                                                {{ $menu->is_available ? 'Available' : 'Hidden' }}
                                            </span>
                                            <div style="display:flex;gap:6px;">
                                                <a href="{{ route('caterer.menus.edit', $menu->id) }}" class="btn-edit-sm"><i class="bi bi-pencil"></i> Edit</a>
                                                <form action="{{ route('caterer.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($menu->name) }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-del-sm"><i class="bi bi-trash3"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-card-list"></i>
                                <h4>No Menu Items Yet</h4>
                                <p>Start adding the dishes and drinks you offer.</p>
                                <a href="{{ route('caterer.menus.create') }}" class="btn-add-main"><i class="bi bi-plus-lg"></i> Add First Item</a>
                            </div>
                        @endif
                    </div>

                    {{-- Packages --}}
                    <div id="panel-packages" style="display:none;">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:10px;margin-bottom:1rem;">
                            <div>
                                <p style="font-weight:700;font-size:0.9rem;color:var(--text-primary);margin:0 0 2px;">{{ $catererProfile->business_name }} — Packages</p>
                                <p style="font-size:0.77rem;color:var(--text-muted);margin:0;">Create tiered packages with pricing per guest.</p>
                            </div>
                            <a href="{{ route('caterer.packages.create') }}" class="btn-add-main" style="background:#7c3aed;box-shadow:0 4px 12px rgba(124,58,237,0.25);">
                                <i class="bi bi-plus-lg"></i> Create Package
                            </a>
                        </div>
                        @if($packages->count() > 0)
                            <div class="summary-bar">
                                <div class="summary-pill">Total: <strong>{{ $packages->count() }}</strong></div>
                                <div class="summary-pill">Active: <strong style="color:#34d399;">{{ $packages->where('is_available',true)->count() }}</strong></div>
                                <div class="summary-pill">Price Range: <strong>₱{{ number_format($packages->min('price_per_guest'), 0) }} – ₱{{ number_format($packages->max('price_per_guest'), 0) }}/guest</strong></div>
                            </div>
                            <div class="packages-grid">
                                @foreach($packages as $pkg)
                                    <div class="pkg-card {{ !$pkg->is_available ? 'unavailable' : '' }}">
                                        <div class="pkg-card-header">
                                            <div class="pkg-card-name">{{ $pkg->name }}</div>
                                            <div class="pkg-card-price">₱{{ number_format($pkg->price_per_guest, 0) }}</div>
                                            <div class="pkg-card-price-unit">Per Guest</div>
                                            <div class="pkg-card-pax"><i class="bi bi-people-fill me-1"></i>{{ $pkg->min_guests }}{{ $pkg->max_guests ? ' – ' . $pkg->max_guests : '+' }} guests</div>
                                        </div>
                                        <div class="pkg-card-body">
                                            @if($pkg->description)<div class="pkg-card-desc">{{ $pkg->description }}</div>@endif
                                            @if($pkg->inclusions)
                                                <div class="pkg-inclusions-title">Inclusions</div>
                                                @foreach($pkg->inclusions_array as $item)
                                                    <div class="pkg-inclusion-item"><i class="bi bi-check-circle-fill"></i> {{ $item }}</div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="pkg-card-footer">
                                            <span class="avail-pill {{ $pkg->is_available ? 'available' : 'unavailable' }}">
                                                <i class="bi bi-circle-fill" style="font-size:0.35rem;"></i>
                                                {{ $pkg->is_available ? 'Active' : 'Hidden' }}
                                            </span>
                                            <div style="display:flex;gap:6px;">
                                                <a href="{{ route('caterer.packages.edit', $pkg->id) }}" class="btn-edit-sm"><i class="bi bi-pencil"></i> Edit</a>
                                                <form action="{{ route('caterer.packages.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($pkg->name) }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-del-sm"><i class="bi bi-trash3"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="bi bi-box-seam"></i>
                                <h4>No Packages Yet</h4>
                                <p>Create catering packages for customers to browse and choose from.</p>
                                <a href="{{ route('caterer.packages.create') }}" class="btn-add-main" style="background:#7c3aed;box-shadow:0 4px 12px rgba(124,58,237,0.25);">
                                    <i class="bi bi-plus-lg"></i> Create First Package
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Reviews ── --}}
            <div id="reviews" class="section-card">
                <div class="section-card-body">
                    <h5 class="section-title" style="margin-bottom:1.25rem;"><i class="bi bi-chat-left-quote"></i> Customer Feedback</h5>
                    <div class="row g-3">
                        @forelse($bookings->where('status','completed')->whereNotNull('review') as $bwr)
                            <div class="col-md-6">
                                <div class="review-card">
                                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                                        <div class="user-cell">
                                            <div class="row-avatar">{{ strtoupper(substr($bwr->user->name ?? 'G', 0, 1)) }}</div>
                                            <div>
                                                <p class="cell-name">{{ $bwr->user->name }}</p>
                                                <p class="cell-sub">{{ \Carbon\Carbon::parse($bwr->event_date)->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= (int)$bwr->review->rating ? '-fill' : '' }}" style="color:var(--orange);font-size:0.8rem;"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p style="font-style:italic;font-size:0.88rem;color:var(--text-primary);line-height:1.55;margin-bottom:12px;">"{{ $bwr->review->comment }}"</p>

                                    @if($bwr->review->caterer_reply)
                                        <div class="review-reply">
                                            <div class="reply-label"><i class="bi bi-reply-fill me-1"></i> Your Reply</div>
                                            <p class="reply-text">"{{ $bwr->review->caterer_reply }}"</p>
                                        </div>
                                    @else
                                        <button class="btn-dark-sm" style="margin-bottom:8px;"
                                                onclick="document.getElementById('rForm{{ $bwr->review->id }}').style.display = document.getElementById('rForm{{ $bwr->review->id }}').style.display === 'none' ? 'block' : 'none'">
                                            <i class="bi bi-reply-fill"></i> Reply
                                        </button>
                                        <form action="{{ route('reviews.reply', $bwr->review->id) }}" method="POST"
                                              id="rForm{{ $bwr->review->id }}" style="display:none;">
                                            @csrf
                                            <textarea name="caterer_reply" rows="3" class="textarea-dark" style="margin-bottom:8px;"
                                                      placeholder="Write a professional response..." required maxlength="1000"></textarea>
                                            <div style="display:flex;justify-content:space-between;align-items:center;">
                                                <small style="color:var(--text-sub);font-size:0.68rem;"><i class="bi bi-info-circle" style="color:var(--orange);"></i> Replies are permanent and public.</small>
                                                <div style="display:flex;gap:6px;">
                                                    <button type="button" class="btn-dark-sm" onclick="document.getElementById('rForm{{ $bwr->review->id }}').style.display='none'">Cancel</button>
                                                    <button type="submit" class="btn-add-main" style="padding:6px 14px;font-size:0.73rem;"><i class="bi bi-send-fill"></i> Publish</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="bi bi-chat-square-text"></i>
                                    <h4>No Reviews Yet</h4>
                                    <p>Complete bookings to start receiving customer feedback.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>{{-- end blur wrapper --}}
    </div>{{-- end dash-main --}}
</div>{{-- end dash-wrap --}}

{{-- Mobile Bottom Nav --}}
<nav class="mobile-bottom-nav d-lg-none">
    <div style="display:flex;justify-content:space-around;">
        <a href="{{ url('/dashboard') }}" style="flex:1;text-align:center;color:var(--orange);text-decoration:none;padding:4px 0;">
            <i class="bi bi-grid-fill" style="font-size:1.2rem;display:block;"></i>
            <small style="font-size:0.65rem;">Dashboard</small>
        </a>
        <a href="#bookings" style="flex:1;text-align:center;color:var(--text-muted);text-decoration:none;padding:4px 0;">
            <i class="bi bi-calendar-check" style="font-size:1.2rem;display:block;"></i>
            <small style="font-size:0.65rem;">Bookings</small>
        </a>
        <a href="#menu-section" onclick="event.preventDefault();switchSection('menus')" style="flex:1;text-align:center;color:var(--text-muted);text-decoration:none;padding:4px 0;">
            <i class="bi bi-card-list" style="font-size:1.2rem;display:block;"></i>
            <small style="font-size:0.65rem;">Menus</small>
        </a>
        <a href="#menu-section" onclick="event.preventDefault();switchSection('packages')" style="flex:1;text-align:center;color:var(--text-muted);text-decoration:none;padding:4px 0;">
            <i class="bi bi-box-seam" style="font-size:1.2rem;display:block;"></i>
            <small style="font-size:0.65rem;">Packages</small>
        </a>
        <a href="{{ route('caterer.edit') }}" style="flex:1;text-align:center;color:var(--text-muted);text-decoration:none;padding:4px 0;">
            <i class="bi bi-person-fill" style="font-size:1.2rem;display:block;"></i>
            <small style="font-size:0.65rem;">Profile</small>
        </a>
    </div>
</nav>

<script>
    document.querySelectorAll('.booking-tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.booking-tab-btn').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            var filter = this.getAttribute('data-filter');
            var rows = document.querySelectorAll('.booking-row');
            var count = 0;
            rows.forEach(function(row) {
                if (filter === 'all' || row.getAttribute('data-status') === filter) { row.style.display = ''; count++; }
                else { row.style.display = 'none'; }
            });
            var nr = document.getElementById('noFilterResults');
            if (nr) nr.classList.toggle('d-none', count > 0);
        });
    });

    function switchSection(section) {
        document.getElementById('panel-menus').style.display    = section === 'menus' ? '' : 'none';
        document.getElementById('panel-packages').style.display = section === 'packages' ? '' : 'none';
        document.getElementById('tab-menus').classList.toggle('active', section === 'menus');
        document.getElementById('tab-packages').classList.toggle('active', section === 'packages');
        var target = document.getElementById('menu-section');
        if (target) setTimeout(function() { target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 50);
    }

    function scrollTo(id) {
        var el = document.getElementById(id);
        if (el) setTimeout(function() { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 50);
    }

    document.querySelectorAll('.cat-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.cat-btn').forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');
            var cat = this.dataset.cat;
            document.querySelectorAll('.menu-card').forEach(function(card) {
                card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
            });
        });
    });

    function toggleNotifDropdown() {
    var d = document.getElementById('notifDropdown');
    d.style.display = d.style.display === 'none' ? 'block' : 'none';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    var dropdown = document.getElementById('notifDropdown');
    if (dropdown && !e.target.closest('#notifDropdown') && !e.target.closest('button[onclick="toggleNotifDropdown()"]')) {
        dropdown.style.display = 'none';
    }
});
</script>
@endsection