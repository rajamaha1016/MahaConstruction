@extends('layouts.app')

@section('title', 'Maha Construction | Premium Luxury Architectural Masterpieces')

@section('content')

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-text-col">
                <div class="pill-badge">
                    <span class="pulse-dot"></span>
                    <span>OUR BRANCHES ARE KANYAKUMARI, TIRUNELVELI, AND CHENNAI</span>
                </div>
                <h1 class="hero-title">
                    BUILDING LUXURY ARCHITECTURAL MASTERPIECES WITH UNCOMPROMISING EXCELLENCE
                </h1>
                <p class="hero-subtitle">
                    Tamil Nadu's premier government-registered engineering firm delivering custom luxury villas, residential residences, and architectural homes with itemized material transparency and 15-year structural warranties.
                </p>
                <div class="hero-checklist">
                    <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> Premium Materials</span>
                    <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> Transparent Pricing</span>
                    <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> On-Time Delivery</span>
                    <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> Expert Engineers</span>
                    <span class="check-item"><span class="check-icon"><i class="fas fa-check"></i></span> Lifetime Support</span>
                </div>
                <div class="hero-cta-group">
                    <button class="btn-gold-pill" data-open-quote>
                        BOOK FREE CONSULTATION
                    </button>
                    <a href="https://wa.me/919488888758?text=Hello%20Er.%20Maha%20Rajan%2C%20I%20want%20to%20consult%20for%20my%20luxury%20home." target="_blank" class="btn-whatsapp-outline">
                        <i class="fab fa-whatsapp" style="font-size:18px;"></i>
                        WHATSAPP DIRECT
                    </a>
                </div>
            </div>

            <div class="hero-image-col">
                <div style="text-align:center;position:relative;">
                    <img src="{{ asset('maha-rajan.png') }}" alt="Er. Maha Rajan" style="width:100%;max-width:420px;height:auto;object-fit:cover;display:block;margin:0 auto;position:relative;z-index:1;">

                    <!-- Engineer Name Card (Overlapping bottom of image with 0 gap) -->
                    <div style="margin-top:-65px;position:relative;z-index:5;max-width:380px;margin-left:auto;margin-right:auto;padding:15px 18px 14px;background:linear-gradient(135deg,rgba(11,19,43,0.96),rgba(5,11,20,0.98));backdrop-filter:blur(10px);border:1.5px solid rgba(212,175,55,0.6);border-radius:18px;box-shadow:0 0 35px rgba(212,175,55,0.25),0 12px 35px rgba(0,0,0,0.7);overflow:hidden;">
                        <!-- Glow top line -->
                        <div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(to right,transparent,#D4AF37,#FFD700,#D4AF37,transparent);"></div>

                        <!-- ER. prefix -->
                        <div style="font-size:0.68rem;font-weight:800;letter-spacing:0.25em;color:#D4AF37;text-transform:uppercase;margin-bottom:3px;opacity:0.9;">— GOVERNMENT REGISTERED ENGINEER —</div>

                        <!-- Name with gradient -->
                        <div style="font-size:1.65rem;font-weight:900;letter-spacing:0.04em;line-height:1.1;background:linear-gradient(135deg,#FFD700 0%,#D4AF37 40%,#FFF8DC 60%,#D4AF37 80%,#B8960C 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 0 8px rgba(212,175,55,0.4));">Er. MAHA RAJAN</div>

                        <!-- Decorative divider -->
                        <div style="display:flex;align-items:center;gap:8px;margin:8px 0 8px;">
                            <div style="flex:1;height:1px;background:linear-gradient(to right,transparent,rgba(212,175,55,0.6));"></div>
                            <div style="width:5px;height:5px;background:#D4AF37;border-radius:50%;box-shadow:0 0 8px #D4AF37;"></div>
                            <div style="flex:1;height:1px;background:linear-gradient(to left,transparent,rgba(212,175,55,0.6));"></div>
                        </div>

                        <!-- Role -->
                        <div style="font-size:0.85rem;font-weight:700;color:#F0EBE0;letter-spacing:0.08em;text-transform:uppercase;margin-top:2px;">CEO OF MAHA CONSTRUCTIONS</div>

                        <!-- Glow bottom line -->
                        <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(to right,transparent,#D4AF37,#FFD700,#D4AF37,transparent);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5 STATS METRICS BAR -->
<section class="stats-metrics-bar">
    <div class="container">
        <div class="stats-grid-5">
            <div class="metric-card">
                <div class="metric-number">10+</div>
                <div class="metric-label">Years Experience</div>
            </div>
            <div class="metric-card">
                <div class="metric-number">150+</div>
                <div class="metric-label">Happy Families</div>
            </div>
            <div class="metric-card">
                <div class="metric-number">100+</div>
                <div class="metric-label">Completed Projects</div>
            </div>
            <div class="metric-card">
                <div class="metric-number">15-Yr</div>
                <div class="metric-label">Structural Warranty</div>
            </div>
            <div class="metric-card">
                <div class="metric-number">100%</div>
                <div class="metric-label">Quality Audit Guarantee</div>
            </div>
        </div>
    </div>
</section>

<!-- HOMES WE'VE PROUDLY DELIVERED (AUTO-SCROLLING PORTFOLIO CAROUSEL — HIREANDBUILD MODEL) -->
<section class="section-pad" id="delivered-homes-section">
    <div class="container">
        <div style="text-align:center;">
            <span class="pill-badge" style="background:rgba(212,175,55,0.12);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.75rem;padding:6px 16px;letter-spacing:0.15em;">
                OUR COMPLETED PROJECTS
            </span>
            <h2 class="sec-title" style="margin-top:12px;">
                HOMES WE'VE PROUDLY DELIVERED
            </h2>
            <p class="sec-sub" style="margin:10px auto 0;max-width:680px;">
                Trusted by homeowners across Tamil Nadu to design and build their landmark luxury villas, turnkey residences, and architectural homes.
            </p>
        </div>

        <div class="projects-carousel-wrap" style="position:relative;margin-top:36px;">
            <!-- Auto-Scrolling Track -->
            <div class="projects-track" id="projectsTrack" style="display:flex;gap:24px;overflow-x:auto;scroll-snap-type:x mandatory;padding:16px 8px 32px;scrollbar-width:none;-webkit-overflow-scrolling:touch;">
                @forelse($projects as $i => $project)
                <div class="hb-project-card project-slide-card {{ $i === 0 ? 'is-active' : '' }}"
                     @if($project->video_url) onclick="window.playVideoModal('{{ $project->video_url }}', '{{ addslashes($project->name) }}')" style="cursor:pointer;" @endif
                     style="flex:0 0 auto;width:340px;max-width:88vw;scroll-snap-align:center;background:#0B132B;border:1.5px solid rgba(212,175,55,0.25);border-radius:20px;overflow:hidden;transition:all 0.3s ease;display:flex;flex-direction:column;box-shadow:0 10px 30px rgba(0,0,0,0.4);"
                     onmouseover="this.style.borderColor='#D4AF37';this.style.transform='translateY(-6px)';this.style.boxShadow='0 20px 40px rgba(212,175,55,0.2)';"
                     onmouseout="this.style.borderColor='rgba(212,175,55,0.25)';this.style.transform='translateY(0)';this.style.boxShadow='0 10px 30px rgba(0,0,0,0.4)';">
                    <!-- Thumbnail Frame -->
                    <div style="position:relative;height:230px;overflow:hidden;background:#050B14;">
                        <img src="{{ ($project->image_urls && count($project->image_urls)>0) ? $project->image_urls[0] : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80' }}"
                             alt="{{ $project->name }}"
                             style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;"
                             loading="lazy">

                        <!-- Top Completed Badge -->
                        <div style="position:absolute;top:14px;left:14px;background:rgba(5,11,20,0.85);backdrop-filter:blur(6px);border:1px solid rgba(212,175,55,0.6);border-radius:20px;padding:4px 12px;display:flex;align-items:center;gap:6px;">
                            <span style="width:6px;height:6px;background:#25D366;border-radius:50%;display:inline-block;box-shadow:0 0 6px #25D366;"></span>
                            <span style="font-size:0.68rem;font-weight:800;color:#D4AF37;letter-spacing:0.1em;text-transform:uppercase;">COMPLETED</span>
                        </div>

                        @if($project->video_url)
                        <!-- Video Play Overlay Trigger -->
                        <div class="video-play-overlay" data-video-url="{{ $project->video_url }}" onclick="event.stopPropagation(); window.playVideoModal('{{ $project->video_url }}', '{{ addslashes($project->name) }}')" style="position:absolute;inset:0;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.1)';" onmouseout="this.style.background='rgba(0,0,0,0.3)';">
                            <div class="play-btn-circle" style="width:52px;height:52px;font-size:1.2rem;background:#D4AF37;color:#050B14;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 24px rgba(212,175,55,0.6);"><i class="fas fa-play" style="font-size:1rem;margin-left:3px;"></i></div>
                        </div>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div style="padding:20px 22px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                        <div>
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                                <h3 style="font-size:1.15rem;font-weight:800;color:#FFFFFF;line-height:1.3;text-transform:uppercase;letter-spacing:0.02em;">{{ $project->name }}</h3>
                                @if($project->video_url)
                                <span style="font-size:0.65rem;color:#D4AF37;background:rgba(212,175,55,0.12);padding:2px 8px;border-radius:10px;font-weight:700;white-space:nowrap;"><i class="fas fa-video" style="margin-right:3px;"></i>Video Tour</span>
                                @endif
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;color:#D4AF37;font-size:0.85rem;font-weight:600;margin-top:6px;">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $project->location ?? 'Nagercoil, Tamil Nadu' }}</span>
                            </div>
                        </div>

                        <!-- Divider & Specs Table -->
                        <div style="margin-top:16px;padding-top:14px;border-top:1px solid rgba(212,175,55,0.18);">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;font-size:0.85rem;">
                                <span style="color:#94A3B8;font-weight:600;">Built-Up Area</span>
                                <span style="color:#FFFFFF;font-weight:800;">{{ $project->duration ? $project->duration : '2,500 sq.ft' }}</span>
                            </div>
                            <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.85rem;">
                                <span style="color:#94A3B8;font-weight:600;">Project Type</span>
                                <span style="color:#D4AF37;font-weight:800;">{{ $project->category ? ucfirst($project->category) : 'Luxury Villa' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="width:100%;text-align:center;color:#94A3B8;padding:40px;">
                    No completed projects added yet.
                </div>
                @endforelse
            </div>

            <!-- Progress Bar Tracker -->
            <div class="projects-progress-track" style="height:3px;background:rgba(255,255,255,0.1);border-radius:4px;max-width:480px;margin:0 auto;overflow:hidden;">
                <div class="projects-progress-fill" id="projectsProgressFill" style="height:100%;background:linear-gradient(90deg,#D4AF37,#FFD700);border-radius:4px;width:0%;transition:width 0.2s ease;"></div>
            </div>

            <!-- Navigation Controls: Arrows & Dots -->
            <div class="projects-controls" style="display:flex;align-items:center;justify-content:center;gap:18px;margin-top:24px;">
                <button class="projects-arrow-btn" id="projectsPrevBtn" aria-label="Previous project" style="width:44px;height:44px;border-radius:50%;border:1px solid rgba(212,175,55,0.4);background:rgba(11,19,43,0.8);color:#D4AF37;font-size:1.1rem;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='#D4AF37';this.style.color='#050B14';" onmouseout="this.style.background='rgba(11,19,43,0.8)';this.style.color='#D4AF37';"><i class="fas fa-arrow-left"></i></button>
                <div class="projects-dots" id="projectsDots" style="display:flex;gap:6px;"></div>
                <button class="projects-arrow-btn" id="projectsNextBtn" aria-label="Next project" style="width:44px;height:44px;border-radius:50%;border:1px solid rgba(212,175,55,0.4);background:rgba(11,19,43,0.8);color:#D4AF37;font-size:1.1rem;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='#D4AF37';this.style.color='#050B14';" onmouseout="this.style.background='rgba(11,19,43,0.8)';this.style.color='#D4AF37';"><i class="fas fa-arrow-right"></i></button>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div style="text-align:center;margin-top:48px;">
            <p style="font-size:0.88rem;color:#94A3B8;margin-bottom:16px;">
                Showing {{ $projects->count() }} of 100+ Landmark Residences Built Across Tamil Nadu
            </p>
            <a href="{{ route('projects') }}" class="btn-gold-pill" style="padding:14px 32px;font-size:0.88rem;font-weight:800;letter-spacing:0.06em;">
                SEE ALL COMPLETED HOUSES IN TAMIL NADU <i class="fas fa-arrow-right" style="margin-left:6px;"></i>
            </a>
        </div>
    </div>
</section>

<!-- TURNKEY PACKAGES SECTION -->
<section class="section-pad" style="background:var(--dark-surface);">
    <div class="container">
        <div style="text-align:center;">
            <span class="sec-tag">TURNKEY PACKAGES</span>
            <h2 class="sec-title">CHOOSE THE RIGHT PACKAGE FOR YOUR CONSTRUCTION</h2>
            <p class="sec-sub" style="margin:10px auto 0;">Clear turnkey pricing per sq.ft with 100% material transparency and registered engineer supervision.</p>

            <div class="tab-toggle-group">
                <button class="tab-btn package-tab-btn active" data-target-group="residentialGroup">RESIDENTIAL</button>
                <button class="tab-btn package-tab-btn" data-target-group="commercialGroup">COMMERCIAL</button>
            </div>
        </div>

        <!-- Residential Group -->
        <div class="pricing-grid-3 package-group" id="residentialGroup">
            <div class="package-card">
                <div>
                    <span class="plan-tier-label">BASIC TIER • 10 Yrs Warranty</span>
                    <h3 class="plan-title">BASIC PLAN</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Solid & Affordable</p>
                    <div class="plan-price">₹1,999 <span>/ sq.ft</span></div>
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
                <button class="btn-gold-pill" style="width:100%;justify-content:center;margin-top:20px;" data-open-quote>VIEW DETAILS</button>
            </div>

            <div class="package-card highlighted">
                <div class="badge-popular">★ MOST POPULAR</div>
                <div>
                    <span class="plan-tier-label">PREMIUM TIER • 15 Yrs Warranty</span>
                    <h3 class="plan-title">PREMIUM PLAN</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Quality & Elegance</p>
                    <div class="plan-price">₹2,399 <span>/ sq.ft</span></div>
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
                <button class="btn-gold-pill" style="width:100%;justify-content:center;margin-top:20px;" data-open-quote>VIEW DETAILS</button>
            </div>

            <div class="package-card">
                <div>
                    <span class="plan-tier-label">LUXURY TIER • 20 Yrs Warranty</span>
                    <h3 class="plan-title">LUXURY PLAN</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Elite Craftsmanship</p>
                    <div class="plan-price">₹2,999 <span>/ sq.ft</span></div>
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
                <button class="btn-gold-pill" style="width:100%;justify-content:center;margin-top:20px;" data-open-quote>VIEW DETAILS</button>
            </div>
        </div>

        <!-- Commercial Group -->
        <div class="pricing-grid-3 package-group" id="commercialGroup" style="display:none;">
            <div class="package-card">
                <div>
                    <span class="plan-tier-label">BASIC TIER • 10 Yrs Warranty</span>
                    <h3 class="plan-title">STANDARD SHELL</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Functional & Efficient</p>
                    <div class="plan-price">₹2,100 <span>/ sq.ft</span></div>
                    <ul class="plan-features-list">
                        <li>Fe-500 TMT structural steel</li>
                        <li>OPC 53 grade cement</li>
                        <li>RCC framed structure</li>
                        <li>Vitrified floor tiles</li>
                        <li>Standard plumbing systems</li>
                        <li>Industrial-grade electrical wiring</li>
                        <li>Aluminium doors & windows</li>
                        <li>Exterior cement texture paint</li>
                    </ul>
                </div>
                <button class="btn-gold-pill" style="width:100%;justify-content:center;margin-top:20px;" data-open-quote>VIEW DETAILS</button>
            </div>

            <div class="package-card highlighted">
                <div class="badge-popular">★ MOST POPULAR</div>
                <div>
                    <span class="plan-tier-label">PREMIUM TIER • 15 Yrs Warranty</span>
                    <h3 class="plan-title">PREMIUM CORPORATE</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Professional & Polished</p>
                    <div class="plan-price">₹2,799 <span>/ sq.ft</span></div>
                    <ul class="plan-features-list">
                        <li>Fe-550 TMT (JSW Steel)</li>
                        <li>Ultratech / Ambuja cement</li>
                        <li>RCC frame + shear walls</li>
                        <li>Granite / double charged vitrified</li>
                        <li>Jaquar / Hindware fixtures</li>
                        <li>Polycab wires + RCCB MCB panel</li>
                        <li>Anodized aluminium UPVC systems</li>
                        <li>Texture + reflective glass curtain</li>
                    </ul>
                </div>
                <button class="btn-gold-pill" style="width:100%;justify-content:center;margin-top:20px;" data-open-quote>VIEW DETAILS</button>
            </div>

            <div class="package-card">
                <div>
                    <span class="plan-tier-label">LUXURY TIER • 20 Yrs Warranty</span>
                    <h3 class="plan-title">ELITE COMMERCIAL</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);">Iconic Architecture</p>
                    <div class="plan-price">₹3,499 <span>/ sq.ft</span></div>
                    <ul class="plan-features-list">
                        <li>Fe-550D TMT (SAIL / JSPL)</li>
                        <li>Birla Aditya / ACC Gold cement</li>
                        <li>Post-tensioned slabs</li>
                        <li>Stone cladding / premium marble</li>
                        <li>Geberit / TOTO commercial fixtures</li>
                        <li>Legrand Mosaic / Schneider systems</li>
                        <li>Structural glazing curtain wall</li>
                        <li>EIFS / metal composite facade</li>
                    </ul>
                </div>
                <button class="btn-gold-pill" style="width:100%;justify-content:center;margin-top:20px;" data-open-quote>VIEW DETAILS</button>
            </div>
        </div>

        <div class="package-action-row">
            <button class="btn-whatsapp-outline" data-open-matrix style="border-color:var(--gold);color:var(--gold);">
                <i class="fas fa-table-columns" style="margin-right:6px;"></i> COMPARE PACKAGES
            </button>
            <a href="{{ route('pricing') }}" class="btn-gold-pill">
                EXPLORE ALL PRICING & SPECS <i class="fas fa-arrow-right" style="margin-left:6px;"></i>
            </a>
        </div>
    </div>
</section>

<!-- MEET YOUR ENGINEER SECTION -->
<section class="section-pad" id="meet-engineer-section" style="padding: 70px 0; background: linear-gradient(180deg, rgba(5,11,20,0.6) 0%, rgba(11,19,43,0.4) 100%);">
    <div class="container">
        <!-- Compact Spotlight Card -->
        <div class="engineer-spotlight-card" style="max-width: 1040px; margin: 0 auto; background: linear-gradient(135deg, rgba(11, 19, 43, 0.95), rgba(5, 11, 20, 0.98)); border: 1px solid rgba(212, 175, 55, 0.35); border-radius: 24px; padding: 36px 40px; box-shadow: 0 16px 40px rgba(0,0,0,0.6), 0 0 30px rgba(212,175,55,0.1); position: relative; overflow: hidden;">
            <!-- Top Gold Beam Line -->
            <div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg, transparent, #D4AF37, #FFD700, #D4AF37, transparent);"></div>

            <div style="display: grid; grid-template-columns: 300px 1fr; gap: 36px; align-items: center;" class="engineer-grid-cols">
                
                <!-- Left: Compact 60-Second Video Preview Frame -->
                <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                    <div style="width: 100%; max-width: 300px; margin-bottom: 10px; text-align: left;">
                        <span class="sec-tag" style="margin-bottom: 0; font-size: 0.75rem; letter-spacing: 0.15em; color: #D4AF37; font-weight: 800; display: inline-block;">MEET YOUR ENGINEER</span>
                    </div>

                    <div class="engineer-video-box"
                         onclick="window.playVideoModal('{{ $intro_video_url }}', 'Er. Maha Rajan - 60-Second Video Introduction')"
                         onmouseover="this.style.borderColor='#D4AF37';this.style.boxShadow='0 14px 30px rgba(212,175,55,0.2)';"
                         onmouseout="this.style.borderColor='rgba(212, 175, 55, 0.4)';this.style.boxShadow='0 10px 25px rgba(0,0,0,0.5)';"
                         style="width: 100%; max-width: 300px; aspect-ratio: 4/3; position: relative; border-radius: 18px; overflow: hidden; border: 1px solid rgba(212, 175, 55, 0.4); background: #050B14; box-shadow: 0 10px 25px rgba(0,0,0,0.5); cursor: pointer; transition: all 0.3s ease;">

                        <!-- Thumbnail Image -->
                        <img src="{{ asset('maha-rajan.png') }}"
                             style="width: 100%; height: 100%; object-fit: cover; object-position: top center; transition: transform 0.4s ease; display: block;"
                             alt="Er. Maha Rajan"
                             onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80'">

                        <!-- Dark Vignette Overlay -->
                        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(5,11,20,0.15) 0%, rgba(5,11,20,0.05) 40%, rgba(5,11,20,0.88) 100%);"></div>

                        <!-- Top Badge: 60-Second Intro -->
                        <div style="position: absolute; top: 10px; left: 10px; background: rgba(5,11,20,0.85); backdrop-filter: blur(4px); border: 1px solid rgba(212,175,55,0.5); color: #D4AF37; font-size: 0.62rem; font-weight: 800; padding: 3px 10px; border-radius: 12px; display: flex; align-items: center; gap: 5px; text-transform: uppercase;">
                            <i class="fas fa-play" style="font-size: 0.5rem; color: #25D366;"></i> 60-Sec Intro
                        </div>

                        <!-- Govt Reg badge top right -->
                        <div style="position: absolute; top: 10px; right: 10px; background: rgba(37,211,102,0.15); border: 1px solid rgba(37,211,102,0.4); color: #25D366; font-size: 0.6rem; font-weight: 800; padding: 3px 8px; border-radius: 12px; display: flex; align-items: center; gap: 4px;">
                            <i class="fas fa-certificate"></i> VERIFIED
                        </div>

                        <!-- Center Play Button -->
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 52px; height: 52px; background: #D4AF37; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #050B14; font-size: 1.2rem; box-shadow: 0 0 24px rgba(212, 175, 55, 0.75);">
                            <i class="fas fa-play" style="margin-left: 3px;"></i>
                        </div>

                        <!-- Bottom Frame Label -->
                        <div style="position: absolute; bottom: 10px; left: 12px; right: 12px; text-align: center;">
                            <div style="font-size: 0.72rem; font-weight: 800; color: #FFF; text-shadow: 0 2px 4px rgba(0,0,0,0.8); letter-spacing: 0.05em;">
                                WATCH INTRO VIDEO <i class="fas fa-arrow-right" style="font-size: 0.65rem; margin-left: 4px; color: #D4AF37;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Mini CTA under video -->
                    <button class="btn-whatsapp-outline"
                            onclick="window.playVideoModal('{{ $intro_video_url }}', 'Er. Maha Rajan - 60-Second Video Introduction')"
                            style="margin-top: 12px; width: 100%; max-width: 300px; padding: 9px 14px; font-size: 0.76rem; justify-content: center; border-color: rgba(212,175,55,0.4); color: #D4AF37; display: flex; align-items: center;">
                        <i class="fas fa-circle-play" style="margin-right: 6px; color: #D4AF37;"></i> PLAY 60-SEC VIDEO
                    </button>
                </div>

                <!-- Right: Executive Info & Credentials -->
                <div>
                    <h2 style="font-size: 1.55rem; font-weight: 800; color: #fff; line-height: 1.3; margin: 0 0 6px 0;">
                        Er. MAHA RAJAN, <span style="font-size: 1rem; color: #D4AF37; font-weight: 700;">B.E. (CIVIL)</span>
                    </h2>
                    
                    <div style="font-size: 0.78rem; color: #94A3B8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-shield-halved" style="color: #D4AF37;"></i> Government Registered Engineer • CEO
                    </div>

                    <blockquote style="font-size: 0.88rem; color: var(--text-cream); font-style: italic; line-height: 1.6; border-left: 3px solid var(--gold); padding: 6px 0 6px 14px; margin: 0 0 18px 0; background: rgba(5,11,20,0.3); border-radius: 0 8px 8px 0;">
                        "Building a luxury home is a once-in-a-lifetime milestone. My team and I take complete personal responsibility for structural safety, itemized cost transparency, and on-time handover."
                    </blockquote>

                    <!-- 3 Compact Metrics Badges -->
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px;" class="engineer-stats-row">
                        <div style="background: rgba(5,11,20,0.6); border: 1px solid rgba(212,175,55,0.2); border-radius: 12px; padding: 10px 8px; text-align: center;">
                            <div style="font-size: 1.25rem; font-weight: 900; color: #D4AF37; line-height: 1;">12+</div>
                            <div style="font-size: 0.65rem; color: #94A3B8; font-weight: 700; text-transform: uppercase; margin-top: 3px;">Years Exp</div>
                        </div>
                        <div style="background: rgba(5,11,20,0.6); border: 1px solid rgba(212,175,55,0.2); border-radius: 12px; padding: 10px 8px; text-align: center;">
                            <div style="font-size: 1.25rem; font-weight: 900; color: #25D366; line-height: 1;">150+</div>
                            <div style="font-size: 0.65rem; color: #94A3B8; font-weight: 700; text-transform: uppercase; margin-top: 3px;">Happy Families</div>
                        </div>
                        <div style="background: rgba(5,11,20,0.6); border: 1px solid rgba(212,175,55,0.2); border-radius: 12px; padding: 10px 8px; text-align: center;">
                            <div style="font-size: 1.25rem; font-weight: 900; color: #FFD700; line-height: 1;">15 Yrs</div>
                            <div style="font-size: 0.65rem; color: #94A3B8; font-weight: 700; text-transform: uppercase; margin-top: 3px;">Warranty</div>
                        </div>
                    </div>

                    <!-- Direct Action Buttons -->
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <button class="btn-gold-pill" data-open-quote style="padding: 9px 20px; font-size: 0.78rem;">
                            <i class="fas fa-calendar-check" style="margin-right: 6px;"></i> DIRECT CONSULTATION
                        </button>
                        <a href="https://wa.me/919488888758?text=Hello%20Er.%20Maha%20Rajan%2C%20I%20want%20to%20consult%20for%20my%20luxury%20home." target="_blank" class="btn-whatsapp-outline" style="padding: 9px 18px; font-size: 0.78rem;">
                            <i class="fab fa-whatsapp" style="margin-right: 6px; color: #25D366;"></i> WHATSAPP ER. MAHA
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- CLIENT SATISFACTION STORIES (HIREANDBUILD MODEL) -->
<section class="section-pad" id="client-stories-section" style="background:var(--dark-surface);">
    <div class="container">
        <div style="text-align:center;">
            <span class="pill-badge" style="background:rgba(212,175,55,0.12);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.75rem;padding:6px 16px;letter-spacing:0.15em;">
                ● REAL CLIENT STORIES
            </span>
            <h2 class="sec-title" style="margin-top:12px;">
                Client <span class="gold" style="position:relative;display:inline-block;">Satisfaction<span style="position:absolute;bottom:-6px;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,#D4AF37,#FFD700,#D4AF37,transparent);"></span></span> Stories
            </h2>
            <p class="sec-sub" style="margin:12px auto 0;max-width:640px;">
                Hear directly from the families whose lives and luxury residences we've had the privilege to build across Tamil Nadu.
            </p>
        </div>

        @if($testimonials->count() > 0)
        <!-- Metric Stats Bar (HireAndBuild 3-Stat Model) -->
        <div class="stories-stats-row" style="display:flex;justify-content:center;gap:0;margin:32px 0 16px;flex-wrap:wrap;">
            <div class="stories-stat" style="padding:0 32px;text-align:center;border-right:1px solid rgba(212,175,55,0.25);">
                <div class="stories-stat-num" style="font-size:1.8rem;font-weight:900;color:#D4AF37;">{{ $testimonials->count() }}+</div>
                <div class="stories-stat-label" style="font-size:0.7rem;font-weight:800;color:#94A3B8;letter-spacing:0.12em;text-transform:uppercase;margin-top:4px;">Stories Shared</div>
            </div>
            <div class="stories-stat" style="padding:0 32px;text-align:center;border-right:1px solid rgba(212,175,55,0.25);">
                <div class="stories-stat-num" style="font-size:1.8rem;font-weight:900;color:#25D366;">100%</div>
                <div class="stories-stat-label" style="font-size:0.7rem;font-weight:800;color:#94A3B8;letter-spacing:0.12em;text-transform:uppercase;margin-top:4px;">Real Clients</div>
            </div>
            <div class="stories-stat" style="padding:0 32px;text-align:center;">
                <div class="stories-stat-num" style="font-size:1.8rem;font-weight:900;color:#FFD700;">{{ number_format($testimonials->avg('rating') ?: 5, 1) }}<i class="fas fa-star" style="font-size:1.4rem;"></i></div>
                <div class="stories-stat-label" style="font-size:0.7rem;font-weight:800;color:#94A3B8;letter-spacing:0.12em;text-transform:uppercase;margin-top:4px;">Avg Rating</div>
            </div>
        </div>

        <!-- Reel Cards Carousel Track -->
        <div class="stories-carousel-wrap" style="position:relative;margin-top:36px;">
            <div class="stories-track" id="storiesTrack" style="display:flex;gap:20px;overflow-x:auto;scroll-snap-type:x mandatory;padding:16px 8px 32px;scrollbar-width:none;">
                @foreach($testimonials as $i => $t)
                <div class="story-card {{ $i === 0 ? 'is-active' : '' }}"
                     style="flex:0 0 auto;width:240px;aspect-ratio:9/15;scroll-snap-align:center;position:relative;border-radius:20px;overflow:hidden;cursor:pointer;background:#111C38;border:2px solid {{ $i === 0 ? '#D4AF37' : 'rgba(255,255,255,0.1)' }};transition:all 0.3s ease;box-shadow:0 12px 30px rgba(0,0,0,0.5);"
                     @if($t->video_url) data-video-url="{{ $t->video_url }}" data-story-index="{{ $i }}" data-client-name="{{ $t->client_name }}" @endif
                     onclick="window.playStoryIndex({{ $i }})">
                    <!-- Photo Background -->
                    <img src="{{ $t->image_url ?? 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80' }}"
                         alt="{{ $t->client_name }}"
                         style="width:100%;height:100%;object-fit:cover;display:block;"
                         loading="lazy">

                    <!-- Dark Shade Gradient -->
                    <div class="story-card-shade" style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.1) 40%, rgba(5,11,20,0.92) 100%);"></div>

                    <!-- Top Left Pill: STORY 01 -->
                    <span class="story-card-tag" style="position:absolute;top:14px;left:14px;background:rgba(5,11,20,0.75);backdrop-filter:blur(4px);border:1px solid rgba(212,175,55,0.5);color:#D4AF37;font-size:0.65rem;font-weight:800;letter-spacing:0.1em;padding:4px 10px;border-radius:20px;text-transform:uppercase;">
                        STORY {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <!-- Glowing Center Play Circle -->
                    @if($t->video_url)
                    <div class="story-card-play" style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);width:54px;height:54px;background:#D4AF37;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#050B14;font-size:1.1rem;box-shadow:0 0 24px rgba(212,175,55,0.7);">
                        <i class="fas fa-play" style="margin-left:2px;"></i>
                    </div>
                    @endif

                    <!-- Bottom Info -->
                    <div class="story-card-info" style="position:absolute;left:16px;right:16px;bottom:16px;">
                        <div class="story-card-name" style="color:#FFFFFF;font-weight:800;font-size:0.95rem;text-shadow:0 2px 6px rgba(0,0,0,0.8);">{{ $t->client_name }}</div>
                        <div style="font-size:0.75rem;color:#D4AF37;font-weight:600;margin-top:2px;"><i class="fas fa-map-marker-alt" style="margin-right:3px;"></i>{{ $t->project_name ?? 'Maha Construction' }}</div>
                        @if($t->video_url)
                        <div class="story-card-watch" style="display:inline-flex;align-items:center;gap:6px;color:#D4AF37;font-size:0.72rem;font-weight:800;letter-spacing:0.08em;margin-top:8px;text-transform:uppercase;background:rgba(212,175,55,0.15);padding:3px 10px;border-radius:12px;border:1px solid rgba(212,175,55,0.3);">
                            <i class="fas fa-play"></i> WATCH STORY
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Progress Bar Tracker -->
            <div class="stories-progress-track" style="height:3px;background:rgba(255,255,255,0.1);border-radius:4px;max-width:480px;margin:0 auto;overflow:hidden;">
                <div class="stories-progress-fill" id="storiesProgressFill" style="height:100%;background:linear-gradient(90deg,#D4AF37,#FFD700);border-radius:4px;width:0%;transition:width 0.2s ease;"></div>
            </div>

            <!-- Navigation Controls: Arrows & Dots -->
            <div class="stories-controls" style="display:flex;align-items:center;justify-content:center;gap:18px;margin-top:24px;">
                <button class="stories-arrow-btn" id="storiesPrevBtn" aria-label="Previous story" style="width:44px;height:44px;border-radius:50%;border:1px solid rgba(212,175,55,0.4);background:rgba(11,19,43,0.8);color:#D4AF37;font-size:1.1rem;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='#D4AF37';this.style.color='#050B14';" onmouseout="this.style.background='rgba(11,19,43,0.8)';this.style.color='#D4AF37';"><i class="fas fa-arrow-left"></i></button>
                <div class="stories-dots" id="storiesDots" style="display:flex;gap:6px;"></div>
                <button class="stories-arrow-btn" id="storiesNextBtn" aria-label="Next story" style="width:44px;height:44px;border-radius:50%;border:1px solid rgba(212,175,55,0.4);background:rgba(11,19,43,0.8);color:#D4AF37;font-size:1.1rem;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='#D4AF37';this.style.color='#050B14';" onmouseout="this.style.background='rgba(11,19,43,0.8)';this.style.color='#D4AF37';"><i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
        @endif

        <div style="text-align:center;margin-top:40px;">
            <a href="{{ route('testimonials') }}" class="btn-gold-pill" style="padding:14px 32px;font-size:0.88rem;font-weight:800;letter-spacing:0.06em;">
                WATCH ALL CLIENT STORIES IN TAMIL NADU <i class="fas fa-arrow-right" style="margin-left:6px;"></i>
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
/* ─── ENGINEER SPOTLIGHT CARD ──────────────────── */
@media (max-width: 768px) {
    .engineer-grid-cols {
        grid-template-columns: 1fr !important;
        gap: 24px !important;
    }
    .engineer-spotlight-card {
        padding: 24px 18px !important;
    }
    .engineer-video-box {
        max-width: 100% !important;
        height: 200px !important;
    }
}

