@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

@php $editing = isset($menu); @endphp

<style>
    :root { --orange:#FF7A00; --orange-lt:#ff9f2f; --charcoal:#1a1a1a; --white:#ffffff; --gray-50:#f9f9f9; --gray-100:#f2f2f2; --gray-200:#e5e5e5; --gray-300:#d0d0d0; --gray-500:#888; --green:#10b981; --red:#ef4444; --radius:16px; }
    body { background:var(--gray-50); font-family:'Inter',sans-serif; }

    .page-topbar { background:var(--charcoal); padding:16px 0; position:sticky; top:0; z-index:100; box-shadow:0 4px 20px rgba(0,0,0,.25); }
    .topbar-inner { max-width:960px; margin:0 auto; padding:0 24px; display:flex; align-items:center; gap:14px; }
    .topbar-back { width:38px; height:38px; border-radius:50%; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; color:white; text-decoration:none; transition:all .2s; flex-shrink:0; }
    .topbar-back:hover { background:var(--orange); border-color:var(--orange); color:white; }
    .topbar-title { font-family:'Montserrat',sans-serif; font-size:.9rem; font-weight:900; color:white; text-transform:uppercase; letter-spacing:.5px; }
    .topbar-title span { color:var(--orange); }

    .page-body { max-width:960px; margin:0 auto; padding:32px 24px 80px; }

    .layout { display:grid; grid-template-columns:1fr 300px; gap:28px; align-items:start; }
    @media(max-width:860px) { .layout { grid-template-columns:1fr; } }

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
    .field-hint { font-size:.68rem; color:var(--gray-500); margin-top:5px; display:flex; align-items:center; gap:4px; }
    .field-hint i { color:var(--orange); font-size:.7rem; }
    .error-msg { font-size:.72rem; color:var(--red); margin-top:5px; display:flex; align-items:center; gap:4px; }

    .price-wrap { position:relative; }
    .price-sym { position:absolute; left:14px; top:50%; transform:translateY(-50%); font-weight:800; color:var(--orange); font-size:.95rem; pointer-events:none; }
    .price-wrap .field-input { padding-left:28px; }

    .category-pills { display:flex; flex-wrap:wrap; gap:8px; }
    .cat-pill { padding:8px 16px; border:2px solid var(--gray-200); border-radius:50px; background:var(--white); color:var(--gray-500); font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px; cursor:pointer; transition:all .2s; }
    .cat-pill:hover { border-color:var(--orange); color:var(--orange); }
    .cat-pill.active { border-color:var(--orange); background:var(--orange); color:var(--white); }
    .cat-pill input { display:none; }

    .toggle-row { display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:var(--gray-50); border:2px solid var(--gray-100); border-radius:10px; }
    .toggle-label { font-family:'Montserrat',sans-serif; font-size:.78rem; font-weight:800; text-transform:uppercase; letter-spacing:.3px; color:var(--charcoal); }
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
    .preview-header { background:var(--charcoal); padding:18px 20px; position:relative; overflow:hidden; }
    .preview-header::before { content:''; position:absolute; top:-25px; right:-25px; width:80px; height:80px; border-radius:50%; background:rgba(255,122,0,.15); }
    .pv-eyebrow { font-family:'Montserrat',sans-serif; font-size:.55rem; font-weight:800; text-transform:uppercase; letter-spacing:2px; color:rgba(255,255,255,.4); margin-bottom:4px; position:relative; z-index:1; }
    .pv-name { font-family:'Montserrat',sans-serif; font-weight:900; font-size:.9rem; text-transform:uppercase; color:var(--white); letter-spacing:-.3px; position:relative; z-index:1; }
    .pv-cat { font-size:.65rem; font-weight:700; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.5px; margin-top:4px; position:relative; z-index:1; }
    .preview-body { padding:18px 20px; }
    .pv-desc { font-size:.78rem; color:var(--gray-500); line-height:1.5; margin-bottom:14px; min-height:40px; font-style:italic; }
    .pv-price-row { display:flex; align-items:baseline; gap:6px; margin-bottom:8px; }
    .pv-price { font-family:'Montserrat',sans-serif; font-weight:900; font-size:1.6rem; color:var(--orange); line-height:1; }
    .pv-price-unit { font-size:.62rem; font-weight:700; color:var(--gray-500); text-transform:uppercase; letter-spacing:.5px; }
    .pv-status { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:50px; font-size:.65rem; font-weight:800; text-transform:uppercase; letter-spacing:.5px; }
    .pv-status.on { background:rgba(16,185,129,.1); color:var(--green); }
    .pv-status.off { background:rgba(239,68,68,.1); color:var(--red); }

    .pv-calc { margin-top:14px; padding:14px 16px; background:var(--gray-50); border-radius:10px; border:1px solid var(--gray-100); }
    .pv-calc-title { font-family:'Montserrat',sans-serif; font-size:.58rem; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:var(--orange); margin-bottom:8px; }
    .pv-calc-row { display:flex; justify-content:space-between; align-items:center; font-size:.78rem; padding:4px 0; }
    .pv-calc-row.total { border-top:2px solid var(--gray-200); padding-top:8px; margin-top:4px; font-weight:800; }
    .pv-calc-label { color:var(--gray-500); }
    .pv-calc-value { font-family:'Montserrat',sans-serif; font-weight:900; color:var(--charcoal); }
    .pv-calc-value.orange { color:var(--orange); }

    .pv-guests-input { display:flex; align-items:center; gap:8px; margin-bottom:10px; }
    .pv-guests-input label { font-size:.65rem; font-weight:800; text-transform:uppercase; letter-spacing:.8px; color:var(--gray-500); white-space:nowrap; }
    .pv-guests-field { width:80px; background:var(--gray-100); border:1.5px solid var(--gray-200); border-radius:8px; padding:7px 10px; font-size:.85rem; font-weight:700; font-family:'Montserrat',sans-serif; color:var(--charcoal); text-align:center; }
    .pv-guests-field:focus { outline:none; border-color:var(--orange); }
</style>

<div class="page-topbar">
    <div class="topbar-inner">
        <a href="{{ route('dashboard') }}" class="topbar-back"><i class="bi bi-arrow-left"></i></a>
        <div>
            <div class="topbar-title">{{ $editing ? 'Edit' : 'Add' }} <span>Menu Item</span></div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="layout">

        {{-- ════════ FORM ════════ --}}
        <div class="form-card">
            <h1 class="form-card-title">{{ $editing ? 'Edit Menu Item' : 'New Menu Item' }}</h1>
            <p class="form-card-sub">{{ $editing ? 'Update the details of this dish' : 'Add a new dish, drink, or food item to your menu' }}</p>

            <form action="{{ $editing ? route('caterer.menus.update', $menu->id) : route('caterer.menus.store') }}"
                  method="POST" id="menuForm">
                @csrf
                @if($editing) @method('PUT') @endif

                <div class="section-divider"><i class="bi bi-egg-fried"></i> Item details</div>

                {{-- Name --}}
                <div class="field">
                    <label class="field-label">Item name <span class="req">*</span></label>
                    <input type="text" name="name" id="itemName"
                           class="field-input @error('name') is-invalid @enderror"
                           placeholder="e.g. Lechon Kawali, Buko Pandan, Softdrinks"
                           value="{{ old('name', $menu->name ?? '') }}" required>
                    @error('name') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                {{-- Category (pill selector) --}}
                <div class="field">
                    <label class="field-label">Category</label>
                    <div class="category-pills" id="catPills">
                        @php $cats = ['Appetizer','Soup','Salad','Main Course','Side Dish','Dessert','Drinks','Others']; @endphp
                        @foreach($cats as $cat)
                            <label class="cat-pill {{ old('category', $menu->category ?? '') === $cat ? 'active' : '' }}">
                                <input type="radio" name="category" value="{{ $cat }}"
                                       {{ old('category', $menu->category ?? '') === $cat ? 'checked' : '' }}>
                                {{ $cat }}
                            </label>
                        @endforeach
                    </div>
                    @error('category') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                {{-- Description --}}
                <div class="field">
                    <label class="field-label">Description</label>
                    <textarea name="description" id="itemDesc"
                              class="field-input @error('description') is-invalid @enderror"
                              rows="3" placeholder="Brief description of this dish (optional)...">{{ old('description', $menu->description ?? '') }}</textarea>
                    @error('description') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                <div class="section-divider"><i class="bi bi-cash-coin"></i> Pricing</div>

                {{-- Price --}}
                <div class="field">
                    <label class="field-label">Price per serving <span class="req">*</span></label>
                    <div class="price-wrap">
                        <span class="price-sym">₱</span>
                        <input type="number" name="price" id="itemPrice"
                               class="field-input @error('price') is-invalid @enderror"
                               placeholder="0.00" step="0.01" min="0"
                               value="{{ old('price', $menu->price ?? '') }}" required>
                    </div>
                    <div class="field-hint"><i class="bi bi-info-circle-fill"></i> Price per plate, cup, or single serving of this item.</div>
                    @error('price') <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                <div class="section-divider"><i class="bi bi-toggles"></i> Availability</div>

                {{-- Toggle --}}
                <div class="field">
                    <div class="toggle-row">
                        <div>
                            <div class="toggle-label">Available to customers</div>
                            <div class="toggle-sub">Turn off to hide without deleting</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_available" value="1" id="itemAvail"
                                   {{ old('is_available', $menu->is_available ?? true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                {{-- Actions --}}
<div class="form-actions">
    <button type="submit" class="btn-save">
        <i class="bi bi-{{ $editing ? 'check-lg' : 'plus-lg' }}"></i>
        {{ $editing ? 'Save Changes' : 'Add Item' }}
    </button>
    <a href="{{ route('dashboard') }}" class="btn-cancel">
        <i class="bi bi-x-lg"></i> Cancel
    </a>
    @if($editing)
        <button type="button" class="btn-cancel" style="color:var(--red);border-color:rgba(239,68,68,.3);"
                onclick="document.getElementById('deleteMenuForm').submit()">
            <i class="bi bi-trash3"></i> Delete
        </button>
    @endif
</div>

</form>{{-- closes the main menuForm --}}

        @if($editing)
        <form id="deleteMenuForm"
              action="{{ route('caterer.menus.destroy', $menu->id) }}"
              method="POST"
              onsubmit="return confirm('Delete this menu item? This cannot be undone.')">
            @csrf
            @method('DELETE')
        </form>
        @endif

    </div>{{-- closes .form-card --}}

        {{-- ════════ LIVE PREVIEW ════════ --}}
        <div>
            <div class="preview-card">
                <div class="preview-header">
                    <div class="pv-eyebrow">Live preview</div>
                    <div class="pv-name" id="pvName">{{ $editing ? $menu->name : 'Item Name' }}</div>
                    <div class="pv-cat" id="pvCat">{{ $editing ? ($menu->category ?? 'Uncategorized') : 'Category' }}</div>
                </div>
                <div class="preview-body">
                    <div class="pv-desc" id="pvDesc">{{ $editing ? ($menu->description ?? 'No description') : 'Add a description...' }}</div>
                    <div class="pv-price-row">
                        <span class="pv-price" id="pvPrice">₱{{ $editing ? number_format($menu->price, 2) : '0.00' }}</span>
                        <span class="pv-price-unit">/ serving</span>
                    </div>
                    <span class="pv-status on" id="pvStatus">
                        <i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Available
                    </span>

                    {{-- Guest calculator in preview --}}
                    <div class="pv-calc">
                        <div class="pv-calc-title"><i class="bi bi-calculator-fill me-1"></i> Cost estimator</div>
                        <div class="pv-guests-input">
                            <label><i class="bi bi-people-fill me-1"></i> Guests</label>
                            <input type="number" class="pv-guests-field" id="pvGuests" placeholder="100" min="1" value="100">
                        </div>
                        <div class="pv-calc-row">
                            <span class="pv-calc-label">Price per serving</span>
                            <span class="pv-calc-value" id="pvCalcUnit">₱0.00</span>
                        </div>
                        <div class="pv-calc-row total">
                            <span class="pv-calc-label">Total for <span id="pvCalcGuestCount">100</span> guests</span>
                            <span class="pv-calc-value orange" id="pvCalcTotal">₱0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
var nameEl  = document.getElementById('itemName');
var descEl  = document.getElementById('itemDesc');
var priceEl = document.getElementById('itemPrice');
var availEl = document.getElementById('itemAvail');
var guestEl = document.getElementById('pvGuests');

function fmt(n) { return '₱' + n.toLocaleString('en-PH', {minimumFractionDigits:2, maximumFractionDigits:2}); }

function updatePreview() {
    document.getElementById('pvName').textContent = nameEl.value || 'Item Name';
    document.getElementById('pvDesc').textContent = descEl.value || 'Add a description...';

    var price = parseFloat(priceEl.value) || 0;
    document.getElementById('pvPrice').textContent = fmt(price);
    document.getElementById('pvCalcUnit').textContent = fmt(price);

    var guests = parseInt(guestEl.value) || 0;
    document.getElementById('pvCalcGuestCount').textContent = guests;
    document.getElementById('pvCalcTotal').textContent = fmt(price * guests);

    var statusEl = document.getElementById('pvStatus');
    if (availEl.checked) {
        statusEl.className = 'pv-status on';
        statusEl.innerHTML = '<i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Available';
    } else {
        statusEl.className = 'pv-status off';
        statusEl.innerHTML = '<i class="bi bi-circle-fill" style="font-size:.4rem;"></i> Hidden';
    }

    var checked = document.querySelector('#catPills input:checked');
    document.getElementById('pvCat').textContent = checked ? checked.value : 'Uncategorized';
}

[nameEl, descEl, priceEl, guestEl].forEach(function(el) { if(el) el.addEventListener('input', updatePreview); });
if (availEl) availEl.addEventListener('change', updatePreview);

document.querySelectorAll('#catPills .cat-pill').forEach(function(pill) {
    pill.addEventListener('click', function() {
        document.querySelectorAll('#catPills .cat-pill').forEach(function(p) { p.classList.remove('active'); });
        this.classList.add('active');
        setTimeout(updatePreview, 10);
    });
});

updatePreview();
</script>
@endsection