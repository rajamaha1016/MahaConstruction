@extends('layouts.app')
@section('title', 'Construction Cost Calculator | Maha Construction')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Calculator</span></div>
        <span class="section-tag">Plan Your Budget</span>
        <h1 style="margin:16px 0;">Cost <span class="gold">Calculator</span></h1>
        <p style="max-width:560px;margin:0 auto;">Estimate your construction cost based on area, tier, and finishes.</p>
    </div>
</section>
<section class="section">
    <div class="container" style="max-width:960px;">
        <div class="calculator-grid-2">
            <div class="calculator-card">
                <h3 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--gold);margin-bottom:24px;"><i class="fas fa-sliders" style="margin-right:6px;"></i> Configuration</h3>
                <!-- Division -->
                <div class="calc-slider-group">
                    <div class="calc-slider-label">
                        <span>Division</span>
                    </div>
                    <div class="calc-tabs" id="divisionTabs">
                        <button class="calc-tab active" data-division="residential">Residential</button>
                        <button class="calc-tab" data-division="commercial">Commercial</button>
                    </div>
                </div>
                <!-- Tier -->
                <div class="calc-slider-group">
                    <div class="calc-slider-label"><span>Package Tier</span></div>
                    <div id="tierTabs" class="calc-tabs" style="flex-direction:column;gap:8px;">
                        @foreach($packages->groupBy('division') as $div => $pkgs)
                        <div class="tier-group" data-division="{{ $div }}" style="{{ $div !== 'residential' ? 'display:none;' : '' }}">
                            @foreach($pkgs as $pkg)
                            <button class="calc-tab {{ $pkg->tier === 'basic' && $div === 'residential' ? 'active' : '' }}"
                                    data-tier="{{ $pkg->tier }}"
                                    data-rate="{{ $pkg->price_per_sqft }}"
                                    data-title="{{ $pkg->title }}"
                                    onclick="selectTier(this)">
                                {{ $pkg->title }} — ₹{{ number_format($pkg->price_per_sqft) }}/sqft
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
                        <span class="calc-slider-value"><span id="areaDisplay">1500</span> sq.ft</span>
                    </div>
                    <input type="range" id="areaSlider" min="500" max="10000" value="1500" step="100" oninput="updateCalc()">
                    <div style="display:flex;justify-content:space-between;margin-top:4px;">
                        <span style="font-size:0.72rem;color:var(--text-muted);">500 sq.ft</span>
                        <span style="font-size:0.72rem;color:var(--text-muted);">10,000 sq.ft</span>
                    </div>
                </div>
                <!-- Floors -->
                <div class="calc-slider-group">
                    <div class="calc-slider-label">
                        <span>No. of Floors</span>
                        <span class="calc-slider-value"><span id="floorsDisplay">1</span></span>
                    </div>
                    <input type="range" id="floorsSlider" min="1" max="5" value="1" step="1" oninput="updateCalc()">
                </div>
            </div>

            <div>
                <div class="calc-result fade-in">
                    <div class="calc-total-label">Estimated Construction Cost</div>
                    <div class="calc-total-value" id="totalCost">₹30,00,000</div>
                    <div class="calc-range" id="costRange">Range: ₹27L – ₹33L</div>
                    <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--border);">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;text-align:left;">
                            <div>
                                <p style="font-size:0.72rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);margin-bottom:4px;">Rate</p>
                                <p style="font-weight:600;color:var(--text-primary);font-size:0.95rem;" id="displayRate">₹1,999/sqft</p>
                            </div>
                            <div>
                                <p style="font-size:0.72rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);margin-bottom:4px;">Total Area</p>
                                <p style="font-weight:600;color:var(--text-primary);font-size:0.95rem;" id="displayArea">1,500 sqft</p>
                            </div>
                            <div>
                                <p style="font-size:0.72rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);margin-bottom:4px;">Floors</p>
                                <p style="font-weight:600;color:var(--text-primary);font-size:0.95rem;" id="displayFloors">1</p>
                            </div>
                            <div>
                                <p style="font-size:0.72rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);margin-bottom:4px;">Package</p>
                                <p style="font-weight:600;color:var(--text-primary);font-size:0.95rem;" id="displayPackage">Basic Plan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:20px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:24px;">
                    <p style="font-size:0.8rem;color:var(--text-muted);line-height:1.8;margin-bottom:16px;">
                        <i class="fas fa-triangle-exclamation" style="color:var(--gold);margin-right:4px;"></i> This is an indicative estimate. Actual costs may vary based on site conditions, material prices, and design complexity. Contact us for a detailed quote.
                    </p>
                    <button class="btn-gold w-full" data-open-quote>Get Exact Quote <i class="fas fa-arrow-right" style="margin-left:6px;"></i></button>
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
    document.getElementById('displayFloors').textContent = floors;
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