/* ─── YOUTUBE LIVE SYNC SLIDER ─────────────────── */
.yt-slider-wrapper {
    position: relative;
    width: 100%;
    overflow: hidden;
    margin-top: 36px;
    padding: 10px 0 16px;
}
.yt-slider-track {
    display: flex;
    gap: 20px;
    transition: transform 0.6s cubic-bezier(0.2, 0.9, 0.3, 1);
    will-change: transform;
}
.yt-slide {
    flex: 0 0 100%;
    width: 100%;
    box-sizing: border-box;
}
@media (min-width: 768px) {
    .yt-slide {
        flex: 0 0 calc((100% - 20px) / 2);
        width: calc((100% - 20px) / 2);
    }
}
@media (min-width: 1024px) {
    .yt-slide {
        flex: 0 0 calc((100% - 40px) / 3);
        width: calc((100% - 40px) / 3);
    }
}

.yt-compact-card {
    background: rgba(11, 19, 43, 0.85);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(212, 175, 55, 0.22);
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: all 0.3s cubic-bezier(0.2, 0.9, 0.3, 1);
}
.yt-compact-card:hover {
    border-color: #D4AF37;
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(212, 175, 55, 0.16);
}
.yt-thumb-frame {
    height: 175px;
    position: relative;
    background: #050B14;
    overflow: hidden;
}
.yt-thumb-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.yt-compact-card:hover .yt-thumb-frame img {
    transform: scale(1.05);
}

