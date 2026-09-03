@extends('layouts.app')
@section('title', 'Construction Cost Calculator | Maha Construction')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-sep">›</span>
            <span style="color:#CBD5E1;">Calculator</span>
        </div>
        <span class="sec-tag">PLAN YOUR BUDGET</span>
        <h1 class="sec-title" style="margin:14px 0 10px;">Cost <span class="gold">Calculator</span></h1>
        <p class="sec-sub" style="max-width:600px;margin:0 auto;color:#CBD5E1;font-size:0.95rem;">
            Estimate your construction cost based on built-up area, tier, and finishes with complete transparency.
        </p>
    </div>
</section>

<section class="section-pad" style="padding-top:40px;">
    <div class="container" style="max-width:980px;">
        <div class="calculator-grid-2">
            <div class="calculator-card">
                <h3 class="calc-card-title">
                    <i class="fas fa-sliders" style="color:#FFD700;margin-right:4px;"></i> Configuration
                </h3>

                <!-- Division -->
                <div class="calc-slider-group">
                    <div class="calc-slider-label">
                        <span>Project Division</span>
                    </div>
                    <div class="calc-tabs" id="divisionTabs">
                        <button class="calc-tab active" data-division="residential">Residential</button>
                        <button class="calc-tab" data-division="commercial">Commercial</button>
                    </div>
                </div>

                <!-- Tier -->
                <div class="calc-slider-group">
                    <div class="calc-slider-label">
                        <span>Package Tier</span>
                    </div>
                    <div id="tierTabs" class="calc-tabs" style="flex-direction:column;gap:8px;background:none;border:none;padding:0;">
                        @foreach($packages->groupBy('division') as $div => $pkgs)
                        <div class="tier-group" data-division="{{ $div }}" style="{{ $div !== 'residential' ? 'display:none;' : '' }}">
                            @foreach($pkgs as $pkg)
                            <button class="calc-tab {{ $pkg->tier === 'basic' && $div === 'residential' ? 'active' : '' }}"
                                    data-tier="{{ $pkg->tier }}"
                                    data-rate="{{ $pkg->price_per_sqft }}"
                                    data-title="{{ $pkg->title }}"
                                    onclick="selectTier(this)">
                                <span class="calc-tab-title">{{ $pkg->title }}</span>
                                <span class="calc-tab-price">₹{{ number_format($pkg->price_per_sqft) }}/sqft</span>
                            </button>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Area Slider -->
                <div class="calc-slider-group">
                    <div class="calc-slider-label">
                        <span>Built-up Area</span>
                        <span class="calc-slider-value"><span id="areaDisplay">1,500</span> sq.ft</span>
                    </div>
                    <input type="range" id="areaSlider" min="500" max="10000" value="1500" step="100" oninput="updateCalc()">
                    <div style="display:flex;justify-content:space-between;margin-top:6px;">
                        <span class="calc-slider-bound">500 sq.ft</span>
                        <span class="calc-slider-bound">10,000 sq.ft</span>
                    </div>
                </div>

                <!-- Floors Slider -->
                <div class="calc-slider-group">
                    <div class="calc-slider-label">
                        <span>No. of Floors</span>
                        <span class="calc-slider-value"><span id="floorsDisplay">1</span> Floor</span>
                    </div>
                    <input type="range" id="floorsSlider" min="1" max="5" value="1" step="1" oninput="updateCalc()">
                    <div style="display:flex;justify-content:space-between;margin-top:6px;">
                        <span class="calc-slider-bound">1 Floor (G)</span>
                        <span class="calc-slider-bound">5 Floors (G+4)</span>
                    </div>
                </div>
            </div>

            <div>
                <div class="calc-result fade-in">
                    <div class="calc-total-label">Estimated Construction Cost</div>
                    <div class="calc-total-value" id="totalCost">₹30,00,000</div>
                    <div class="calc-range" id="costRange">Range: ₹27L – ₹33L</div>

                    <div class="calc-breakdown-divider">
                        <div class="calc-breakdown-grid">
                            <div class="calc-metric-card">
                                <p class="calc-metric-label">Rate</p>
                                <p class="calc-metric-value" id="displayRate">₹1,999/sqft</p>
                            </div>
                            <div class="calc-metric-card">
                                <p class="calc-metric-label">Total Area</p>
                                <p class="calc-metric-value" id="displayArea">1,500 sqft</p>
                            </div>
                            <div class="calc-metric-card">
                                <p class="calc-metric-label">Floors</p>
                                <p class="calc-metric-value" id="displayFloors">1 Floor</p>
                            </div>
                            <div class="calc-metric-card">
                                <p class="calc-metric-label">Package</p>
                                <p class="calc-metric-value" id="displayPackage">Basic Plan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="calc-disclaimer-box">
                    <p class="calc-disclaimer-text">
                        <i class="fas fa-triangle-exclamation" style="color:#FFD700;font-size:1.15rem;"></i>
                        <span>This is an indicative estimate. Actual costs may vary based on site conditions, material prices, and design complexity. Contact us for a detailed quote.</span>
                    </p>
                    <button class="btn-gold w-full" data-open-quote>
                        <span>Get Exact Quote</span>
                        <i class="fas fa-arrow-right" style="margin-left:6px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
let selectedRate = 1999;
let selectedPackage = 'Basic Plan';

document.querySelectorAll('[data-division]').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('[data-division]').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        const div = tab.dataset.division;
        document.querySelectorAll('.tier-group').forEach(g => {
            g.style.display = g.dataset.division === div ? '' : 'none';
        });
        const firstBtn = document.querySelector(`.tier-group[data-division="${div}"] .calc-tab`);
        if (firstBtn) selectTier(firstBtn);
    });
});

function selectTier(btn) {
    document.querySelectorAll('.calc-tab[data-tier]').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selectedRate = parseInt(btn.dataset.rate);
    selectedPackage = btn.dataset.title;
    updateCalc();
}

function updateCalc() {
    const area   = parseInt(document.getElementById('areaSlider').value);
    const floors = parseInt(document.getElementById('floorsSlider').value);
    document.getElementById('areaDisplay').textContent  = area.toLocaleString('en-IN');
    document.getElementById('floorsDisplay').textContent = floors;

    const total  = area * floors * selectedRate;
    const low    = Math.round(total * 0.90);
    const high   = Math.round(total * 1.10);

    document.getElementById('totalCost').textContent  = '₹' + formatCrore(total);
    document.getElementById('costRange').textContent   = 'Range: ₹' + formatCrore(low) + ' – ₹' + formatCrore(high);
    document.getElementById('displayRate').textContent = '₹' + selectedRate.toLocaleString('en-IN') + '/sqft';
    document.getElementById('displayArea').textContent = (area * floors).toLocaleString('en-IN') + ' sqft';
    document.getElementById('displayFloors').textContent = floors + (floors > 1 ? ' Floors' : ' Floor');
    document.getElementById('displayPackage').textContent = selectedPackage;
}

function formatCrore(n) {
    if (n >= 10000000) return (n/10000000).toFixed(2) + ' Cr';
    if (n >= 100000)  return (n/100000).toFixed(2) + ' L';
    return n.toLocaleString('en-IN');
}

updateCalc();
</script>
@endpush
@endsection
