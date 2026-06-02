@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --orange:     #FF7A00;
        --orange-lt:  #ff9f2f;
        --charcoal:   #1a1a1a;
        --white:      #ffffff;
        --gray-50:    #f9f9f9;
        --gray-100:   #f2f2f2;
        --gray-300:   #d0d0d0;
        --gray-500:   #888;
        --green:      #27ae60;
        --blue:       #2196F3;
        --red:        #e74c3c;
        --purple:     #7c3aed;
        --radius-lg:  24px;
        --radius-md:  16px;
        --radius-sm:  10px;
        --shadow-sm:  0 2px 12px rgba(0,0,0,0.06);
        --shadow-md:  0 8px 32px rgba(0,0,0,0.10);
        --shadow-lg:  0 20px 60px rgba(0,0,0,0.13);
    }

    * { box-sizing: border-box; }
    body { background: var(--gray-50); font-family: 'Inter', sans-serif; color: var(--charcoal); }

    /* ── HERO ── */
    .hero-wrapper { position:relative; height:clamp(340px,55vw,520px); overflow:hidden; background:var(--charcoal); }
    .hero-wrapper img { width:100%;height:100%;object-fit:cover;opacity:.55;transition:transform 8s ease; }
    .hero-wrapper:hover img { transform:scale(1.04); }
    .hero-overlay { position:absolute;inset:0;background:linear-gradient(to bottom,transparent 30%,rgba(0,0,0,.85) 100%); }
    .hero-content { position:absolute;bottom:0;left:0;right:0;padding:clamp(1.5rem,4vw,3rem); }
    .hero-specialty { display:inline-flex;align-items:center;gap:6px;background:var(--orange);color:#fff;font-family:'Montserrat',sans-serif;font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;padding:6px 16px;border-radius:50px;margin-bottom:12px; }
    .hero-verified  { display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.25);color:#fff;font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;padding:5px 12px;border-radius:50px;margin-left:8px; }
    .hero-verified i { color:#4fc3f7; }
    .hero-title { font-family:'Montserrat',sans-serif;font-weight:900;font-size:clamp(1.8rem,5vw,3.2rem);text-transform:uppercase;letter-spacing:-1px;color:#fff;margin:0 0 8px;line-height:1.1; }
    .hero-location { color:rgba(255,255,255,.8);font-size:clamp(.85rem,1.5vw,1rem);font-weight:500; }
    .hero-location i { color:var(--orange); }

    /* ── BREADCRUMB ── */
    .breadcrumb-bar { background:var(--white);border-bottom:1px solid var(--gray-100);padding:14px 0; }
    .breadcrumb-bar .breadcrumb { margin:0;font-size:.82rem; }
    .breadcrumb-item a { color:var(--orange);font-weight:600;text-decoration:none; }
    .breadcrumb-item.active { font-weight:700;color:var(--charcoal); }

    /* ── LAYOUT ── */
    .detail-layout { display:grid;grid-template-columns:1fr 420px;gap:32px;align-items:start;padding:40px 0 80px; }
    @media(max-width:991px){.detail-layout{grid-template-columns:1fr;} .sticky-col{position:static!important;}}

    /* ── CARDS ── */
    .section-card { background:var(--white);border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);padding:clamp(1.5rem,4vw,2.5rem);margin-bottom:24px; }
    .section-card:last-child{margin-bottom:0;}
    .section-eyebrow { font-family:'Montserrat',sans-serif;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:2px;color:var(--orange);margin-bottom:6px; }
    .section-title   { font-family:'Montserrat',sans-serif;font-size:clamp(1.1rem,2.5vw,1.4rem);font-weight:900;text-transform:uppercase;letter-spacing:-.5px;margin-bottom:16px;color:var(--charcoal); }

    /* ── STATS ── */
    .stats-row { display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px; }
    @media(max-width:575px){.stats-row{grid-template-columns:1fr 1fr;}}
    .stat-pill { background:var(--gray-50);border:2px solid var(--gray-100);border-radius:var(--radius-md);padding:18px 14px;text-align:center;transition:all .3s; }
    .stat-pill:hover{border-color:var(--orange);transform:translateY(-3px);box-shadow:var(--shadow-sm);}
    .stat-pill-value { font-family:'Montserrat',sans-serif;font-size:clamp(1.1rem,2.5vw,1.4rem);font-weight:900;color:var(--orange);display:block;line-height:1.1; }
    .stat-pill-label { font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-500);margin-top:4px;display:block; }

    /* ── INCLUSIONS ── */
    .inclusion-list { list-style:none;padding:0;margin:0; }
    .inclusion-list li { display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--gray-100);font-size:.92rem;font-weight:500; }
    .inclusion-list li:last-child{border-bottom:none;}
    .inclusion-check { width:22px;height:22px;border-radius:50%;background:var(--green);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:white;font-size:.7rem; }

    /* ── TRUST BADGES ── */
    .trust-badge { display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:var(--radius-sm);background:var(--gray-50);border-left:4px solid;font-size:.85rem;font-weight:600;margin-bottom:10px; }
    .trust-badge:last-child{margin-bottom:0;}
    .trust-badge.green{border-color:var(--green);} .trust-badge.blue{border-color:var(--blue);} .trust-badge.orange{border-color:var(--orange);}
    .trust-badge i{font-size:1.2rem;}
    .trust-badge.green i{color:var(--green);} .trust-badge.blue i{color:var(--blue);} .trust-badge.orange i{color:var(--orange);}

    /* ══════════════════════════════════════════════════
       MENU & PACKAGE SELECTOR (Interactive)
    ══════════════════════════════════════════════════ */
    .mp-tab-nav { display:flex;gap:4px;border-bottom:2px solid var(--gray-100);margin-bottom:22px; }
    .mp-tab {
        border:none;background:transparent;padding:10px 18px;
        font-family:'Montserrat',sans-serif;font-size:.72rem;font-weight:800;
        text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;
        cursor:pointer;border-bottom:3px solid transparent;margin-bottom:-2px;transition:all .2s;
    }
    .mp-tab:hover{color:var(--charcoal);}
    .mp-tab.active{color:var(--orange);border-bottom-color:var(--orange);}

    /* ── PACKAGE SELECTOR ── */
    .pkg-selector-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px; }
    .pkg-sel-card {
        border:2.5px solid var(--gray-100);border-radius:var(--radius-md);overflow:hidden;
        transition:all .25s;cursor:pointer;position:relative;
    }
    .pkg-sel-card:hover { border-color:var(--orange);transform:translateY(-3px);box-shadow:0 10px 28px rgba(255,122,0,.12); }
    .pkg-sel-card.selected {
        border-color:var(--orange);
        box-shadow:0 0 0 3px rgba(255,122,0,.25), 0 12px 32px rgba(255,122,0,.18);
        transform:translateY(-3px);
    }
    .pkg-sel-check {
        position:absolute;top:10px;right:10px;width:26px;height:26px;
        border-radius:50%;background:var(--orange);color:#fff;
        display:none;align-items:center;justify-content:center;
        font-size:.75rem;font-weight:900;z-index:2;
        box-shadow:0 3px 10px rgba(255,122,0,.4);
    }
    .pkg-sel-card.selected .pkg-sel-check { display:flex; }
    .pkg-sel-header {
        background:linear-gradient(135deg,var(--charcoal),#2d2d2d);
        padding:16px 18px;position:relative;overflow:hidden;
    }
    .pkg-sel-card.selected .pkg-sel-header { background:linear-gradient(135deg,#2d1a00,#3d2200); }
    .pkg-sel-header::before{content:'';position:absolute;top:-20px;right:-20px;width:70px;height:70px;border-radius:50%;background:rgba(255,122,0,.15);}
    .pkg-sel-name  { font-family:'Montserrat',sans-serif;font-weight:900;font-size:.85rem;color:#fff;text-transform:uppercase;letter-spacing:-.3px;margin-bottom:4px;position:relative;z-index:1; }
    .pkg-sel-price { font-family:'Montserrat',sans-serif;font-weight:900;font-size:1.4rem;color:var(--orange);line-height:1;position:relative;z-index:1; }
    .pkg-sel-unit  { font-size:.58rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);position:relative;z-index:1; }
    .pkg-sel-pax   { font-size:.68rem;color:rgba(255,255,255,.55);font-weight:600;margin-top:5px;position:relative;z-index:1; }
    .pkg-sel-body  { padding:14px 18px; }
    .pkg-sel-desc  { font-size:.78rem;color:var(--gray-500);line-height:1.5;margin-bottom:10px; }
    .pkg-inc-title { font-family:'Montserrat',sans-serif;font-size:.58rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:var(--orange);margin-bottom:7px; }
    .pkg-inc-item  { display:flex;align-items:center;gap:7px;font-size:.75rem;color:var(--charcoal);margin-bottom:4px; }
    .pkg-inc-item i{ color:var(--green);font-size:.78rem;flex-shrink:0; }
    .pkg-sel-btn {
        display:block;width:calc(100% - 36px);margin:10px 18px 14px;
        padding:9px 0;border-radius:8px;border:2px solid var(--orange);
        background:transparent;color:var(--orange);
        font-family:'Montserrat',sans-serif;font-size:.7rem;font-weight:800;
        text-transform:uppercase;letter-spacing:.8px;cursor:pointer;
        transition:all .2s;
    }
    .pkg-sel-btn:hover, .pkg-sel-card.selected .pkg-sel-btn {
        background:var(--orange);color:#fff;
    }
    .pkg-sel-card.selected .pkg-sel-btn { pointer-events:none; }

    /* ── MENU ITEM SELECTOR (add-ons) ── */
    .menu-selector-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(210px,1fr));gap:14px; }
    .menu-sel-card {
        border:2px solid var(--gray-100);border-radius:var(--radius-md);padding:14px 16px;
        transition:all .25s;cursor:pointer;position:relative;
    }
    .menu-sel-card:hover { border-color:var(--orange);transform:translateY(-2px);box-shadow:0 8px 20px rgba(255,122,0,.1); }
    .menu-sel-card.selected {
        border-color:var(--orange);background:rgba(255,122,0,.04);
        box-shadow:0 0 0 2px rgba(255,122,0,.2);
        transform:translateY(-2px);
    }
    .menu-sel-badge {
        position:absolute;top:8px;right:8px;width:22px;height:22px;
        border-radius:50%;background:var(--orange);color:#fff;
        display:none;align-items:center;justify-content:center;font-size:.6rem;font-weight:900;
    }
    .menu-sel-card.selected .menu-sel-badge { display:flex; }
    .menu-sel-cat   { font-size:.58rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:var(--orange);margin-bottom:4px; }
    .menu-sel-name  { font-family:'Montserrat',sans-serif;font-weight:900;font-size:.85rem;color:var(--charcoal);margin-bottom:4px;text-transform:uppercase;letter-spacing:-.3px; }
    .menu-sel-desc  { font-size:.74rem;color:var(--gray-500);line-height:1.45;margin-bottom:10px;min-height:26px; }
    .menu-sel-footer{ display:flex;align-items:center;justify-content:space-between; }
    .menu-sel-price { font-family:'Montserrat',sans-serif;font-weight:900;font-size:1rem;color:var(--orange); }
    .menu-sel-addtag{
        font-size:.6rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;
        padding:3px 9px;border-radius:20px;
        background:var(--gray-100);color:var(--gray-500);
        transition:all .2s;
    }
    .menu-sel-card.selected .menu-sel-addtag { background:rgba(255,122,0,.12);color:var(--orange); }
    /* ── MENU ITEM QTY STEPPER ── */
.menu-qty-controls {
    display:none;
    align-items:center;
    gap:6px;
    margin-top:8px;
}
.menu-sel-card.selected .menu-qty-controls { display:flex; }
.menu-sel-card.selected .menu-sel-addtag { display:none; }
.qty-btn {
    width:24px;height:24px;border-radius:50%;
    border:1.5px solid var(--orange);
    background:transparent;color:var(--orange);
    font-size:.85rem;font-weight:900;
    cursor:pointer;display:flex;align-items:center;justify-content:center;
    transition:all .2s;line-height:1;padding:0;
}
.qty-btn:hover { background:var(--orange);color:#fff; }
.qty-display {
    font-family:'Montserrat',sans-serif;font-weight:900;font-size:.82rem;
    color:var(--charcoal);min-width:20px;text-align:center;
}
.menu-sel-price-unit {
    font-size:.62rem;color:var(--gray-500);font-weight:600;
    margin-left:2px;
}

    /* Category filter pills */
    .cat-filter { display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px; }
    .cat-pill { padding:5px 14px;border:2px solid var(--gray-300);border-radius:50px;background:#fff;color:var(--gray-500);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;cursor:pointer;transition:all .2s; }
    .cat-pill:hover,.cat-pill.active { border-color:var(--orange);background:var(--orange);color:#fff; }

    /* ── LIVE ORDER SUMMARY PANEL ── */
    .order-summary-panel {
        background:linear-gradient(135deg, #1a1a1a, #2a1500);
        border-radius:var(--radius-md);
        padding:20px 22px;
        margin-top:22px;
        border:2px solid rgba(255,122,0,.3);
        display:none;
    }
    .order-summary-panel.show { display:block;animation:fadeStepIn .3s ease-out; }
    .osp-title {
        font-family:'Montserrat',sans-serif;font-size:.65rem;font-weight:800;
        text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,.45);
        margin-bottom:14px;display:flex;align-items:center;gap:6px;
    }
    .osp-title i { color:var(--orange); }
    .osp-pkg-row {
        display:flex;justify-content:space-between;align-items:center;
        padding:10px 12px;border-radius:8px;
        background:rgba(255,122,0,.1);border:1px solid rgba(255,122,0,.25);
        margin-bottom:10px;
    }
    .osp-pkg-name { font-family:'Montserrat',sans-serif;font-size:.8rem;font-weight:900;color:#fff;text-transform:uppercase; }
    .osp-pkg-calc { font-size:.72rem;color:rgba(255,255,255,.5);margin-top:2px; }
    .osp-pkg-amount { font-family:'Montserrat',sans-serif;font-size:1rem;font-weight:900;color:var(--orange); }

    .osp-addons-title {
        font-family:'Montserrat',sans-serif;font-size:.58rem;font-weight:800;
        text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,.35);
        margin:12px 0 8px;
    }
    .osp-addon-row {
        display:flex;justify-content:space-between;align-items:center;
        padding:6px 0;border-bottom:1px solid rgba(255,255,255,.06);font-size:.78rem;
    }
    .osp-addon-row:last-child{border-bottom:none;}
    .osp-addon-name { color:rgba(255,255,255,.7);font-weight:500; }
    .osp-addon-price { font-weight:700;color:rgba(255,255,255,.85); }

    .osp-divider { border:none;border-top:1px solid rgba(255,255,255,.1);margin:14px 0; }
    .osp-total-row {
        display:flex;justify-content:space-between;align-items:center;
    }
    .osp-total-label {
        font-family:'Montserrat',sans-serif;font-size:.7rem;font-weight:800;
        text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.55);
    }
    .osp-total-amount {
        font-family:'Montserrat',sans-serif;font-size:1.5rem;font-weight:900;color:var(--orange);
    }
    .osp-per-guest {
        font-size:.65rem;color:rgba(255,255,255,.3);text-align:right;margin-top:2px;
    }
    .osp-dp-row {
        display:flex;justify-content:space-between;align-items:center;
        margin-top:10px;padding:10px 12px;border-radius:8px;
        background:rgba(39,174,96,.1);border:1px solid rgba(39,174,96,.25);
    }
    .osp-dp-label { font-size:.7rem;font-weight:700;color:rgba(255,255,255,.55); }
    .osp-dp-amount { font-family:'Montserrat',sans-serif;font-size:.95rem;font-weight:900;color:#4ade80; }

    /* Guest count inside summary panel */
    .osp-pax-row {
        display:flex;align-items:center;gap:10px;margin-bottom:14px;
    }
    .osp-pax-label { font-size:.7rem;font-weight:700;color:rgba(255,255,255,.45);text-transform:uppercase;letter-spacing:.5px; }
    .osp-pax-input {
        width:90px;background:rgba(255,255,255,.08);border:1.5px solid rgba(255,255,255,.15);
        border-radius:8px;padding:7px 10px;font-size:.88rem;font-weight:700;
        font-family:'Montserrat',sans-serif;color:#fff;
        transition:border-color .2s;
    }
    .osp-pax-input:focus{outline:none;border-color:var(--orange);}
    .osp-pax-input::placeholder{color:rgba(255,255,255,.25);}

    /* No package selected hint */
    .mp-empty { text-align:center;padding:36px 20px;color:var(--gray-500); }
    .mp-empty i { font-size:2.2rem;opacity:.25;display:block;margin-bottom:10px; }
    .mp-empty p { font-size:.85rem;font-weight:600; }

    /* ── REVIEWS ── */
    .review-card { border:2px solid var(--gray-100);border-radius:var(--radius-md);padding:20px;margin-bottom:14px;transition:border-color .3s; }
    .review-card:hover{border-color:rgba(255,122,0,.3);}
    .review-card:last-child{margin-bottom:0;}
    .review-stars i{color:var(--orange);font-size:.8rem;}
    .review-author { font-family:'Montserrat',sans-serif;font-weight:800;font-size:.8rem;text-transform:uppercase;letter-spacing:.5px; }
    .review-date   { font-size:.72rem;color:var(--gray-500); }
    .review-text   { font-size:.88rem;color:#444;line-height:1.55;margin-top:10px;font-style:italic; }
    .no-reviews    { text-align:center;padding:40px 20px;color:var(--gray-500); }
    .no-reviews i  { font-size:2.5rem;opacity:.3;display:block;margin-bottom:10px; }

    /* ── HOW TO BOOK ── */
    .how-to-book { margin-bottom: 24px; }
    .htb-header { background:var(--charcoal);border-radius:var(--radius-lg) var(--radius-lg) 0 0;padding:22px 28px 18px;position:relative;overflow:hidden; }
    .htb-header::before { content:'';position:absolute;top:-30px;right:-30px;width:100px;height:100px;border-radius:50%;background:rgba(255,122,0,.12); }
    .htb-eyebrow { font-family:'Montserrat',sans-serif;font-size:.6rem;font-weight:800;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,.45);margin-bottom:4px; }
    .htb-title { font-family:'Montserrat',sans-serif;font-size:1.05rem;font-weight:900;text-transform:uppercase;letter-spacing:-.3px;color:#fff; }
    .htb-steps { background:var(--white);border-radius:0 0 var(--radius-lg) var(--radius-lg);box-shadow:var(--shadow-sm);overflow:hidden; }
    .htb-step { display:flex;align-items:flex-start;gap:16px;padding:18px 24px;border-bottom:1px solid var(--gray-100);transition:background .2s; }
    .htb-step:last-child{border-bottom:none;}
    .htb-step:hover{background:#fff8f2;}
    .htb-step-num { width:36px;height:36px;border-radius:50%;flex-shrink:0;background:linear-gradient(135deg,var(--orange),var(--orange-lt));display:flex;align-items:center;justify-content:center;font-family:'Montserrat',sans-serif;font-size:.75rem;font-weight:900;color:white;box-shadow:0 4px 12px rgba(255,122,0,.25);margin-top:2px; }
    .htb-step-title { font-family:'Montserrat',sans-serif;font-size:.82rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;color:var(--charcoal);margin-bottom:3px; }
    .htb-step-desc { font-size:.78rem;color:var(--gray-500);line-height:1.5;font-weight:500; }
    .htb-step-tag { font-size:.63rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;padding:3px 10px;border-radius:20px;margin-top:6px;display:inline-block; }
    .htb-step-tag.orange{background:rgba(255,122,0,.1);color:var(--orange);}
    .htb-step-tag.green{background:rgba(39,174,96,.1);color:var(--green);}
    .htb-step-tag.blue{background:rgba(33,150,243,.1);color:var(--blue);}
    .htb-step-tag.gray{background:var(--gray-100);color:var(--gray-500);}

    /* ══════════════════════════════════════════════════
       BOOKING CARD — REDESIGNED RIGHT COLUMN
    ══════════════════════════════════════════════════ */
    .booking-card {
        background:var(--white);
        border-radius:var(--radius-lg);
        box-shadow:var(--shadow-lg);
        overflow:hidden;
        position:sticky;
        top:24px;
    }

    /* Header */
    .booking-card-header {
        background:var(--charcoal);
        padding:28px 28px 24px;
        position:relative;
        overflow:hidden;
    }
    .booking-card-header::before{content:'';position:absolute;top:-40px;right:-40px;width:120px;height:120px;border-radius:50%;background:rgba(255,122,0,.15);}
    .booking-card-header::after{content:'';position:absolute;bottom:-30px;left:-30px;width:90px;height:90px;border-radius:50%;background:rgba(255,122,0,.08);}
    .booking-card-label {
        font-family:'Montserrat',sans-serif;
        font-size:.6rem;font-weight:800;
        text-transform:uppercase;letter-spacing:2px;
        color:rgba(255,255,255,.45);
        margin-bottom:4px;
    }
    .booking-card-title {
        font-family:'Montserrat',sans-serif;
        font-size:1.1rem;font-weight:900;
        text-transform:uppercase;letter-spacing:-.3px;
        color:#fff;
        margin-bottom:14px;
    }
    .price-range-display { display:flex;align-items:baseline;gap:6px;flex-wrap:wrap; }
    .price-min { font-family:'Montserrat',sans-serif;font-size:clamp(1.5rem,4vw,1.9rem);font-weight:900;color:#fff;line-height:1; }
    .price-sep { font-size:.9rem;font-weight:600;color:rgba(255,255,255,.35); }
    .price-max { font-family:'Montserrat',sans-serif;font-size:clamp(1.5rem,4vw,1.9rem);font-weight:900;color:var(--orange);line-height:1; }
    .price-unit { font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.4);display:block;margin-top:5px; }
    .rating-summary {
        display:flex;align-items:center;gap:10px;
        margin-top:16px;padding:10px 13px;
        background:rgba(255,255,255,.07);
        border-radius:var(--radius-sm);
    }
    .rating-score  { font-family:'Montserrat',sans-serif;font-size:1.5rem;font-weight:900;color:#fff; }
    .rating-stars i { color:#ffc107;font-size:.75rem; }
    .rating-count  { font-size:.7rem;color:rgba(255,255,255,.45);margin-top:2px; }

    /* Selection bar */
    .booking-selection-bar {
        background:rgba(255,122,0,.07);
        border-bottom:1px solid rgba(255,122,0,.15);
        padding:12px 24px;
        font-size:.78rem;
        display:none;
    }
    .booking-selection-bar.show {
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:6px;
    }
    .bsb-label {
        color:var(--gray-500);
        font-weight:600;
        font-size:.7rem;
        text-transform:uppercase;
        letter-spacing:.5px;
        margin-bottom:2px;
    }
    .bsb-value {
        font-family:'Montserrat',sans-serif;
        font-weight:900;
        color:var(--orange);
        font-size:.9rem;
    }

    /* Step tabs */
    .form-steps-bar {
        display:flex;
        padding:0 24px;
        border-bottom:1px solid var(--gray-100);
        background:var(--gray-50);
    }
    .form-step-tab {
        flex:1;
        padding:14px 6px 12px;
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:5px;
        cursor:pointer;
        border-bottom:3px solid transparent;
        transition:all .2s;
    }
    .form-step-tab.active { border-bottom-color:var(--orange); }
    .form-step-tab.done   { border-bottom-color:var(--green); }
    .form-step-tab-num {
        width:26px;height:26px;
        border-radius:50%;
        display:flex;align-items:center;justify-content:center;
        font-family:'Montserrat',sans-serif;
        font-size:.65rem;font-weight:900;
        background:var(--gray-300);color:white;
        transition:all .2s;
    }
    .form-step-tab.active .form-step-tab-num { background:var(--orange); }
    .form-step-tab.done   .form-step-tab-num { background:var(--green); }
    .form-step-tab-label {
        font-family:'Montserrat',sans-serif;
        font-size:.55rem;font-weight:800;
        text-transform:uppercase;letter-spacing:.8px;
        color:var(--gray-500);
        transition:color .2s;
    }
    .form-step-tab.active .form-step-tab-label { color:var(--orange); }
    .form-step-tab.done   .form-step-tab-label { color:var(--green); }

    /* Form body */
    .booking-form-body { padding:24px 28px 28px; }

    /* Unified field spacing — replaces all mb-3 inside the form */
    .form-group { margin-bottom:16px; }
    .form-group:last-of-type { margin-bottom:0; }

    .form-step-panel{display:none;}
    .form-step-panel.active{display:block;animation:fadeStepIn .25s ease-out;}
    @keyframes fadeStepIn{from{opacity:0;transform:translateY(6px);}to{opacity:1;transform:translateY(0);}}

    .form-field-label {
        font-family:'Montserrat',sans-serif;
        font-size:.62rem;font-weight:800;
        text-transform:uppercase;letter-spacing:1.2px;
        color:var(--charcoal);
        margin-bottom:8px;
        display:block;
    }
    .form-field-label .req { color:var(--red); }

    .form-field {
        width:100%;
        background:var(--gray-100);
        border:2px solid transparent;
        border-radius:var(--radius-sm);
        padding:11px 14px;
        font-size:.9rem;font-weight:500;
        transition:all .3s;
        font-family:'Inter',sans-serif;
        color:var(--charcoal);
        appearance:none;-webkit-appearance:none;
    }
    .form-field::placeholder{color:#bbb;}
    .form-field:focus{outline:none;background:#fff;border-color:var(--orange);box-shadow:0 4px 14px rgba(255,122,0,.12);}
    .form-field.is-invalid{border-color:var(--red);}
    .form-field.is-valid{border-color:var(--green);}
    select.form-field{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23888' d='M6 8L1 3h10z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;padding-right:36px;}
    textarea.form-field{resize:vertical;min-height:90px;}

    /* Two-column row */
    .form-row-2 {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:14px;
        margin-bottom:16px;
    }
    @media(max-width:480px){.form-row-2{grid-template-columns:1fr;}}

    /* Availability boxes */
    .avail-box{display:none;margin-top:8px;padding:9px 13px;border-radius:var(--radius-sm);font-size:.78rem;font-weight:700;align-items:center;gap:8px;}
    .avail-box.show{display:flex;}
    .avail-box.checking{background:rgba(0,0,0,.06);color:var(--gray-500);}
    .avail-box.available{background:rgba(39,174,96,.1);color:var(--green);border:1px solid rgba(39,174,96,.25);}
    .avail-box.unavailable{background:rgba(220,53,69,.1);color:#dc3545;border:1px solid rgba(220,53,69,.25);}

    /* Package hint strip inside form */
    .form-pkg-hint {
        display:none;
        align-items:center;
        justify-content:space-between;
        margin-bottom:16px;
        padding:10px 14px;
        background:rgba(255,122,0,.07);
        border-left:3px solid var(--orange);
        border-radius:0 8px 8px 0;
        font-size:.8rem;
    }
    .form-pkg-hint.show { display:flex; }
    .form-pkg-hint-icon { color:var(--orange); margin-right:5px; }
    .form-pkg-hint-total {
        font-family:'Montserrat',sans-serif;
        font-weight:900;
        color:var(--orange);
        font-size:.85rem;
        white-space:nowrap;
    }

    /* Downpayment inline strip */
    .form-dp-strip {
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:10px 14px;
        border-radius:8px;
        background:rgba(39,174,96,.08);
        border:1px solid rgba(39,174,96,.2);
        margin-bottom:16px;
    }
    .form-dp-label { font-size:.7rem;font-weight:700;color:var(--gray-500); }
    .form-dp-amount {
        font-family:'Montserrat',sans-serif;
        font-size:.92rem;font-weight:900;
        color:var(--green);
    }

    /* Booking summary (step 3) */
    .booking-summary{background:var(--gray-50);border-radius:var(--radius-sm);border:1px solid var(--gray-100);padding:16px 18px;margin-bottom:18px;}
    .summary-title{font-family:'Montserrat',sans-serif;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:var(--orange);margin-bottom:12px;display:flex;align-items:center;gap:6px;}
    .summary-row{display:flex;justify-content:space-between;align-items:flex-start;padding:7px 0;border-bottom:1px solid var(--gray-100);font-size:.82rem;}
    .summary-row:last-child{border-bottom:none;}
    .summary-label{color:var(--gray-500);font-weight:500;}
    .summary-value{font-weight:700;color:var(--charcoal);text-align:right;max-width:60%;}
    .summary-total .summary-label{font-weight:800;color:var(--charcoal);font-size:.85rem;}
    .summary-total .summary-value{color:var(--orange);font-size:1rem;font-family:'Montserrat',sans-serif;}

    /* Nav buttons */
    .form-nav{display:flex;gap:10px;margin-top:20px;}
    .btn-prev{
        flex:0 0 auto;
        background:var(--gray-100);border:none;
        border-radius:var(--radius-sm);
        padding:13px 16px;
        font-family:'Montserrat',sans-serif;font-size:.75rem;font-weight:800;
        text-transform:uppercase;letter-spacing:.8px;
        color:var(--charcoal);cursor:pointer;transition:all .2s;
    }
    .btn-prev:hover{background:var(--gray-300);}
    .btn-next,.btn-book{
        flex:1;
        background:var(--orange);color:#fff;border:none;
        border-radius:var(--radius-sm);padding:14px;
        font-family:'Montserrat',sans-serif;font-size:.82rem;font-weight:900;
        text-transform:uppercase;letter-spacing:1px;
        cursor:pointer;transition:all .3s;
        box-shadow:0 6px 20px rgba(255,122,0,.28);
        display:flex;align-items:center;justify-content:center;gap:8px;
    }
    .btn-next:hover,.btn-book:hover:not(:disabled){background:var(--charcoal);transform:translateY(-2px);box-shadow:0 10px 28px rgba(0,0,0,.2);}
    .btn-book:disabled{background:var(--gray-300);cursor:not-allowed;box-shadow:none;transform:none;}

    /* Login CTA */
    .btn-login-book{
        width:100%;background:var(--charcoal);color:#fff;border:none;
        border-radius:var(--radius-sm);padding:15px;
        font-family:'Montserrat',sans-serif;font-size:.85rem;font-weight:900;
        text-transform:uppercase;letter-spacing:1.2px;
        text-decoration:none;display:block;text-align:center;
        transition:all .3s;margin-top:4px;
    }
    .btn-login-book:hover{background:var(--orange);color:#fff;transform:translateY(-2px);}

    /* Admin preview */
    .admin-preview-box{margin-top:4px;padding:20px 16px;border-radius:var(--radius-sm);background:var(--gray-100);border:2px dashed var(--gray-300);text-align:center;color:var(--gray-500);font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;}
    .admin-preview-box i{font-size:1.4rem;display:block;margin-bottom:6px;}

    /* Security note */
    .security-note{
        margin-top:18px;padding-top:16px;
        border-top:1px solid var(--gray-100);
        text-align:center;font-size:.72rem;color:var(--gray-500);
        display:flex;align-items:center;justify-content:center;gap:5px;
    }
    .security-note i { color:var(--orange); }

    /* Alert */
    .alert-success-custom{background:rgba(39,174,96,.1);border:1px solid rgba(39,174,96,.3);border-radius:var(--radius-md);padding:16px 20px;margin-bottom:24px;color:var(--green);font-weight:600;font-size:.9rem;display:flex;align-items:center;gap:10px;}
    .btn-admin-return{background:var(--charcoal);color:#fff;border:none;border-radius:50px;padding:8px 20px;font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .3s;}
    .btn-admin-return:hover{background:var(--orange);color:#fff;}

    /* Scroll hint */
    .scroll-hint {
        display:inline-flex;align-items:center;gap:6px;
        font-size:.7rem;font-weight:700;color:var(--orange);
        background:rgba(255,122,0,.08);border:1px solid rgba(255,122,0,.2);
        border-radius:20px;padding:4px 12px;margin-top:10px;cursor:pointer;
        text-decoration:none;transition:all .2s;
    }
    .scroll-hint:hover{background:var(--orange);color:#fff;}

    /* Guest login note */
    .guest-login-note {
        text-align:center;
        padding:20px 28px 0;
        font-size:.82rem;
        color:var(--gray-500);
        font-weight:500;
    }
</style>

{{-- HERO --}}
<div class="hero-wrapper">
    <img src="{{ $caterer->profile_picture ? asset('storage/' . $caterer->profile_picture) : asset('images/placeholder-caterer.jpg') }}"
         alt="{{ $caterer->business_name }}">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div>
            <span class="hero-specialty"><i class="bi bi-egg-fried"></i> {{ $caterer->specialty }}</span>
            @if($caterer->status === 'verified')
                <span class="hero-verified"><i class="bi bi-patch-check-fill"></i> Verified</span>
            @endif
        </div>
        <h1 class="hero-title">{{ $caterer->business_name }}</h1>
        <p class="hero-location"><i class="bi bi-geo-alt-fill"></i> {{ $caterer->location }}, Cebu</p>
    </div>
</div>

{{-- BREADCRUMB --}}
<div class="breadcrumb-bar">
    <div class="container d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Marketplace</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/caterers') }}">All Caterers</a></li>
                <li class="breadcrumb-item active fw-bold">{{ $caterer->business_name }}</li>
            </ol>
        </nav>
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('dashboard') }}" class="btn-admin-return">
                <i class="bi bi-speedometer2"></i> Admin Dashboard
            </a>
        @endif
    </div>
</div>

<div class="container">

    @if(session('success'))
        <div class="alert-success-custom mt-4">
            <i class="bi bi-check-circle-fill fs-5"></i> {{ session('success') }}
        </div>
    @endif

    <div class="detail-layout">

        {{-- ════════════════════ LEFT COLUMN ════════════════════ --}}
        <div>

            {{-- Quick Stats --}}
            <div class="section-card">
                <div class="stats-row">
                    <div class="stat-pill">
                        <span class="stat-pill-value">₱{{ number_format($caterer->min_budget, 0) }}</span>
                        <span class="stat-pill-label">Min / Guest</span>
                    </div>
                    <div class="stat-pill">
                        <span class="stat-pill-value">₱{{ number_format($caterer->max_budget, 0) }}</span>
                        <span class="stat-pill-label">Max / Guest</span>
                    </div>
                    <div class="stat-pill">
                        @php $avgRating = $caterer->reviews->avg('rating'); @endphp
                        <span class="stat-pill-value">{{ $caterer->reviews->count() > 0 ? number_format($avgRating, 1) : '—' }}</span>
                        <span class="stat-pill-label">Avg Rating</span>
                    </div>
                </div>
                <p class="section-eyebrow">About</p>
                <h2 class="section-title">Our Culinary Story</h2>
                <p style="color:#555;line-height:1.7;font-size:.95rem;">
                    Welcome to <strong>{{ $caterer->business_name }}</strong>. Located in the heart of
                    <strong>{{ $caterer->location }}</strong>, we pride ourselves on our
                    <strong>{{ $caterer->specialty }}</strong> expertise, creating unforgettable dining
                    experiences for Cebuano celebrations of every kind.
                </p>
            </div>

            {{-- Inclusions + Trust --}}
            <div class="section-card">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="section-eyebrow">What's Included</p>
<h3 class="section-title">Service Inclusions</h3>

@php
    $allInclusions = $caterer->packages
        ->flatMap(fn($pkg) => $pkg->inclusions_array ?? [])
        ->filter()
        ->unique()
        ->values();
@endphp

@if($allInclusions->count() > 0)
    <ul class="inclusion-list">
        @foreach($allInclusions as $item)
            <li>
                <span class="inclusion-check"><i class="bi bi-check-lg"></i></span>
                {{ $item }}
            </li>
        @endforeach
    </ul>
@else
    <p style="font-size:.85rem;color:var(--gray-500);font-style:italic;">
        No inclusions listed yet.
    </p>
@endif
                    </div>
                    <div class="col-md-6">
                        <p class="section-eyebrow">Compliance</p>
                        <h3 class="section-title">Trust & Safety</h3>
                        <div class="trust-badge green"><i class="bi bi-patch-check-fill"></i><div><div style="font-size:.82rem;font-weight:700;">Sanitary Permit Verified</div><div style="font-size:.7rem;color:var(--gray-500);font-weight:500;">Local Health Office Approved</div></div></div>
                        <div class="trust-badge blue"><i class="bi bi-building-check"></i><div><div style="font-size:.82rem;font-weight:700;">DTI Registered Business</div><div style="font-size:.7rem;color:var(--gray-500);font-weight:500;">Government Accredited</div></div></div>
                        <div class="trust-badge orange"><i class="bi bi-shield-check"></i><div><div style="font-size:.82rem;font-weight:700;">CaterConnect Verified</div><div style="font-size:.7rem;color:var(--gray-500);font-weight:500;">Documents Reviewed by Admin</div></div></div>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════
                 INTERACTIVE MENU & PACKAGE SELECTOR
            ═══════════════════════════════════════════════════════ --}}
            <div class="section-card" id="menuPackageSection">
                <p class="section-eyebrow">Build Your Order</p>
                <h3 class="section-title" style="margin-bottom:4px;">
                    Menus & Packages
                    <span style="font-size:.72rem;color:var(--gray-500);font-weight:600;text-transform:none;letter-spacing:0;">
                        — pick a package, add menu items, get your estimate
                    </span>
                </h3>

                {{-- Tab Nav --}}
                <div class="mp-tab-nav">
                    <button class="mp-tab active" id="mpTab-packages" onclick="switchMpTab('packages')">
                        <i class="bi bi-box-seam me-1"></i> 1. Pick a Package
                        <span class="badge ms-1 rounded-pill" style="background:var(--purple);color:white;font-size:0.6rem;">{{ $caterer->packages->count() }}</span>
                    </button>
                    <button class="mp-tab" id="mpTab-menus" onclick="switchMpTab('menus')">
                        <i class="bi bi-card-list me-1"></i> 2. Add Menu Items
                        <span class="badge ms-1 rounded-pill" style="background:var(--orange);color:white;font-size:0.6rem;" id="menuAddOnCount">{{ $caterer->menus->count() }}</span>
                    </button>
                </div>

                {{-- ── PACKAGES PANEL ── --}}
                <div id="mpPanel-packages">
                    @if($caterer->packages->count() > 0)
                        <p style="font-size:.78rem;color:var(--gray-500);margin-bottom:16px;">
                            <i class="bi bi-info-circle" style="color:var(--orange);margin-right:4px;"></i>
                            Click a package to select it. Then go to Step 2 to add individual menu items.
                        </p>
                        <div class="pkg-selector-grid">
                            @foreach($caterer->packages as $pkg)
                                <div class="pkg-sel-card"
                                     id="pkg-card-{{ $pkg->id }}"
                                     data-pkg-id="{{ $pkg->id }}"
                                     data-pkg-name="{{ $pkg->name }}"
                                     data-pkg-price="{{ $pkg->price_per_guest }}"
                                     data-pkg-min="{{ $pkg->min_guests }}"
                                     data-pkg-max="{{ $pkg->max_guests ?? '' }}"
                                     onclick="selectPackage(this)">

                                    <div class="pkg-sel-check"><i class="bi bi-check-lg"></i></div>

                                    <div class="pkg-sel-header">
                                        <div class="pkg-sel-name">{{ $pkg->name }}</div>
                                        <div class="pkg-sel-price">₱{{ number_format($pkg->price_per_guest, 0) }}</div>
                                        <div class="pkg-sel-unit">Per Guest</div>
                                        <div class="pkg-sel-pax">
                                            <i class="bi bi-people-fill me-1"></i>
                                            {{ $pkg->min_guests }}{{ $pkg->max_guests ? ' – ' . $pkg->max_guests : '+' }} guests
                                        </div>
                                    </div>
                                    <div class="pkg-sel-body">
                                        @if($pkg->description)
                                            <div class="pkg-sel-desc">{{ $pkg->description }}</div>
                                        @endif
                                        @if($pkg->inclusions)
                                            <div class="pkg-inc-title">What's Included</div>
                                            @foreach($pkg->inclusions_array as $item)
                                                <div class="pkg-inc-item">
                                                    <i class="bi bi-check-circle-fill"></i> {{ $item }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button class="pkg-sel-btn" onclick="event.stopPropagation(); selectPackage(document.getElementById('pkg-card-{{ $pkg->id }}'))">
                                        <span class="btn-select-text">Select This Package</span>
                                        <span class="btn-selected-text" style="display:none;">✓ Selected</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mp-empty">
                            <i class="bi bi-box-seam"></i>
                            <p>No packages listed yet.</p>
                        </div>
                    @endif
                </div>

                {{-- ── MENUS PANEL ── --}}
<div id="mpPanel-menus" style="display:none;">
    @if($caterer->menus->count() > 0)
        <div style="background:rgba(255,122,0,.06);border:1px solid rgba(255,122,0,.18);border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:.78rem;color:#555;">
            <i class="bi bi-plus-circle" style="color:var(--orange);margin-right:5px;"></i>
            <strong>Optional:</strong> Click any item to add it as an extra. Each item price is added to your estimate.
            <span id="selectedMenuCount" style="display:none;margin-left:8px;padding:2px 10px;background:var(--orange);color:#fff;border-radius:20px;font-weight:700;font-size:.72rem;"></span>
        </div>

        @php $menuCategories = $caterer->menus->pluck('category')->filter()->unique()->values(); @endphp
        @if($menuCategories->count() > 1)
            <div class="cat-filter" id="menuCatFilter">
                <button class="cat-pill active" data-cat="all" onclick="filterMenuCat(this, 'all')">All</button>
                @foreach($menuCategories as $cat)
                    <button class="cat-pill" data-cat="{{ $cat }}" onclick="filterMenuCat(this, '{{ $cat }}')">{{ $cat }}</button>
                @endforeach
            </div>
        @endif

        <div class="menu-selector-grid" id="menuSelectorGrid">
            @foreach($caterer->menus as $menu)
                <div class="menu-sel-card"
                     data-category="{{ $menu->category ?? '' }}"
                     data-menu-id="{{ $menu->id }}"
                     data-menu-name="{{ $menu->name }}"
                     data-menu-price="{{ $menu->price }}"
                     onclick="toggleMenuItem(this)">

                    <div class="menu-sel-badge"><i class="bi bi-check-lg"></i></div>
                    <div class="menu-sel-cat">{{ $menu->category ?: 'General' }}</div>
                    <div class="menu-sel-name">{{ $menu->name }}</div>
                    <div class="menu-sel-desc">{{ $menu->description ?: '—' }}</div>

                    <div class="menu-sel-footer">
                        <div>
                            <div class="menu-sel-price">₱{{ number_format($menu->price, 2) }}</div>
                            <span class="menu-sel-price-unit">per unit</span>
                        </div>
                        <span class="menu-sel-addtag add-tag">+ Add</span>
                    </div>

                    <div class="menu-qty-controls">
                        <button class="qty-btn"
                                onclick="event.stopPropagation(); changeQty(this.closest('.menu-sel-card'), -1)">−</button>
                        <span class="qty-display">1</span>
                        <button class="qty-btn"
                                onclick="event.stopPropagation(); changeQty(this.closest('.menu-sel-card'), 1)">+</button>
                        <span class="qty-subtotal" style="font-size:.7rem;color:var(--gray-500);margin-left:4px;"></span>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="mp-empty">
            <i class="bi bi-card-list"></i>
            <p>No menu items listed yet.</p>
        </div>
    @endif
</div>

                {{-- ── LIVE ORDER SUMMARY ── --}}
                <div class="order-summary-panel" id="orderSummaryPanel">
                    <div class="osp-title"><i class="bi bi-receipt"></i> Live Estimate</div>

                    <div class="osp-pax-row">
                        <span class="osp-pax-label"><i class="bi bi-people-fill me-1"></i> Guests</span>
                        <input type="number" class="osp-pax-input" id="ospPaxInput" placeholder="e.g. 100" min="1" oninput="recalculate()">
                        <span style="font-size:.68rem;color:rgba(255,255,255,.3);margin-left:4px;">pax</span>
                    </div>

                    <div id="ospPkgRow" class="osp-pkg-row" style="display:none;">
                        <div>
                            <div class="osp-pkg-name" id="ospPkgName">—</div>
                            <div class="osp-pkg-calc" id="ospPkgCalc"></div>
                        </div>
                        <div class="osp-pkg-amount" id="ospPkgAmount">₱0</div>
                    </div>

                    <div id="ospAddonsSection" style="display:none;">
                        <div class="osp-addons-title">Menu Add-ons</div>
                        <div id="ospAddonsList"></div>
                        <div class="osp-addon-row" style="border-top:1px solid rgba(255,255,255,.1);padding-top:8px;margin-top:4px;">
                            <span class="osp-addon-name" style="font-weight:700;color:rgba(255,255,255,.5);">Add-ons Subtotal</span>
                            <span class="osp-addon-price" id="ospAddonsSubtotal">₱0</span>
                        </div>
                    </div>

                    <hr class="osp-divider">

                    <div class="osp-total-row">
                        <div class="osp-total-label">Estimated Total</div>
                        <div>
                            <div class="osp-total-amount" id="ospGrandTotal">₱0</div>
                            <div class="osp-per-guest" id="ospPerGuest"></div>
                        </div>
                    </div>

                    <div class="osp-dp-row">
                        <div class="osp-dp-label"><i class="bi bi-wallet2 me-1"></i> 50% Downpayment</div>
                        <div class="osp-dp-amount" id="ospDownpayment">₱0</div>
                    </div>
                </div>

            </div>


            {{-- Reviews --}}
            <div class="section-card">
                <p class="section-eyebrow">Customer Feedback</p>
                <h3 class="section-title">Reviews
                    @if($caterer->reviews->count() > 0)
                        <span style="font-size:.75rem;color:var(--gray-500);font-weight:600;letter-spacing:0;text-transform:none;">
                            — {{ $caterer->reviews->count() }} review{{ $caterer->reviews->count() !== 1 ? 's' : '' }}
                        </span>
                    @endif
                </h3>
                @forelse($caterer->reviews as $review)
                    <div class="review-card">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <div class="review-stars mb-1">
                                    @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$review->rating?'-fill':'' }}"></i>@endfor
                                </div>
                                <div class="review-author">{{ $review->user->name ?? 'Anonymous' }}</div>
                            </div>
                            <div class="review-date">{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</div>
                        </div>
                        @if($review->comment)
                            <p class="review-text">"{{ $review->comment }}"</p>
                        @endif

                        @if($review->caterer_reply)
                            <div style="margin-top:12px;padding:12px 16px;background:linear-gradient(135deg,#fff8f0,#fff4e6);border-left:3px solid var(--orange);border-radius:0 10px 10px 0;">
                                <div style="display:flex;align-items:center;gap:6px;margin-bottom:6px;">
                                    <div style="width:24px;height:24px;border-radius:50%;background:var(--orange);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-shop" style="color:white;font-size:.65rem;"></i>
                                    </div>
                                    <span style="font-family:'Montserrat',sans-serif;font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:var(--orange);">
                                        Caterer's Reply
                                    </span>
                                    <span style="font-size:.65rem;color:var(--gray-500);margin-left:auto;">
                                        {{ \Carbon\Carbon::parse($review->caterer_reply_at)->format('M d, Y') }}
                                    </span>
                                </div>
                                <p style="font-size:.85rem;color:#444;line-height:1.55;margin:0;font-style:italic;">
                                    "{{ $review->caterer_reply }}"
                                </p>
                            </div>
                        @endif

                        @auth
                            @if(
                                Auth::user()->catererProfile
                                && (int)Auth::user()->catererProfile->id === (int)$review->caterer_profile_id
                                && !$review->caterer_reply
                            )
                                <div style="margin-top:12px;">
                                    <button class="btn btn-sm rounded-pill fw-bold px-3"
                                            style="background:var(--charcoal);color:white;font-size:.72rem;"
                                            onclick="document.getElementById('replyForm{{ $review->id }}').style.display = document.getElementById('replyForm{{ $review->id }}').style.display === 'none' ? 'block' : 'none'">
                                        <i class="bi bi-reply-fill me-1"></i> Reply to this Review
                                    </button>

                                    <form action="{{ route('reviews.reply', $review->id) }}" method="POST"
                                          id="replyForm{{ $review->id }}" style="display:none;margin-top:10px;">
                                        @csrf
                                        <textarea name="caterer_reply" rows="3"
                                                  class="form-control rounded-3 mb-2"
                                                  style="border:1.5px solid #e0e0e0;padding:12px 16px;font-size:.88rem;resize:none;"
                                                  placeholder="Write a professional response to this review..."
                                                  required maxlength="1000"></textarea>
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <small style="color:var(--gray-500);font-size:.7rem;">
                                                <i class="bi bi-info-circle"></i> Replies are permanent and visible to all users.
                                            </small>
                                            <div style="display:flex;gap:8px;">
                                                <button type="button" class="btn btn-sm btn-light rounded-pill px-3 fw-bold"
                                                        style="font-size:.75rem;"
                                                        onclick="document.getElementById('replyForm{{ $review->id }}').style.display='none'">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-sm rounded-pill px-3 fw-bold"
                                                        style="background:var(--orange);color:white;font-size:.75rem;">
                                                    <i class="bi bi-send-fill me-1"></i> Publish Reply
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @empty
                    <div class="no-reviews">
                        <i class="bi bi-chat-square-text"></i>
                        <p>No reviews yet. Be the first to book and share your experience!</p>
                    </div>
                @endforelse
            </div>

        </div>{{-- end left column --}}

        {{-- ════════════════════ RIGHT COLUMN ════════════════════ --}}
        <div class="sticky-col" style="position:sticky;top:24px;" id="bookingFormAnchor">

            {{-- HOW TO BOOK --}}
            <div class="how-to-book">
                <div class="htb-header">
                    <div class="htb-eyebrow">Quick Guide</div>
                    <div class="htb-title">How to Book This Caterer</div>
                </div>
                <div class="htb-steps">
                    <div class="htb-step">
                        <div class="htb-step-num">1</div>
                        <div>
                            <div class="htb-step-title">Browse & Select a Package</div>
                            <div class="htb-step-desc">Choose a package and add menu items to see your live estimate.</div>
                            <span class="htb-step-tag orange">You do this</span>
                        </div>
                    </div>
                    <div class="htb-step">
                        <div class="htb-step-num">2</div>
                        <div>
                            <div class="htb-step-title">Fill in Event Details</div>
                            <div class="htb-step-desc">Enter your event date, time, venue, guest count, and event type.</div>
                            <span class="htb-step-tag orange">You do this</span>
                        </div>
                    </div>
                    <div class="htb-step">
                        <div class="htb-step-num">3</div>
                        <div>
                            <div class="htb-step-title">Submit Your Request</div>
                            <div class="htb-step-desc">No payment yet. Your request is sent to the caterer for review.</div>
                            <span class="htb-step-tag orange">You do this</span>
                        </div>
                    </div>
                    <div class="htb-step">
                        <div class="htb-step-num">4</div>
                        <div>
                            <div class="htb-step-title">Caterer Reviews & Approves</div>
                            <div class="htb-step-desc">The caterer reviews within 24 hours and approves or declines.</div>
                            <span class="htb-step-tag blue">Caterer does this</span>
                        </div>
                    </div>
                    <div class="htb-step">
                        <div class="htb-step-num">5</div>
                        <div>
                            <div class="htb-step-title">Pay 50% Downpayment</div>
                            <div class="htb-step-desc">Once approved, pay the downpayment by the caterer's deadline.</div>
                            <span class="htb-step-tag green">Booking confirmed</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════
                 BOOKING CARD
            ══════════════════════════ --}}
            <div class="booking-card">

                {{-- Header --}}
                <div class="booking-card-header">
                    <div class="booking-card-label">Book This Caterer</div>
                    <div class="booking-card-title">{{ $caterer->business_name }}</div>
                    <div class="price-range-display">
                        <span class="price-min">₱{{ number_format($caterer->min_budget, 0) }}</span>
                        <span class="price-sep">–</span>
                        <span class="price-max">₱{{ number_format($caterer->max_budget, 0) }}</span>
                    </div>
                    <span class="price-unit">Per Guest · Price Range</span>
                    @if($caterer->reviews->count() > 0)
                        <div class="rating-summary">
                            <div class="rating-score">{{ number_format($caterer->reviews->avg('rating'), 1) }}</div>
                            <div>
                                <div class="rating-stars">
                                    @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=round($caterer->reviews->avg('rating'))?'-fill':'' }}"></i>@endfor
                                </div>
                                <div class="rating-count">{{ $caterer->reviews->count() }} review{{ $caterer->reviews->count()!==1?'s':'' }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Selected package / estimate bar --}}
                <div class="booking-selection-bar" id="bookingSelectionBar">
                    <div>
                        <div class="bsb-label">Selected Package</div>
                        <div class="bsb-value" id="bsbPkgName">—</div>
                    </div>
                    <div style="text-align:right;">
                        <div class="bsb-label">Estimate</div>
                        <div class="bsb-value" id="bsbEstimate">—</div>
                    </div>
                </div>

                @auth
                    @if(Auth::user()->role === 'admin')

                        <div class="booking-form-body">
                            <div class="admin-preview-box">
                                <i class="bi bi-shield-lock"></i>
                                Administrative Preview Only
                            </div>
                        </div>

                    @else

                        {{-- Step tabs --}}
                        <div class="form-steps-bar">
                            <div class="form-step-tab active" id="tab-1">
                                <div class="form-step-tab-num">1</div>
                                <div class="form-step-tab-label">Event</div>
                            </div>
                            <div class="form-step-tab" id="tab-2">
                                <div class="form-step-tab-num">2</div>
                                <div class="form-step-tab-label">Details</div>
                            </div>
                            <div class="form-step-tab" id="tab-3">
                                <div class="form-step-tab-num">3</div>
                                <div class="form-step-tab-label">Review</div>
                            </div>
                        </div>

                        <div class="booking-form-body">
                            <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                                @csrf
                                <input type="hidden" name="caterer_profile_id"   value="{{ $caterer->id }}">
                                <input type="hidden" name="selected_package_id"   id="formPackageId">
                                <input type="hidden" name="selected_package_name" id="formPackageName">
                                <input type="hidden" name="selected_menu_ids"     id="formMenuIds">
                                <input type="hidden" name="estimated_total"       id="formEstimatedTotal">

                                {{-- ── STEP 1 ── --}}
                                <div class="form-step-panel active" id="panel-1">

                                    {{-- Selected package hint --}}
                                    <div id="formPkgHint" class="form-pkg-hint">
                                        <div>
                                            <i class="bi bi-box-seam form-pkg-hint-icon"></i>
                                            Package: <strong id="formPkgHintName" style="color:var(--orange);"></strong>
                                        </div>
                                        <span id="formPkgHintTotal" class="form-pkg-hint-total"></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-field-label">
                                            <i class="bi bi-calendar3" style="color:var(--orange);margin-right:4px;"></i>
                                            Event Date <span class="req">*</span>
                                        </label>
                                        <input type="date" name="event_date" id="event_date"
                                               class="form-field @error('event_date') is-invalid @enderror"
                                               value="{{ old('event_date') }}" required>
                                        <div class="avail-box checking" id="avail-checking"><i class="bi bi-hourglass-split"></i> Checking…</div>
                                        <div class="avail-box available"   id="avail-ok"><i class="bi bi-check-circle-fill"></i> Date is available!</div>
                                        <div class="avail-box unavailable" id="avail-no"><i class="bi bi-x-circle-fill"></i> Fully booked for this date</div>
                                        @error('event_date')<div style="color:var(--red);font-size:.78rem;margin-top:5px;">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="form-row-2">
                                        <div>
                                            <label class="form-field-label">
                                                <i class="bi bi-clock" style="color:var(--orange);margin-right:4px;"></i>
                                                Event Time <span class="req">*</span>
                                            </label>
                                            <input type="time" name="event_time" id="event_time"
                                                   class="form-field @error('event_time') is-invalid @enderror"
                                                   value="{{ old('event_time') }}" required>
                                            @error('event_time')<div style="color:var(--red);font-size:.78rem;margin-top:5px;">{{ $message }}</div>@enderror
                                        </div>
                                        <div>
                                            <label class="form-field-label">
                                                <i class="bi bi-people-fill" style="color:var(--orange);margin-right:4px;"></i>
                                                No. of Guests <span class="req">*</span>
                                            </label>
                                            <input type="number" name="pax" id="paxInput"
                                                   class="form-field @error('pax') is-invalid @enderror"
                                                   placeholder="e.g. 100" value="{{ old('pax') }}"
                                                   min="1" required oninput="syncPaxFromForm()">
                                            @error('pax')<div style="color:var(--red);font-size:.78rem;margin-top:5px;">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-field-label">
                                            <i class="bi bi-star" style="color:var(--orange);margin-right:4px;"></i>
                                            Event Type <span class="req">*</span>
                                        </label>
                                        <select name="event_type" id="event_type"
                                                class="form-field @error('event_type') is-invalid @enderror" required>
                                            <option value="" disabled {{ old('event_type') ? '' : 'selected' }}>Select event type…</option>
                                            <option value="wedding"     {{ old('event_type')==='wedding'     ?'selected':'' }}>Wedding Reception</option>
                                            <option value="birthday"    {{ old('event_type')==='birthday'    ?'selected':'' }}>Birthday Celebration</option>
                                            <option value="corporate"   {{ old('event_type')==='corporate'   ?'selected':'' }}>Corporate Event</option>
                                            <option value="debut"       {{ old('event_type')==='debut'       ?'selected':'' }}>Debut / Cotillion</option>
                                            <option value="reunion"     {{ old('event_type')==='reunion'     ?'selected':'' }}>Family Reunion</option>
                                            <option value="graduation"  {{ old('event_type')==='graduation'  ?'selected':'' }}>Graduation Party</option>
                                            <option value="christening" {{ old('event_type')==='christening' ?'selected':'' }}>Christening / Baptism</option>
                                            <option value="fiesta"      {{ old('event_type')==='fiesta'      ?'selected':'' }}>Fiesta / Community Event</option>
                                            <option value="other"       {{ old('event_type')==='other'       ?'selected':'' }}>Other</option>
                                        </select>
                                        @error('event_type')<div style="color:var(--red);font-size:.78rem;margin-top:5px;">{{ $message }}</div>@enderror
                                    </div>

                                    {{-- Live downpayment strip --}}
                                    <div class="form-dp-strip">
                                        <span class="form-dp-label">
                                            <i class="bi bi-wallet2 me-1"></i> 50% Downpayment
                                        </span>
                                        <span class="form-dp-amount" id="inlineDP">—</span>
                                    </div>

                                    <div class="form-nav">
                                        <button type="button" class="btn-next" onclick="goStep(2)">
                                            Next: Event Details <i class="bi bi-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- ── STEP 2 ── --}}
                                <div class="form-step-panel" id="panel-2">

                                    <div class="form-group">
                                        <label class="form-field-label">
                                            <i class="bi bi-geo-alt" style="color:var(--orange);margin-right:4px;"></i>
                                            Venue / Event Location <span class="req">*</span>
                                        </label>
                                        <input type="text" name="event_location" id="event_location"
                                               class="form-field @error('event_location') is-invalid @enderror"
                                               placeholder="e.g. Alferez Resort, Naga City"
                                               value="{{ old('event_location') }}" required>
                                        @error('event_location')<div style="color:var(--red);font-size:.78rem;margin-top:5px;">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-field-label">
                                            <i class="bi bi-egg-fried" style="color:var(--orange);margin-right:4px;"></i>
                                            Dietary Requirements
                                            <span style="font-weight:500;text-transform:none;letter-spacing:0;color:var(--gray-500);">(optional)</span>
                                        </label>
                                        <input type="text" name="dietary_requirements" id="dietary_requirements"
                                               class="form-field"
                                               placeholder="e.g. Halal, Vegetarian, No pork"
                                               value="{{ old('dietary_requirements') }}">
                                    </div>

                                    <div class="form-group">
                                        <label class="form-field-label">
                                            <i class="bi bi-chat-left-text" style="color:var(--orange);margin-right:4px;"></i>
                                            Special Notes
                                            <span style="font-weight:500;text-transform:none;letter-spacing:0;color:var(--gray-500);">(optional)</span>
                                        </label>
                                        <textarea name="notes" id="notes" class="form-field"
                                                  placeholder="Any special requests or themes…">{{ old('notes') }}</textarea>
                                    </div>

                                    <div class="form-nav">
                                        <button type="button" class="btn-prev" onclick="goStep(1)">
                                            <i class="bi bi-arrow-left"></i> Back
                                        </button>
                                        <button type="button" class="btn-next" onclick="goStep(3)">
                                            Review Booking <i class="bi bi-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- ── STEP 3 ── --}}
                                <div class="form-step-panel" id="panel-3">
                                    <div class="booking-summary" id="bookingSummary">
                                        <div class="summary-title">
                                            <i class="bi bi-clipboard-check"></i> Booking Summary
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Caterer</span>
                                            <span class="summary-value">{{ $caterer->business_name }}</span>
                                        </div>
                                        <div class="summary-row" id="sum-row-pkg" style="display:none;">
                                            <span class="summary-label">Package</span>
                                            <span class="summary-value" id="sum-pkg">—</span>
                                        </div>
                                        <div class="summary-row" id="sum-row-addons" style="display:none;">
                                            <span class="summary-label">Menu Add-ons</span>
                                            <span class="summary-value" id="sum-addons">—</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Event Date</span>
                                            <span class="summary-value" id="sum-date">—</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Event Time</span>
                                            <span class="summary-value" id="sum-time">—</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Event Type</span>
                                            <span class="summary-value" id="sum-type">—</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Guests</span>
                                            <span class="summary-value" id="sum-pax">—</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Venue</span>
                                            <span class="summary-value" id="sum-venue">—</span>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Dietary</span>
                                            <span class="summary-value" id="sum-dietary">None specified</span>
                                        </div>
                                        <div class="summary-row summary-total">
                                            <span class="summary-label">Est. Total</span>
                                            <span class="summary-value" id="sum-total">—</span>
                                        </div>
                                        <div class="summary-row summary-total" style="margin-top:4px;">
                                            <span class="summary-label" style="color:var(--green);font-size:.78rem;">50% Downpayment</span>
                                            <span class="summary-value" id="sum-dp" style="color:var(--green);">—</span>
                                        </div>
                                    </div>

                                    <p style="font-size:.75rem;color:var(--gray-500);line-height:1.55;margin-bottom:0;">
                                        <i class="bi bi-info-circle" style="color:var(--orange);margin-right:4px;"></i>
                                        No payment collected now. The caterer will review and set a downpayment deadline if approved.
                                    </p>

                                    <div class="form-nav">
                                        <button type="button" class="btn-prev" onclick="goStep(2)">
                                            <i class="bi bi-arrow-left"></i> Back
                                        </button>
                                        <button type="submit" class="btn-book" id="submit-btn">
                                            <i class="bi bi-send-fill"></i> Submit Booking Request
                                        </button>
                                    </div>
                                </div>

                            </form>

                            <div class="security-note">
                                <i class="bi bi-shield-lock-fill"></i> Your information is safe and secure.
                            </div>
                        </div>

                    @endif
                @else
                    <div class="guest-login-note">
                        You need to be logged in to book this caterer.
                    </div>
                    <div class="booking-form-body" style="padding-top:12px;">
                        <a href="{{ route('login') }}" class="btn-login-book">
                            <i class="bi bi-lock-fill me-2"></i> Login to Book
                        </a>
                        <div class="security-note">
                            <i class="bi bi-shield-lock-fill"></i> Your information is safe and secure.
                        </div>
                    </div>
                @endauth

            </div>{{-- end booking-card --}}

        </div>{{-- end right column --}}

    </div>{{-- end detail-layout --}}
</div>{{-- end container --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    var minB = {{ $caterer->min_budget ?? 0 }};
    var maxB = {{ $caterer->max_budget ?? 0 }};
    var currentStep = 1;

    /* ═══════════════════════════════════════════
       STATE
    ═══════════════════════════════════════════ */
    var selectedPackage = null;   // { id, name, price }
    var selectedMenus   = {};     // { menuId: { name, price, qty } }

    /* ═══════════════════════════════════════════
       TAB SWITCHER
    ═══════════════════════════════════════════ */
    window.switchMpTab = function(tab) {
        document.getElementById('mpPanel-menus').style.display    = tab === 'menus'    ? '' : 'none';
        document.getElementById('mpPanel-packages').style.display = tab === 'packages' ? '' : 'none';
        document.getElementById('mpTab-menus').classList.toggle('active',    tab === 'menus');
        document.getElementById('mpTab-packages').classList.toggle('active', tab === 'packages');
    };

    /* ═══════════════════════════════════════════
       PACKAGE SELECTION
    ═══════════════════════════════════════════ */
    window.selectPackage = function(card) {
        document.querySelectorAll('.pkg-sel-card').forEach(function(c) {
            c.classList.remove('selected');
            var selectText   = c.querySelector('.btn-select-text');
            var selectedText = c.querySelector('.btn-selected-text');
            if (selectText)   selectText.style.display   = '';
            if (selectedText) selectedText.style.display = 'none';
        });

        card.classList.add('selected');
        var sT = card.querySelector('.btn-select-text');
        var xT = card.querySelector('.btn-selected-text');
        if (sT) sT.style.display = 'none';
        if (xT) xT.style.display = '';

        selectedPackage = {
            id:    card.dataset.pkgId,
            name:  card.dataset.pkgName,
            price: parseFloat(card.dataset.pkgPrice)
        };

        var paxVal = parseInt(document.getElementById('paxInput').value) || parseInt(document.getElementById('ospPaxInput').value) || 0;
        if (paxVal > 0) document.getElementById('ospPaxInput').value = paxVal;

        recalculate();
        showOrderSummary();

        setTimeout(function(){ switchMpTab('menus'); }, 300);
    };

    /* ═══════════════════════════════════════════
       MENU ITEM TOGGLE
    ═══════════════════════════════════════════ */
    window.toggleMenuItem = function(card) {
        var id    = card.dataset.menuId;
        var name  = card.dataset.menuName;
        var price = parseFloat(card.dataset.menuPrice);

        if (selectedMenus[id]) {
            delete selectedMenus[id];
            card.classList.remove('selected');
            var qtyDisplay = card.querySelector('.qty-display');
            if (qtyDisplay) qtyDisplay.textContent = '1';
            var qtySub = card.querySelector('.qty-subtotal');
            if (qtySub) qtySub.textContent = '';
        } else {
            selectedMenus[id] = { name: name, price: price, qty: 1 };
            card.classList.add('selected');
        }

        updateMenuCount();
        recalculate();
    };

    /* ═══════════════════════════════════════════
       QUANTITY CHANGE
    ═══════════════════════════════════════════ */
    window.changeQty = function(card, delta) {
        var id    = card.dataset.menuId;
        var price = parseFloat(card.dataset.menuPrice);
        if (!selectedMenus[id]) return;

        var newQty = (selectedMenus[id].qty || 1) + delta;

        if (newQty < 1) {
            delete selectedMenus[id];
            card.classList.remove('selected');
            var qtyDisplay = card.querySelector('.qty-display');
            if (qtyDisplay) qtyDisplay.textContent = '1';
            var qtySub = card.querySelector('.qty-subtotal');
            if (qtySub) qtySub.textContent = '';
            updateMenuCount();
            recalculate();
            return;
        }

        selectedMenus[id].qty = newQty;
        var qtyDisplay = card.querySelector('.qty-display');
        if (qtyDisplay) qtyDisplay.textContent = newQty;
        var qtySub = card.querySelector('.qty-subtotal');
        if (qtySub) qtySub.textContent = '= ₱' + (price * newQty).toLocaleString('en-PH');

        recalculate();
    };

    /* ═══════════════════════════════════════════
       UPDATE MENU SELECTED COUNT BADGE
    ═══════════════════════════════════════════ */
    function updateMenuCount() {
        var count   = Object.keys(selectedMenus).length;
        var countEl = document.getElementById('selectedMenuCount');
        if (countEl) {
            if (count > 0) {
                countEl.textContent  = count + ' selected';
                countEl.style.display = 'inline-block';
            } else {
                countEl.style.display = 'none';
            }
        }
    }

    /* ═══════════════════════════════════════════
       MENU CATEGORY FILTER
    ═══════════════════════════════════════════ */
    window.filterMenuCat = function(btn, cat) {
        document.querySelectorAll('#menuCatFilter .cat-pill').forEach(function(p){ p.classList.remove('active'); });
        btn.classList.add('active');
        document.querySelectorAll('#menuSelectorGrid .menu-sel-card').forEach(function(card) {
            card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
        });
    };

    /* ═══════════════════════════════════════════
       RECALCULATE LIVE ESTIMATE
    ═══════════════════════════════════════════ */
    window.recalculate = function() {
        var pax = parseInt(document.getElementById('ospPaxInput').value) || 0;

        // Package subtotal
        var pkgTotal = 0;
        var pkgRow   = document.getElementById('ospPkgRow');
        if (selectedPackage) {
            if (pax > 0) {
                pkgTotal = selectedPackage.price * pax;
                if (pkgRow) {
                    pkgRow.style.display = '';
                    setText('ospPkgName',   selectedPackage.name);
                    setText('ospPkgCalc',   '₱' + selectedPackage.price.toLocaleString('en-PH') + ' × ' + pax + ' guests');
                    setText('ospPkgAmount', '₱' + pkgTotal.toLocaleString('en-PH'));
                }
            } else {
                if (pkgRow) {
                    pkgRow.style.display = '';
                    setText('ospPkgName',   selectedPackage.name);
                    setText('ospPkgCalc',   'Enter guest count to calculate');
                    setText('ospPkgAmount', '₱—');
                }
            }
        } else {
            if (pkgRow) pkgRow.style.display = 'none';
        }

        // Add-ons subtotal (qty-aware)
        var addonsTotal  = 0;
        var menuIds      = Object.keys(selectedMenus);
        var addonsSection = document.getElementById('ospAddonsSection');
        var addonsList    = document.getElementById('ospAddonsList');

        if (menuIds.length > 0) {
            addonsSection.style.display = '';
            addonsList.innerHTML = '';
            menuIds.forEach(function(id) {
                var item     = selectedMenus[id];
                var qty      = item.qty || 1;
                var lineTotal = item.price * qty;
                addonsTotal  += lineTotal;

                var row = document.createElement('div');
                row.className = 'osp-addon-row';
                row.innerHTML = '<span class="osp-addon-name">'
                              + item.name
                              + (qty > 1 ? ' <span style="font-size:.68rem;opacity:.6;">×' + qty + '</span>' : '')
                              + '</span>'
                              + '<span class="osp-addon-price">₱' + lineTotal.toLocaleString('en-PH') + '</span>';
                addonsList.appendChild(row);
            });
            setText('ospAddonsSubtotal', '₱' + addonsTotal.toLocaleString('en-PH'));
        } else {
            addonsSection.style.display = 'none';
        }

        // Grand total
        var grand = pkgTotal + addonsTotal;
        setText('ospGrandTotal',  grand > 0 ? '₱' + grand.toLocaleString('en-PH') : '₱0');
        setText('ospDownpayment', grand > 0 ? '₱' + (grand * 0.5).toLocaleString('en-PH') : '₱0');
        if (pax > 0 && grand > 0) {
            setText('ospPerGuest', '≈ ₱' + Math.round(grand / pax).toLocaleString('en-PH') + ' per guest');
        } else {
            setText('ospPerGuest', '');
        }

        // Update booking selection bar
        updateSelectionBar(grand);

        // Update hidden form fields
        var pkgIdField    = document.getElementById('formPackageId');
        var pkgNameField  = document.getElementById('formPackageName');
        var menuIdsField  = document.getElementById('formMenuIds');
        var estTotalField = document.getElementById('formEstimatedTotal');
        if (pkgIdField    && selectedPackage) pkgIdField.value   = selectedPackage.id;
        if (pkgNameField  && selectedPackage) pkgNameField.value = selectedPackage.name;
        if (menuIdsField)  menuIdsField.value  = menuIds.join(',');
        if (estTotalField) estTotalField.value = grand;

        // Update form package hint
        updateFormPkgHint(pax, pkgTotal, addonsTotal, grand);

        // Update inline downpayment strip in booking form
        var inlineDP = document.getElementById('inlineDP');
        if (inlineDP) {
            inlineDP.textContent = grand > 0 ? '₱' + (grand * 0.5).toLocaleString('en-PH') : '—';
        }
    };

    function updateSelectionBar(grand) {
        var bar = document.getElementById('bookingSelectionBar');
        if (!bar) return;
        if (selectedPackage) {
            bar.classList.add('show');
            setText('bsbPkgName',  selectedPackage.name);
            setText('bsbEstimate', grand > 0 ? '₱' + grand.toLocaleString('en-PH') : 'Enter guests');
        } else {
            bar.classList.remove('show');
        }
    }

    function updateFormPkgHint(pax, pkgTotal, addonsTotal, grand) {
        var hint    = document.getElementById('formPkgHint');
        var hintNm  = document.getElementById('formPkgHintName');
        var hintTot = document.getElementById('formPkgHintTotal');
        if (!hint) return;
        if (selectedPackage) {
            hint.classList.add('show');
            if (hintNm)  hintNm.textContent  = selectedPackage.name;
            if (hintTot) hintTot.textContent = grand > 0 ? 'Est. ₱' + grand.toLocaleString('en-PH') : '';
        } else {
            hint.classList.remove('show');
        }
    }

    function showOrderSummary() {
        var panel = document.getElementById('orderSummaryPanel');
        if (panel) panel.classList.add('show');
    }

    /* ═══════════════════════════════════════════
       SYNC PAX FROM BOOKING FORM → ESTIMATOR
    ═══════════════════════════════════════════ */
    window.syncPaxFromForm = function() {
        var val      = document.getElementById('paxInput').value;
        var ospInput = document.getElementById('ospPaxInput');
        if (ospInput) ospInput.value = val;
        recalculate();
    };

    /* ═══════════════════════════════════════════
       BOOKING STEP NAVIGATION
    ═══════════════════════════════════════════ */
    window.goStep = function(step) {
        if (step === 2 && currentStep === 1) {
            var ok = true;
            ['event_date','event_time','paxInput','event_type'].forEach(function(id) {
                var f = document.getElementById(id);
                if (f && !f.value) { f.classList.add('is-invalid'); ok = false; }
                else if (f) f.classList.remove('is-invalid');
            });
            if (!ok) return;
        }
        if (step === 3 && currentStep === 2) {
            var venue = document.getElementById('event_location');
            if (venue && !venue.value.trim()) { venue.classList.add('is-invalid'); return; }
            if (venue) venue.classList.remove('is-invalid');
            buildSummary();
        }
        currentStep = step;
        document.querySelectorAll('.form-step-panel').forEach(function(p){ p.classList.remove('active'); });
        var panel = document.getElementById('panel-' + step);
        if (panel) panel.classList.add('active');
        document.querySelectorAll('.form-step-tab').forEach(function(t, i) {
            t.classList.remove('active','done');
            if (i + 1 < step)  t.classList.add('done');
            if (i + 1 === step) t.classList.add('active');
            var num = t.querySelector('.form-step-tab-num');
            if (num) num.textContent = (i + 1 < step) ? '✓' : (i + 1);
        });
    };

    function buildSummary() {
        var dateVal  = document.getElementById('event_date')           ? document.getElementById('event_date').value : '';
        var timeVal  = document.getElementById('event_time')           ? document.getElementById('event_time').value : '';
        var paxVal   = document.getElementById('paxInput')             ? document.getElementById('paxInput').value : '';
        var typeEl   = document.getElementById('event_type');
        var venueVal = document.getElementById('event_location')       ? document.getElementById('event_location').value : '';
        var dietVal  = document.getElementById('dietary_requirements') ? document.getElementById('dietary_requirements').value : '';
        var typeLabel = typeEl && typeEl.selectedIndex > 0 ? typeEl.options[typeEl.selectedIndex].text : '—';

        var dateDisplay = '—';
        if (dateVal) {
            var d = new Date(dateVal + 'T00:00:00');
            dateDisplay = d.toLocaleDateString('en-PH', { year:'numeric', month:'long', day:'numeric' });
        }
        var timeDisplay = '—';
        if (timeVal) {
            var parts = timeVal.split(':');
            var hr = parseInt(parts[0]); var mn = parts[1];
            var ampm = hr >= 12 ? 'PM' : 'AM'; hr = hr % 12 || 12;
            timeDisplay = hr + ':' + mn + ' ' + ampm;
        }

        // Package + menu calculation (qty-aware)
        var pax = parseInt(paxVal) || 0;
        var pkgTotal    = selectedPackage && pax > 0 ? selectedPackage.price * pax : 0;
        var addonsTotal = 0;
        var addonLines  = [];
        Object.values(selectedMenus).forEach(function(m) {
            var qty       = m.qty || 1;
            var lineTotal = m.price * qty;
            addonsTotal  += lineTotal;
            addonLines.push(m.name + (qty > 1 ? ' ×' + qty : '') + ' (₱' + lineTotal.toLocaleString('en-PH') + ')');
        });
        var grand = pkgTotal + addonsTotal;

        var totalDisplay = grand > 0
            ? '₱' + grand.toLocaleString('en-PH')
            : (minB > 0 && pax > 0
                ? '₱' + (minB * pax).toLocaleString('en-PH') + ' – ₱' + (maxB * pax).toLocaleString('en-PH')
                : '—');
        var dpDisplay = grand > 0 ? '₱' + (grand * 0.5).toLocaleString('en-PH') : '—';

        setText('sum-date',    dateDisplay);
        setText('sum-time',    timeDisplay);
        setText('sum-type',    typeLabel);
        setText('sum-pax',     paxVal ? paxVal + ' guests' : '—');
        setText('sum-venue',   venueVal || '—');
        setText('sum-dietary', dietVal  || 'None specified');
        setText('sum-total',   totalDisplay);
        setText('sum-dp',      dpDisplay);

        // Package row
        var pkgRow = document.getElementById('sum-row-pkg');
        if (pkgRow) {
            if (selectedPackage) {
                pkgRow.style.display = '';
                setText('sum-pkg', selectedPackage.name + (pax > 0 ? ' (₱' + selectedPackage.price.toLocaleString('en-PH') + ' × ' + pax + ')' : ''));
            } else {
                pkgRow.style.display = 'none';
            }
        }

        // Add-ons row (shows qty breakdown)
        var addonsRow = document.getElementById('sum-row-addons');
        if (addonsRow) {
            var menuKeys = Object.keys(selectedMenus);
            if (menuKeys.length > 0) {
                addonsRow.style.display = '';
                setText('sum-addons', menuKeys.length + ' item(s) — ₱' + addonsTotal.toLocaleString('en-PH'));
            } else {
                addonsRow.style.display = 'none';
            }
        }

        // Update hidden fields before submit
        var estTotalField = document.getElementById('formEstimatedTotal');
        if (estTotalField) estTotalField.value = grand;
    }

    function setText(id, val) {
        var el = document.getElementById(id);
        if (el) el.textContent = val;
    }

    /* ═══════════════════════════════════════════
       SCROLL TO BOOKING
    ═══════════════════════════════════════════ */
    window.scrollToBooking = function() {
        var el = document.getElementById('bookingFormAnchor');
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    /* ═══════════════════════════════════════════
       AVAILABILITY CHECK
    ═══════════════════════════════════════════ */
    var dateInput   = document.getElementById('event_date');
    var checkingBox = document.getElementById('avail-checking');
    var okBox       = document.getElementById('avail-ok');
    var noBox       = document.getElementById('avail-no');

    function hideAvail() {
        [checkingBox, okBox, noBox].forEach(function(b){ if (b) b.classList.remove('show'); });
    }

   if (dateInput) {
    var today = new Date();
    today.setHours(0, 0, 0, 0);

    // Allow selecting from tomorrow onwards
    var minDate = new Date(today);
    minDate.setDate(minDate.getDate() + 1);

    var dd = String(minDate.getDate()).padStart(2, '0');
    var mm = String(minDate.getMonth() + 1).padStart(2, '0');
    dateInput.setAttribute('min', minDate.getFullYear() + '-' + mm + '-' + dd);

    dateInput.addEventListener('change', function() {
        var date = this.value;
        if (!date) { hideAvail(); return; }

        var chosen = new Date(date + 'T00:00:00');
        var diffDays = Math.ceil((chosen - today) / (1000 * 60 * 60 * 24));

        if (diffDays < 10) {
            hideAvail();
            document.getElementById('avail-no').innerHTML =
                '<i class="bi bi-x-circle-fill"></i> Your event date is less than 10 days away. Submit your booking request anyway and use the chat inside your booking to confirm with the caterer if they can accommodate.'
            document.getElementById('avail-no').classList.add('show');
            dateInput.classList.add('is-invalid');
            dateInput.classList.remove('is-valid');
            return;
        }

        document.getElementById('avail-no').innerHTML =
            '<i class="bi bi-x-circle-fill"></i> Fully booked for this date';

        hideAvail();
        if (checkingBox) checkingBox.classList.add('show');

        fetch('/api/check-availability?caterer_id={{ $caterer->id }}&date=' + date)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                hideAvail();
                if (data.available === false) {
                    if (noBox) noBox.classList.add('show');
                    dateInput.classList.add('is-invalid');
                    dateInput.classList.remove('is-valid');
                } else {
                    if (okBox) okBox.classList.add('show');
                    dateInput.classList.remove('is-invalid');
                    dateInput.classList.add('is-valid');
                }
            })
            .catch(function() { hideAvail(); });
    });
}

});
</script>
@endsection