.yt-slider-btn {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #0B132B;
    border: 1px solid rgba(212, 175, 55, 0.35);
    color: #D4AF37;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
    box-shadow: 0 4px 14px rgba(0,0,0,0.3);
}
.yt-slider-btn:hover {
    background: #D4AF37;
    color: #050B14;
    border-color: #D4AF37;
    transform: scale(1.08);
    box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
}
.yt-slider-dot {
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.35s ease;
}
.yt-slider-dot.active {
    background: #D4AF37;
    width: 26px !important;
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
}
</style>
@endpush

<!-- YOUTUBE & SITE TOURS SECTION (LIVE YOUTUBE SYNC) -->
<section class="section-pad" id="youtube-sync-section">
    <div class="container">
        <div style="text-align:center;">
            <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,0,0,0.12);border:1px solid rgba(255,0,0,0.4);border-radius:20px;padding:5px 16px;margin-bottom:12px;">
                <i class="fab fa-youtube" style="color:#FF0000;font-size:0.9rem;"></i>
                <span style="font-size:0.72rem;font-weight:800;letter-spacing:0.12em;color:#FF5555;text-transform:uppercase;">LIVE YOUTUBE CHANNEL SYNC</span>
            </div>
            <h2 class="sec-title">
                LEARN BEFORE YOU BUILD — <span class="gold">SITE TOURS</span>
            </h2>
            <p class="sec-sub" style="margin:10px auto 0;max-width:680px;">
                Real site walkthroughs, structural testing, and luxury villa showcases direct from our official channel.
            </p>
        </div>

        <!-- Channel Info Banner -->
        <div id="ytChannelBanner" style="display:flex;align-items:center;justify-content:center;gap:16px;margin-top:28px;flex-wrap:wrap;">
            <img id="ytChannelAvatar" src="{{ $channelMeta['avatar'] ?? asset('logo.jpg') }}" alt="{{ $channelMeta['name'] ?? 'Maha Constructions' }}"
                 style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid rgba(212,175,55,0.5);"
                 onerror="this.src='{{ asset('logo.jpg') }}'">
            <div style="text-align:left;">
                <div id="ytChannelName" style="font-size:1rem;font-weight:800;color:#FFF;">{{ $channelMeta['name'] ?? 'Maha Constructions' }}</div>
                <div style="font-size:0.78rem;color:#94A3B8;margin-top:2px;">
                    <span id="ytChannelHandle">{{ $yt_channel_handle ?? '@mahaconstructions2013' }}</span>
                    @if(!empty($channelMeta['subs']))
                    <span id="ytChannelSubs"> • {{ $channelMeta['subs'] }}</span>
                    @else
                    <span id="ytChannelSubs"></span>
                    @endif
                    <span id="ytLiveIndicator" style="margin-left:8px;color:#25D366;font-weight:700;"><i class="fas fa-circle" style="font-size:0.45rem;vertical-align:middle;margin-right:4px;"></i>LIVE SYNC</span>
                </div>
            </div>
        </div>

        <div id="ytVideosContainer">
        @if(!empty($syncedVideos) && count($syncedVideos) > 0)
        <!-- Slider Track Wrapper -->
        <div class="yt-slider-wrapper" id="ytSliderWrapper">
            <div class="yt-slider-track" id="ytSliderTrack">
                @foreach($syncedVideos as $v)
                <div class="yt-slide">
                    <div class="yt-compact-card">
                        <!-- Video Thumbnail with Play Overlay -->
                        <div class="yt-thumb-frame">
                            <img src="{{ $v['thumbnail'] }}"
                                 alt="{{ $v['title'] }}"
                                 loading="lazy"
                                 onerror="this.src='https://img.youtube.com/vi/{{ $v['youtubeId'] }}/hqdefault.jpg'">

                            <!-- Duration Badge -->
                            <div style="position:absolute;bottom:8px;right:8px;background:rgba(5,11,20,0.85);backdrop-filter:blur(4px);color:#F0EBE0;font-size:0.68rem;font-weight:800;padding:2px 7px;border-radius:5px;border:1px solid rgba(255,255,255,0.15);">
                                <i class="fas fa-play" style="font-size:0.55rem;margin-right:4px;color:var(--gold);"></i>{{ $v['duration'] ?? 'Site Tour' }}
                            </div>

                            <!-- YouTube Brand Badge Top Left -->
                            <div style="position:absolute;top:8px;left:8px;background:rgba(5,11,20,0.85);backdrop-filter:blur(4px);color:#FF0000;font-size:0.64rem;font-weight:800;padding:2px 9px;border-radius:10px;border:1px solid rgba(255,0,0,0.3);display:flex;align-items:center;gap:4px;">
                                <i class="fab fa-youtube"></i>
                                <span style="color:#FFF;">{{ strtoupper($channelMeta['name'] ?? 'MAHA CONSTRUCTIONS') }}</span>
                            </div>

                            <!-- Play Overlay Trigger -->
                            <div class="video-play-overlay" data-video-url="{{ $v['videoUrl'] }}" onclick="window.playVideoModal('{{ $v['videoUrl'] }}', '{{ addslashes($v['title']) }}')" style="position:absolute;inset:0;background:rgba(0,0,0,0.32);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.1)';" onmouseout="this.style.background='rgba(0,0,0,0.32)';">
                                <div class="play-btn-circle" style="width:46px;height:46px;font-size:0.95rem;background:#D4AF37;color:#050B14;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 18px rgba(212,175,55,0.6);">
                                    <i class="fas fa-play" style="margin-left:2px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Video Info -->
                        <div style="padding:14px 16px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                            <div>
                                <div style="display:flex;align-items:center;gap:6px;font-size:0.68rem;color:#94A3B8;margin-bottom:6px;">
                                    @if(!empty($v['views']))
                                    <span style="color:#D4AF37;font-weight:700;"><i class="fas fa-eye" style="margin-right:3px;"></i>{{ $v['views'] }}</span>
                                    <span>•</span>
                                    @endif
                                    <span><i class="fas fa-clock" style="margin-right:3px;"></i>{{ $v['published'] ?? 'Recent' }}</span>
                                </div>
                                <h4 style="font-size:0.88rem;color:#FFFFFF;line-height:1.35;margin:0;font-weight:700;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="{{ $v['title'] }}">
                                    {{ $v['title'] }}
                                </h4>
                            </div>

                            <div style="margin-top:14px;padding-top:10px;border-top:1px solid rgba(212,175,55,0.12);display:flex;justify-content:space-between;align-items:center;">
                                <button class="btn-whatsapp-outline" onclick="window.playVideoModal('{{ $v['videoUrl'] }}', '{{ addslashes($v['title']) }}')" style="padding:5px 12px;font-size:0.72rem;border-color:rgba(212,175,55,0.4);color:#D4AF37;cursor:pointer;">
                                    <i class="fas fa-play" style="margin-right:4px;"></i> WATCH ON SITE
                                </button>
                                <a href="{{ $v['watchUrl'] ?? ('https://www.youtube.com/watch?v='.$v['youtubeId']) }}" target="_blank" style="font-size:0.72rem;color:#94A3B8;text-decoration:none;display:inline-flex;align-items:center;gap:4px;" onmouseover="this.style.color='#FF5555';" onmouseout="this.style.color='#94A3B8';">
                                    <i class="fab fa-youtube" style="color:#FF0000;"></i> YouTube <i class="fas fa-arrow-up-right-from-square" style="font-size:0.6rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Slider Controls -->
        <div class="yt-slider-controls" style="display:flex;justify-content:center;align-items:center;gap:16px;margin-top:20px;">
            <button class="yt-slider-btn prev" onclick="window.moveYtSlider(-1)" aria-label="Previous video">
                <i class="fas fa-chevron-left" style="font-size:0.8rem;"></i>
            </button>
            <div id="ytSliderDots" style="display:flex;align-items:center;gap:6px;"></div>
            <button class="yt-slider-btn next" onclick="window.moveYtSlider(1)" aria-label="Next video">
                <i class="fas fa-chevron-right" style="font-size:0.8rem;"></i>
            </button>
        </div>
        @else
        <div id="ytEmptyState" style="text-align:center;padding:50px 20px;background:#0B132B;border:1px dashed rgba(212,175,55,0.3);border-radius:18px;margin-top:36px;">
            <i class="fab fa-youtube" style="font-size:3rem;color:#FF0000;margin-bottom:12px;display:inline-block;"></i>
            <h3 style="color:#fff;font-size:1.2rem;margin-bottom:6px;">YouTube Channel Syncing</h3>
            <p style="color:#94A3B8;font-size:0.85rem;max-width:500px;margin:0 auto 16px;">Videos from {{ $yt_channel_handle ?? '@mahaconstructions2013' }} are being loaded. Check back shortly or visit our channel directly.</p>
        </div>
        @endif
        </div>

        <div style="text-align:center;margin-top:36px;display:flex;justify-content:center;gap:14px;flex-wrap:wrap;">
            <a href="{{ $yt_channel_url }}" target="_blank" class="btn-gold-pill" style="background:#FF0000;color:#fff;box-shadow:0 0 20px rgba(255,0,0,0.35);">
                <i class="fab fa-youtube" style="margin-right:6px;"></i> SUBSCRIBE ON YOUTUBE
            </a>
            <a href="{{ rtrim($yt_channel_url, '/') }}/videos" target="_blank" class="btn-whatsapp-outline" style="border-color:#D4AF37;color:#D4AF37;">
                <i class="fas fa-video" style="margin-right:6px;"></i> VIEW ALL VIDEOS ON YOUTUBE
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function() {
    const channelName = @json($channelMeta['name'] ?? 'Maha Constructions');
    let currentIndex = 0;
    let autoPlayTimer = null;
    let isHovered = false;

    function escapeHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    function getVisibleCardsCount() {
        if (window.innerWidth >= 1024) return 3;
        if (window.innerWidth >= 768) return 2;
        return 1;
    }

    function updateSlider(animate = true) {
        const track = document.getElementById('ytSliderTrack');
        if (!track) return;
        const slides = track.querySelectorAll('.yt-slide');
        if (slides.length === 0) return;

        const visibleCount = getVisibleCardsCount();
        const maxIndex = Math.max(0, slides.length - visibleCount);

        if (currentIndex > maxIndex) {
            currentIndex = 0; // Wrap around to start for continuous slideshow
        }
        if (currentIndex < 0) {
            currentIndex = maxIndex;
        }

        const slideWidth = slides[0].offsetWidth;
        const gap = 20; // 20px gap
        const offset = currentIndex * (slideWidth + gap);

        track.style.transition = animate ? 'transform 0.6s cubic-bezier(0.2, 0.9, 0.3, 1)' : 'none';
        track.style.transform = `translateX(-${offset}px)`;

        renderDots(maxIndex);
    }

    function renderDots(maxIndex) {
        const dotsContainer = document.getElementById('ytSliderDots');
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';

        for (let i = 0; i <= maxIndex; i++) {
            const dot = document.createElement('span');
            dot.className = `yt-slider-dot ${i === currentIndex ? 'active' : ''}`;
            dot.style.width = i === currentIndex ? '26px' : '8px';
            dot.addEventListener('click', function() {
                currentIndex = i;
                updateSlider(true);
                resetAutoPlay();
            });
            dotsContainer.appendChild(dot);
        }
    }

    window.moveYtSlider = function(dir) {
        const track = document.getElementById('ytSliderTrack');
        if (!track) return;
        const slides = track.querySelectorAll('.yt-slide');
        const visibleCount = getVisibleCardsCount();
        const maxIndex = Math.max(0, slides.length - visibleCount);

        currentIndex += dir;
        if (currentIndex > maxIndex) currentIndex = 0;
        if (currentIndex < 0) currentIndex = maxIndex;

        updateSlider(true);
        resetAutoPlay();
    };

    window.gotoYtSlide = function(idx) {
        currentIndex = idx;
        updateSlider(true);
        resetAutoPlay();
    };

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayTimer = setInterval(function() {
            if (!isHovered && !document.hidden) {
                window.moveYtSlider(1);
            }
        }, 3800);
    }

    function stopAutoPlay() {
        if (autoPlayTimer) {
            clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }
    }

    function resetAutoPlay() {
        stopAutoPlay();
        startAutoPlay();
    }

    // Bind hover pause to track wrapper
    function initSliderHover() {
        const wrapper = document.getElementById('ytSliderWrapper');
        if (wrapper) {
            wrapper.addEventListener('mouseenter', () => { isHovered = true; });
            wrapper.addEventListener('mouseleave', () => { isHovered = false; });
            // Touch gestures for mobile swipe
            let touchStartX = 0;
            wrapper.addEventListener('touchstart', (e) => {
                touchStartX = e.touches[0].clientX;
                isHovered = true;
            }, { passive: true });
            wrapper.addEventListener('touchend', (e) => {
                const touchEndX = e.changedTouches[0].clientX;
                isHovered = false;
                if (touchStartX - touchEndX > 50) {
                    window.moveYtSlider(1);
                } else if (touchEndX - touchStartX > 50) {
                    window.moveYtSlider(-1);
                }
            }, { passive: true });
        }
    }

    function renderVideoCard(v) {
        const title = escapeHtml(v.title || 'Site Tour');
        const videoUrl = v.videoUrl || ('https://www.youtube.com/embed/' + v.youtubeId + '?autoplay=1');
        const watchUrl = v.watchUrl || ('https://www.youtube.com/watch?v=' + v.youtubeId);
        const thumb = v.thumbnail || ('https://img.youtube.com/vi/' + v.youtubeId + '/hqdefault.jpg');
        const views = v.views ? '<span style="color:#D4AF37;font-weight:700;"><i class="fas fa-eye" style="margin-right:3px;"></i>' + escapeHtml(v.views) + '</span><span>•</span>' : '';
        const published = escapeHtml(v.published || 'Recent');
        const duration = escapeHtml(v.duration || 'Site Tour');

        return '<div class="yt-slide">'
            + '<div class="yt-compact-card">'
            + '<div class="yt-thumb-frame">'
            + '<img src="' + thumb + '" alt="' + title + '" loading="lazy" onerror="this.src=\'https://img.youtube.com/vi/' + v.youtubeId + '/hqdefault.jpg\'">'
            + '<div style="position:absolute;bottom:8px;right:8px;background:rgba(5,11,20,0.85);backdrop-filter:blur(4px);color:#F0EBE0;font-size:0.68rem;font-weight:800;padding:2px 7px;border-radius:5px;border:1px solid rgba(255,255,255,0.15);"><i class="fas fa-play" style="font-size:0.55rem;margin-right:4px;color:var(--gold);"></i>' + duration + '</div>'
            + '<div style="position:absolute;top:8px;left:8px;background:rgba(5,11,20,0.85);backdrop-filter:blur(4px);color:#FF0000;font-size:0.64rem;font-weight:800;padding:2px 9px;border-radius:10px;border:1px solid rgba(255,0,0,0.3);display:flex;align-items:center;gap:4px;"><i class="fab fa-youtube"></i><span style="color:#FFF;">' + escapeHtml(channelName.toUpperCase()) + '</span></div>'
            + '<div class="video-play-overlay" onclick="window.playVideoModal(\'' + videoUrl + '\', \'' + title.replace(/'/g, "\\'") + '\')" style="position:absolute;inset:0;background:rgba(0,0,0,0.32);display:flex;align-items:center;justify-content:center;cursor:pointer;"><div class="play-btn-circle" style="width:46px;height:46px;font-size:0.95rem;background:#D4AF37;color:#050B14;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 18px rgba(212,175,55,0.6);"><i class="fas fa-play" style="margin-left:2px;"></i></div></div>'
            + '</div>'
            + '<div style="padding:14px 16px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">'
            + '<div><div style="display:flex;align-items:center;gap:6px;font-size:0.68rem;color:#94A3B8;margin-bottom:6px;">' + views
            + '<span><i class="fas fa-clock" style="margin-right:3px;"></i>' + published + '</span></div>'
            + '<h4 style="font-size:0.88rem;color:#FFFFFF;line-height:1.35;margin:0;font-weight:700;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="' + title + '">' + title + '</h4></div>'
            + '<div style="margin-top:14px;padding-top:10px;border-top:1px solid rgba(212,175,55,0.12);display:flex;justify-content:space-between;align-items:center;">'
            + '<button class="btn-whatsapp-outline" onclick="window.playVideoModal(\'' + videoUrl + '\', \'' + title.replace(/'/g, "\\'") + '\')" style="padding:5px 12px;font-size:0.72rem;border-color:rgba(212,175,55,0.4);color:#D4AF37;cursor:pointer;"><i class="fas fa-play" style="margin-right:4px;"></i> WATCH ON SITE</button>'
            + '<a href="' + watchUrl + '" target="_blank" style="font-size:0.72rem;color:#94A3B8;text-decoration:none;display:inline-flex;align-items:center;gap:4px;"><i class="fab fa-youtube" style="color:#FF0000;"></i> YouTube <i class="fas fa-arrow-up-right-from-square" style="font-size:0.6rem;"></i></a>'
            + '</div></div></div></div>';
    }

    async function refreshYouTubeVideos() {
        try {
            const res = await fetch('/api/youtube/channel-videos');
            if (!res.ok) return;
            const data = await res.json();
            if (!data.videos || data.videos.length === 0) return;

            const container = document.getElementById('ytVideosContainer');
            if (!container) return;

            container.innerHTML = '<div class="yt-slider-wrapper" id="ytSliderWrapper">'
                + '<div class="yt-slider-track" id="ytSliderTrack">'
                + data.videos.map(renderVideoCard).join('')
                + '</div></div>'
                + '<div class="yt-slider-controls" style="display:flex;justify-content:center;align-items:center;gap:16px;margin-top:20px;">'
                + '<button class="yt-slider-btn prev" onclick="window.moveYtSlider(-1)" aria-label="Previous video"><i class="fas fa-chevron-left" style="font-size:0.8rem;"></i></button>'
                + '<div id="ytSliderDots" style="display:flex;align-items:center;gap:6px;"></div>'
                + '<button class="yt-slider-btn next" onclick="window.moveYtSlider(1)" aria-label="Next video"><i class="fas fa-chevron-right" style="font-size:0.8rem;"></i></button>'
                + '</div>';

            if (data.channel_name) {
                const nameEl = document.getElementById('ytChannelName');
                if (nameEl) nameEl.textContent = data.channel_name;
            }
            if (data.channel_avatar) {
                const avatarEl = document.getElementById('ytChannelAvatar');
                if (avatarEl) avatarEl.src = data.channel_avatar;
            }
            if (data.channel_subs) {
                const subsEl = document.getElementById('ytChannelSubs');
                if (subsEl) subsEl.textContent = ' • ' + data.channel_subs;
            }

            initSliderHover();
            currentIndex = 0;
            updateSlider(false);
            resetAutoPlay();
        } catch (e) { /* silent */ }
    }

    // Initialize on page load
    window.addEventListener('DOMContentLoaded', function() {
        initSliderHover();
        updateSlider(false);
        startAutoPlay();
    });

    // Resize handler for responsive slide recalculation
    window.addEventListener('resize', function() {
        updateSlider(false);
    });

    // Auto-refresh data every 30 minutes
    setInterval(refreshYouTubeVideos, 30 * 60 * 1000);

    // Refresh when user returns to tab
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateSlider(false);
            startAutoPlay();
        } else {
            stopAutoPlay();
        }
    });
})();
</script>
@endpush

