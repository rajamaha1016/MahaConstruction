@extends('layouts.app')

@section('title', 'Construction Pricing Plans | Maha Construction')

@section('content')

<section class="section-pad" style="padding-top:60px;">
    <div class="container">
        <div style="text-align:center;">
            <span class="sec-tag">MAHA CONSTRUCTION • TRANSPARENT PRICING</span>
            <h1 class="sec-title">CONSTRUCTION PRICING PLANS</h1>
            <p class="sec-sub" style="margin:10px auto 0;">Itemized clear per square-foot construction rates for Residential & Commercial projects — with written warranties, brand-grade materials, and full pricing transparency.</p>

            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;margin:24px 0 16px;">
                <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> 20-Year Warranty</span>
                <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> No Hidden Charges</span>
                <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> On-Time Delivery</span>
                <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> ISO Certified Quality</span>
                <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> Free Site Consultation</span>
            </div>

            <div class="tab-toggle-group">
                <button class="tab-btn package-tab-btn active" data-target-group="pricingResGroup">RESIDENTIAL</button>
                <button class="tab-btn package-tab-btn" data-target-group="pricingComGroup">COMMERCIAL</button>
            </div>

            <div style="display:flex;gap:16px;justify-content:center;margin-top:20px;">
                <button class="btn-whatsapp-outline" id="toggleSpecTableBtn" style="border-color:var(--gold);color:var(--gold);">
                    <i class="fas fa-table" style="margin-right:6px;"></i> VIEW SPEC TABLE
                </button>
                <button class="btn-gold-pill" data-open-quote>
                    CALCULATE COST <i class="fas fa-arrow-right" style="margin-left:6px;"></i>
                </button>
            </div>
        </div>

        <!-- SPECIFICATION COMPARISON MATRIX TABLE (COLLAPSIBLE) -->
        <div id="specTableContainer" style="display:none;margin-top:40px;">
            <div class="matrix-modal-header" style="text-align:center;margin-bottom:16px;">
                <span class="sec-tag">MATERIAL MATRIX</span>
                <h3 style="color:#fff;font-size:1.4rem;">COMPLETE SPECIFICATION COMPARISON</h3>
            </div>
            <div class="table-responsive">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>SPECIFICATION</th>
                            <th>BASIC</th>
                            <th>PREMIUM</th>
                            <th>LUXURY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="feature-title">STRUCTURAL STEEL</td>
                            <td>Fe-500 TMT (Standard)</td>
                            <td>Fe-550 TMT (JSW / Vizag)</td>
                            <td>Fe-550 TMT (Tata Tiscon / JSPL)</td>
                        </tr>
                        <tr>
                            <td class="feature-title">CEMENT QUALITY</td>
                            <td>Coromandel / ACC</td>
                            <td>Ultratech Premium / Dalmia</td>
                            <td>Birla Super / ACC Gold</td>
                        </tr>
                        <tr>
                            <td class="feature-title">SAND & AGGREGATES</td>
                            <td>M-Sand blockwork</td>
                            <td>Double-washed M-Sand</td>
                            <td>Premium river sand</td>
                        </tr>
                        <tr>
                            <td class="feature-title">FLOOR TILES</td>
                            <td>Vitrified tiles (2'×2')</td>
                            <td>Kajaria double charged (4'×2')</td>
                            <td>Italian Travertine / marble slabs</td>
                        </tr>
                        <tr>
                            <td class="feature-title">BATHROOM FITTINGS</td>
                            <td>Parryware / Metro CP</td>
                            <td>Jaquar sanitary & CP sets</td>
                            <td>Kohler / Grohe premium</td>
                        </tr>
                        <tr>
                            <td class="feature-title">ELECTRICAL WIRING</td>
                            <td>Kundan / Anchor wires</td>
                            <td>Polycab + Roma switches</td>
                            <td>Finolex + Legrand switches</td>
                        </tr>
                        <tr>
                            <td class="feature-title">MAIN DOOR</td>
                            <td>Solid flush door</td>
                            <td>Teak wood luxury door</td>
                            <td>First-grade carved Teak</td>
                        </tr>
                        <tr>
                            <td class="feature-title">WALL FINISH</td>
                            <td>Asian Paints Emulsion</td>
                            <td>Apex Ultima weather coat</td>
                            <td>Royale textured / custom panels</td>
                        </tr>
                        <tr>
                            <td class="feature-title">STRUCTURAL WARRANTY</td>
                            <td>10 Years</td>
                            <td>15 Years</td>
                            <td>20 Years</td>
                        </tr>
                        <tr>
                            <td class="feature-title">DELIVERY TIMELINE</td>
                            <td>12 Months</td>
                            <td>14 Months</td>
                            <td>18 Months</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RESIDENTIAL PRICING CARDS -->
        <div class="pricing-grid-3 package-group" id="pricingResGroup">
            @php
                $resTiers = ['basic', 'standard', 'premium', 'luxury'];
                $resFallbacks = [
                    'basic'   => ['title'=>'BASIC PLAN',   'subtitle'=>'Solid & Affordable',     'price'=>1999,  'warranty'=>'10 Yrs', 'delivery'=>'12 Mo', 'features'=>['Fe-500 TMT steel','Coromandel / ACC cement','M-Sand blockwork','Vitrified floor tiles (2\'×2\')','Parryware CP fittings','Kundan / Anchor concealed wiring','Flush door entry system','Asian Paints Emulsion finish'], 'highlighted'=>false],
                    'standard'=> ['title'=>'STANDARD PLAN','subtitle'=>'Value & Performance',     'price'=>2199,  'warranty'=>'12 Yrs', 'delivery'=>'13 Mo', 'features'=>['Fe-500D TMT steel','ACC / Ramco cement','Washed M-Sand','Vitrified tiles (2\'×4\')','Cera CP fittings','Finolex wiring','Flush door','Asian Paints Ace finish'], 'highlighted'=>false],
                    'premium' => ['title'=>'PREMIUM PLAN', 'subtitle'=>'Quality & Elegance',     'price'=>2399,  'warranty'=>'15 Yrs', 'delivery'=>'14 Mo', 'features'=>['Fe-550 TMT (JSW / Vizag Steel)','Ultratech Premium / Dalmia cement','Double-washed M-Sand','Kajaria double charged tiles (4\'×2\')','Jaquar sanitary & CP sets','Polycab wires & Roma switches','Teak wood entry door','Asian Paints Apex Ultima'], 'highlighted'=>true],
                    'luxury'  => ['title'=>'LUXURY PLAN',  'subtitle'=>'Elite Craftsmanship',    'price'=>2999,  'warranty'=>'20 Yrs', 'delivery'=>'18 Mo', 'features'=>['Fe-550 TMT (Tata Tiscon / JSPL)','Birla Super / ACC Gold cement','River sand / premium concrete sand','Italian Travertine / marble slabs','Kohler / Grohe collection','Finolex cables & Legrand switches','First-grade carved teak doors','Royale textured / custom panel finish'], 'highlighted'=>false],
                ];
                $shownRes = false;
            @endphp
            @foreach($resTiers as $tier)
                @php
                    $pkg = $residential[$tier] ?? null;
                    $fb  = $resFallbacks[$tier] ?? null;
                    if (!$pkg && !$fb) continue;
                    $isHL = $pkg ? $pkg->is_highlighted : ($fb['highlighted'] ?? false);
                    $shownRes = true;
                @endphp
                <div class="package-card {{ $isHL ? 'highlighted' : '' }}">
                    @if($isHL)<div class="badge-popular"><i class="fas fa-star" style="margin-right:4px;"></i> MOST POPULAR</div>@endif
                    <div>
                        <span class="plan-tier-label">{{ strtoupper($pkg ? $pkg->division : 'RESIDENTIAL') }} • {{ strtoupper($tier) }}</span>
                        <h3 class="plan-title">{{ $pkg ? strtoupper($pkg->title) : ($fb['title'] ?? strtoupper($tier).' PLAN') }}</h3>
                        <p style="font-size:0.8rem;color:var(--text-muted);">{{ $pkg ? $pkg->subtitle : ($fb['subtitle'] ?? '') }}</p>
                        <div class="plan-price">₹{{ number_format($pkg ? $pkg->price_per_sqft : ($fb['price'] ?? 0)) }} <span>/ sq.ft</span></div>

                        @if($pkg && $pkg->description)
                        <div style="font-size:0.8rem;color:var(--text-muted);margin:16px 0 12px;">{{ $pkg->description }}</div>
                        @elseif(!$pkg)
                        <div style="font-size:0.8rem;color:var(--text-muted);margin:16px 0 12px;">A {{ strtolower($tier) }} residential construction package with quality materials and proven structural systems.</div>
                        @endif

                        <div style="display:flex;gap:12px;margin-bottom:16px;">
                            <div class="metric-card" style="flex:1;padding:8px;">
                                <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">{{ $pkg ? $pkg->warranty_years.' Yrs' : ($fb['warranty'] ?? '—') }}</div>
                                <div style="font-size:0.6rem;color:var(--text-muted);">WARRANTY</div>
                            </div>
                            <div class="metric-card" style="flex:1;padding:8px;">
                                <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">{{ $pkg ? $pkg->delivery_months.' Mo' : ($fb['delivery'] ?? '—') }}</div>
                                <div style="font-size:0.6rem;color:var(--text-muted);">DELIVERY</div>
                            </div>
                        </div>

                        <h4 style="font-size:0.8rem;color:var(--gold);font-weight:800;margin-bottom:8px;">KEY MATERIALS & SPECS</h4>
                        <ul class="plan-features-list">
                            @if($pkg && $pkg->features && count($pkg->features))
                                @foreach($pkg->features as $f)<li>{{ $f }}</li>@endforeach
                            @elseif(!$pkg && !empty($fb['features']))
                                @foreach($fb['features'] as $f)<li>{{ $f }}</li>@endforeach
                            @endif
                        </ul>
                    </div>
                    <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                        <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                        <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                    </div>
                </div>
            @endforeach
            @if(!$shownRes)
            {{-- No packages in DB yet: show original static cards --}}
            <div class="package-card">
                <div>
                    <span class="plan-tier-label">BASIC TIER</span>
                    <h3 class="plan-title">BASIC PLAN</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Solid & Affordable</p>
                    <div class="plan-price">₹1,999 <span>/ sq.ft</span></div>
                    <ul class="plan-features-list">
                        <li>Fe-500 TMT steel</li><li>Coromandel / ACC cement</li><li>M-Sand blockwork</li><li>Vitrified floor tiles (2'×2')</li><li>Parryware CP fittings</li>
                    </ul>
                </div>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                    <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                    <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                </div>
            </div>
            @endif
        </div>

        <!-- COMMERCIAL PRICING CARDS -->
        <div class="pricing-grid-3 package-group" id="pricingComGroup" style="display:none;">
            @php
                $comTiers = ['basic', 'standard', 'premium', 'luxury', 'elite'];
                $comFallbacks = [
                    'basic'   => ['title'=>'STANDARD SHELL',     'subtitle'=>'Functional & Efficient',  'price'=>2100, 'highlighted'=>false, 'features'=>['Fe-500 TMT structural steel','OPC 53 grade cement','RCC framed structure','Vitrified floor tiles']],
                    'standard'=> ['title'=>'ENHANCED SHELL',     'subtitle'=>'Commercial Value',         'price'=>2400, 'highlighted'=>false, 'features'=>['Fe-500D TMT steel','Ultratech cement','RCC frame','Granito tiles']],
                    'premium' => ['title'=>'PREMIUM CORPORATE',  'subtitle'=>'Professional & Polished',  'price'=>2799, 'highlighted'=>true,  'features'=>['Fe-550 TMT (JSW Steel)','Ultratech / Ambuja cement','RCC frame + shear walls','Granite / double charged vitrified']],
                    'luxury'  => ['title'=>'LUXURY COMMERCIAL',  'subtitle'=>'Executive Grade',          'price'=>3200, 'highlighted'=>false, 'features'=>['Fe-550D TMT (SAIL)','Birla cement','Post-tensioned slabs','Marble / granite composite']],
                    'elite'   => ['title'=>'ELITE COMMERCIAL',   'subtitle'=>'Iconic Architecture',      'price'=>3499, 'highlighted'=>false, 'features'=>['Fe-550D TMT (SAIL / JSPL)','Birla Aditya / ACC Gold cement','Post-tensioned slabs','Stone cladding / premium marble']],
                ];
                $shownCom = false;
            @endphp
            @foreach($comTiers as $tier)
                @php
                    $pkg = $commercial[$tier] ?? null;
                    $fb  = $comFallbacks[$tier] ?? null;
                    if (!$pkg && !$fb) continue;
                    $isHL = $pkg ? $pkg->is_highlighted : ($fb['highlighted'] ?? false);
                    $shownCom = true;
                @endphp
                <div class="package-card {{ $isHL ? 'highlighted' : '' }}">
                    @if($isHL)<div class="badge-popular"><i class="fas fa-star" style="margin-right:4px;"></i> MOST POPULAR</div>@endif
                    <div>
                        <span class="plan-tier-label">{{ strtoupper($pkg ? $pkg->division : 'COMMERCIAL') }} • {{ strtoupper($tier) }}</span>
                        <h3 class="plan-title">{{ $pkg ? strtoupper($pkg->title) : ($fb['title'] ?? strtoupper($tier)) }}</h3>
                        <p style="font-size:0.8rem;color:var(--text-muted);">{{ $pkg ? $pkg->subtitle : ($fb['subtitle'] ?? '') }}</p>
                        <div class="plan-price">₹{{ number_format($pkg ? $pkg->price_per_sqft : ($fb['price'] ?? 0)) }} <span>/ sq.ft</span></div>

                        @if($pkg && $pkg->description)
                        <div style="font-size:0.8rem;color:var(--text-muted);margin:16px 0 12px;">{{ $pkg->description }}</div>
                        @endif

                        @if($pkg && $pkg->warranty_years)
                        <div style="display:flex;gap:12px;margin-bottom:16px;">
                            <div class="metric-card" style="flex:1;padding:8px;">
                                <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">{{ $pkg->warranty_years }} Yrs</div>
                                <div style="font-size:0.6rem;color:var(--text-muted);">WARRANTY</div>
                            </div>
                            @if($pkg->delivery_months)
                            <div class="metric-card" style="flex:1;padding:8px;">
                                <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">{{ $pkg->delivery_months }} Mo</div>
                                <div style="font-size:0.6rem;color:var(--text-muted);">DELIVERY</div>
                            </div>
                            @endif
                        </div>
                        @endif

                        <h4 style="font-size:0.8rem;color:var(--gold);font-weight:800;margin-bottom:8px;">KEY MATERIALS & SPECS</h4>
                        <ul class="plan-features-list">
                            @if($pkg && $pkg->features && count($pkg->features))
                                @foreach($pkg->features as $f)<li>{{ $f }}</li>@endforeach
                            @elseif(!$pkg && !empty($fb['features']))
                                @foreach($fb['features'] as $f)<li>{{ $f }}</li>@endforeach
                            @endif
                        </ul>
                    </div>
                    <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                        <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                        <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                    </div>
                </div>
            @endforeach
            @if(!$shownCom)
            {{-- No packages in DB yet: show fallback static --}}
            <div class="package-card">
                <div>
                    <span class="plan-tier-label">BASIC TIER</span>
                    <h3 class="plan-title">STANDARD SHELL</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Functional & Efficient</p>
                    <div class="plan-price">₹2,100 <span>/ sq.ft</span></div>
                    <ul class="plan-features-list">
                        <li>Fe-500 TMT structural steel</li><li>OPC 53 grade cement</li><li>RCC framed structure</li><li>Vitrified floor tiles</li>
                    </ul>
                </div>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                    <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                    <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- WHY OUR PRICING IS DIFFERENT -->
