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
            <div class="package-card">
                <div>
                    <span class="plan-tier-label">BASIC TIER</span>
                    <h3 class="plan-title">BASIC PLAN</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Solid & Affordable</p>
                    <div class="plan-price">₹1,999 <span>/ sq.ft</span></div>

                    <div style="font-size:0.8rem;color:var(--text-muted);margin:16px 0 12px;">
                        A solid, cost-effective residential build using quality materials, standard-grade finishes, and proven structural systems — ideal for budget-conscious homeowners.
                    </div>

                    <div style="display:flex;gap:12px;margin-bottom:16px;">
                        <div class="metric-card" style="flex:1;padding:8px;">
                            <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">10 Yrs</div>
                            <div style="font-size:0.6rem;color:var(--text-muted);">WARRANTY</div>
                        </div>
                        <div class="metric-card" style="flex:1;padding:8px;">
                            <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">12 Mo</div>
                            <div style="font-size:0.6rem;color:var(--text-muted);">DELIVERY</div>
                        </div>
                    </div>

                    <h4 style="font-size:0.8rem;color:var(--gold);font-weight:800;margin-bottom:8px;">KEY MATERIALS & SPECS</h4>
                    <ul class="plan-features-list">
                        <li>Fe-500 TMT steel</li>
                        <li>Coromandel / ACC cement</li>
                        <li>M-Sand blockwork</li>
                        <li>Vitrified floor tiles (2'×2')</li>
                        <li>Parryware CP fittings</li>
                        <li>Kundan / Anchor concealed wiring</li>
                        <li>Flush door entry system</li>
                        <li>Asian Paints Emulsion finish</li>
                    </ul>
                </div>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                    <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                    <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                </div>
            </div>

            <div class="package-card highlighted">
                <div class="badge-popular"><i class="fas fa-star" style="margin-right:4px;"></i> MOST POPULAR</div>
                <div>
                    <span class="plan-tier-label">PREMIUM TIER</span>
                    <h3 class="plan-title">PREMIUM PLAN</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Quality & Elegance</p>
                    <div class="plan-price">₹2,399 <span>/ sq.ft</span></div>

                    <div style="font-size:0.8rem;color:var(--text-muted);margin:16px 0 12px;">
                        A premium residential construction package with superior materials, polished finishes, and enhanced structural systems — built for growing families seeking elevated quality.
                    </div>

                    <div style="display:flex;gap:12px;margin-bottom:16px;">
                        <div class="metric-card" style="flex:1;padding:8px;">
                            <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">15 Yrs</div>
                            <div style="font-size:0.6rem;color:var(--text-muted);">WARRANTY</div>
                        </div>
                        <div class="metric-card" style="flex:1;padding:8px;">
                            <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">14 Mo</div>
                            <div style="font-size:0.6rem;color:var(--text-muted);">DELIVERY</div>
                        </div>
                    </div>

                    <h4 style="font-size:0.8rem;color:var(--gold);font-weight:800;margin-bottom:8px;">KEY MATERIALS & SPECS</h4>
                    <ul class="plan-features-list">
                        <li>Fe-550 TMT (JSW / Vizag Steel)</li>
                        <li>Ultratech Premium / Dalmia cement</li>
                        <li>Double-washed M-Sand</li>
                        <li>Kajaria double charged tiles (4'×2')</li>
                        <li>Jaquar sanitary & CP sets</li>
                        <li>Polycab wires & Roma switches</li>
                        <li>Teak wood entry door</li>
                        <li>Asian Paints Apex Ultima</li>
                    </ul>
                </div>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                    <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                    <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                </div>
            </div>

            <div class="package-card">
                <div>
                    <span class="plan-tier-label">LUXURY TIER</span>
                    <h3 class="plan-title">LUXURY PLAN</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Elite Craftsmanship</p>
                    <div class="plan-price">₹2,999 <span>/ sq.ft</span></div>

                    <div style="font-size:0.8rem;color:var(--text-muted);margin:16px 0 12px;">
                        A fully bespoke luxury residential build using world-class materials, custom architectural details, and premium brand fixtures — crafted for discerning homeowners.
                    </div>

                    <div style="display:flex;gap:12px;margin-bottom:16px;">
                        <div class="metric-card" style="flex:1;padding:8px;">
                            <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">20 Yrs</div>
                            <div style="font-size:0.6rem;color:var(--text-muted);">WARRANTY</div>
                        </div>
                        <div class="metric-card" style="flex:1;padding:8px;">
                            <div style="font-size:0.9rem;font-weight:800;color:var(--gold);">18 Mo</div>
                            <div style="font-size:0.6rem;color:var(--text-muted);">DELIVERY</div>
                        </div>
                    </div>

                    <h4 style="font-size:0.8rem;color:var(--gold);font-weight:800;margin-bottom:8px;">KEY MATERIALS & SPECS</h4>
                    <ul class="plan-features-list">
                        <li>Fe-550 TMT (Tata Tiscon / JSPL)</li>
                        <li>Birla Super / ACC Gold cement</li>
                        <li>River sand / premium concrete sand</li>
                        <li>Italian Travertine / marble slabs</li>
                        <li>Kohler / Grohe collection</li>
                        <li>Finolex cables & Legrand switches</li>
                        <li>First-grade carved teak doors</li>
                        <li>Royale textured / custom panel finish</li>
                    </ul>
                </div>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                    <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                    <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                </div>
            </div>
        </div>

        <!-- COMMERCIAL PRICING CARDS -->
        <div class="pricing-grid-3 package-group" id="pricingComGroup" style="display:none;">
            <div class="package-card">
                <div>
                    <span class="plan-tier-label">BASIC TIER</span>
                    <h3 class="plan-title">STANDARD SHELL</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Functional & Efficient</p>
                    <div class="plan-price">₹2,100 <span>/ sq.ft</span></div>
                    <ul class="plan-features-list">
                        <li>Fe-500 TMT structural steel</li>
                        <li>OPC 53 grade cement</li>
                        <li>RCC framed structure</li>
                        <li>Vitrified floor tiles</li>
                    </ul>
                </div>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                    <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                    <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                </div>
            </div>

            <div class="package-card highlighted">
                <div class="badge-popular"><i class="fas fa-star" style="margin-right:4px;"></i> MOST POPULAR</div>
                <div>
                    <span class="plan-tier-label">PREMIUM TIER</span>
                    <h3 class="plan-title">PREMIUM CORPORATE</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Professional & Polished</p>
                    <div class="plan-price">₹2,799 <span>/ sq.ft</span></div>
                    <ul class="plan-features-list">
                        <li>Fe-550 TMT (JSW Steel)</li>
                        <li>Ultratech / Ambuja cement</li>
                        <li>RCC frame + shear walls</li>
                        <li>Granite / double charged vitrified</li>
                    </ul>
                </div>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                    <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                    <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                </div>
            </div>

            <div class="package-card">
                <div>
                    <span class="plan-tier-label">LUXURY TIER</span>
                    <h3 class="plan-title">ELITE COMMERCIAL</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Iconic Architecture</p>
                    <div class="plan-price">₹3,499 <span>/ sq.ft</span></div>
                    <ul class="plan-features-list">
                        <li>Fe-550D TMT (SAIL / JSPL)</li>
                        <li>Birla Aditya / ACC Gold cement</li>
                        <li>Post-tensioned slabs</li>
                        <li>Stone cladding / premium marble</li>
                    </ul>
                </div>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:8px;">
                    <button class="btn-gold-pill" style="justify-content:center;" data-open-quote>CALCULATE MY COST</button>
                    <button class="btn-whatsapp-outline" style="justify-content:center;border-color:var(--border-gold);color:var(--text-cream);" data-open-quote>GET FREE QUOTE</button>
                </div>
            </div>
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
