@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --orange:#FF7A00;--orange-lt:#ff9f2f;--charcoal:#1a1a1a;--white:#ffffff;
        --gray-50:#f9f9f9;--gray-100:#f2f2f2;--gray-300:#d0d0d0;--gray-500:#888;
        --green:#27ae60;--red:#e74c3c;--blue:#2196F3;
        --radius-lg:20px;--radius-md:14px;--radius-sm:10px;
        --shadow-sm:0 2px 12px rgba(0,0,0,0.06);
    }
    *{box-sizing:border-box;}
    body{background:var(--gray-50);font-family:'Inter',sans-serif;color:var(--charcoal);}

    .page-topbar{background:var(--charcoal);padding:16px 32px;display:flex;align-items:center;justify-content:space-between;gap:16px;position:sticky;top:0;z-index:100;box-shadow:0 4px 20px rgba(0,0,0,.25);flex-wrap:wrap;}
    .topbar-left{display:flex;align-items:center;gap:14px;}
    .topbar-back{width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;transition:all .2s;flex-shrink:0;}
    .topbar-back:hover{background:var(--orange);color:white;border-color:var(--orange);}
    .topbar-title{font-family:'Montserrat',sans-serif;font-size:1rem;font-weight:900;color:white;}
    .topbar-title span{color:var(--orange);}
    .topbar-ref{font-size:.68rem;font-weight:700;color:rgba(255,255,255,.4);font-family:'Montserrat',sans-serif;letter-spacing:.5px;}
    .topbar-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}

    .status-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 16px;border-radius:50px;font-size:.7rem;font-weight:800;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:.5px;}
    .btn-confirm{display:inline-flex;align-items:center;gap:7px;padding:9px 22px;border-radius:50px;background:var(--green);color:white;border:none;font-family:'Montserrat',sans-serif;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;cursor:pointer;transition:all .2s;box-shadow:0 4px 14px rgba(39,174,96,.3);}
    .btn-confirm:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(39,174,96,.4);}
    .btn-reject{display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:50px;background:rgba(231,76,60,.08);color:var(--red);border:1.5px solid rgba(231,76,60,.25);font-family:'Montserrat',sans-serif;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;cursor:pointer;transition:all .2s;}
    .btn-reject:hover{background:var(--red);color:white;border-color:var(--red);}
    .btn-complete{display:inline-flex;align-items:center;gap:7px;padding:9px 22px;border-radius:50px;background:var(--blue);color:white;border:none;font-family:'Montserrat',sans-serif;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;cursor:pointer;transition:all .2s;box-shadow:0 4px 14px rgba(33,150,243,.25);}
    .btn-complete:hover{transform:translateY(-1px);}

    .page-body{max-width:1280px;margin:0 auto;padding:28px 24px 60px;}
    .booking-layout{display:grid;grid-template-columns:300px 1fr 320px;gap:22px;align-items:start;}
    @media(max-width:1100px){.booking-layout{grid-template-columns:280px 1fr;}.customer-col{display:none;}}
    @media(max-width:768px){.booking-layout{grid-template-columns:1fr;}.page-topbar{padding:14px 16px;}.page-body{padding:18px 14px 50px;}.chat-card{height:70vh;}}

    .card{background:var(--white);border-radius:var(--radius-lg);border:1px solid #ececec;box-shadow:var(--shadow-sm);overflow:hidden;margin-bottom:0;}
    .card-section-label{font-family:'Montserrat',sans-serif;font-size:.6rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:var(--orange);margin-bottom:12px;display:flex;align-items:center;gap:8px;}
    .card-section-label::after{content:'';flex:1;height:1px;background:linear-gradient(to right,rgba(255,122,0,.2),transparent);}

    .event-card-header{background:linear-gradient(135deg,var(--charcoal) 0%,#2d2d2d 100%);padding:24px;position:relative;overflow:hidden;}
    .event-card-header::before{content:'';position:absolute;top:-30px;right:-30px;width:100px;height:100px;border-radius:50%;background:rgba(255,122,0,.12);}
    .event-date-label{font-family:'Montserrat',sans-serif;font-size:.6rem;font-weight:800;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,.4);margin-bottom:4px;}
    .event-date-value{font-family:'Montserrat',sans-serif;font-size:1.25rem;font-weight:900;color:white;margin-bottom:14px;}
    .event-card-body{padding:20px;}

    .info-row{display:flex;align-items:flex-start;gap:12px;margin-bottom:13px;}
    .info-row:last-child{margin-bottom:0;}
    .info-icon{width:34px;height:34px;border-radius:10px;flex-shrink:0;background:#fff4e8;display:flex;align-items:center;justify-content:center;color:var(--orange);font-size:.9rem;}
    .info-label{font-size:.62rem;color:var(--gray-500);font-weight:600;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:.8px;margin-bottom:2px;}
    .info-value{font-size:.88rem;font-weight:600;color:var(--charcoal);word-break:break-word;}

    .pkg-menu-banner{background:linear-gradient(135deg,#fff8f0,#fff4e6);border:1.5px solid rgba(255,122,0,.25);border-radius:var(--radius-sm);padding:14px 16px;margin-bottom:14px;}
    .pmb-label{font-family:'Montserrat',sans-serif;font-size:.58rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:var(--orange);margin-bottom:8px;display:flex;align-items:center;gap:6px;}
    .pmb-name{font-family:'Montserrat',sans-serif;font-size:.9rem;font-weight:900;color:var(--charcoal);margin-bottom:2px;}
    .pmb-price{font-size:.75rem;font-weight:700;color:var(--orange);}
    .pmb-addons-title{font-family:'Montserrat',sans-serif;font-size:.58rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:var(--gray-500);margin:10px 0 6px;}
    .pmb-addon-item{display:flex;align-items:center;gap:6px;font-size:.75rem;color:#555;margin-bottom:3px;}
    .pmb-addon-item i{color:var(--green);font-size:.7rem;flex-shrink:0;}

    .stat-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;}
    .stat-box{background:var(--gray-50);border-radius:var(--radius-sm);border:1.5px solid #ececec;padding:13px 14px;text-align:center;}
    .stat-box-val{font-family:'Montserrat',sans-serif;font-size:1.3rem;font-weight:900;color:var(--orange);line-height:1;margin-bottom:3px;}
    .stat-box-lbl{font-size:.62rem;color:var(--gray-500);font-weight:700;text-transform:uppercase;letter-spacing:.5px;}

    .participant-item{display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--gray-100);}
    .participant-item:last-child{border-bottom:none;padding-bottom:0;}
    .participant-avatar{width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.9rem;color:white;flex-shrink:0;}
    .participant-info .p-role{font-size:.62rem;color:var(--gray-500);text-transform:uppercase;letter-spacing:.8px;font-weight:700;font-family:'Montserrat',sans-serif;}
    .participant-info .p-name{font-size:.88rem;font-weight:700;color:var(--charcoal);}

    .chat-card{display:flex;flex-direction:column;height:80vh;}
    .chat-header{padding:18px 22px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;}
    .chat-header-title{font-family:'Montserrat',sans-serif;font-size:.85rem;font-weight:900;text-transform:uppercase;letter-spacing:-.3px;color:var(--charcoal);}
    .chat-header-sub{font-size:.7rem;color:var(--gray-500);margin-top:1px;}
    .chat-online{display:flex;align-items:center;gap:5px;font-size:.7rem;color:var(--green);font-weight:600;}
    .chat-online-dot{width:7px;height:7px;border-radius:50%;background:var(--green);}
    .chat-window{flex:1;overflow-y:auto;padding:22px;background:#fff;background-image:radial-gradient(rgba(255,122,0,.04) 1px,transparent 1px);background-size:22px 22px;}
    .chat-window::-webkit-scrollbar{width:4px;}
    .chat-window::-webkit-scrollbar-thumb{background:var(--gray-300);border-radius:4px;}
    .msg-group{display:flex;flex-direction:column;gap:14px;}
    .msg-row{display:flex;}
    .msg-row.sent{justify-content:flex-end;}
    .msg-row.received{justify-content:flex-start;}
    .msg-wrap{max-width:78%;}
    .msg-bubble{padding:12px 17px;font-size:.9rem;line-height:1.55;word-break:break-word;}
    .msg-bubble.sent{background:linear-gradient(135deg,var(--orange),var(--orange-lt));color:white;border-radius:18px 18px 4px 18px;box-shadow:0 4px 14px rgba(255,122,0,.22);}
    .msg-bubble.received{background:var(--gray-100);color:var(--charcoal);border-radius:18px 18px 18px 4px;border:1px solid #e8e8e8;}
    .msg-time{font-size:.62rem;color:var(--gray-500);margin-top:4px;font-weight:500;}
    .msg-row.sent .msg-time{text-align:right;}
    .msg-row.received .msg-time{text-align:left;}
    .chat-empty{text-align:center;padding:50px 20px;}
    .chat-empty i{font-size:2.8rem;color:var(--orange);opacity:.2;display:block;margin-bottom:12px;}
    .chat-empty h6{font-family:'Montserrat',sans-serif;font-weight:800;font-size:.85rem;text-transform:uppercase;color:var(--gray-500);margin-bottom:6px;}
    .chat-empty p{font-size:.8rem;color:var(--gray-500);max-width:260px;margin:0 auto;line-height:1.55;}
    .chat-footer{padding:16px 20px;border-top:1px solid var(--gray-100);flex-shrink:0;background:white;}
    .chat-input-row{display:flex;align-items:center;gap:10px;background:var(--gray-100);border-radius:50px;padding:6px 6px 6px 18px;border:1.5px solid transparent;transition:border-color .2s;}
    .chat-input-row:focus-within{border-color:var(--orange);background:white;}
    .chat-input{flex:1;background:transparent;border:none;outline:none;font-size:.9rem;font-family:'Inter',sans-serif;color:var(--charcoal);padding:8px 0;}
    .chat-input::placeholder{color:#bbb;}
    .chat-send{width:40px;height:40px;border-radius:50%;background:var(--orange);border:none;color:white;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .2s;font-size:.95rem;}
    .chat-send:hover{background:var(--charcoal);transform:scale(1.05);}

    .customer-col{position:sticky;top:82px;}
    .customer-card{border-radius:var(--radius-lg);overflow:hidden;border:1px solid #ececec;box-shadow:var(--shadow-sm);}
    .customer-hero{background:linear-gradient(135deg,var(--charcoal) 0%,#2d2d2d 100%);padding:24px 20px 20px;text-align:center;position:relative;overflow:hidden;}
    .customer-hero::before{content:'';position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200"><defs><pattern id="d" x="0" y="0" width="30" height="30" patternUnits="userSpaceOnUse"><circle cx="15" cy="15" r="1.5" fill="rgba(255,255,255,0.06)"/></pattern></defs><rect width="400" height="200" fill="url(%23d)"/></svg>');pointer-events:none;}
    .customer-avatar-fallback{width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,var(--orange),var(--orange-lt));display:flex;align-items:center;justify-content:center;font-family:'Montserrat',sans-serif;font-size:1.6rem;font-weight:900;color:white;border:3px solid rgba(255,122,0,.5);box-shadow:0 0 0 4px rgba(255,122,0,.12);margin:0 auto;}
    .customer-name{font-family:'Montserrat',sans-serif;font-size:.95rem;font-weight:900;color:white;margin-bottom:2px;position:relative;z-index:1;}
    .customer-username{font-size:.72rem;color:rgba(255,255,255,.45);position:relative;z-index:1;margin-bottom:10px;}
    .customer-since{display:inline-flex;align-items:center;gap:5px;background:rgba(255,122,0,.15);border:1px solid rgba(255,122,0,.3);color:var(--orange);border-radius:20px;padding:4px 12px;font-size:.65rem;font-weight:700;font-family:'Montserrat',sans-serif;position:relative;z-index:1;}
    .customer-info-section{padding:16px 18px;border-bottom:1px solid var(--gray-100);background:white;}
    .customer-info-section:last-child{border-bottom:none;}
    .cis-title{font-family:'Montserrat',sans-serif;font-size:.6rem;font-weight:800;text-transform:uppercase;letter-spacing:1.4px;color:var(--orange);margin-bottom:12px;display:flex;align-items:center;gap:7px;}
    .cis-title::after{content:'';flex:1;height:1px;background:linear-gradient(to right,rgba(255,122,0,.2),transparent);}
    .cinfo-row{display:flex;align-items:flex-start;gap:10px;margin-bottom:11px;}
    .cinfo-row:last-child{margin-bottom:0;}
    .cinfo-icon{width:30px;height:30px;border-radius:8px;flex-shrink:0;background:#fff4e8;display:flex;align-items:center;justify-content:center;color:var(--orange);font-size:.8rem;}
    .cinfo-label{font-size:.6rem;color:var(--gray-500);font-weight:600;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:.7px;margin-bottom:1px;}
    .cinfo-value{font-size:.82rem;font-weight:600;color:var(--charcoal);word-break:break-word;}
    .history-stats{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;}
    .hstat{background:var(--gray-50);border-radius:10px;padding:10px 12px;text-align:center;}
    .hstat-num{font-family:'Montserrat',sans-serif;font-size:1.2rem;font-weight:900;color:var(--orange);line-height:1;margin-bottom:3px;}
    .hstat-lbl{font-size:.6rem;color:var(--gray-500);font-weight:700;text-transform:uppercase;letter-spacing:.4px;}
    .past-item{display:flex;align-items:center;gap:9px;padding:7px 0;border-bottom:1px solid #f5f5f5;}
    .past-item:last-child{border-bottom:none;}
    .past-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}
    .past-dot.completed{background:var(--green);}.past-dot.rejected{background:var(--red);}.past-dot.confirmed{background:var(--blue);}.past-dot.pending{background:#f39c12;}.past-dot.paid{background:#059669;}.past-dot.awaiting_payment{background:#2563eb;}
    .past-date{font-size:.78rem;font-weight:600;color:var(--charcoal);}
    .past-pax{font-size:.68rem;color:var(--gray-500);}
    .past-status{font-size:.62rem;font-weight:800;font-family:'Montserrat',sans-serif;text-transform:uppercase;margin-left:auto;flex-shrink:0;}
    .past-status.completed{color:var(--green);}.past-status.rejected{color:var(--red);}.past-status.confirmed{color:var(--blue);}.past-status.pending{color:#f39c12;}.past-status.paid{color:#059669;}.past-status.awaiting_payment{color:#2563eb;}
    .review-item{background:var(--gray-50);border-radius:10px;padding:11px 13px;margin-bottom:8px;}
    .review-item:last-child{margin-bottom:0;}
    .review-stars i{font-size:.68rem;color:#f39c12;}
    .review-text{font-size:.78rem;color:#444;line-height:1.5;font-style:italic;margin-top:5px;}
    .review-meta{font-size:.62rem;color:var(--gray-500);margin-top:4px;font-weight:600;}
    .no-data{text-align:center;padding:14px;color:#ccc;font-size:.78rem;}
    .no-data i{display:block;font-size:1.4rem;margin-bottom:5px;}

    .modal-content{border-radius:var(--radius-lg);border:none;box-shadow:0 20px 60px rgba(0,0,0,.2);}
    .modal-header{border-bottom:1px solid var(--gray-100);padding:22px 26px 18px;}
    .modal-body{padding:20px 26px;}
    .modal-footer{border-top:1px solid var(--gray-100);padding:16px 26px;}
    .modal-title{font-family:'Montserrat',sans-serif;font-weight:900;font-size:1rem;}

    .payment-method-option:has(input:checked){border-color:#0066cc !important;background:#e8f4ff !important;}
</style>

@php
    $selectedPkg = $booking->package ?? null;

    $rawIds = $booking->selected_menu_ids;
    if (is_array($rawIds)) {
        $selectedMenuIds = $rawIds;
    } elseif (is_string($rawIds) && str_contains($rawIds, ',')) {
        $selectedMenuIds = array_filter(explode(',', $rawIds));
    } elseif (is_string($rawIds) && !empty($rawIds)) {
        $selectedMenuIds = json_decode($rawIds, true) ?? [];
    } elseif (is_int($rawIds) || is_numeric($rawIds)) {
        $selectedMenuIds = [$rawIds];
    } else {
        $selectedMenuIds = [];
    }
    $selectedMenuIds = array_map('intval', (array) $selectedMenuIds);

    $selectedMenus  = count($selectedMenuIds) > 0
                        ? $booking->catererProfile->menus->whereIn('id', $selectedMenuIds)
                        : collect();

    $pricePerGuest  = $selectedPkg ? ($selectedPkg->price_per_guest ?? 0) : 0;
    $packageTotal   = $booking->pax * $pricePerGuest;
    $addonsTotal    = $selectedMenus->sum('price');
    $estimatedTotal = $booking->estimated_total ?: ($packageTotal + $addonsTotal);

    $methodIcons = [
        'gcash'           => ['icon' => 'bi-phone-fill',       'color' => '#0066cc', 'label' => 'GCash'],
        'maya'            => ['icon' => 'bi-phone-fill',       'color' => '#00a651', 'label' => 'Maya'],
        'bank_transfer'   => ['icon' => 'bi-bank',             'color' => '#1a1a1a', 'label' => 'Bank Transfer'],
        'credit_card'     => ['icon' => 'bi-credit-card-fill', 'color' => '#e74c3c', 'label' => 'Credit Card'],
        'cash'            => ['icon' => 'bi-cash-coin',        'color' => '#f39c12', 'label' => 'Cash'],
        'online_transfer' => ['icon' => 'bi-arrow-left-right', 'color' => '#2196F3', 'label' => 'Online Transfer'],
    ];
@endphp

{{-- ═══════════ TOP BAR ═══════════ --}}
<div class="page-topbar">
    <div class="topbar-left">
        <a href="{{ url('/dashboard') }}" class="topbar-back"><i class="bi bi-arrow-left"></i></a>
        <div>
            <div class="topbar-title">Event <span>Collaboration</span></div>
            <div class="topbar-ref">#BKG-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>
    <div class="topbar-actions">
        @php $sc = $booking->status_color; @endphp
        <span class="status-badge" style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};border:1px solid {{ $sc['text'] }}25;">
            <i class="bi bi-{{ $sc['icon'] }}"></i> {{ $booking->status_label }}
        </span>

        @if($isCaterer && $booking->status === 'pending')
            <button type="button" class="btn-confirm" data-bs-toggle="modal" data-bs-target="#confirmModal"><i class="bi bi-check-circle-fill"></i> Confirm Booking</button>
            <button type="button" class="btn-reject" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="bi bi-x-circle-fill"></i> Reject</button>
        @endif

        @if($isCaterer && $booking->status === 'paid')
            <form action="{{ route('bookings.update', $booking->id) }}" method="POST" style="margin:0;">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="completed">
                <button type="submit" class="btn-complete" onclick="return confirm('Mark this event as completed?')"><i class="bi bi-patch-check-fill"></i> Mark Complete</button>
            </form>
        @endif

        @if($isCaterer && $booking->status === 'awaiting_payment')
            <span style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:50px;background:#dbeafe;color:#2563eb;font-family:'Montserrat',sans-serif;font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;">
                <i class="bi bi-receipt"></i> Payment Receipt to Review
            </span>
        @endif

        @if($isCustomer && in_array($booking->status, ['pending', 'confirmed']))
            <button type="button" class="btn-reject" onclick="if(confirm('Are you sure you want to cancel this booking?')) document.getElementById('cancelBookingForm').submit()">
                <i class="bi bi-x-circle-fill"></i> Cancel Booking
            </button>
            <form id="cancelBookingForm" action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display:none;">
                @csrf @method('PATCH')
                <input type="hidden" name="cancellation_reason" value="Cancelled by customer">
            </form>
        @endif
    </div>
</div>

<div class="page-body">

    {{-- ═══════════ PROGRESS TRACKER ═══════════ --}}
    <div style="background:white;border-radius:16px;padding:20px 24px;margin-bottom:22px;box-shadow:var(--shadow-sm);">
        @php
            $steps = [
                ['key'=>'pending',           'label'=>'Inquiry',   'icon'=>'bi-send-fill'],
                ['key'=>'confirmed',          'label'=>'Confirmed', 'icon'=>'bi-check-circle-fill'],
                ['key'=>'awaiting_payment',   'label'=>'Payment',   'icon'=>'bi-credit-card-fill'],
                ['key'=>'paid',               'label'=>'Secured',   'icon'=>'bi-patch-check-fill'],
                ['key'=>'completed',          'label'=>'Completed', 'icon'=>'bi-trophy-fill'],
            ];
            $statusOrder = ['pending'=>0,'confirmed'=>1,'awaiting_payment'=>2,'paid'=>3,'completed'=>4];
            $currentIndex = $statusOrder[$booking->status] ?? -1;
            $isCancelledOrRejected = in_array($booking->status, ['cancelled','rejected']);
        @endphp
        @if(!$isCancelledOrRejected)
            <div style="display:flex;justify-content:space-between;align-items:flex-start;position:relative;">
                <div style="position:absolute;top:18px;left:40px;right:40px;height:3px;background:#e5e7eb;z-index:0;"></div>
                @if($currentIndex >= 0)
                    @php $pct = $currentIndex / (count($steps) - 1) * 100; @endphp
                    <div style="position:absolute;top:18px;left:40px;height:3px;background:#FF7A00;z-index:1;width:calc({{ $pct }}% - 40px);"></div>
                @endif
                @foreach($steps as $i => $step)
                    @php $isDone=$currentIndex>$i; $isCurrent=$currentIndex===$i; $bg=$isDone||$isCurrent?'#FF7A00':'#e5e7eb'; $tc=$isDone||$isCurrent?'#1a1a1a':'#9ca3af'; $ic=$isDone||$isCurrent?'white':'#9ca3af'; @endphp
                    <div style="flex:1;text-align:center;position:relative;z-index:2;">
                        <div style="width:36px;height:36px;border-radius:50%;background:{{ $bg }};display:flex;align-items:center;justify-content:center;margin:0 auto 6px;border:3px solid white;box-shadow:0 2px 6px rgba(0,0,0,.1);">
                            @if($isDone)<i class="bi bi-check-lg" style="color:white;font-size:.85rem;"></i>@else<i class="bi {{ $step['icon'] }}" style="color:{{ $ic }};font-size:.75rem;"></i>@endif
                        </div>
                        <div style="font-family:'Montserrat',sans-serif;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;color:{{ $tc }};">{{ $step['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align:center;padding:10px 0;">
                <span style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;border-radius:50px;font-family:'Montserrat',sans-serif;font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;background:{{ $sc['bg'] }};color:{{ $sc['text'] }};"><i class="bi bi-{{ $sc['icon'] }}"></i> {{ $booking->status_label }}</span>
            </div>
        @endif
    </div>

    <div class="booking-layout">

        {{-- ═══════════ LEFT — EVENT SUMMARY ═══════════ --}}
        <div style="position:sticky;top:82px;">
            <div class="card">
                <div class="event-card-header">
                    <div class="event-date-label">Event Date</div>
                    <div class="event-date-value">{{ \Carbon\Carbon::parse($booking->event_date)->format('F d, Y') }}</div>
                    @if($booking->event_time)
                        <div style="font-size:.75rem;color:rgba(255,255,255,.55);font-weight:600;margin-top:-8px;margin-bottom:12px;"><i class="bi bi-clock" style="color:var(--orange);margin-right:4px;"></i>{{ $booking->formatted_time }}</div>
                    @endif
                    @if($booking->event_type)
                        <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,122,0,.15);border:1px solid rgba(255,122,0,.3);color:var(--orange);border-radius:20px;padding:4px 12px;font-size:.65rem;font-weight:800;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:.5px;"><i class="bi bi-star-fill" style="font-size:.55rem;"></i> {{ $booking->event_type_label }}</span>
                    @endif
                </div>

                <div class="event-card-body">

                    {{-- Package & Menu --}}
                    @if($selectedPkg || $selectedMenus->count() > 0)
                        <div class="pkg-menu-banner">
                            @if($selectedPkg)
                                <div class="pmb-label"><i class="bi bi-box-seam-fill"></i> Selected Package</div>
                                <div class="pmb-name">{{ $selectedPkg->name }}</div>
                                <div class="pmb-price">₱{{ number_format($selectedPkg->price_per_guest, 0) }} / guest · {{ $booking->pax }} guests · <strong style="color:var(--charcoal);">₱{{ number_format($packageTotal, 0) }}</strong></div>
                            @endif
                            @if($selectedMenus->count() > 0)
                                <div class="pmb-addons-title">Menu Add-ons ({{ $selectedMenus->count() }})</div>
                                @foreach($selectedMenus as $menuItem)
                                    <div class="pmb-addon-item"><i class="bi bi-check-circle-fill"></i><span>{{ $menuItem->name }}</span><span style="margin-left:auto;font-weight:700;color:var(--orange);">₱{{ number_format($menuItem->price, 0) }}</span></div>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    <div class="stat-row">
                        <div class="stat-box"><div class="stat-box-val">{{ $booking->pax }}</div><div class="stat-box-lbl">Guests</div></div>
                        <div class="stat-box"><div class="stat-box-val" style="font-size:1rem;">₱{{ number_format($estimatedTotal, 0) }}</div><div class="stat-box-lbl">Est. Total</div></div>
                    </div>

                    @if($booking->event_location)
                        <div class="info-row"><div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div><div class="info-content"><div class="info-label">Venue</div><div class="info-value">{{ $booking->event_location }}</div></div></div>
                    @endif
                    @if($booking->dietary_requirements)
                        <div class="info-row"><div class="info-icon"><i class="bi bi-egg-fried"></i></div><div class="info-content"><div class="info-label">Dietary</div><div class="info-value">{{ $booking->dietary_requirements }}</div></div></div>
                    @endif
                    @if($booking->notes)
                        <div class="info-row"><div class="info-icon"><i class="bi bi-chat-left-text-fill"></i></div><div class="info-content"><div class="info-label">Notes</div><div class="info-value" style="font-size:.82rem;">{{ $booking->notes }}</div></div></div>
                    @endif
                    @if($booking->rejection_reason)
                        <div style="background:#fef2f2;border-left:3px solid var(--red);border-radius:0 8px 8px 0;padding:10px 13px;margin-top:10px;font-size:.78rem;color:var(--red);"><i class="bi bi-x-circle-fill" style="margin-right:5px;"></i><strong>Reason:</strong> {{ $booking->rejection_reason }}</div>
                    @endif

                    {{-- ═══════════ PAYMENT SECTION ═══════════ --}}
                    @if(in_array($booking->status, ['confirmed','awaiting_payment','paid','completed','cancelled']))
                    <div style="margin-top:18px;">
                        <div class="card-section-label"><i class="bi bi-credit-card-2-front-fill"></i> Payment Status</div>

                        @php $pColor = $booking->payment_status_color; @endphp
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px;">
                            <span style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:50px;font-size:.72rem;font-weight:800;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:.5px;background:{{ $pColor['bg'] }};color:{{ $pColor['text'] }};">
                                <i class="bi bi-@if($booking->payment_status==='verified')patch-check-fill @elseif($booking->payment_status==='submitted')hourglass-split @elseif($booking->payment_status==='rejected')x-circle-fill @else wallet2 @endif"></i>
                                {{ $booking->payment_status_label }}
                            </span>
                            @if($booking->downpayment_amount)
                                <span style="font-family:'Montserrat',sans-serif;font-size:1rem;font-weight:900;color:var(--orange);">₱{{ number_format($booking->downpayment_amount, 2) }}</span>
                            @endif
                        </div>

                        {{-- Deadline countdown --}}
                        @if(in_array($booking->status, ['confirmed']) && $booking->downpayment_deadline && $booking->payment_status !== 'verified')
                            @php $daysLeft = $booking->days_until_deadline; @endphp
                            <div style="padding:12px 16px;border-radius:10px;margin-bottom:14px;display:flex;align-items:center;gap:10px;background:{{ $daysLeft!==null&&$daysLeft<=2?'#fef2f2':($daysLeft!==null&&$daysLeft<=5?'#fffbeb':'#f0f9ff') }};border-left:4px solid {{ $daysLeft!==null&&$daysLeft<=2?'var(--red)':($daysLeft!==null&&$daysLeft<=5?'#f59e0b':'var(--blue)') }};">
                                <i class="bi bi-clock-history" style="font-size:1.2rem;color:{{ $daysLeft!==null&&$daysLeft<=2?'var(--red)':'#f59e0b' }};flex-shrink:0;"></i>
                                <div>
                                    <div style="font-family:'Montserrat',sans-serif;font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;color:{{ $daysLeft!==null&&$daysLeft<=2?'var(--red)':'#92400e' }};margin-bottom:2px;">
                                        @if($daysLeft!==null&&$daysLeft<0) Deadline Passed @elseif($daysLeft===0) Due Today @elseif($daysLeft===1) Due Tomorrow @else {{ $daysLeft }} Days Remaining @endif
                                    </div>
                                    <div style="font-size:.78rem;color:#555;">Deadline: <strong>{{ $booking->downpayment_deadline->format('M d, Y') }}</strong></div>
                                </div>
                            </div>
                        @endif

                        {{-- Verified success --}}
                        @if($booking->payment_status === 'verified')
                            <div style="background:#d1fae5;border:1px solid rgba(16,185,129,.3);border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                                <i class="bi bi-patch-check-fill" style="color:#059669;font-size:1.3rem;flex-shrink:0;"></i>
                                <div>
                                    <div style="font-family:'Montserrat',sans-serif;font-size:.75rem;font-weight:800;color:#065f46;">Payment Confirmed</div>
                                    <div style="font-size:.72rem;color:#047857;">Verified on {{ $booking->payment_verified_at ? $booking->payment_verified_at->format('M d, Y \a\t g:i A') : '—' }} @if($booking->payment_method_used) via <strong>{{ ucfirst(str_replace('_',' ',$booking->payment_method_used)) }}</strong>@endif</div>
                                </div>
                            </div>
                        @endif

                        {{-- Rejected warning --}}
                        @if($booking->payment_status === 'rejected' && $booking->payment_rejection_reason)
                            <div style="background:#fef2f2;border-left:3px solid var(--red);border-radius:0 10px 10px 0;padding:12px 14px;margin-bottom:14px;">
                                <div style="font-family:'Montserrat',sans-serif;font-size:.68rem;font-weight:800;color:var(--red);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;"><i class="bi bi-exclamation-triangle-fill me-1"></i> Receipt Rejected</div>
                                <div style="font-size:.78rem;color:#b91c1c;line-height:1.5;">{{ $booking->payment_rejection_reason }}</div>
                                @if($isCustomer)<div style="font-size:.72rem;color:#888;margin-top:6px;">Please upload a new receipt below.</div>@endif
                            </div>
                        @endif

                        {{-- Auto-cancelled notice --}}
                        @if($booking->cancellation_type === 'auto_deadline')
                            <div style="background:#fef2f2;border:1px solid rgba(220,38,38,.2);border-radius:10px;padding:14px 16px;display:flex;align-items:flex-start;gap:10px;">
                                <i class="bi bi-clock-fill" style="color:#dc2626;font-size:1.1rem;flex-shrink:0;margin-top:1px;"></i>
                                <div>
                                    <div style="font-family:'Montserrat',sans-serif;font-size:.72rem;font-weight:800;color:#dc2626;text-transform:uppercase;">Auto-Cancelled</div>
                                    <div style="font-size:.78rem;color:#b91c1c;line-height:1.5;margin-top:2px;">This booking was automatically cancelled because the 50% downpayment was not received before the deadline.</div>
                                </div>
                            </div>
                        @endif

                        {{-- ─── CUSTOMER: Show GCash details + upload receipt ─── --}}
                        @if($isCustomer && $booking->status === 'confirmed' && in_array($booking->payment_status, ['unpaid','rejected']) && !$booking->isDeadlinePassed())

                            {{-- GCash details from caterer --}}
                            @if($booking->catererProfile->gcash_number || $booking->catererProfile->gcash_qr_path)
                            <div style="margin-top:14px;padding:18px 20px;background:linear-gradient(135deg,#e8f4ff,#dceeff);border:2px solid rgba(0,102,204,.2);border-radius:14px;margin-bottom:14px;">
                                <div style="font-family:'Montserrat',sans-serif;font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#0066cc;margin-bottom:14px;display:flex;align-items:center;gap:6px;">
                                    <i class="bi bi-phone-fill"></i> Pay via GCash
                                </div>

                                {{-- Downpayment amount reminder --}}
                                @if($booking->downpayment_amount)
                                <div style="background:white;border-radius:10px;padding:10px 14px;margin-bottom:12px;border:1.5px solid rgba(0,102,204,.15);display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-size:.72rem;font-weight:700;color:#666;"><i class="bi bi-info-circle" style="color:#0066cc;margin-right:4px;"></i> Amount to send (50% downpayment)</span>
                                    <span style="font-family:'Montserrat',sans-serif;font-size:1.05rem;font-weight:900;color:#0066cc;">₱{{ number_format($booking->downpayment_amount, 2) }}</span>
                                </div>
                                @endif

                                @if($booking->catererProfile->gcash_number)
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;background:white;border-radius:10px;padding:12px 14px;border:1.5px solid rgba(0,102,204,.15);">
                                    <div style="width:36px;height:36px;border-radius:9px;background:#0066cc;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-phone-fill" style="color:white;font-size:.9rem;"></i>
                                    </div>
                                    <div style="flex:1;">
                                        <div style="font-size:.6rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.8px;">GCash Number</div>
                                        <div style="font-family:'Montserrat',sans-serif;font-size:1.05rem;font-weight:900;color:#0066cc;letter-spacing:.5px;">+63 {{ $booking->catererProfile->gcash_number }}</div>
                                        <div style="font-size:.68rem;color:#555;margin-top:1px;">{{ $booking->catererProfile->business_name }}</div>
                                    </div>
                                    <button type="button" id="copyGcashBtn"
                                        onclick="navigator.clipboard.writeText('{{ $booking->catererProfile->gcash_number }}').then(()=>{ var b=document.getElementById('copyGcashBtn'); b.innerHTML='<i class=\'bi bi-check-lg\'></i>'; b.style.background='#d1fae5'; b.style.color='#059669'; setTimeout(()=>{ b.innerHTML='<i class=\'bi bi-clipboard\'></i>'; b.style.background='#e8f4ff'; b.style.color='#0066cc'; },2000); })"
                                        style="width:36px;height:36px;border-radius:8px;background:#e8f4ff;border:1.5px solid rgba(0,102,204,.2);color:#0066cc;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;transition:all .2s;">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                                @endif

                                @if($booking->catererProfile->gcash_qr_path)
                                <div style="text-align:center;">
                                    <div style="font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#0066cc;margin-bottom:8px;opacity:.7;">Scan QR Code to Pay</div>
                                    <img src="{{ asset('storage/' . $booking->catererProfile->gcash_qr_path) }}"
                                         style="max-width:180px;border-radius:14px;border:2px solid rgba(0,102,204,.2);box-shadow:0 4px 16px rgba(0,102,204,.12);"
                                         alt="GCash QR Code">
                                </div>
                                @endif
                            </div>
                            @endif

                            {{-- Upload receipt --}}
                            <div style="padding:18px 20px;background:linear-gradient(135deg,#fffbf5,#fff8f0);border:2px solid rgba(255,122,0,.2);border-radius:14px;">
                                <div style="font-family:'Montserrat',sans-serif;font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:var(--orange);margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                                    <i class="bi bi-upload"></i> Upload Proof of Payment
                                </div>
                                <form action="{{ route('bookings.uploadPayment', $booking->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- GCash is the only method so pre-fill it --}}
                                    <input type="hidden" name="payment_method_used" value="gcash">
                                    <div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:white;border:2px solid rgba(0,102,204,.25);border-radius:10px;margin-bottom:14px;">
                                        <div style="width:28px;height:28px;border-radius:6px;background:#0066cc;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-phone-fill" style="color:white;font-size:.75rem;"></i></div>
                                        <span style="font-size:.82rem;font-weight:700;color:#1a1a1a;">Paying via GCash</span>
                                        <i class="bi bi-check-circle-fill" style="color:#0066cc;margin-left:auto;"></i>
                                    </div>
                                    <div style="margin-bottom:14px;">
                                        <label style="display:block;font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#1a1a1a;margin-bottom:8px;">Payment Screenshot <span style="color:#e74c3c;">*</span></label>
                                        <input type="file" name="payment_receipt" accept=".jpg,.jpeg,.png" required
                                               style="width:100%;background:#f5f5f5;border:2px dashed #d0d0d0;border-radius:10px;padding:12px 14px;font-size:.85rem;cursor:pointer;">
                                        <div style="font-size:.65rem;color:#888;margin-top:5px;"><i class="bi bi-info-circle-fill" style="color:var(--orange);"></i> JPG/PNG only, max 5MB.</div>
                                    </div>
                                    <button type="submit"
                                            style="width:100%;background:var(--orange);color:white;border:none;border-radius:10px;padding:13px;font-family:'Montserrat',sans-serif;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;cursor:pointer;box-shadow:0 4px 14px rgba(255,122,0,.3);"
                                            onmouseover="this.style.background='#1a1a1a'" onmouseout="this.style.background='#FF7A00'">
                                        <i class="bi bi-send-fill me-2"></i> Submit Payment Receipt
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- CUSTOMER: Waiting for verification --}}
                        @if($isCustomer && $booking->status === 'awaiting_payment' && $booking->payment_status === 'submitted')
                            <div style="margin-top:14px;padding:14px 16px;background:#eff6ff;border:1px solid rgba(59,130,246,.2);border-radius:10px;display:flex;align-items:center;gap:10px;">
                                <i class="bi bi-hourglass-split" style="color:#2563eb;font-size:1.1rem;flex-shrink:0;"></i>
                                <div>
                                    <div style="font-family:'Montserrat',sans-serif;font-size:.72rem;font-weight:800;color:#1e40af;">Awaiting Verification</div>
                                    <div style="font-size:.75rem;color:#3b82f6;">Your receipt has been submitted. The caterer will verify shortly.</div>
                                </div>
                            </div>
                            @if($booking->payment_receipt_path)
                                <div style="margin-top:10px;text-align:center;">
                                    <a href="{{ asset('storage/' . $booking->payment_receipt_path) }}" target="_blank"
                                       style="display:inline-flex;align-items:center;gap:6px;font-size:.75rem;font-weight:700;color:var(--orange);text-decoration:none;">
                                        <i class="bi bi-image"></i> View Submitted Receipt
                                    </a>
                                </div>
                            @endif
                        @endif

                        {{-- CATERER: Verify/reject receipt --}}
                        @if($isCaterer && $booking->status === 'awaiting_payment' && $booking->payment_status === 'submitted')
                            <div style="margin-top:14px;padding:18px 20px;background:linear-gradient(135deg,#f0f7ff,#e8f2ff);border:2px solid rgba(59,130,246,.25);border-radius:14px;">
                                <div style="font-family:'Montserrat',sans-serif;font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#2563eb;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                                    <i class="bi bi-shield-check"></i> Verify Customer Payment
                                </div>
                                @if($booking->payment_receipt_path)
                                    <div style="margin-bottom:14px;text-align:center;">
                                        <div style="font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#888;margin-bottom:8px;">Submitted Receipt</div>
                                        <a href="{{ asset('storage/' . $booking->payment_receipt_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $booking->payment_receipt_path) }}"
                                                 style="max-width:100%;max-height:300px;border-radius:10px;border:2px solid #e0e0e0;cursor:zoom-in;object-fit:contain;" alt="Receipt">
                                        </a>
                                        <div style="font-size:.68rem;color:#888;margin-top:6px;">
                                            Method: <strong style="color:#1a1a1a;">{{ ucfirst(str_replace('_',' ',$booking->payment_method_used ?? 'GCash')) }}</strong>
                                            · Amount: <strong style="color:var(--orange);">₱{{ number_format($booking->downpayment_amount ?? 0, 2) }}</strong>
                                        </div>
                                    </div>
                                @endif
                                <div style="display:flex;gap:10px;">
                                    <form action="{{ route('bookings.verifyPayment', $booking->id) }}" method="POST" style="flex:1;">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Confirm that you have received the downpayment?')"
                                                style="width:100%;padding:12px;border:none;border-radius:10px;background:#059669;color:white;font-family:'Montserrat',sans-serif;font-size:.75rem;font-weight:800;text-transform:uppercase;letter-spacing:.8px;cursor:pointer;box-shadow:0 4px 14px rgba(5,150,105,.3);">
                                            <i class="bi bi-check-circle-fill me-1"></i> Verify Payment
                                        </button>
                                    </form>
                                    <button type="button"
                                            onclick="var f=document.getElementById('rejectPaymentForm');f.style.display=f.style.display==='none'?'block':'none'"
                                            style="padding:12px 18px;border:2px solid rgba(220,38,38,.3);border-radius:10px;background:rgba(220,38,38,.05);color:#dc2626;font-family:'Montserrat',sans-serif;font-size:.75rem;font-weight:800;text-transform:uppercase;cursor:pointer;"
                                            onmouseover="this.style.background='#dc2626';this.style.color='white'"
                                            onmouseout="this.style.background='rgba(220,38,38,.05)';this.style.color='#dc2626'">
                                        <i class="bi bi-x-circle-fill me-1"></i> Reject
                                    </button>
                                </div>
                                <form action="{{ route('bookings.rejectPayment', $booking->id) }}" method="POST" id="rejectPaymentForm" style="display:none;margin-top:12px;">
                                    @csrf
                                    <textarea name="payment_rejection_reason" rows="2"
                                              style="width:100%;background:#fff5f5;border:1.5px solid rgba(220,38,38,.3);border-radius:8px;padding:10px 14px;font-size:.82rem;resize:none;margin-bottom:8px;"
                                              placeholder="Reason for rejection..." required></textarea>
                                    <button type="submit" style="width:100%;padding:10px;border:none;border-radius:8px;background:#dc2626;color:white;font-size:.75rem;font-weight:700;cursor:pointer;">
                                        Confirm Rejection
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- View receipt link (caterer, after verified) --}}
                        @if($isCaterer && $booking->payment_status === 'verified' && $booking->payment_receipt_path)
                            <div style="margin-top:10px;text-align:center;">
                                <a href="{{ asset('storage/' . $booking->payment_receipt_path) }}" target="_blank"
                                   style="display:inline-flex;align-items:center;gap:6px;font-size:.75rem;font-weight:700;color:#059669;text-decoration:none;">
                                    <i class="bi bi-image"></i> View Payment Receipt
                                </a>
                            </div>
                        @endif
                    </div>
                    @endif

                    {{-- Participants --}}
                    <div style="margin-top:18px;">
                        <div class="card-section-label"><i class="bi bi-people-fill"></i> Participants</div>
                        <div class="participant-item">
                            <div class="participant-avatar" style="background:var(--charcoal);">{{ strtoupper(substr($booking->user->name, 0, 1)) }}</div>
                            <div class="participant-info"><div class="p-role">Customer</div><div class="p-name">{{ $booking->user->name }}</div></div>
                        </div>
                        <div class="participant-item">
                            <div class="participant-avatar" style="background:var(--orange);">{{ strtoupper(substr($booking->catererProfile->business_name ?? 'C', 0, 1)) }}</div>
                            <div class="participant-info"><div class="p-role">Caterer</div><div class="p-name">{{ $booking->catererProfile->business_name ?? 'Business' }}</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════ MIDDLE — CHAT ═══════════ --}}
        <div class="card chat-card">
            <div class="chat-header">
                <div>
                    <div class="chat-header-title">Live Discussion</div>
                    <div class="chat-header-sub">All messages are saved and visible to both parties</div>
                </div>
                <div class="chat-online"><div class="chat-online-dot"></div> Secure Channel</div>
            </div>
            <div class="chat-window" id="chat-window">
                <div class="msg-group">
                    @forelse($booking->messages as $msg)
                        @php $isMine = $msg->sender_id === auth()->id(); @endphp
                        <div class="msg-row {{ $isMine ? 'sent' : 'received' }}">
                            <div class="msg-wrap">
                                <div class="msg-bubble {{ $isMine ? 'sent' : 'received' }}">{{ $msg->message }}</div>
                                <div class="msg-time">{{ $msg->created_at->format('h:i A') }}@if(!$isMine) · {{ $msg->sender->name ?? '' }}@endif</div>
                            </div>
                        </div>
                    @empty
                        <div class="chat-empty">
                            <i class="bi bi-chat-square-text"></i>
                            <h6>No messages yet</h6>
                            <p>Start the conversation — ask about the menu, venue setup, or any special requirements.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="chat-footer">
                <form action="{{ route('chat.store', $booking->id) }}" method="POST">
                    @csrf
                    <div class="chat-input-row">
                        <input type="text" name="message" class="chat-input" placeholder="Write a message…" required autocomplete="off">
                        <button type="submit" class="chat-send"><i class="bi bi-send-fill"></i></button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ═══════════ RIGHT — CUSTOMER PROFILE ═══════════ --}}
        @if($isCaterer)
        <div class="customer-col">
            <div class="customer-card">
                <div class="customer-hero">
                    <div style="position:relative;z-index:1;margin-bottom:12px;">
                        <div class="customer-avatar-fallback">{{ strtoupper(substr($booking->user->name, 0, 1)) }}</div>
                    </div>
                    <div class="customer-name">{{ $booking->user->name }}</div>
                    <div class="customer-username">{{ $booking->user->username ? '@'.$booking->user->username : '@'.strtolower(str_replace(' ','',$booking->user->name)) }}</div>
                    <div class="customer-since"><i class="bi bi-person-check-fill"></i> Member since {{ $booking->user->created_at->format('M Y') }}</div>
                </div>
                <div class="customer-info-section">
                    <div class="cis-title"><i class="bi bi-person-lines-fill"></i> Contact Info</div>
                    <div class="cinfo-row"><div class="cinfo-icon"><i class="bi bi-envelope-fill"></i></div><div><div class="cinfo-label">Email</div><div class="cinfo-value" style="font-size:.78rem;">{{ $booking->user->email }}</div></div></div>
                    <div class="cinfo-row"><div class="cinfo-icon"><i class="bi bi-geo-alt-fill"></i></div><div><div class="cinfo-label">Address</div><div class="cinfo-value" style="font-size:.78rem;">{{ $booking->user->address ?? 'Not provided' }}</div></div></div>
                </div>
                <div class="customer-info-section">
                    <div class="cis-title"><i class="bi bi-clock-history"></i> History With You</div>
                    <div class="history-stats">
                        <div class="hstat"><div class="hstat-num">{{ $customerStats['total_bookings'] }}</div><div class="hstat-lbl">Bookings</div></div>
                        <div class="hstat"><div class="hstat-num">{{ $customerStats['completed'] }}</div><div class="hstat-lbl">Completed</div></div>
                    </div>
                    @php $otherBookings = $pastBookings->where('id', '!=', $booking->id)->take(3); @endphp
                    @if($otherBookings->count() > 0)
                        @foreach($otherBookings as $past)
                            <div class="past-item">
                                <div class="past-dot {{ $past->status }}"></div>
                                <div style="flex:1;min-width:0;">
                                    <div class="past-date">{{ \Carbon\Carbon::parse($past->event_date)->format('M j, Y') }}</div>
                                    <div class="past-pax">{{ $past->pax }} guests</div>
                                </div>
                                <div class="past-status {{ $past->status }}">{{ ucfirst($past->status) }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-data"><i class="bi bi-calendar-x"></i> No other bookings.</div>
                    @endif
                </div>
                <div class="customer-info-section">
                    <div class="cis-title"><i class="bi bi-star-fill"></i> Reviews Left</div>
                    @if($customerReviews->count() > 0)
                        @foreach($customerReviews->take(2) as $review)
                            <div class="review-item">
                                <div class="review-stars">@for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$review->rating?'-fill':'' }}"></i>@endfor</div>
                                <div class="review-text">"{{ Str::limit($review->comment, 90) }}"</div>
                                <div class="review-meta">{{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-data"><i class="bi bi-chat-square-text"></i> No reviews yet.</div>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- ═══════════ CONFIRM MODAL ═══════════ --}}
{{-- FIX: Only render this modal if the viewer is a caterer with a valid profile --}}
@if($isCaterer && Auth::user()->catererProfile)
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:580px;">
        {{-- enctype needed for QR code image upload --}}
        <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="modal-content" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="confirmed">
            {{-- GCash is the only payment method --}}
            <input type="hidden" name="payment_methods[]" value="gcash">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2" style="color:#27ae60;"></i> Confirm Booking</h5>
                    <div style="font-size:.72rem;color:#888;margin-top:2px;">Set downpayment terms and your GCash details before confirming.</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" style="max-height:80vh;overflow-y:auto;">

                {{-- Booking Summary --}}
                <div style="background:#f9f9f9;border-radius:14px;padding:16px 18px;margin-bottom:20px;border:1px solid #ececec;">
                    <div style="font-family:'Montserrat',sans-serif;font-size:.6rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#FF7A00;margin-bottom:12px;"><i class="bi bi-clipboard-check"></i> Booking Summary</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <div style="background:white;border-radius:10px;padding:11px 13px;border:1px solid #ececec;"><div style="font-size:.6rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:3px;">Customer</div><div style="font-size:.88rem;font-weight:700;">{{ $booking->user->name }}</div></div>
                        <div style="background:white;border-radius:10px;padding:11px 13px;border:1px solid #ececec;"><div style="font-size:.6rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:3px;">Event Date</div><div style="font-size:.88rem;font-weight:700;color:#FF7A00;">{{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}</div></div>
                        <div style="background:white;border-radius:10px;padding:11px 13px;border:1px solid #ececec;"><div style="font-size:.6rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:3px;">Guests</div><div style="font-size:.88rem;font-weight:700;">{{ $booking->pax }} pax</div></div>
                        <div style="background:white;border-radius:10px;padding:11px 13px;border:1px solid #ececec;"><div style="font-size:.6rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:3px;">Est. Total</div><div style="font-size:.88rem;font-weight:700;">₱{{ number_format($estimatedTotal, 0) }}</div></div>
                    </div>
                </div>

                {{-- Downpayment Deadline --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-family:'Montserrat',sans-serif;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:#1a1a1a;margin-bottom:8px;">
                        <i class="bi bi-calendar-check" style="color:#FF7A00;margin-right:5px;"></i> Downpayment Deadline <span style="color:#e74c3c;">*</span>
                    </label>
                    <input type="date" name="downpayment_deadline" id="deadlineInput"
                           style="width:100%;background:#f5f5f5;border:2px solid transparent;border-radius:10px;padding:12px 16px;font-size:.9rem;font-family:'Inter',sans-serif;color:#1a1a1a;outline:none;"
                           onfocus="this.style.borderColor='#FF7A00';this.style.background='white'"
                           onblur="this.style.borderColor='transparent';this.style.background='#f5f5f5'"
                           min="{{ \Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}"
                           max="{{ \Carbon\Carbon::parse($booking->event_date)->subDays(7)->format('Y-m-d') }}"
                           required>
                    <div style="font-size:.68rem;color:#888;margin-top:5px;">
                        <i class="bi bi-info-circle" style="color:#FF7A00;"></i>
                        Must be at least 7 days before event (<strong>{{ \Carbon\Carbon::parse($booking->event_date)->subDays(7)->format('M d, Y') }}</strong> latest).
                    </div>
                </div>

                {{-- Payment Method: GCash only --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-family:'Montserrat',sans-serif;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:#1a1a1a;margin-bottom:10px;">
                        <i class="bi bi-credit-card" style="color:#FF7A00;margin-right:5px;"></i> Payment Method
                    </label>

                    {{-- GCash — active --}}
                    <div style="display:flex;align-items:center;gap:10px;padding:12px 14px;background:#e8f4ff;border:2px solid #0066cc;border-radius:10px;margin-bottom:8px;">
                        <div style="width:30px;height:30px;border-radius:7px;background:#0066cc;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi bi-phone-fill" style="color:white;font-size:.78rem;"></i>
                        </div>
                        <span style="font-size:.85rem;font-weight:700;color:#1a1a1a;">GCash</span>
                        <span style="margin-left:auto;font-size:.65rem;font-weight:800;color:#0066cc;background:white;padding:2px 10px;border-radius:20px;border:1px solid rgba(0,102,204,.25);">
                            <i class="bi bi-check-circle-fill me-1"></i> Active
                        </span>
                    </div>

                    {{-- Coming soon methods --}}
                    @foreach(['maya'=>['#00a651','bi-phone-fill','Maya'],'bank_transfer'=>['#1a1a1a','bi-bank','Bank Transfer'],'cash'=>['#f39c12','bi-cash-coin','Cash'],'online_transfer'=>['#2196F3','bi-arrow-left-right','Online Transfer']] as $val => $info)
                    <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f9f9f9;border:2px solid #ebebeb;border-radius:10px;margin-bottom:6px;opacity:.45;">
                        <div style="width:30px;height:30px;border-radius:7px;background:{{ $info[0] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="bi {{ $info[1] }}" style="color:white;font-size:.78rem;"></i>
                        </div>
                        <span style="font-size:.85rem;font-weight:700;color:#888;">{{ $info[2] }}</span>
                        <span style="margin-left:auto;font-size:.62rem;font-weight:700;color:#bbb;background:#f0f0f0;padding:2px 9px;border-radius:20px;">Coming Soon</span>
                    </div>
                    @endforeach
                </div>

                {{-- GCash Account Details --}}
                <div style="padding:18px 20px;background:linear-gradient(135deg,#e8f4ff,#dceeff);border:2px solid rgba(0,102,204,.2);border-radius:14px;">
                    <div style="font-family:'Montserrat',sans-serif;font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#0066cc;margin-bottom:16px;display:flex;align-items:center;gap:6px;">
                        <i class="bi bi-phone-fill"></i> Your GCash Details for Customer
                    </div>

                    {{-- GCash Number --}}
                    <div style="margin-bottom:16px;">
                        <label style="display:block;font-family:'Montserrat',sans-serif;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:#1a1a1a;margin-bottom:8px;">
                            GCash Number <span style="color:#e74c3c;">*</span>
                        </label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-weight:800;color:#0066cc;font-size:.9rem;pointer-events:none;">+63</span>
                            <input type="text" name="gcash_number" id="gcashNumber"
                                   style="width:100%;background:white;border:2px solid rgba(0,102,204,.25);border-radius:10px;padding:12px 16px 12px 48px;font-size:.9rem;font-weight:600;font-family:'Inter',sans-serif;color:#1a1a1a;outline:none;transition:border-color .2s;"
                                   placeholder="9XX XXX XXXX"
                                   maxlength="13"
                                   onfocus="this.style.borderColor='#0066cc'"
                                   onblur="this.style.borderColor='rgba(0,102,204,.25)'"
                                   value="{{ Auth::user()->catererProfile?->gcash_number ?? '' }}"
                                   required>
                        </div>
                        <div style="font-size:.65rem;color:#555;margin-top:5px;">
                            <i class="bi bi-info-circle" style="color:#0066cc;"></i>
                            The customer will use this number to send the downpayment.
                        </div>
                    </div>

                    {{-- GCash QR Code --}}
                    <div>
                        <label style="display:block;font-family:'Montserrat',sans-serif;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:#1a1a1a;margin-bottom:8px;">
                            GCash QR Code
                            <span style="font-weight:600;font-size:.6rem;color:#888;text-transform:none;letter-spacing:0;">(optional but recommended)</span>
                        </label>

                        {{-- Show existing QR if already saved --}}
                        @if(Auth::user()->catererProfile?->gcash_qr_path)
                        <div style="text-align:center;margin-bottom:10px;" id="existingQrWrap">
                            <img src="{{ asset('storage/' . Auth::user()->catererProfile->gcash_qr_path) }}"
                                 style="max-width:140px;border-radius:12px;border:2px solid rgba(0,102,204,.2);" alt="Current QR">
                            <div style="font-size:.65rem;color:#0066cc;margin-top:4px;font-weight:600;">Current QR Code</div>
                        </div>
                        @endif

                        {{-- New QR upload preview --}}
                        <div id="gcashQrPreviewWrap" style="display:none;margin-bottom:10px;text-align:center;">
                            <img id="gcashQrPreview" src="" style="max-width:140px;border-radius:12px;border:2px solid rgba(0,102,204,.2);" alt="QR Preview">
                            <div style="font-size:.65rem;color:#0066cc;margin-top:4px;font-weight:600;">New QR Preview</div>
                            <button type="button" onclick="document.getElementById('gcashQrInput').value='';document.getElementById('gcashQrPreviewWrap').style.display='none';document.getElementById('gcashQrLabel').style.display='flex';"
                                    style="font-size:.65rem;color:#dc2626;background:none;border:none;cursor:pointer;margin-top:4px;">
                                <i class="bi bi-x-circle"></i> Remove
                            </button>
                        </div>

                        <label style="display:flex;flex-direction:column;align-items:center;gap:8px;padding:18px;background:white;border:2px dashed rgba(0,102,204,.3);border-radius:10px;cursor:pointer;transition:all .2s;"
                               id="gcashQrLabel"
                               onmouseover="this.style.borderColor='#0066cc';this.style.background='#f0f7ff'"
                               onmouseout="this.style.borderColor='rgba(0,102,204,.3)';this.style.background='white'">
                            <i class="bi bi-qr-code" style="font-size:1.6rem;color:#0066cc;opacity:.6;"></i>
                            <span style="font-size:.75rem;font-weight:700;color:#666;">
                                {{ Auth::user()->catererProfile?->gcash_qr_path ? 'Click to replace QR code' : 'Click to upload QR code' }}
                            </span>
                            <span style="font-size:.65rem;color:#aaa;">JPG or PNG, max 5MB</span>
                            <input type="file" name="gcash_qr_code" id="gcashQrInput" accept=".jpg,.jpeg,.png" style="display:none;">
                        </label>
                    </div>
                </div>

            </div>{{-- end modal-body --}}

            <div class="modal-footer" style="display:flex;gap:10px;">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal" style="font-size:.82rem;">Cancel</button>
                <button type="button" class="btn rounded-pill px-4 fw-bold" id="confirmSubmitBtn"
                        style="background:#27ae60;color:white;font-size:.82rem;flex:1;box-shadow:0 4px 14px rgba(39,174,96,.3);">
                    <i class="bi bi-check-circle-fill me-2"></i> Confirm & Notify Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endif {{-- end @if($isCaterer && Auth::user()->catererProfile) --}}

{{-- ═══════════ REJECT MODAL ═══════════ --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="modal-content">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="rejected">
            <div class="modal-header">
                <h5 class="modal-title">Reject Inquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3" style="font-size:.85rem;">The customer will be notified. Please select a reason:</p>
                <select name="rejection_reason" class="form-select mb-3 rounded-3" style="border:1.5px solid #e0e0e0;padding:12px 16px;font-size:.88rem;" required>
                    <option value="Fully booked for this date">Fully booked for this date</option>
                    <option value="Event size not supported">Event size not supported</option>
                    <option value="Outside service area">Outside service area</option>
                    <option value="Other">Other</option>
                </select>
                <textarea name="custom_reason" class="form-control rounded-3" rows="3"
                          style="border:1.5px solid #e0e0e0;padding:12px 16px;font-size:.88rem;resize:none;"
                          placeholder="Optional note to the customer…"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Auto-scroll chat to bottom
    var cw = document.getElementById('chat-window');
    if (cw) cw.scrollTop = cw.scrollHeight;

    // GCash QR code preview
    var gcashQrInput = document.getElementById('gcashQrInput');
    if (gcashQrInput) {
        gcashQrInput.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;
            var reader = new FileReader();
            reader.onload = function (e) {
                var preview = document.getElementById('gcashQrPreview');
                var wrap    = document.getElementById('gcashQrPreviewWrap');
                var label   = document.getElementById('gcashQrLabel');
                var existing = document.getElementById('existingQrWrap');
                if (preview) preview.src = e.target.result;
                if (wrap)    wrap.style.display = 'block';
                if (label)   label.style.display = 'none';
                if (existing) existing.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    }

    // Confirm modal submit validation
    var confirmBtn = document.getElementById('confirmSubmitBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function () {
            var deadline    = document.getElementById('deadlineInput');
            var gcashNumber = document.getElementById('gcashNumber');

            if (!deadline || !deadline.value) {
                deadline.style.borderColor = '#e74c3c';
                deadline.focus();
                return;
            }

            if (!gcashNumber || !gcashNumber.value.trim()) {
                gcashNumber.style.borderColor = '#e74c3c';
                gcashNumber.focus();
                // Show a small error hint
                var hint = document.getElementById('gcashNumberError');
                if (!hint) {
                    hint = document.createElement('div');
                    hint.id = 'gcashNumberError';
                    hint.style.cssText = 'font-size:.7rem;color:#e74c3c;margin-top:5px;font-weight:600;';
                    hint.innerHTML = '<i class="bi bi-exclamation-circle"></i> Please enter your GCash number.';
                    gcashNumber.parentElement.after(hint);
                }
                return;
            }

            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Confirming…';
            confirmBtn.closest('form').submit();
        });
    }
});
</script>
@endsection