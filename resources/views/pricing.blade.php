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
                    REQUEST FREE ESTIMATE <i class="fas fa-arrow-right" style="margin-left:6px;"></i>
                </button>
            </div>
        </div>

        <!-- SPECIFICATION COMPARISON MATRIX TABLE (COLLAPSIBLE) -->
        <div id="specTableContainer" style="display:none;margin-top:40px;">
            <div class="matrix-modal-header" style="text-align:center;margin-bottom:16px;">
                <span class="sec-tag">MATERIAL MATRIX</span>
                <h3 style="color:#fff;font-size:1.4rem;" id="specTableHeading">COMPLETE SPECIFICATION COMPARISON</h3>
                <p style="font-size:0.85rem;color:var(--text-muted);margin:4px auto 0;max-width:600px;">Direct, transparent benchmark specifications. Every material and structural item is certified and registered.</p>
            </div>

            <!-- Residential Table -->
            <div class="table-responsive" id="specTableResWrap">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>SPECIFICATION</th>
                            @foreach($package_spec_matrix_res['headers'] as $header)
                                <th>{{ strtoupper($header) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($package_spec_matrix_res['rows'] as $row)
                            <tr>
                                <td class="feature-title">{{ $row['feature'] }}</td>
                                @foreach($row['values'] as $val)
                                    <td>{{ $val }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Commercial Table -->
            <div class="table-responsive" id="specTableComWrap" style="display:none;">
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>SPECIFICATION</th>
                            @foreach($package_spec_matrix_com['headers'] as $header)
                                <th>{{ strtoupper($header) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($package_spec_matrix_com['rows'] as $row)
                            <tr>
                                <td class="feature-title">{{ $row['feature'] }}</td>
                                @foreach($row['values'] as $val)
                                    <td>{{ $val }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RESIDENTIAL PRICING CARDS -->
        <div class="pricing-grid-3 package-group" id="pricingResGroup">
            @php
                $resDbPackages = \App\Models\PackageDetail::where('division', 'residential')->get();
                $resFallbacks = [
                    [
                        'tier'=>'basic', 'title'=>'BASIC PLAN', 'subtitle'=>'Solid & Affordable', 'price'=>1999, 'warranty'=>10, 'delivery'=>12,
                        'description'=>'A solid, cost-effective residential build using quality materials, standard-grade finishes, and proven structural systems — ideal for budget-conscious homeowners.',
                        'features'=>['Fe-500 TMT steel','Coromandel / ACC cement','M-Sand blockwork','Vitrified floor tiles (2\'×2\')','Parryware CP fittings','Kundan / Anchor concealed wiring','Flush door entry system','Asian Paints Emulsion finish'],
                        'inclusions'=>['Site supervision','Civil structural work','Plastering & waterproofing','Electrical wiring (concealed)','Plumbing works','Toilet sanitary fixtures','Main door with frame'],
                        'exclusions'=>['Interior design','Modular kitchen','Landscaping','Smart home systems'],
                        'highlighted'=>false
                    ],
                    [
                        'tier'=>'standard', 'title'=>'STANDARD PLAN', 'subtitle'=>'Value & Performance', 'price'=>2199, 'warranty'=>12, 'delivery'=>13,
                        'description'=>'An upgraded residential package with reinforced materials, enhanced bath fixtures, and premium electrical fittings for enhanced comfort.',
                        'features'=>['Fe-500D TMT steel','ACC / Ramco cement','Washed M-Sand','Vitrified tiles (2\'×4\')','Cera CP fittings','Finolex wiring','Flush door','Asian Paints Ace finish'],
                        'inclusions'=>['Site supervision','Complete civil structure','Waterproofing','Underground sump & overhead tank','Concealed wiring & plumbing','Parryware / Cera sanitaryware'],
                        'exclusions'=>['Interior false ceiling','Modular kitchen','Exterior paving & landscaping'],
                        'highlighted'=>false
                    ],
                    [
                        'tier'=>'premium', 'title'=>'PREMIUM PLAN', 'subtitle'=>'Quality & Elegance', 'price'=>2399, 'warranty'=>15, 'delivery'=>14,
                        'description'=>'A premium residential construction package with superior materials, polished finishes, and enhanced structural systems — built for growing families seeking elevated quality.',
                        'features'=>['Fe-550 TMT (JSW / Vizag Steel)','Ultratech Premium / Dalmia cement','Double-washed M-Sand','Kajaria double charged tiles (4\'×2\')','Jaquar sanitary & CP sets','Polycab wires & Roma switches','Teak wood entry door','Asian Paints Apex Ultima'],
                        'inclusions'=>['All Basic inclusions','Modular kitchen carcass','Premium tile work','CCTV provision','Power backup provision','Gypsum ceiling in living areas'],
                        'exclusions'=>['Interior furniture','Landscaping','Smart automation'],
                        'highlighted'=>true
                    ],
                    [
                        'tier'=>'luxury', 'title'=>'LUXURY PLAN', 'subtitle'=>'Elite Craftsmanship', 'price'=>2999, 'warranty'=>20, 'delivery'=>18,
                        'description'=>'A fully bespoke luxury residential build using world-class materials, custom architectural details, and premium brand fixtures — crafted for discerning homeowners.',
                        'features'=>['Fe-550 TMT (Tata Tiscon / JSPL)','Birla Super / ACC Gold cement','River sand / premium concrete sand','Italian Travertine / marble slabs','Kohler / Grohe collection','Finolex cables & Legrand switches','First-grade carved teak doors','Royale textured / custom panel finish'],
                        'inclusions'=>['All Premium inclusions','Full modular kitchen','Smart home pre-wiring','Home theatre provision','Landscape design (basic)','Custom ceiling designs','Premium bathroom accessories'],
                        'exclusions'=>['Smart home devices','Furniture & furnishings'],
                        'highlighted'=>false
                    ],
                ];
                $activeResPackages = $resDbPackages->isNotEmpty() ? $resDbPackages : collect($resFallbacks);
            @endphp
            @foreach($activeResPackages as $pkgItem)
                @php
                    $isModel = $pkgItem instanceof \App\Models\PackageDetail;
                    $isHL = $isModel ? $pkgItem->is_highlighted : ($pkgItem['highlighted'] ?? false);
                    $title = strtoupper($isModel ? $pkgItem->title : $pkgItem['title']);
                    $subtitle = $isModel ? $pkgItem->subtitle : ($pkgItem['subtitle'] ?? '');
                    $price = $isModel ? $pkgItem->price_per_sqft : ($pkgItem['price'] ?? null);
                    $warranty = $isModel ? ($pkgItem->warranty_years ?? 10) : ($pkgItem['warranty'] ?? 10);
                    $delivery = $isModel ? ($pkgItem->delivery_months ?? 12) : ($pkgItem['delivery'] ?? 12);
                    $rawTier = $isModel ? ($pkgItem->tier ?? 'Standard') : ($pkgItem['tier'] ?? 'Standard');
                    $tierClean = strtoupper(trim(preg_replace('/\btier\b/i', '', $rawTier)));
                    $tierLabel = ($tierClean ? $tierClean . ' TIER' : 'STANDARD TIER') . ($warranty ? ' • ' . $warranty . ' Yrs Warranty' : '');
                    $features = $isModel ? ((is_array($pkgItem->features) && count($pkgItem->features)) ? $pkgItem->features : ['Brand-grade structural materials', 'Concealed electrical & plumbing', 'Quality vitrified flooring', 'Standard CP fittings']) : ($pkgItem['features'] ?? []);
                    $inclusions = $isModel ? ((is_array($pkgItem->inclusions) && count($pkgItem->inclusions)) ? $pkgItem->inclusions : ['Site supervision', 'Civil structural work', 'Plastering & waterproofing']) : ($pkgItem['inclusions'] ?? []);
                    $exclusions = $isModel ? ((is_array($pkgItem->exclusions) && count($pkgItem->exclusions)) ? $pkgItem->exclusions : ['Interior design', 'Modular kitchen']) : ($pkgItem['exclusions'] ?? []);
                    $description = $isModel ? ($pkgItem->description ?? 'Turnkey residential construction package engineered with registered engineer supervision.') : ($pkgItem['description'] ?? '');
                    $pkgPayload = [
                        'division'       => 'residential',
                        'tier'           => $rawTier,
                        'title'          => $title,
                        'subtitle'       => $subtitle,
                        'price_per_sqft' => $price,
                        'warranty_years' => $warranty,
                        'delivery_months'=> $delivery,
                        'description'    => $description,
                        'features'       => $features,
                        'inclusions'     => $inclusions,
                        'exclusions'     => $exclusions,
                    ];
                @endphp
                <div class="package-card {{ $isHL ? 'highlighted' : '' }}">
                    @if($isHL)<div class="badge-popular"><i class="fas fa-star" style="margin-right:4px;"></i> MOST POPULAR</div>@endif
                    <div>
                        <span class="plan-tier-label">{{ $tierLabel }}</span>
                        <h3 class="plan-title">{{ $title }}</h3>
                        <p style="font-size:0.8rem;color:var(--text-muted);">{{ $subtitle }}</p>
                        @if($price && $price > 0)
                            <div class="plan-price">₹{{ number_format($price) }} <span>/ sq.ft</span></div>
                        @else
                            <div class="plan-price" style="font-size:1.35rem;letter-spacing:0.02em;">CUSTOM ESTIMATE <span style="font-size:0.75rem;display:block;color:var(--text-muted);font-weight:400;margin-top:2px;">Rate upon site consultation</span></div>
                        @endif

                        @if($description)
                        <div style="font-size:0.8rem;color:var(--text-muted);margin:16px 0 12px;line-height:1.5;">{{ $description }}</div>
                        @endif

                        <div style="display:flex;gap:12px;margin-bottom:16px;">
                            <div class="metric-card" style="flex:1;padding:8px;">
                                <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">{{ $warranty }} Yrs</div>
                                <div style="font-size:0.6rem;color:var(--text-muted);">WARRANTY</div>
                            </div>
                            <div class="metric-card" style="flex:1;padding:8px;">
                                <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">{{ $delivery }} Mo</div>
                                <div style="font-size:0.6rem;color:var(--text-muted);">DELIVERY</div>
                            </div>
                        </div>

                        <h4 style="font-size:0.8rem;color:var(--gold);font-weight:800;margin-bottom:8px;">KEY MATERIALS & SPECS</h4>
                        <ul class="plan-features-list">
                            @foreach($features as $f)<li>{{ $f }}</li>@endforeach
                        </ul>
                    </div>
                    <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                        <button type="button" class="btn-gold-pill" style="justify-content:center;" data-open-package-details data-package="{{ json_encode($pkgPayload) }}">
                            <i class="fas fa-list-check" style="margin-right:6px;"></i> VIEW INCLUSIONS & DETAILS
                        </button>
                        <button type="button" class="btn-whatsapp-outline" style="width:100%;justify-content:center;border-color:var(--border-gold);color:var(--text-cream);padding:10px;" data-open-quote>
                            <i class="fas fa-paper-plane" style="margin-right:6px;"></i> REQUEST ESTIMATE
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- COMMERCIAL PRICING CARDS -->
        <div class="pricing-grid-3 package-group" id="pricingComGroup" style="display:none;">
            @php
                $comDbPackages = \App\Models\PackageDetail::where('division', 'commercial')->get();
                $comFallbacks = [
                    [
                        'tier'=>'basic', 'title'=>'STANDARD SHELL', 'subtitle'=>'Functional & Efficient', 'price'=>2199, 'warranty'=>10, 'delivery'=>14, 'highlighted'=>false,
                        'description'=>'A functional, code-compliant commercial shell ideal for office spaces, retail outlets, and light commercial use — efficient and cost-effective at scale.',
                        'features'=>['Fe-500 TMT structural steel','OPC 53 grade cement','RCC framed structure','Vitrified floor tiles'],
                        'inclusions'=>['Core structural work','Basic MEP (electrical & plumbing)','Slab & column concrete','External plastering','Staircase with MS railing','Commercial-grade flooring','Waterproofing of terrace'],
                        'exclusions'=>['Interior partitions','HVAC systems','False ceiling','Fire safety systems']
                    ],
                    [
                        'tier'=>'standard', 'title'=>'ENHANCED SHELL', 'subtitle'=>'Commercial Value', 'price'=>2499, 'warranty'=>12, 'delivery'=>16, 'highlighted'=>false,
                        'description'=>'Enhanced commercial core & shell with improved structural capacity, higher grade steel, and commercial plumbing provisions.',
                        'features'=>['Fe-500D TMT steel','Ultratech cement','RCC frame','Granito tiles'],
                        'inclusions'=>['Structural framing','Common area flooring','Main electrical riser','Plumbing shaft provisions','External facade base plaster'],
                        'exclusions'=>['Tenant interior fitouts','Elevator cabins','Air conditioning']
                    ],
                    [
                        'tier'=>'premium', 'title'=>'PREMIUM CORPORATE', 'subtitle'=>'Professional & Polished', 'price'=>2799, 'warranty'=>15, 'delivery'=>18, 'highlighted'=>true,
                        'description'=>'A professional-grade commercial building with premium structural detailing, enhanced MEP systems, and modern facade finishes — suited for corporate offices and retail centers.',
                        'features'=>['Fe-550 TMT (JSW Steel)','Ultratech / Ambuja cement','RCC frame + shear walls','Granite / double charged vitrified'],
                        'inclusions'=>['All Shell inclusions','False ceiling provision','Lift pit & motor room','HVAC duct provision','Fire hydrant system','CCTV & access control provision','DG set provision'],
                        'exclusions'=>['Fit-out interiors','IT infrastructure','Furniture']
                    ],
                    [
                        'tier'=>'luxury', 'title'=>'ELITE COMMERCIAL', 'subtitle'=>'Iconic Architecture', 'price'=>3499, 'warranty'=>20, 'delivery'=>24, 'highlighted'=>false,
                        'description'=>'An iconic high-end commercial tower built to global standards — with curtain wall facades, high-capacity MEP systems, and architectural features that define city skylines.',
                        'features'=>['Fe-550D TMT (SAIL / JSPL)','Birla Aditya / ACC Gold cement','Post-tensioned slabs','Stone cladding / premium marble'],
                        'inclusions'=>['All Premium inclusions','Intelligent BMS system','Full fire suppression system','VRF HVAC system','High-speed elevator system','Basement parking structure','Green building LEED compliance','Architectural lighting design'],
                        'exclusions'=>['Tenant fit-out works','IT & AV systems']
                    ],
                ];
                $activeComPackages = $comDbPackages->isNotEmpty() ? $comDbPackages : collect($comFallbacks);
            @endphp
            @foreach($activeComPackages as $pkgItem)
                @php
                    $isModel = $pkgItem instanceof \App\Models\PackageDetail;
                    $isHL = $isModel ? $pkgItem->is_highlighted : ($pkgItem['highlighted'] ?? false);
                    $title = strtoupper($isModel ? $pkgItem->title : $pkgItem['title']);
                    $subtitle = $isModel ? $pkgItem->subtitle : ($pkgItem['subtitle'] ?? '');
                    $price = $isModel ? $pkgItem->price_per_sqft : ($pkgItem['price'] ?? null);
                    $warranty = $isModel ? ($pkgItem->warranty_years ?? 10) : ($pkgItem['warranty'] ?? 10);
                    $delivery = $isModel ? ($pkgItem->delivery_months ?? 12) : ($pkgItem['delivery'] ?? 12);
                    $rawTier = $isModel ? ($pkgItem->tier ?? 'Standard') : ($pkgItem['tier'] ?? 'Standard');
                    $tierClean = strtoupper(trim(preg_replace('/\btier\b/i', '', $rawTier)));
                    $tierLabel = ($tierClean ? $tierClean . ' TIER' : 'STANDARD TIER') . ($warranty ? ' • ' . $warranty . ' Yrs Warranty' : '');
                    $features = $isModel ? ((is_array($pkgItem->features) && count($pkgItem->features)) ? $pkgItem->features : ['Core structural frame', 'Basic MEP works', 'Industrial grade electrical', 'Aluminium doors & windows']) : ($pkgItem['features'] ?? []);
                    $inclusions = $isModel ? ((is_array($pkgItem->inclusions) && count($pkgItem->inclusions)) ? $pkgItem->inclusions : ['Core structural work', 'External plastering', 'Terrace waterproofing']) : ($pkgItem['inclusions'] ?? []);
                    $exclusions = $isModel ? ((is_array($pkgItem->exclusions) && count($pkgItem->exclusions)) ? $pkgItem->exclusions : ['Interior partitions', 'HVAC systems']) : ($pkgItem['exclusions'] ?? []);
                    $description = $isModel ? ($pkgItem->description ?? 'Turnkey commercial construction package built to code and structural specifications.') : ($pkgItem['description'] ?? '');
                    $pkgPayload = [
                        'division'       => 'commercial',
                        'tier'           => $rawTier,
                        'title'          => $title,
                        'subtitle'       => $subtitle,
                        'price_per_sqft' => $price,
                        'warranty_years' => $warranty,
                        'delivery_months'=> $delivery,
                        'description'    => $description,
                        'features'       => $features,
                        'inclusions'     => $inclusions,
                        'exclusions'     => $exclusions,
                    ];
                @endphp
                <div class="package-card {{ $isHL ? 'highlighted' : '' }}">
                    @if($isHL)<div class="badge-popular"><i class="fas fa-star" style="margin-right:4px;"></i> MOST POPULAR</div>@endif
                    <div>
                        <span class="plan-tier-label">{{ $tierLabel }}</span>
                        <h3 class="plan-title">{{ $title }}</h3>
                        <p style="font-size:0.8rem;color:var(--text-muted);">{{ $subtitle }}</p>
                        @if($price && $price > 0)
                            <div class="plan-price">₹{{ number_format($price) }} <span>/ sq.ft</span></div>
                        @else
                            <div class="plan-price" style="font-size:1.35rem;letter-spacing:0.02em;">CUSTOM ESTIMATE <span style="font-size:0.75rem;display:block;color:var(--text-muted);font-weight:400;margin-top:2px;">Rate upon site consultation</span></div>
                        @endif

                        @if($description)
                        <div style="font-size:0.8rem;color:var(--text-muted);margin:16px 0 12px;line-height:1.5;">{{ $description }}</div>
                        @endif

                        <div style="display:flex;gap:12px;margin-bottom:16px;">
                            <div class="metric-card" style="flex:1;padding:8px;">
                                <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">{{ $warranty }} Yrs</div>
                                <div style="font-size:0.6rem;color:var(--text-muted);">WARRANTY</div>
                            </div>
                            <div class="metric-card" style="flex:1;padding:8px;">
                                <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">{{ $delivery }} Mo</div>
                                <div style="font-size:0.6rem;color:var(--text-muted);">DELIVERY</div>
                            </div>
                        </div>

                        <h4 style="font-size:0.8rem;color:var(--gold);font-weight:800;margin-bottom:8px;">KEY MATERIALS & SPECS</h4>
                        <ul class="plan-features-list">
                            @foreach($features as $f)<li>{{ $f }}</li>@endforeach
                        </ul>
                    </div>
                    <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                        <button type="button" class="btn-gold-pill" style="justify-content:center;" data-open-package-details data-package="{{ json_encode($pkgPayload) }}">
                            <i class="fas fa-list-check" style="margin-right:6px;"></i> VIEW INCLUSIONS & DETAILS
                        </button>
                        <button type="button" class="btn-whatsapp-outline" style="width:100%;justify-content:center;border-color:var(--border-gold);color:var(--text-cream);padding:10px;" data-open-quote>
                            <i class="fas fa-paper-plane" style="margin-right:6px;"></i> REQUEST ESTIMATE
                        </button>
                    </div>
                </div>
            @endforeach
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
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleSpecTableBtn');
    const container = document.getElementById('specTableContainer');
    const resWrap   = document.getElementById('specTableResWrap');
    const comWrap   = document.getElementById('specTableComWrap');
    const heading   = document.getElementById('specTableHeading');

    if (toggleBtn && container) {
        toggleBtn.addEventListener('click', function() {
            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'block';
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash" style="margin-right:6px;"></i> HIDE SPEC TABLE';
                container.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                container.style.display = 'none';
                toggleBtn.innerHTML = '<i class="fas fa-table" style="margin-right:6px;"></i> VIEW SPEC TABLE';
            }
        });
    }

    // Connect residential / commercial tabs to spec table display
    document.querySelectorAll('.package-tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.getAttribute('data-target-group');
            const isCommercial = (target === 'pricingComGroup');
            if (resWrap && comWrap) {
                if (isCommercial) {
                    resWrap.style.display = 'none';
                    comWrap.style.display = 'block';
                    if (heading) heading.textContent = 'COMMERCIAL SPECIFICATION COMPARISON';
                } else {
                    resWrap.style.display = 'block';
                    comWrap.style.display = 'none';
                    if (heading) heading.textContent = 'RESIDENTIAL SPECIFICATION COMPARISON';
                }
            }
        });
    });
});
</script>
@endpush

@endsection