<!-- BANKING PARTNERS & MATERIAL VENDORS -->
@php
    $bankingPartners = $partners->where('division', 'banking');
    $vendorPartners  = $partners->where('division', 'vendor');
@endphp
<section class="section-pad" style="background:var(--dark-surface);">
    <div class="container">
        @if($bankingPartners->count() > 0)
        <div style="text-align:center;">
            <span class="sec-tag">FINANCE & LOANS</span>
            <h2 class="sec-title" style="font-size:1.8rem;">Our Banking <span class="gold">Partners</span></h2>
            <p class="sec-sub" style="margin:6px auto 0;font-size:0.85rem;">Get your home loan sanctioned easily through our trusted banking network with fast approvals and competitive interest rates.</p>
        </div>

        <div class="partner-marquee">
            <div class="partner-track">
                @foreach($bankingPartners->concat($bankingPartners)->concat($bankingPartners) as $p)
                <a href="{{ $p->website_url ?? '#' }}" target="_blank" class="partner-card" title="{{ $p->name }}">
                    @if(!empty($p->logo_url))
                    <div class="partner-logo-frame">
                        <img src="{{ asset($p->logo_url) }}" alt="{{ $p->name }}" class="partner-logo-img" onerror="this.style.display='none'">
                    </div>
                    @else
                    <div class="partner-badge-circle" style="background:{{ \App\Support\BrandColor::for($p->name) }};">{{ \App\Support\BrandColor::initials($p->name) }}</div>
                    @endif
                    <div class="partner-name">{{ $p->name }}</div>
                    <span class="partner-tag"><i class="fas fa-check-circle" style="margin-right:3px;color:#25D366;"></i> HOME LOAN APPROVED</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($vendorPartners->count() > 0)
        <div style="text-align:center;margin-top:56px;">
            <span class="sec-tag">TRUSTED BRANDS</span>
            <h2 class="sec-title" style="font-size:1.8rem;">Our <span class="gold">Vendors</span></h2>
            <p class="sec-sub" style="margin:6px auto 0;font-size:0.85rem;">Every material sourced from certified, industry-leading manufacturers.</p>
        </div>
        <div class="partner-marquee">
            <div class="partner-track reverse">
                @foreach($vendorPartners->concat($vendorPartners) as $p)
                <a href="{{ $p->website_url ?? '#' }}" target="_blank" class="partner-card" title="{{ $p->name }}">
                    @if(!empty($p->logo_url))
                    <div class="partner-logo-frame">
                        <img src="{{ asset($p->logo_url) }}" alt="{{ $p->name }}" class="partner-logo-img" onerror="this.style.display='none'">
                    </div>
                    @else
                    <div class="partner-badge-circle" style="background:{{ \App\Support\BrandColor::for($p->name) }};">{{ \App\Support\BrandColor::initials($p->name) }}</div>
                    @endif
                    <div class="partner-name">{{ $p->name }}</div>
                    <span class="partner-tag"><i class="fas fa-shield-alt" style="margin-right:3px;color:var(--gold);"></i> CERTIFIED BRAND</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<!-- 7-STEP CONSTRUCTION PROCESS -->