<section class="section-pad" style="background:var(--dark-surface);">
    <div class="container">
        <div style="text-align:center;">
            <span class="sec-tag">TRANSPARENT BILLING</span>
            <h2 class="sec-title">WHY OUR PRICING IS DIFFERENT</h2>
        </div>

        <div class="pricing-grid-3" style="margin-top:40px;">
            <div class="metric-card" style="text-align:left;padding:24px;">
                <div style="font-size:1.6rem;color:var(--gold);margin-bottom:10px;"><i class="fas fa-shield-halved"></i></div>
                <h4 style="color:#fff;font-size:1.1rem;margin-bottom:6px;">ZERO HIDDEN COSTS</h4>
                <p style="font-size:0.85rem;color:var(--text-muted);">Your quoted per-sqft rate is the final rate. No surprise material escalations or hidden labour charges — guaranteed by contract.</p>
            </div>
            <div class="metric-card" style="text-align:left;padding:24px;">
                <div style="font-size:1.6rem;color:var(--gold);margin-bottom:10px;"><i class="fas fa-certificate"></i></div>
                <h4 style="color:#fff;font-size:1.1rem;margin-bottom:6px;">WRITTEN WARRANTY</h4>
                <p style="font-size:0.85rem;color:var(--text-muted);">Every project is backed by a registered structural warranty certificate — up to 20 years for Luxury packages.</p>
            </div>
            <div class="metric-card" style="text-align:left;padding:24px;">
                <div style="font-size:1.6rem;color:var(--gold);margin-bottom:10px;"><i class="fas fa-gem"></i></div>
                <h4 style="color:#fff;font-size:1.1rem;margin-bottom:6px;">BRAND-GRADE MATERIALS</h4>
                <p style="font-size:0.85rem;color:var(--text-muted);">We use only listed brand-grade materials — JSW, UltraTech, Kohler, Legrand — never substituted without your written approval.</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.getElementById('toggleSpecTableBtn')?.addEventListener('click', function() {
    const container = document.getElementById('specTableContainer');
    if (container) {
        if (container.style.display === 'none') {
            container.style.display = 'block';
            this.innerText = 'HIDE SPEC TABLE';
        } else {
            container.style.display = 'none';
            this.innerText = 'VIEW SPEC TABLE';
        }
    }
});
</script>
@endpush

@endsection
