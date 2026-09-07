@extends('layouts.app')

@section('title', 'Maha Interior | Designing Beautiful Living | Luxury Interior Design & Turnkey Execution')
@section('description', 'Maha Interior is Tamil Nadu\'s premier interior design and execution studio. Delivering bespoke modular kitchens, luxury wardrobes, living spaces, and turnkey interior fitouts.')

@section('content')

<!-- =======================================================
     SECTION 1: INTRO / HERO (#interior-intro)
======================================================= -->
<section class="hero-section" id="interior-intro" style="position:relative;min-height:92vh;display:flex;align-items:center;background:radial-gradient(circle at 75% 30%, rgba(212,175,55,0.12) 0%, rgba(5,11,20,0.96) 65%), url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1920&q=85') center/cover no-repeat;padding:120px 0 70px;">
    <!-- Dark Vignette Overlay -->
    <div style="position:absolute;inset:0;background:linear-gradient(180deg, rgba(5,11,20,0.85) 0%, rgba(5,11,20,0.65) 50%, rgba(5,11,20,0.95) 100%);"></div>

    <div class="container" style="position:relative;z-index:2;">
        <div style="max-width:840px;">
            <!-- Gold Pill Badge -->
            <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(212,175,55,0.15);border:1px solid #D4AF37;padding:6px 18px;border-radius:30px;margin-bottom:20px;box-shadow:0 0 20px rgba(212,175,55,0.25);">
                <span style="width:8px;height:8px;background:#25D366;border-radius:50%;box-shadow:0 0 8px #25D366;"></span>
                <span style="font-size:0.75rem;font-weight:800;letter-spacing:0.18em;color:#D4AF37;text-transform:uppercase;font-family:var(--font-heading);">
                    MAHA INTERIOR • DIVISION OF MAHA CONSTRUCTION
                </span>
            </div>

            <!-- Primary Headline & Tagline -->
            <h1 style="font-size:clamp(2.4rem, 5.5vw, 4.2rem);font-weight:900;line-height:1.12;letter-spacing:0.02em;font-family:var(--font-heading);margin:0 0 14px 0;text-transform:uppercase;">
                <span style="background:linear-gradient(135deg, #FFFFFF 20%, #FFFDF0 50%, #FFD700 85%, #D4AF37 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;filter:drop-shadow(0 4px 14px rgba(212,175,55,0.35));">
                    MAHA INTERIOR
                </span>
                <br>
                <span style="font-size:clamp(1.3rem, 3vw, 2.2rem);color:#D4AF37;font-weight:800;letter-spacing:0.14em;display:block;margin-top:6px;text-shadow:0 0 15px rgba(212,175,55,0.4);">
                    DESIGNING BEAUTIFUL LIVING
                </span>
            </h1>

            <p style="font-size:clamp(0.95rem, 1.8vw, 1.15rem);color:#E2E8F0;line-height:1.65;margin:0 0 28px 0;max-width:720px;font-family:var(--font-body);">
                Tamil Nadu’s premier interior architecture and turnkey execution studio. Crafting bespoke modular kitchens, luxury wardrobes, acoustic living spaces, and atmospheric lighting with registered civil engineering precision.
            </p>

            <!-- Value Highlights Checklist -->
            <div style="display:flex;flex-wrap:wrap;gap:16px 28px;margin-bottom:36px;">
                <div style="display:flex;align-items:center;gap:8px;font-size:0.85rem;color:#F0EBE0;font-weight:600;">
                    <i class="fas fa-shield-halved" style="color:#D4AF37;font-size:1rem;"></i> 12-Year Hardware Warranty
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:0.85rem;color:#F0EBE0;font-weight:600;">
                    <i class="fas fa-layer-group" style="color:#D4AF37;font-size:1rem;"></i> 100% BWP Marine Plywood
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:0.85rem;color:#F0EBE0;font-weight:600;">
                    <i class="fas fa-clock" style="color:#25D366;font-size:1rem;"></i> 45-Day Delivery Promise
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:0.85rem;color:#F0EBE0;font-weight:600;">
                    <i class="fas fa-file-invoice-dollar" style="color:#D4AF37;font-size:1rem;"></i> Zero Cost Escalation Guarantee
                </div>
            </div>

            <!-- Hero Primary CTAs -->
            <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;">
                <a href="#interior-projects" class="btn-gold-pill" style="padding:16px 36px;font-size:0.9rem;letter-spacing:0.08em;font-weight:800;display:inline-flex;align-items:center;gap:10px;">
                    EXPLORE OUR INTERIORS <i class="fas fa-arrow-down" style="font-size:0.85rem;"></i>
                </a>
                <a href="#interior-enquiry" class="btn-whatsapp-outline" style="padding:15px 32px;font-size:0.9rem;letter-spacing:0.08em;font-weight:800;border-color:#D4AF37;color:#D4AF37;display:inline-flex;align-items:center;gap:10px;" onmouseover="this.style.background='#D4AF37';this.style.color='#050B14';" onmouseout="this.style.background='transparent';this.style.color='#D4AF37';">
                    <i class="fas fa-calendar-check"></i> BOOK A CONSULTATION
                </a>
            </div>
        </div>
    </div>
</section>

<!-- STATS METRICS STRIP -->
<section class="stats-metrics-bar" style="background:#081020;border-top:1px solid rgba(212,175,55,0.3);border-bottom:1px solid rgba(212,175,55,0.2);padding:24px 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:24px;text-align:center;">
            <div>
                <div style="font-size:2.2rem;font-weight:900;color:#D4AF37;font-family:var(--font-heading);">150+</div>
                <div style="font-size:0.75rem;font-weight:800;color:#94A3B8;letter-spacing:0.12em;text-transform:uppercase;margin-top:4px;">Interiors Handed Over</div>
            </div>
            <div>
                <div style="font-size:2.2rem;font-weight:900;color:#25D366;font-family:var(--font-heading);">45 Days</div>
                <div style="font-size:0.75rem;font-weight:800;color:#94A3B8;letter-spacing:0.12em;text-transform:uppercase;margin-top:4px;">Guaranteed Turnkey Timeline</div>
            </div>
            <div>
                <div style="font-size:2.2rem;font-weight:900;color:#FFD700;font-family:var(--font-heading);">10 Years</div>
                <div style="font-size:0.75rem;font-weight:800;color:#94A3B8;letter-spacing:0.12em;text-transform:uppercase;margin-top:4px;">Hardware & Plywood Warranty</div>
            </div>
            <div>
                <div style="font-size:2.2rem;font-weight:900;color:#D4AF37;font-family:var(--font-heading);">100%</div>
                <div style="font-size:0.75rem;font-weight:800;color:#94A3B8;letter-spacing:0.12em;text-transform:uppercase;margin-top:4px;">Factory Machine Finish</div>
            </div>
        </div>
    </div>
</section>


<!-- =======================================================
     SECTION 2: OUR INTERIOR SERVICES (#interior-services)
======================================================= -->
<section class="section-pad" id="interior-services" style="background:#050B14;scroll-margin-top:70px;">
    <div class="container">
        <div style="text-align:center;max-width:760px;margin:0 auto 48px;">
            <span class="pill-badge" style="background:rgba(212,175,55,0.12);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.75rem;padding:6px 18px;letter-spacing:0.15em;">
                BESPOKE CAPABILITIES
            </span>
            <h2 class="sec-title" style="margin-top:14px;font-size:clamp(1.8rem, 3.5vw, 2.6rem);">
                OUR INTERIOR <span class="gold">SERVICES</span>
            </h2>
            <p class="sec-sub" style="margin:10px auto 0;">
                Comprehensive interior architecture from conceptual 3D renders to machine edge-banded fabrication and white-glove turnkey installation.
            </p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:28px;">
            @forelse($services as $srv)
            <div class="interior-service-card" style="background:#0B132B;border:1.5px solid rgba(212,175,55,0.25);border-radius:20px;overflow:hidden;transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);display:flex;flex-direction:column;box-shadow:0 10px 30px rgba(0,0,0,0.4);"
                 onmouseover="this.style.borderColor='#D4AF37';this.style.transform='translateY(-6px)';this.style.boxShadow='0 18px 40px rgba(212,175,55,0.18)';"
                 onmouseout="this.style.borderColor='rgba(212,175,55,0.25)';this.style.transform='translateY(0)';this.style.boxShadow='0 10px 30px rgba(0,0,0,0.4)';">
                
                <!-- Service Thumbnail Image -->
                <div style="position:relative;height:200px;overflow:hidden;background:#000;">
                    <img src="{{ $srv->image_url ?: 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=800&q=80' }}"
                         alt="{{ $srv->name }}"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;"
                         loading="lazy">
                    <div style="position:absolute;inset:0;background:linear-gradient(180deg, rgba(5,11,20,0.1) 0%, rgba(11,19,43,0.9) 100%);"></div>
                    <span style="position:absolute;top:14px;left:14px;background:rgba(5,11,20,0.85);backdrop-filter:blur(6px);border:1px solid rgba(212,175,55,0.6);border-radius:20px;padding:4px 12px;font-size:0.68rem;font-weight:800;color:#D4AF37;letter-spacing:0.1em;text-transform:uppercase;">
                        {{ $srv->category ?: 'INTERIOR SERVICE' }}
                    </span>
                </div>

                <!-- Card Body -->
                <div style="padding:24px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <h3 style="font-size:1.25rem;font-weight:800;color:#FFFFFF;margin:0 0 10px;font-family:var(--font-heading);">
                            {{ $srv->name }}
                        </h3>
                        <p style="font-size:0.86rem;color:#94A3B8;line-height:1.55;margin:0 0 18px;">
                            {{ $srv->overview }}
                        </p>

                        @if(!empty($srv->benefits) && is_array($srv->benefits))
                        <!-- Benefits Checklist -->
                        <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:20px;padding-top:14px;border-top:1px solid rgba(212,175,55,0.15);">
                            @foreach(array_slice($srv->benefits, 0, 3) as $benefit)
                            <div style="display:flex;align-items:center;gap:8px;font-size:0.82rem;color:#E2E8F0;">
                                <i class="fas fa-check-circle" style="color:#25D366;font-size:0.75rem;"></i>
                                <span>{{ $benefit }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Action Button: Smooth scroll to enquiry with service preselection -->
                    <a href="#interior-enquiry" onclick="preselectInteriorService('{{ addslashes($srv->name) }}')" style="display:inline-flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:11px;border-radius:12px;background:rgba(212,175,55,0.1);color:#D4AF37;border:1px solid rgba(212,175,55,0.35);font-size:0.8rem;font-weight:800;letter-spacing:0.06em;text-decoration:none;text-transform:uppercase;transition:all 0.2s;" onmouseover="this.style.background='#D4AF37';this.style.color='#050B14';" onmouseout="this.style.background='rgba(212,175,55,0.1)';this.style.color='#D4AF37';">
                        CONSULT FOR THIS SERVICE <i class="fas fa-arrow-right" style="font-size:0.7rem;"></i>
                    </a>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:#94A3B8;">
                Interior services are currently being updated.
            </div>
            @endforelse
        </div>
    </div>
</section>


<!-- =======================================================
     SECTION 3: COMPLETED PROJECTS (#interior-projects)
======================================================= -->
<section class="section-pad" id="interior-projects" style="background:#0B132B;scroll-margin-top:70px;">
    <div class="container">
        <div style="text-align:center;max-width:760px;margin:0 auto 36px;">
            <span class="pill-badge" style="background:rgba(212,175,55,0.12);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.75rem;padding:6px 18px;letter-spacing:0.15em;">
                PORTFOLIO SHOWCASE
            </span>
            <h2 class="sec-title" style="margin-top:14px;font-size:clamp(1.8rem, 3.5vw, 2.6rem);">
                COMPLETED <span class="gold">INTERIOR PROJECTS</span>
            </h2>
            <p class="sec-sub" style="margin:10px auto 0;">
                Explore real homes and commercial spaces transformed through bespoke joinery, quartz stone, and ambient lighting across Tamil Nadu.
            </p>
        </div>

        <!-- On-Page Category Filter Buttons (No Redirection) -->
        <div class="tab-toggle-group" style="display:flex;justify-content:center;flex-wrap:wrap;gap:8px;margin-bottom:36px;">
            <button type="button" class="tab-btn interior-filter-btn active" data-category="all">ALL SPACES</button>
            <button type="button" class="tab-btn interior-filter-btn" data-category="living-room">LIVING ROOM</button>
            <button type="button" class="tab-btn interior-filter-btn" data-category="modular-kitchen">MODULAR KITCHEN</button>
            <button type="button" class="tab-btn interior-filter-btn" data-category="bedroom">BEDROOM</button>
            <button type="button" class="tab-btn interior-filter-btn" data-category="office-interior">OFFICE INTERIOR</button>
            <button type="button" class="tab-btn interior-filter-btn" data-category="full-home-interior">FULL HOME</button>
            <button type="button" class="tab-btn interior-filter-btn" data-category="commercial-interior">COMMERCIAL</button>
        </div>

        <!-- Projects Grid -->
        <div id="interiorProjectsGrid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:28px;">
            @forelse($projects as $i => $project)
            <div class="interior-project-card" data-category="{{ $project->category }}"
                 style="background:#050B14;border:1.5px solid rgba(212,175,55,0.22);border-radius:20px;overflow:hidden;transition:all 0.3s ease;display:flex;flex-direction:column;box-shadow:0 10px 30px rgba(0,0,0,0.5);"
                 onmouseover="this.style.borderColor='#D4AF37';this.style.transform='translateY(-6px)';this.style.boxShadow='0 18px 40px rgba(212,175,55,0.2)';"
                 onmouseout="this.style.borderColor='rgba(212,175,55,0.22)';this.style.transform='translateY(0)';this.style.boxShadow='0 10px 30px rgba(0,0,0,0.5)';">
                
                <!-- Thumbnail Frame -->
                <div style="position:relative;height:220px;overflow:hidden;background:#000;">
                    <img src="{{ ($project->image_urls && count($project->image_urls) > 0) ? $project->image_urls[0] : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80' }}"
                         alt="{{ $project->name }}"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;"
                         loading="lazy">
                    <div style="position:absolute;inset:0;background:linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(5,11,20,0.85) 100%);"></div>

                    <!-- Category Badge -->
                    <div style="position:absolute;top:14px;left:14px;background:rgba(5,11,20,0.85);backdrop-filter:blur(6px);border:1px solid rgba(212,175,55,0.6);border-radius:20px;padding:4px 12px;display:flex;align-items:center;gap:6px;">
                        <span style="width:6px;height:6px;background:#25D366;border-radius:50%;"></span>
                        <span style="font-size:0.68rem;font-weight:800;color:#D4AF37;letter-spacing:0.1em;text-transform:uppercase;">
                            {{ str_replace('-', ' ', $project->category) }}
                        </span>
                    </div>

                    @if($project->video_url)
                    <!-- Video Play Overlay Trigger -->
                    <div class="video-play-overlay" onclick="window.playVideoModal('{{ $project->video_url }}', '{{ addslashes($project->name) }}')" style="position:absolute;inset:0;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.1)';" onmouseout="this.style.background='rgba(0,0,0,0.3)';">
                        <div class="play-btn-circle" style="width:52px;height:52px;font-size:1.1rem;background:#D4AF37;color:#050B14;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 20px rgba(212,175,55,0.6);">
                            <i class="fas fa-play" style="margin-left:3px;"></i>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Card Info -->
                <div style="padding:20px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                            <h3 style="font-size:1.15rem;font-weight:800;color:#FFFFFF;margin:0;line-height:1.3;font-family:var(--font-heading);">
                                {{ $project->name }}
                            </h3>
                            @if($project->video_url)
                            <span style="font-size:0.65rem;color:#D4AF37;background:rgba(212,175,55,0.12);padding:2px 8px;border-radius:10px;font-weight:700;white-space:nowrap;">
                                <i class="fas fa-video" style="margin-right:3px;"></i>Video Tour
                            </span>
                            @endif
                        </div>

                        <div style="display:flex;align-items:center;gap:6px;color:#D4AF37;font-size:0.82rem;font-weight:600;margin-top:6px;">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $project->location ?? 'Tamil Nadu' }}</span>
                        </div>

                        <p style="font-size:0.82rem;color:#94A3B8;line-height:1.45;margin-top:10px;">
                            {{ Str::limit($project->description, 95) }}
                        </p>
                    </div>

                    <!-- Divider & Area Specs -->
                    <div style="margin-top:16px;padding-top:12px;border-top:1px solid rgba(212,175,55,0.15);display:flex;justify-content:space-between;align-items:center;font-size:0.82rem;">
                        <span style="color:#94A3B8;font-weight:600;">Coverage Area</span>
                        <span style="color:#FFFFFF;font-weight:800;">{{ $project->duration ?: 'Turnkey Space' }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:#94A3B8;">
                Interior projects showcase is being updated.
            </div>
            @endforelse
            <div id="noFilteredProjectsMsg" style="display:none;grid-column:1/-1;text-align:center;padding:48px 20px;color:#94A3B8;">
                <i class="fas fa-couch" style="font-size:2rem;color:rgba(212,175,55,0.4);margin-bottom:12px;display:block;"></i>
                <p style="font-size:0.95rem;color:#FFF;margin-bottom:6px;">No projects currently listed in this space.</p>
                <p style="font-size:0.8rem;color:#64748b;">Browse other spaces above or consult Er. Maha Rajan for custom projects.</p>
            </div>
        </div>

        <!-- On-Page Reveal / Load More (Keeps user on the same page, NO redirects) -->
        <div style="text-align:center;margin-top:40px;">
            <p style="font-size:0.85rem;color:#94A3B8;margin-bottom:12px;">
                Showing all curated interior transformations across Tamil Nadu
            </p>
            <a href="#interior-enquiry" class="btn-whatsapp-outline" style="padding:12px 28px;font-size:0.84rem;font-weight:800;border-color:rgba(212,175,55,0.4);color:#D4AF37;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-paper-plane"></i> REQUEST ESTIMATE FOR YOUR SPACE
            </a>
        </div>
    </div>
</section>


<!-- =======================================================
     SECTION 4: CLIENT TESTIMONIALS (#interior-testimonials)
======================================================= -->
<section class="section-pad" id="interior-testimonials" style="background:#050B14;scroll-margin-top:70px;">
    <div class="container">
        <div style="text-align:center;max-width:760px;margin:0 auto 36px;">
            <span class="pill-badge" style="background:rgba(212,175,55,0.12);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.75rem;padding:6px 18px;letter-spacing:0.15em;">
                CLIENT SATISFACTION
            </span>
            <h2 class="sec-title" style="margin-top:14px;font-size:clamp(1.8rem, 3.5vw, 2.6rem);">
                CLIENT <span class="gold">TESTIMONIALS</span>
            </h2>
            <p class="sec-sub" style="margin:10px auto 0;">
                Hear directly from families and professionals whose living spaces and modular kitchens we have designed and delivered.
            </p>
        </div>

        @if($testimonials->count() > 0)
        <!-- 3-Stat Metric Row -->
        <div style="display:flex;justify-content:center;gap:0;margin:0 auto 36px;flex-wrap:wrap;max-width:600px;background:#0B132B;border-radius:18px;border:1px solid rgba(212,175,55,0.2);padding:14px 20px;">
            <div style="flex:1;min-width:120px;text-align:center;padding:8px;border-right:1px solid rgba(212,175,55,0.2);">
                <div style="font-size:1.8rem;font-weight:900;color:#D4AF37;font-family:var(--font-heading);">{{ $testimonials->count() }}+</div>
                <div style="font-size:0.68rem;font-weight:800;color:#94A3B8;letter-spacing:0.1em;text-transform:uppercase;margin-top:2px;">Interior Stories</div>
            </div>
            <div style="flex:1;min-width:120px;text-align:center;padding:8px;border-right:1px solid rgba(212,175,55,0.2);">
                <div style="font-size:1.8rem;font-weight:900;color:#25D366;font-family:var(--font-heading);">100%</div>
                <div style="font-size:0.68rem;font-weight:800;color:#94A3B8;letter-spacing:0.1em;text-transform:uppercase;margin-top:2px;">On-Time Delivery</div>
            </div>
            <div style="flex:1;min-width:120px;text-align:center;padding:8px;">
                <div style="font-size:1.8rem;font-weight:900;color:#FFD700;font-family:var(--font-heading);">5.0 <i class="fas fa-star" style="font-size:1.2rem;"></i></div>
                <div style="font-size:0.68rem;font-weight:800;color:#94A3B8;letter-spacing:0.1em;text-transform:uppercase;margin-top:2px;">Client Rating</div>
            </div>
        </div>

        <!-- Testimonial Cards Grid -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:28px;">
            @foreach($testimonials as $t)
            <div style="background:#0B132B;border:1.5px solid rgba(212,175,55,0.25);border-radius:20px;padding:28px;display:flex;flex-direction:column;justify-content:space-between;box-shadow:0 10px 30px rgba(0,0,0,0.4);position:relative;overflow:hidden;">
                <!-- Subtle gold top highlight -->
                <div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg, transparent, #D4AF37, transparent);"></div>

                <div>
                    <!-- Star Rating & Quote Icon -->
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                        <div style="color:#FFD700;font-size:0.95rem;">
                            @for($s = 0; $s < ($t->rating ?? 5); $s++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <i class="fas fa-quote-right" style="color:rgba(212,175,55,0.25);font-size:1.6rem;"></i>
                    </div>

                    <!-- Client Feedback -->
                    <p style="font-size:0.92rem;color:#E2E8F0;line-height:1.65;font-style:italic;margin:0 0 20px;">
                        "{{ $t->feedback }}"
                    </p>
                </div>

                <!-- Client Info Foot -->
                <div style="display:flex;align-items:center;gap:14px;padding-top:16px;border-top:1px solid rgba(212,175,55,0.15);">
                    <img src="{{ $t->image_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}"
                         alt="{{ $t->client_name }}"
                         style="width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid #D4AF37;">
                    <div style="flex:1;">
                        <div style="font-weight:800;color:#FFFFFF;font-size:0.95rem;font-family:var(--font-heading);">
                            {{ $t->client_name }}
                        </div>
                        <div style="font-size:0.75rem;color:#D4AF37;font-weight:600;">
                            {{ $t->client_role ?? 'Homeowner' }}
                        </div>
                        @if($t->project_name)
                        <div style="font-size:0.72rem;color:#94A3B8;margin-top:2px;">
                            <i class="fas fa-home" style="margin-right:4px;"></i> {{ $t->project_name }}
                        </div>
                        @endif
                    </div>
                    @if($t->video_url)
                    <button onclick="window.playVideoModal('{{ $t->video_url }}', '{{ addslashes($t->client_name) }} - Video Review')" style="background:rgba(212,175,55,0.15);border:1px solid #D4AF37;color:#D4AF37;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.2s;" title="Watch Video Review" onmouseover="this.style.background='#D4AF37';this.style.color='#050B14';" onmouseout="this.style.background='rgba(212,175,55,0.15)';this.style.color='#D4AF37';">
                        <i class="fas fa-play" style="font-size:0.85rem;margin-left:2px;"></i>
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>


<!-- =======================================================
     SECTION 5: ENGINEER / COMPANY INTRO (#interior-engineer)
======================================================= -->
<section class="section-pad" id="interior-engineer" style="background:#0B132B;scroll-margin-top:70px;">
    <div class="container">
        <!-- Compact Spotlight Card -->
        <div style="max-width:1040px;margin:0 auto;background:linear-gradient(135deg, rgba(11,19,43,0.95), rgba(5,11,20,0.98));border:1px solid rgba(212,175,55,0.35);border-radius:24px;padding:40px;box-shadow:0 16px 40px rgba(0,0,0,0.6), 0 0 30px rgba(212,175,55,0.1);position:relative;overflow:hidden;">
            <!-- Top Gold Beam Line -->
            <div style="position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg, transparent, #D4AF37, #FFD700, #D4AF37, transparent);"></div>

            <div style="display:grid;grid-template-columns:300px 1fr;gap:40px;align-items:center;" class="engineer-grid-cols">
                
                <!-- Left: Engineer Portrait & 60-Sec Intro Video -->
                <div style="display:flex;flex-direction:column;align-items:center;width:100%;">
                    <div style="width:100%;max-width:300px;margin-bottom:10px;text-align:left;">
                        <span class="sec-tag" style="margin-bottom:0;font-size:0.75rem;letter-spacing:0.15em;color:#D4AF37;font-weight:800;display:inline-block;">ENGINEER-LED INTERIORS</span>
                    </div>

                    <div class="engineer-video-box"
                         onclick="window.playVideoModal('{{ $intro_video_url }}', 'Er. Maha Rajan - 60-Second Video Introduction')"
                         onmouseover="this.style.borderColor='#D4AF37';this.style.boxShadow='0 14px 30px rgba(212,175,55,0.2)';"
                         onmouseout="this.style.borderColor='rgba(212,175,55,0.4)';this.style.boxShadow='0 10px 25px rgba(0,0,0,0.5)';"
                         style="width:100%;max-width:300px;aspect-ratio:4/3;position:relative;border-radius:18px;overflow:hidden;border:1px solid rgba(212,175,55,0.4);background:#050B14;box-shadow:0 10px 25px rgba(0,0,0,0.5);cursor:pointer;transition:all 0.3s ease;">

                        <!-- Thumbnail Image -->
                        <img src="{{ asset('maha-rajan.png') }}"
                             style="width:100%;height:100%;object-fit:cover;object-position:top center;display:block;"
                             alt="Er. Maha Rajan"
                             onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80'">

                        <!-- Dark Vignette Overlay -->
                        <div style="position:absolute;inset:0;background:linear-gradient(180deg, rgba(5,11,20,0.15) 0%, rgba(5,11,20,0.05) 40%, rgba(5,11,20,0.88) 100%);"></div>

                        <!-- Badges -->
                        <div style="position:absolute;top:10px;left:10px;background:rgba(5,11,20,0.85);backdrop-filter:blur(4px);border:1px solid rgba(212,175,55,0.5);color:#D4AF37;font-size:0.62rem;font-weight:800;padding:3px 10px;border-radius:12px;display:flex;align-items:center;gap:5px;text-transform:uppercase;">
                            <i class="fas fa-play" style="font-size:0.5rem;color:#25D366;"></i> 60-Sec Intro
                        </div>

                        <div style="position:absolute;top:10px;right:10px;background:rgba(37,211,102,0.15);border:1px solid rgba(37,211,102,0.4);color:#25D366;font-size:0.6rem;font-weight:800;padding:3px 8px;border-radius:12px;display:flex;align-items:center;gap:4px;">
                            <i class="fas fa-certificate"></i> VERIFIED
                        </div>

                        <!-- Center Play Button -->
                        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);width:52px;height:52px;background:#D4AF37;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#050B14;font-size:1.2rem;box-shadow:0 0 24px rgba(212,175,55,0.75);">
                            <i class="fas fa-play" style="margin-left:3px;"></i>
                        </div>

                        <!-- Bottom Frame Label -->
                        <div style="position:absolute;bottom:10px;left:12px;right:12px;text-align:center;">
                            <div style="font-size:0.72rem;font-weight:800;color:#FFF;text-shadow:0 2px 4px rgba(0,0,0,0.8);letter-spacing:0.05em;">
                                WATCH INTRO VIDEO <i class="fas fa-arrow-right" style="font-size:0.65rem;margin-left:4px;color:#D4AF37;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Mini CTA under video -->
                    <button class="btn-whatsapp-outline"
                            onclick="window.playVideoModal('{{ $intro_video_url }}', 'Er. Maha Rajan - 60-Second Video Introduction')"
                            style="margin-top:12px;width:100%;max-width:300px;padding:9px 14px;font-size:0.76rem;justify-content:center;border-color:rgba(212,175,55,0.4);color:#D4AF37;display:flex;align-items:center;">
                        <i class="fas fa-circle-play" style="margin-right:6px;color:#D4AF37;"></i> PLAY 60-SEC VIDEO
                    </button>
                </div>

                <!-- Right: Executive Info & Why Engineer-Led Matters -->
                <div>
                    <h3 style="font-size:1.6rem;font-weight:800;color:#fff;line-height:1.25;margin:0 0 4px 0;font-family:var(--font-heading);">
                        Er. Maha Rajan <span style="font-size:0.95rem;color:#D4AF37;font-weight:700;">(B.E. Civil)</span>
                    </h3>
                    <div style="font-size:0.8rem;color:#25D366;font-weight:700;letter-spacing:0.08em;margin-bottom:16px;">
                        GOVERNMENT REGISTERED ENGINEER • 12+ YEARS STRUCTURAL & INTERIOR EXCELLENCE
                    </div>

                    <p style="font-size:0.88rem;color:#CBD5E1;line-height:1.65;margin:0 0 20px;">
                        Most interior failures occur because carpenters cut into load-bearing RCC structures, create hazardous electrical overloads, or use sub-standard commercial ply that bends and warps in moisture.
                    </p>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px 20px;margin-bottom:24px;">
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="fas fa-plug-circle-bolt" style="color:#D4AF37;margin-top:3px;"></i>
                            <div>
                                <strong style="color:#FFF;font-size:0.82rem;display:block;">MEP & Conduiting Safety</strong>
                                <span style="font-size:0.75rem;color:#94A3B8;">Constant-voltage drivers and zero risk of fire hazard overloads.</span>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="fas fa-cubes" style="color:#D4AF37;margin-top:3px;"></i>
                            <div>
                                <strong style="color:#FFF;font-size:0.82rem;display:block;">BWP Marine Ply Only</strong>
                                <span style="font-size:0.75rem;color:#94A3B8;">IS:710 boiling water proof certified core with zero hollow voids.</span>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="fas fa-ruler-combined" style="color:#D4AF37;margin-top:3px;"></i>
                            <div>
                                <strong style="color:#FFF;font-size:0.82rem;display:block;">Precision Joinery</strong>
                                <span style="font-size:0.75rem;color:#94A3B8;">Factory edge-banding for seamless waterproof joints.</span>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="fas fa-handshake" style="color:#25D366;margin-top:3px;"></i>
                            <div>
                                <strong style="color:#FFF;font-size:0.82rem;display:block;">Zero Hidden Costs</strong>
                                <span style="font-size:0.75rem;color:#94A3B8;">Itemized BOQ contracts with strict milestone guarantees.</span>
                            </div>
                        </div>
                    </div>

                    <a href="#interior-enquiry" class="btn-gold-pill" style="padding:12px 28px;font-size:0.84rem;font-weight:800;letter-spacing:0.06em;display:inline-flex;align-items:center;gap:8px;">
                        CONSULT ER. MAHA RAJAN DIRECTLY <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- =======================================================
     SECTION 6: INTERIOR PACKAGES (#interior-packages)
======================================================= -->
<section class="section-pad" id="interior-packages" style="background:#050B14;scroll-margin-top:70px;">
    <div class="container">
        <div style="text-align:center;max-width:760px;margin:0 auto 48px;">
            <span class="pill-badge" style="background:rgba(212,175,55,0.12);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.75rem;padding:6px 18px;letter-spacing:0.15em;">
                TRANSPARENT VALUE PLANS
            </span>
            <h2 class="sec-title" style="margin-top:14px;font-size:clamp(1.8rem, 3.5vw, 2.6rem);">
                INTERIOR <span class="gold">PACKAGES</span>
            </h2>
            <p class="sec-sub" style="margin:10px auto 0;">
                Transparent turnkey pricing per sq.ft with 100% itemized material transparency and German hardware fittings.
            </p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:32px;align-items:stretch;">
            @forelse($packages as $pkg)
            <div class="interior-package-card {{ $pkg->is_highlighted ? 'highlighted' : '' }}"
                 style="background:#0B132B;border:{{ $pkg->is_highlighted ? '2px solid #D4AF37' : '1.5px solid rgba(212,175,55,0.25)' }};border-radius:24px;padding:36px 30px;display:flex;flex-direction:column;justify-content:space-between;position:relative;box-shadow:{{ $pkg->is_highlighted ? '0 16px 40px rgba(212,175,55,0.25)' : '0 10px 30px rgba(0,0,0,0.5)' }};transition:all 0.3s ease;">
                
                @if($pkg->is_highlighted)
                <!-- Popular Badge -->
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg, #D4AF37, #FFD700);color:#050B14;font-size:0.72rem;font-weight:900;letter-spacing:0.12em;padding:5px 18px;border-radius:20px;text-transform:uppercase;box-shadow:0 4px 14px rgba(212,175,55,0.5);">
                    MOST POPULAR CHOICE
                </div>
                @endif

                <div>
                    <!-- Tier & Title -->
                    <span style="font-size:0.72rem;font-weight:800;color:#D4AF37;letter-spacing:0.15em;text-transform:uppercase;display:block;margin-bottom:6px;">
                        {{ strtoupper($pkg->tier) }} PLAN
                    </span>
                    <h3 style="font-size:1.6rem;font-weight:900;color:#FFFFFF;margin:0 0 6px;font-family:var(--font-heading);">
                        {{ $pkg->title }}
                    </h3>
                    <p style="font-size:0.82rem;color:#94A3B8;margin:0 0 20px;">
                        {{ $pkg->subtitle }}
                    </p>

                    <!-- Price Box -->
                    <div style="background:rgba(5,11,20,0.8);border:1px solid rgba(212,175,55,0.2);border-radius:14px;padding:16px 20px;margin-bottom:24px;display:flex;justify-content:space-between;align-items:baseline;">
                        <div>
                            <span style="font-size:2rem;font-weight:900;color:#D4AF37;font-family:var(--font-heading);">
                                ₹{{ number_format($pkg->price_per_sqft) }}
                            </span>
                            <span style="font-size:0.85rem;color:#94A3B8;">/ sq.ft</span>
                        </div>
                        <span style="font-size:0.68rem;color:#25D366;font-weight:800;letter-spacing:0.06em;">TURNKEY RATE</span>
                    </div>

                    <!-- Warranty & Delivery Badges -->
                    <div style="display:flex;gap:10px;margin-bottom:24px;">
                        <span style="background:rgba(212,175,55,0.1);border:1px solid rgba(212,175,55,0.3);color:#D4AF37;font-size:0.72rem;font-weight:700;padding:4px 10px;border-radius:8px;">
                            <i class="fas fa-shield-alt"></i> {{ $pkg->warranty_years ?? 10 }} Yrs Warranty
                        </span>
                        <span style="background:rgba(37,211,102,0.1);border:1px solid rgba(37,211,102,0.3);color:#25D366;font-size:0.72rem;font-weight:700;padding:4px 10px;border-radius:8px;">
                            <i class="fas fa-calendar-check"></i> {{ $pkg->delivery_months ?? 2 }} Mos Handover
                        </span>
                    </div>

                    <!-- Key Features List -->
                    <ul style="list-style:none;padding:0;margin:0 0 28px;display:flex;flex-direction:column;gap:10px;">
                        @if(!empty($pkg->features) && is_array($pkg->features))
                            @foreach(array_slice($pkg->features, 0, 6) as $feat)
                            <li style="display:flex;align-items:flex-start;gap:10px;font-size:0.84rem;color:#CBD5E1;line-height:1.45;">
                                <i class="fas fa-check" style="color:#D4AF37;font-size:0.75rem;margin-top:3px;flex-shrink:0;"></i>
                                <span>{{ $feat }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <!-- Card Bottom Actions: Both keep visitor on the same page -->
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <a href="#interior-enquiry" onclick="preselectInteriorPackage('{{ addslashes($pkg->title) }}')" class="btn-gold-pill" style="width:100%;text-align:center;padding:12px;font-size:0.84rem;font-weight:800;letter-spacing:0.05em;display:flex;align-items:center;justify-content:center;gap:6px;">
                        <i class="fas fa-paper-plane"></i> BOOK THIS PACKAGE
                    </a>
                    
                    <!-- View Details Modal Trigger (Opens existing on-page modal) -->
                    <button type="button" onclick="openInteriorPackageDetailsModal({{ json_encode($pkg) }})" style="background:transparent;border:1px solid rgba(212,175,55,0.3);color:#CBD5E1;padding:10px;border-radius:14px;font-size:0.78rem;font-weight:700;cursor:pointer;transition:all 0.2s;letter-spacing:0.04em;" onmouseover="this.style.borderColor='#D4AF37';this.style.color='#D4AF37';" onmouseout="this.style.borderColor='rgba(212,175,55,0.3)';this.style.color='#CBD5E1';">
                        <i class="fas fa-list-check" style="margin-right:4px;"></i> VIEW FULL INCLUSIONS & SPECS
                    </button>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:#94A3B8;">
                Interior packages are currently being updated.
            </div>
            @endforelse
        </div>
    </div>
</section>


<!-- =======================================================
     SECTION 7: ENQUIRE / BOOK CONSULTATION (#interior-enquiry)
======================================================= -->
<section class="section-pad" id="interior-enquiry" style="background:#0B132B;scroll-margin-top:70px;">
    <div class="container">
        <div style="max-width:880px;margin:0 auto;background:#050B14;border:1.5px solid #D4AF37;border-radius:28px;padding:44px 36px;box-shadow:0 20px 60px rgba(0,0,0,0.8), 0 0 35px rgba(212,175,55,0.2);position:relative;overflow:hidden;">
            <!-- Top Gold Beam Line -->
            <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg, transparent, #D4AF37, #FFD700, #D4AF37, transparent);"></div>

            <div style="text-align:center;margin-bottom:32px;">
                <span class="pill-badge" style="background:rgba(212,175,55,0.12);border:1px solid rgba(212,175,55,0.4);color:#D4AF37;font-size:0.75rem;padding:6px 18px;letter-spacing:0.15em;">
                    DIRECT STUDIO CONSULTATION
                </span>
                <h2 class="sec-title" style="margin-top:12px;font-size:clamp(1.8rem, 3.2vw, 2.4rem);">
                    ENQUIRE / <span class="gold">BOOK A CONSULTATION</span>
                </h2>
                <p class="sec-sub" style="margin:8px auto 0;font-size:0.88rem;">
                    Submit your details for a personalized 3D spatial review, modular kitchen plan, and transparent itemized quote from Er. Maha Rajan.
                </p>
            </div>

            <!-- Dedicated Interior Consultation Form -->
            <form id="interiorEnquiryForm" class="quote-form-grid">
                @csrf
                <!-- Hidden UI aid: Backend strictly forces business_type = 'interior' -->
                <input type="hidden" name="business_type" value="interior">

                <div class="form-field full-width">
                    <label style="font-size:0.75rem;font-weight:800;color:#D4AF37;letter-spacing:0.08em;margin-bottom:6px;display:block;">FULL NAME *</label>
                    <input type="text" name="name" id="interiorFormName" required placeholder="Enter your full name" style="width:100%;padding:14px 18px;background:#0B132B;border:1px solid rgba(212,175,55,0.3);border-radius:12px;color:#FFF;font-size:0.9rem;">
                </div>

                <div class="form-field">
                    <label style="font-size:0.75rem;font-weight:800;color:#D4AF37;letter-spacing:0.08em;margin-bottom:6px;display:block;">EMAIL ADDRESS *</label>
                    <input type="email" name="email" id="interiorFormEmail" required placeholder="name@gmail.com" style="width:100%;padding:14px 18px;background:#0B132B;border:1px solid rgba(212,175,55,0.3);border-radius:12px;color:#FFF;font-size:0.9rem;">
                </div>

                <div class="form-field">
                    <label style="font-size:0.75rem;font-weight:800;color:#D4AF37;letter-spacing:0.08em;margin-bottom:6px;display:block;">TELEPHONE / WHATSAPP *</label>
                    <input type="tel" name="phone" id="interiorFormPhone" required placeholder="+91 90959 29543" style="width:100%;padding:14px 18px;background:#0B132B;border:1px solid rgba(212,175,55,0.3);border-radius:12px;color:#FFF;font-size:0.9rem;">
                </div>

                <div class="form-field">
                    <label style="font-size:0.75rem;font-weight:800;color:#D4AF37;letter-spacing:0.08em;margin-bottom:6px;display:block;">INTERIOR SERVICE / ROOM TYPE</label>
                    <select name="project_type" id="interiorFormService" style="width:100%;padding:14px 18px;background:#0B132B;border:1px solid rgba(212,175,55,0.3);border-radius:12px;color:#FFF;font-size:0.9rem;">
                        <option value="Full Home Interior">Full Home Turnkey Interior</option>
                        <option value="Modular Kitchen">Modular Kitchen</option>
                        <option value="Wardrobe Design">Wardrobe & Closet Systems</option>
                        <option value="Living Room Interiors">Living Room & TV Entertainment Console</option>
                        <option value="Bedroom Interiors">Master Bedroom Suite</option>
                        <option value="False Ceiling & Lighting">False Ceiling & Architectural Lighting</option>
                        <option value="Interior Renovation & Remodeling">Renovation & Remodeling</option>
                        <option value="Commercial / Office Interior">Commercial / Office Interior</option>
                    </select>
                </div>

                <div class="form-field">
                    <label style="font-size:0.75rem;font-weight:800;color:#D4AF37;letter-spacing:0.08em;margin-bottom:6px;display:block;">ESTIMATED BUDGET RANGE</label>
                    <select name="budget_range" id="interiorFormBudget" style="width:100%;padding:14px 18px;background:#0B132B;border:1px solid rgba(212,175,55,0.3);border-radius:12px;color:#FFF;font-size:0.9rem;">
                        <option value="₹3 Lakhs - ₹6 Lakhs">₹3 Lakhs - ₹6 Lakhs</option>
                        <option value="₹6 Lakhs - ₹12 Lakhs">₹6 Lakhs - ₹12 Lakhs</option>
                        <option value="₹12 Lakhs - ₹25 Lakhs">₹12 Lakhs - ₹25 Lakhs</option>
                        <option value="₹25 Lakhs+">₹25 Lakhs+ (Luxury Bespoke)</option>
                    </select>
                </div>

                <div class="form-field full-width">
                    <label style="font-size:0.75rem;font-weight:800;color:#D4AF37;letter-spacing:0.08em;margin-bottom:6px;display:block;">FLOOR PLAN / SPECIFIC REQUIREMENTS</label>
                    <textarea name="message" id="interiorFormMessage" rows="3" placeholder="Describe your apartment/villa size, handover date, preferred finishes, or modular needs..." style="width:100%;padding:14px 18px;background:#0B132B;border:1px solid rgba(212,175,55,0.3);border-radius:12px;color:#FFF;font-size:0.9rem;"></textarea>
                </div>

                <div class="form-field full-width">
                    <button type="submit" class="btn-gold-submit" id="interiorSubmitBtn" style="width:100%;padding:16px;font-size:0.95rem;font-weight:900;letter-spacing:0.08em;display:flex;align-items:center;justify-content:center;gap:8px;">
                        <i class="fas fa-paper-plane"></i> SUBMIT INTERIOR CONSULTATION REQUEST
                    </button>
                </div>

                <!-- Success Box -->
                <div id="interiorSuccessMessage" class="form-success-box" style="display:none;background:rgba(37,211,102,0.15);border:1px solid #25D366;color:#86EFAC;padding:16px;border-radius:12px;text-align:center;font-weight:700;">
                    <i class="fas fa-circle-check" style="margin-right:6px;color:#25D366;"></i>
                    Interior Consultation Request Submitted! Er. Maha Rajan's interior team will contact you within 24 hours.
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Smooth helper to preselect service in the consultation form
    function preselectInteriorService(serviceName) {
        const select = document.getElementById('interiorFormService');
        if (!select) return;
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].text.toLowerCase().includes(serviceName.toLowerCase()) ||
                serviceName.toLowerCase().includes(select.options[i].text.toLowerCase())) {
                select.selectedIndex = i;
                break;
            }
        }
    }

    // Helper to preselect package in the consultation form
    function preselectInteriorPackage(packageTitle) {
        const textarea = document.getElementById('interiorFormMessage');
        if (textarea) {
            textarea.value = "I am interested in the " + packageTitle + " package. Please share detailed inclusions and site consultation availability.";
        }
    }

    // Reuse existing package details modal on the same page
    function openInteriorPackageDetailsModal(pkg) {
        const modal = document.getElementById('packageDetailsModal');
        if (!modal) return;

        document.getElementById('modalPkgTierLabel').textContent = 'MAHA INTERIOR • ' + (pkg.tier || 'PLAN').toUpperCase();
        document.getElementById('modalPkgTitle').textContent = pkg.title;
        document.getElementById('modalPkgSubtitle').textContent = pkg.subtitle || '';
        document.getElementById('modalPkgPrice').innerHTML = '₹' + Number(pkg.price_per_sqft).toLocaleString() + ' <span>/ sq.ft</span>';
        document.getElementById('modalPkgWarranty').innerHTML = '<i class="fas fa-shield-halved" style="color:var(--gold);"></i> ' + (pkg.warranty_years || 10) + ' Yrs Hardware Warranty';
        document.getElementById('modalPkgDelivery').innerHTML = '<i class="fas fa-calendar-check" style="color:var(--gold);"></i> ' + (pkg.delivery_months || 2) + ' Mos Handover';
        document.getElementById('modalPkgDescription').textContent = pkg.description || '';

        // Inclusions
        const incList = document.getElementById('modalPkgInclusions');
        incList.innerHTML = '';
        if (Array.isArray(pkg.inclusions)) {
            pkg.inclusions.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = '<i class="fas fa-check" style="color:#25D366;margin-right:8px;"></i>' + item;
                incList.appendChild(li);
            });
        }

        // Exclusions
        const excList = document.getElementById('modalPkgExclusions');
        excList.innerHTML = '';
        if (Array.isArray(pkg.exclusions)) {
            pkg.exclusions.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = '<i class="fas fa-xmark" style="color:#FF3B30;margin-right:8px;"></i>' + item;
                excList.appendChild(li);
            });
        }

        // Features
        const featList = document.getElementById('modalPkgFeatures');
        featList.innerHTML = '';
        if (Array.isArray(pkg.features)) {
            pkg.features.forEach(item => {
                const li = document.createElement('li');
                li.style.display = 'flex';
                li.style.alignItems = 'center';
                li.style.gap = '8px';
                li.style.fontSize = '0.82rem';
                li.style.color = '#CBD5E1';
                li.innerHTML = '<i class="fas fa-layer-group" style="color:var(--gold);font-size:0.75rem;"></i>' + item;
                featList.appendChild(li);
            });
        }

        // Action in modal scrolls to on-page enquiry
        const reqBtn = document.getElementById('btnPkgRequestQuote');
        if (reqBtn) {
            reqBtn.onclick = function() {
                modal.classList.remove('open');
                preselectInteriorPackage(pkg.title);
                window.location.hash = '#interior-enquiry';
            };
        }

        modal.classList.add('open');
    }

    // On-Page Project Category Filtering (zero page redirect)
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.interior-filter-btn');
        const projectCards = document.querySelectorAll('.interior-project-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const targetCategory = this.getAttribute('data-category');
                let visibleCount = 0;
                projectCards.forEach(card => {
                    const cardCat = card.getAttribute('data-category');
                    if (targetCategory === 'all' || cardCat === targetCategory) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                const emptyMsg = document.getElementById('noFilteredProjectsMsg');
                if (emptyMsg) {
                    emptyMsg.style.display = (visibleCount === 0) ? 'block' : 'none';
                }
            });
        });

        // Dedicated AJAX Submission for Interior Enquiry (Server forces business_type = 'interior')
        const interiorForm = document.getElementById('interiorEnquiryForm');
        const interiorSuccessMessage = document.getElementById('interiorSuccessMessage');
        const interiorSubmitBtn = document.getElementById('interiorSubmitBtn');

        if (interiorForm) {
            interiorForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (interiorSubmitBtn) {
                    interiorSubmitBtn.disabled = true;
                    interiorSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> SUBMITTING...';
                }

                const formData = new FormData(interiorForm);
                const data = Object.fromEntries(formData.entries());

                fetch('/api/leads/interior/enquiry', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    if (interiorSubmitBtn) {
                        interiorSubmitBtn.disabled = false;
                        interiorSubmitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> SUBMIT INTERIOR CONSULTATION REQUEST';
                    }
                    if (interiorSuccessMessage) {
                        interiorSuccessMessage.style.display = 'block';
                    }
                    interiorForm.reset();
                    setTimeout(() => {
                        if (interiorSuccessMessage) {
                            interiorSuccessMessage.style.display = 'none';
                        }
                    }, 5000);
                })
                .catch(err => {
                    if (interiorSubmitBtn) {
                        interiorSubmitBtn.disabled = false;
                        interiorSubmitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> SUBMIT INTERIOR CONSULTATION REQUEST';
                    }
                    alert('Thank you! Your interior consultation request has been logged.');
                    interiorForm.reset();
                });
            });
        }
    });
</script>
@endpush