<section class="section-pad">
    <div class="container">
        <div style="text-align:center;">
            <span class="sec-tag">OUR 7 STEP TRANSPARENT PROCESS</span>
            <h2 class="sec-title">OUR STEP-BY-STEP CONSTRUCTION PROCESS</h2>
            <p class="sec-sub" style="margin:10px auto 0;">Clear step-by-step roadmap ensuring zero cost overruns and 100% material quality control.</p>
        </div>

        <div class="process-steps-7grid">
            <div class="metric-card" style="padding:16px 8px;">
                <div style="font-size:0.75rem;font-weight:800;color:var(--gold);">01</div>
                <div style="font-weight:800;font-size:0.8rem;color:#fff;margin:6px 0 4px;">CONSULTATION</div>
                <div style="font-size:0.65rem;color:var(--text-muted);">Initial discussion on requirements.</div>
            </div>
            <div class="metric-card" style="padding:16px 8px;">
                <div style="font-size:0.75rem;font-weight:800;color:var(--gold);">02</div>
                <div style="font-weight:800;font-size:0.8rem;color:#fff;margin:6px 0 4px;">SITE VISIT</div>
                <div style="font-size:0.65rem;color:var(--text-muted);">Soil testing & plot measurement.</div>
            </div>
            <div class="metric-card" style="padding:16px 8px;">
                <div style="font-size:0.75rem;font-weight:800;color:var(--gold);">03</div>
                <div style="font-weight:800;font-size:0.8rem;color:#fff;margin:6px 0 4px;">PLANNING</div>
                <div style="font-size:0.65rem;color:var(--text-muted);">2D plan & 3D elevation modeling.</div>
            </div>
            <div class="metric-card" style="padding:16px 8px;">
                <div style="font-size:0.75rem;font-weight:800;color:var(--gold);">04</div>
                <div style="font-weight:800;font-size:0.8rem;color:#fff;margin:6px 0 4px;">ESTIMATE</div>
                <div style="font-size:0.65rem;color:var(--text-muted);">Cost breakdown & agreement signed.</div>
            </div>
            <div class="metric-card" style="padding:16px 8px;">
                <div style="font-size:0.75rem;font-weight:800;color:var(--gold);">05</div>
                <div style="font-weight:800;font-size:0.8rem;color:#fff;margin:6px 0 4px;">CONSTRUCTION</div>
                <div style="font-size:0.65rem;color:var(--text-muted);">Daily site execution by engineers.</div>
            </div>
            <div class="metric-card" style="padding:16px 8px;">
                <div style="font-size:0.75rem;font-weight:800;color:var(--gold);">06</div>
                <div style="font-weight:800;font-size:0.8rem;color:#fff;margin:6px 0 4px;">QUALITY CHECKS</div>
                <div style="font-size:0.65rem;color:var(--text-muted);">100+ quality inspection checklist.</div>
            </div>
            <div class="metric-card" style="padding:16px 8px;">
                <div style="font-size:0.75rem;font-weight:800;color:var(--gold);">07</div>
                <div style="font-weight:800;font-size:0.8rem;color:#fff;margin:6px 0 4px;">HANDOVER</div>
                <div style="font-size:0.65rem;color:var(--text-muted);">Timely key handover & warranty.</div>
            </div>
        </div>

        <div style="text-align:center;margin-top:36px;">
            <button class="btn-gold-pill" data-open-quote>BOOK A FREE CONSULTATION</button>
        </div>
    </div>
