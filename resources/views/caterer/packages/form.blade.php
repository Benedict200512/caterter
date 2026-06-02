@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

@php $editing = isset($package); @endphp

<style>
    :root { --orange:#FF7A00; --orange-lt:#ff9f2f; --charcoal:#1a1a1a; --white:#ffffff; --gray-50:#f9f9f9; --gray-100:#f2f2f2; --gray-200:#e5e5e5; --gray-300:#d0d0d0; --gray-500:#888; --green:#10b981; --red:#ef4444; --radius:16px; }
    body { background:var(--gray-50); font-family:'Inter',sans-serif; }

    .page-topbar { background:var(--charcoal); padding:16px 0; position:sticky; top:0; z-index:100; box-shadow:0 4px 20px rgba(0,0,0,.25); }
    .topbar-inner { max-width:1060px; margin:0 auto; padding:0 24px; display:flex; align-items:center; gap:14px; }
    .topbar-back { width:38px; height:38px; border-radius:50%; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; color:white; text-decoration:none; transition:all .2s; flex-shrink:0; }
    .topbar-back:hover { background:var(--orange); border-color:var(--orange); color:white; }
    .topbar-title { font-family:'Montserrat',sans-serif; font-size:.9rem; font-weight:900; color:white; text-transform:uppercase; letter-spacing:.5px; }
    .topbar-title span { color:var(--orange); }

    .page-body { max-width:1060px; margin:0 auto; padding:32px 24px 80px; }
    .layout { display:grid; grid-template-columns:1fr 340px; gap:28px; align-items:start; }
    @media(max-width:920px) { .layout { grid-template-columns:1fr; } }

    .form-card { background:var(--white); border-radius:var(--radius); padding:32px; box-shadow:0 2px 12px rgba(0,0,0,.06); }
    .form-card-title { font-family:'Montserrat',sans-serif; font-size:1.1rem; font-weight:900; color:var(--charcoal); text-transform:uppercase; letter-spacing:-.3px; margin:0 0 4px; }
    .form-card-sub { font-size:.8rem; color:var(--gray-500); margin:0 0 24px; }

    .section-divider { font-family:'Montserrat',sans-serif; font-size:.6rem; font-weight:800; text-transform:uppercase; letter-spacing:2px; color:var(--orange); margin:24px 0 14px; display:flex; align-items:center; gap:8px; }
    .section-divider::after { content:''; flex:1; height:1px; background:linear-gradient(to right,rgba(255,122,0,.2),transparent); }

    .field { margin-bottom:18px; }
    .field-label { font-family:'Montserrat',sans-serif; font-size:.62rem; font-weight:800; text-transform:uppercase; letter-spacing:1.2px; color:var(--charcoal); margin-bottom:7px; display:block; }
    .field-label .req { color:var(--orange); }
    .field-input { width:100%; background:var(--gray-100); border:2px solid transparent; border-radius:10px; padding:12px 16px; font-size:.9rem; font-weight:500; transition:all .25s; font-family:'Inter',sans-serif; color:var(--charcoal); }
    .field-input:focus { outline:none; background:var(--white); border-color:var(--orange); box-shadow:0 4px 14px rgba(255,122,0,.1); }
    .field-input.is-invalid { border-color:var(--red); }
    .field-hint { font-size:.68rem; color:var(--gray-500); margin-top:5px; }
    .error-msg { font-size:.72rem; color:var(--red); margin-top:5px; display:flex; align-items:center; gap:4px; }

    .price-wrap { position:relative; }
    .price-sym { position:absolute; left:14px; top:50%; transform:translateY(-50%); font-weight:800; color:var(--orange); font-size:.95rem; pointer-events:none; }
    .price-wrap .field-input { padding-left:28px; }

    .two-col { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    @media(max-width:500px) { .two-col { grid-template-columns:1fr; } }

    .inclusions-area { background:var(--gray-50); border:2px solid var(--gray-100); border-radius:10px; padding:16px; }
    .inc-row { display:flex; gap:8px; margin-bottom:8px; }
    .inc-input { flex:1; background:var(--white); border:2px solid var(--gray-100); border-radius:8px; padding:10px 14px; font-size:.85rem; font-family:'Inter',sans-serif; transition:border-color .2s; }
    .inc-input:focus { outline:none; border-color:var(--orange); }
    .btn-remove-inc { background:rgba(239,68,68,.08); color:var(--red); border:none; border-radius:8px; width:36px; height:36px; cursor:pointer; transition:all .2s; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .btn-remove-inc:hover { background:var(--red); color:var(--white); }
    .btn-add-inc { display:inline-flex; align-items:center; gap:6px; background:none; border:2px dashed var(--gray-300); border-radius:8px; padding:8px 16px; color:var(--gray-500); font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px; cursor:pointer; transition:all .2s; }
    .btn-add-inc:hover { border-color:var(--orange); color:var(--orange); }

    .toggle-row { display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border:2px solid var(--gray-100); border-radius:10px; }
    .toggle-label { font-family:'Montserrat',sans-serif; font-size:.78rem; font-weight:800; text-transform:uppercase; letter-spacing:.3px; }
    .toggle-sub { font-size:.68rem; color:var(--gray-500); margin-top:2px; }
    .toggle-switch { position:relative; width:48px; height:26px; flex-shrink:0; }
    .toggle-switch input { opacity:0; width:0; height:0; }
    .toggle-slider { position:absolute; cursor:pointer; inset:0; background:var(--gray-300); border-radius:26px; transition:.3s; }
    .toggle-slider::before { content:''; position:absolute; width:20px; height:20px; left:3px; bottom:3px; background:var(--white); border-radius:50%; transition:.3s; }
    input:checked + .toggle-slider { background:var(--green); }
    input:checked + .toggle-slider::before { transform:translateX(22px); }

    .form-actions { display:flex; gap:10px; flex-wrap:wrap; margin-top:28px; padding-top:22px; border-top:2px solid var(--gray-100); }
    .btn-save { flex:1; min-width:140px; background:var(--orange); color:var(--white); border:none; border-radius:10px; padding:14px; font-family:'Montserrat',sans-serif; font-size:.82rem; font-weight:900; text-transform:uppercase; letter-spacing:.8px; cursor:pointer; transition:all .25s; box-shadow:0 4px 14px rgba(255,122,0,.25); display:flex; align-items:center; justify-content:center; gap:6px; }
    .btn-save:hover { background:var(--charcoal); transform:translateY(-2px); }
    .btn-cancel { padding:14px 22px; background:var(--white); border:2px solid var(--gray-200); border-radius:10px; font-family:'Montserrat',sans-serif; font-size:.78rem; font-weight:800; text-transform:uppercase; text-decoration:none; color:var(--charcoal); transition:all .2s; display:flex; align-items:center; gap:5px; }
    .btn-cancel:hover { border-color:var(--orange); color:var(--orange); }

    .preview-card { background:var(--white); border-radius:var(--radius); box-shadow:0 2px 12px rgba(0,0,0,.06); overflow:hidden; position:sticky; top:80px; }
    .pv-header { background:var(--charcoal); padding:22px 20px; position:relative; overflow:hidden; }
    .pv-header::before { content:''; position:absolute; top:-25px; right:-25px; width:80px; height:80px; border-radius:50%; background:rgba(255,122,0,.15); }
    .pv-eyebrow { font-family:'Montserrat',sans-serif; font-size:.55rem; font-weight:800; text-transform:uppercase; letter-spacing:2px; color:rgba(255,255,255,.4); margin-bottom:6px; position:relative; z-index:1; }
    .pv-name { font-family:'Montserrat',sans-serif; font-weight:900; font-size:.95rem; text-transform:uppercase; color:var(--white); letter-spacing:-.3px; position:relative; z-index:1; margin-bottom:6px; }
    .pv-price { font-family:'Montserrat',sans-serif; font-weight:900; font-size:1.8rem; color:var(--orange); line-height:1; position:relative; z-index:1; }
    .pv-unit { font-size:.58rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:rgba(255,255,255,.4); margin-top:3px; position:relative; z-index:1; }
    .pv-pax { font-size:.7rem; color:rgba(255,255,255,.55); font-weight:600; margin-top:6px; position:relative; z-index:1; }
    .pv-body { padding:18px 20px; }
    .pv-desc { font-size:.78rem; color:var(--gray-500); line-height:1.5; margin-bottom:12px; font-style:italic; }
    .pv-inc-title { font-family:'Montserrat',sans-serif; font-size:.58rem; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:var(--orange); margin-bottom:8px; }
    .pv-inc-item { display:flex; align-items:center; gap:7px; font-size:.78rem; color:var(--charcoal); margin-bottom:5px; }
    .pv-inc-item i { color:var(--green); font-size:.78rem; flex-shrink:0; }
    .pv-empty-inc { font-size:.75rem; color:var(--gray-500); font-style:italic; }

    .pv-calc { margin-top:14px; padding:14px 16px; background:linear-gradient(135deg,#1a1a1a,#2a1500); border-radius:10px; border:1.5px solid rgba(255,122,0,.25); }
    .pv-calc-title { font-family:'Montserrat',sans-serif; font-size:.58rem; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:rgba(255,255,255,.45); margin-bottom:10px; display:flex; align-items:center; gap:5px; }
    .pv-calc-title i { color:var(--orange); }
    .pv-guests-row { display:flex; align-items:center; gap:8px; margin-bottom:10px; }
    .pv-guests-label { font-size:.65rem; font-weight:700; color:rgba(255,255,255,.45); text-transform:uppercase; letter-spacing:.5px; }
    .pv-guests-field { width:80px; background:rgba(255,255,255,.08); border:1.5px solid rgba(255,255,255,.15); border-radius:8px; padding:7px 10px; font-size:.85rem; font-weight:700; font-family:'Montserrat',sans-serif; color:var(--white); text-align:center; }
    .pv-guests-field:focus { outline:none; border-color:var(--orange); }
    .pv-calc-row { display:flex; justify-content:space-between; align-items:center; padding:5px 0; font-size:.78rem; }
    .pv-calc-label { color:rgba(255,255,255,.5); }
    .pv-calc-value { font-family:'Montserrat',sans-serif; font-weight:900; color:var(--white); }
    .pv-calc-divider { border:none; border-top:1px solid rgba(255,255,255,.1); margin:8px 0; }
    .pv-calc-total-label { font-family:'Montserrat',sans-serif; font-size:.68rem; font-weight:800; text-transform:uppercase; letter-spacing:.8px; color:rgba(255,255,255,.5); }
    .pv-calc-total-value { font-family:'Montserrat',sans-serif; font-size:1.4rem; font-weight:900; color:var(--orange); }
    .pv-calc-dp { display:flex; justify-content:space-between; align-items:center; margin-top:8px; padding:8px 10px; background:rgba(16,185,129,.1); border:1px solid rgba(16,185,129,.25); border-radius:8px; }
    .pv-calc-dp-label { font-size:.68rem; font-weight:700; color:rgba(255,255,255,.5); }
    .pv-calc-dp-value { font-family:'Montserrat',sans-serif; font-size:.95rem; font-weight:900; color:#4ade80; }
</style>

<div class="page-topbar">
    <div class="topbar-inner">
        <a href="{{ route('dashboard') }}" class="topbar-back"><i class="bi bi-arrow-left"></i></a>
        <div class="topbar-title">{{ $editing ? 'Edit' : 'Create' }} <span>Package</span></div>
    </div>
</div>

<div class="page-body">
    <div class="layout">

        {{-- ════════ FORM ════════ --}}
        <div class="form-card">
            <h1 class="form-card-title">{{ $editing ? 'Edit Package' : 'New Package' }}</h1>
            <p class="form-card-sub">{{ $editing ? 'Update your package details and inclusions' : 'Build a catering package with per-guest pricing' }}</p>

            <form action="{{ $editing ? route('caterer.packages.update', $package->id) : route('caterer.packages.store') }}"
                  method="POST" id="pkgForm">
                @csrf
                @if($editing) @method('PUT') @endif

                <div class="section-divider"><i class="bi bi-box-seam"></i> Package details</div>

                <div class="field">
                    <label class="field-label">Package name <span class="req">*</span></label>
                    <input type="text" name="name" id="pkgName"
                           class="field-input @error('name') is-invalid @enderror"
                           placeholder="e.g. Silver Package, Premium Buffet"
                           value="{{ old('name', $package->name ?? '') }}" required>
                    @error('name') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label class="field-label">Description</label>
                    <textarea name="description" id="pkgDesc"
                              class="field-input @error('description') is-invalid @enderror"
                              rows="3" placeholder="What makes this package special...">{{ old('description', $package->description ?? '') }}</textarea>
                    @error('description') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                <div class="section-divider"><i class="bi bi-cash-coin"></i> Pricing + guests</div>

                <div class="field">
                    <label class="field-label">Price per guest <span class="req">*</span></label>
                    <div class="price-wrap">
                        <span class="price-sym">₱</span>
                        <input type="number" name="price_per_guest" id="pkgPrice"
                               class="field-input @error('price_per_guest') is-invalid @enderror"
                               placeholder="0.00" step="0.01" min="1"
                               value="{{ old('price_per_guest', $package->price_per_guest ?? '') }}" required>
                    </div>
                    <div class="field-hint">Cost per head for this package.</div>
                    @error('price_per_guest') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                <div class="two-col">
                    <div class="field">
                        <label class="field-label">Min guests <span class="req">*</span></label>
                        <input type="number" name="min_guests" id="pkgMinPax"
                               class="field-input @error('min_guests') is-invalid @enderror"
                               placeholder="50" min="1"
                               value="{{ old('min_guests', $package->min_guests ?? 50) }}" required>
                        @error('min_guests') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label class="field-label">Max guests</label>
                        <input type="number" name="max_guests" id="pkgMaxPax"
                               class="field-input @error('max_guests') is-invalid @enderror"
                               placeholder="Unlimited" min="1"
                               value="{{ old('max_guests', $package->max_guests ?? '') }}">
                        <div class="field-hint">Leave blank for unlimited.</div>
                        @error('max_guests') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="section-divider"><i class="bi bi-list-check"></i> Inclusions</div>

                <div class="inclusions-area">
                    <div id="incList">
                        @php
                            $existingInc = [];
                            if (isset($package) && $package->inclusions) {
                                $existingInc = array_filter(array_map('trim', explode(',', $package->inclusions)));
                            }
                            if (old('inclusions_items')) { $existingInc = old('inclusions_items'); }
                            if (empty($existingInc)) { $existingInc = ['']; }
                        @endphp
                        @foreach($existingInc as $inc)
                            <div class="inc-row">
                                <input type="text" class="inc-input inc-field" placeholder="e.g. Professional Waitstaff" value="{{ $inc }}">
                                <button type="button" class="btn-remove-inc" onclick="removeInc(this)"><i class="bi bi-x-lg"></i></button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn-add-inc" onclick="addInc()">
                        <i class="bi bi-plus-lg"></i> Add inclusion
                    </button>
                </div>
                <input type="hidden" name="inclusions" id="incHidden" value="{{ old('inclusions', $package->inclusions ?? '') }}">

                <div class="section-divider"><i class="bi bi-toggles"></i> Availability</div>

                <div class="field">
                    <div class="toggle-row">
                        <div>
                            <div class="toggle-label">Active / available</div>
                            <div class="toggle-sub">Hide this package without deleting it</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_available" value="1"
                                   {{ old('is_available', $package->is_available ?? true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
    <button type="submit" class="btn-save">
        <i class="bi bi-{{ $editing ? 'check-lg' : 'plus-lg' }}"></i>
        {{ $editing ? 'Save Changes' : 'Create Package' }}
    </button>
    <a href="{{ route('dashboard') }}" class="btn-cancel">
        <i class="bi bi-x-lg"></i> Cancel
    </a>
    @if($editing)
        <button type="button" class="btn-cancel" style="color:var(--red);border-color:rgba(239,68,68,.3);"
                onclick="document.getElementById('deletePkgForm').submit()">
            <i class="bi bi-trash3"></i> Delete
        </button>
    @endif
</div>
            </form>{{-- closes pkgForm --}}

        @if($editing)
        <form id="deletePkgForm"
              action="{{ route('caterer.packages.destroy', $package->id) }}"
              method="POST"
              onsubmit="return confirm('Delete this package? This cannot be undone.')">
            @csrf
            @method('DELETE')
        </form>
        @endif

    </div>{{-- closes .form-card --}}   
        </div>

        {{-- ════════ LIVE PREVIEW ════════ --}}
        <div>
            <div class="preview-card">
                <div class="pv-header">
                    <div class="pv-eyebrow">Live preview</div>
                    <div class="pv-name" id="pvName">{{ $editing ? $package->name : 'Package Name' }}</div>
                    <div class="pv-price" id="pvPrice">₱{{ $editing ? number_format($package->price_per_guest, 0) : '0' }}</div>
                    <div class="pv-unit">Per guest</div>
                    <div class="pv-pax" id="pvPax">
                        <i class="bi bi-people-fill me-1"></i>
                        {{ $editing ? ($package->min_guests . ($package->max_guests ? ' – ' . $package->max_guests : '+')) : '50+' }} guests
                    </div>
                </div>
                <div class="pv-body">
                    <div class="pv-desc" id="pvDesc">{{ $editing ? ($package->description ?? 'No description') : 'Add a description...' }}</div>
                    <div class="pv-inc-title">Inclusions</div>
                    <div id="pvInclusions">
                        <div class="pv-empty-inc">Add inclusions to see them here...</div>
                    </div>

                    {{-- Guest count calculator --}}
                    <div class="pv-calc">
                        <div class="pv-calc-title"><i class="bi bi-calculator-fill"></i> Cost estimator</div>
                        <div class="pv-guests-row">
                            <span class="pv-guests-label"><i class="bi bi-people-fill me-1"></i> Guests</span>
                            <input type="number" class="pv-guests-field" id="pvGuests" placeholder="100" min="1" value="100">
                            <span style="font-size:.65rem;color:rgba(255,255,255,.3);">pax</span>
                        </div>
                        <div class="pv-calc-row">
                            <span class="pv-calc-label">Price per guest</span>
                            <span class="pv-calc-value" id="pvCalcUnit">₱0</span>
                        </div>
                        <div class="pv-calc-row">
                            <span class="pv-calc-label">Guests</span>
                            <span class="pv-calc-value" id="pvCalcGuests">100</span>
                        </div>
                        <hr class="pv-calc-divider">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <div class="pv-calc-total-label">Estimated total</div>
                            <div class="pv-calc-total-value" id="pvCalcTotal">₱0</div>
                        </div>
                        <div class="pv-calc-dp">
                            <span class="pv-calc-dp-label"><i class="bi bi-wallet2 me-1"></i> 50% Downpayment</span>
                            <span class="pv-calc-dp-value" id="pvCalcDP">₱0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function addInc() {
    var row = document.createElement('div');
    row.className = 'inc-row';
    row.innerHTML = '<input type="text" class="inc-input inc-field" placeholder="e.g. High-Quality Dinnerware">' +
                    '<button type="button" class="btn-remove-inc" onclick="removeInc(this)"><i class="bi bi-x-lg"></i></button>';
    document.getElementById('incList').appendChild(row);
    row.querySelector('input').addEventListener('input', updatePV);
    row.querySelector('input').focus();
    updatePV();
}

function removeInc(btn) {
    var rows = document.querySelectorAll('.inc-row');
    if (rows.length > 1) { btn.closest('.inc-row').remove(); }
    else { btn.closest('.inc-row').querySelector('input').value = ''; }
    updatePV();
}

function fmt(n) { return '₱' + n.toLocaleString('en-PH', {minimumFractionDigits:0, maximumFractionDigits:0}); }

function updatePV() {
    var name  = document.getElementById('pkgName').value || 'Package Name';
    var desc  = document.getElementById('pkgDesc').value || 'Add a description...';
    var price = parseFloat(document.getElementById('pkgPrice').value) || 0;
    var minP  = document.getElementById('pkgMinPax').value || '50';
    var maxP  = document.getElementById('pkgMaxPax').value;
    var guests = parseInt(document.getElementById('pvGuests').value) || 0;

    document.getElementById('pvName').textContent = name;
    document.getElementById('pvDesc').textContent = desc;
    document.getElementById('pvPrice').textContent = fmt(price);
    document.getElementById('pvPax').innerHTML = '<i class="bi bi-people-fill me-1"></i>' + minP + (maxP ? ' – ' + maxP : '+') + ' guests';

    document.getElementById('pvCalcUnit').textContent = fmt(price);
    document.getElementById('pvCalcGuests').textContent = guests;
    var total = price * guests;
    document.getElementById('pvCalcTotal').textContent = fmt(total);
    document.getElementById('pvCalcDP').textContent = fmt(total * 0.5);

    var items = [];
    document.querySelectorAll('.inc-field').forEach(function(inp) { if(inp.value.trim()) items.push(inp.value.trim()); });
    var pvInc = document.getElementById('pvInclusions');
    if (items.length > 0) {
        pvInc.innerHTML = items.map(function(item) {
            return '<div class="pv-inc-item"><i class="bi bi-check-circle-fill"></i>' + item + '</div>';
        }).join('');
    } else {
        pvInc.innerHTML = '<div class="pv-empty-inc">Add inclusions to see them here...</div>';
    }
}

document.getElementById('pkgForm').addEventListener('submit', function() {
    var items = [];
    document.querySelectorAll('.inc-field').forEach(function(inp) { if(inp.value.trim()) items.push(inp.value.trim()); });
    document.getElementById('incHidden').value = items.join(',');
});

['pkgName','pkgDesc','pkgPrice','pkgMinPax','pkgMaxPax','pvGuests'].forEach(function(id) {
    var el = document.getElementById(id);
    if (el) el.addEventListener('input', updatePV);
});
document.querySelectorAll('.inc-field').forEach(function(inp) { inp.addEventListener('input', updatePV); });

updatePV();
</script>
@endsection