</section>

<!-- FREE HOME BUILDER'S GUIDE DOWNLOAD & LEAD FORM -->
<section class="section-pad" style="background:var(--dark-surface);">
    <div class="container">
        <div class="guidebook-card-box">
            <div style="display:flex;justify-content:center;align-items:center;">
                <img src="/images/guidebook-cover.jpg" alt="நம் கனவு இல்லம் - வீடு நமது அடையாளம் | Home Builder Guide Book" class="guidebook-img" style="border-radius:14px;box-shadow:0 15px 35px rgba(0,0,0,0.6), 0 0 20px rgba(212,175,55,0.25);border:2px solid rgba(212,175,55,0.4);max-width:280px;width:100%;transition:transform 0.3s ease;">
            </div>
            <div>
                <span class="sec-tag">THE HOME BUILDER'S GUIDE</span>
                <h2 style="font-size:1.8rem;font-weight:800;color:#fff;margin:6px 0;">GET YOUR FREE HOME BUILDER'S GUIDE!</h2>
                <p style="font-size:0.9rem;color:var(--text-muted);line-height:1.6;">
                    Avoid costly mistakes and save lakhs in your construction. Practical tips from a Government Registered Engineer. Enter your details to get the full PDF document immediately.
                </p>

                <!-- Download Form -->
                <form id="guideBookForm" class="guide-form-grid">
                    <div class="full">
                        <input type="text" name="name" required placeholder="Your Name *" class="input-dark">
                    </div>
                    <div>
                        <input type="tel" name="phone" required placeholder="Mobile Number *" class="input-dark">
                    </div>
                    <div>
                        <input type="email" name="email" required placeholder="Gmail Address / Email *" class="input-dark">
                    </div>
                    <div class="full">
                        <button type="submit" class="btn-gold-submit" style="display:flex;align-items:center;justify-content:center;gap:8px;">
                            <i class="fas fa-paper-plane"></i> SEND & DOWNLOAD MY FREE GUIDE
                        </button>
                    </div>
                </form>

                <!-- Instant Download Success Box -->
                <div id="guideSuccessBox" class="form-success-box" style="display:none;margin-top:20px;text-align:center;">
                    <div style="font-size:1.6rem;margin-bottom:6px;"><i class="fas fa-circle-check" style="color:#25D366;"></i></div>
                    <h4 style="color:#fff;font-size:1.1rem;">Guide Sent Successfully!</h4>
                    <p style="font-size:0.85rem;color:var(--text-cream);margin:6px 0 16px;">
                        Thank you <strong class="user-name-placeholder">Client</strong>! Your download has started automatically. If it didn't start, please click the button below to download it manually.
                    </p>
                    <button class="btn-gold-pill" id="downloadAgainBtn">
                        <i class="fas fa-download" style="margin-right:6px;"></i> DOWNLOAD PDF AGAIN
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOLLOW OUR CONSTRUCTION JOURNEY (SOCIAL CHANNELS) -->
<section class="section-pad">
    <div class="container">
        <div style="text-align:center;">
            <span class="sec-tag">JOIN OUR COMMUNITY</span>
            <h2 class="sec-title">FOLLOW OUR CONSTRUCTION JOURNEY</h2>
            <p class="sec-sub" style="margin:10px auto 0;">Stay updated with live site walkthroughs, structural engineering tips, and home designs across Tamil Nadu.</p>
        </div>

        <div class="social-cards-grid">
            <div class="social-card-v2" style="--social-color:#C13584;">
                <div class="social-avatar-ring">
                    <img src="{{ asset('logo.png') }}" alt="Maha Constructions on Instagram">
                    <div class="social-avatar-badge"><i class="fab fa-instagram"></i></div>
                </div>
                <span class="social-platform-label">Instagram</span>
                <div class="social-handle">@mahaconstructions_2013</div>
                <div class="social-underline"></div>
                <div class="social-count">15K+</div>
                <div class="social-count-label">Followers</div>
                <a href="https://www.instagram.com/mahaconstructions_2013" target="_blank" class="social-cta-btn"><i class="fab fa-instagram" style="margin-right:6px;"></i> Follow Us</a>
            </div>

            <div class="social-card-v2" style="--social-color:#1877F2;">
                <div class="social-avatar-ring">
                    <img src="{{ asset('logo.png') }}" alt="Maha Constructions on Facebook">
                    <div class="social-avatar-badge"><i class="fab fa-facebook-f"></i></div>
                </div>
                <span class="social-platform-label">Facebook</span>
                <div class="social-handle">mahaconstructions</div>
                <div class="social-underline"></div>
                <div class="social-count">20K+</div>
                <div class="social-count-label">Followers</div>
                <a href="https://www.facebook.com/mahaconstructions" target="_blank" class="social-cta-btn"><i class="fab fa-facebook-f" style="margin-right:6px;"></i> Like Page</a>
            </div>

            <div class="social-card-v2" style="--social-color:#FF0000;">
                <div class="social-avatar-ring">
                    <img src="{{ asset('logo.png') }}" alt="Maha Constructions on YouTube">
                    <div class="social-avatar-badge"><i class="fab fa-youtube"></i></div>
                </div>
                <span class="social-platform-label">YouTube</span>
                <div class="social-handle">{{ $yt_channel_handle ?? '@mahaconstructions2013' }}</div>
                <div class="social-underline"></div>
                <div class="social-count">{{ !empty($yt_channel_meta['subs']) ? preg_replace('/\s*subscribers?/i', '', $yt_channel_meta['subs']) : '30K+' }}</div>
                <div class="social-count-label">Subscribers</div>
                <a href="{{ $yt_channel_url }}" target="_blank" class="social-cta-btn"><i class="fab fa-youtube" style="margin-right:6px;"></i> Subscribe</a>
            </div>
        </div>
    </div>
</section>

@endsection
