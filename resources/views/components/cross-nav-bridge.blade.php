@props(['target' => null])

@php
    // Determine destination target if not explicitly passed
    // 'interior' / 'interiors' => bridge displayed on Construction page, pointing to MAHA Interiors
    // 'construction'           => bridge displayed on Interior page, pointing to MAHA Construction
    $dest = $target ?? (request()->routeIs('interior') ? 'construction' : 'interior');
    $isToInterior = in_array(strtolower($dest), ['interior', 'interiors']);

    $destUrl = $isToInterior ? route('interior') : route('home');
    $buttonLabel = $isToInterior ? 'Explore MAHA Interiors →' : 'Explore MAHA Construction →';
    $buttonText = $isToInterior ? 'Explore MAHA Interiors' : 'Explore MAHA Construction';

    $sectionId = $isToInterior ? 'cross-nav-to-interior' : 'cross-nav-to-construction';
    $themeClass = $isToInterior ? 'theme-to-interior' : 'theme-to-construction';

    $kicker = 'ONE VISION • TWO SPECIALITIES';
    $pretitle = $isToInterior
        ? 'Your home should reflect the way you live, the way you feel, and the way you dream.'
        : 'Ready to build the foundation?';
    $heading = $isToInterior
        ? 'From Building to Beautiful Living'
        : 'From Inspiring Interiors Back to Strong Foundations';
    $targetBrand = $isToInterior
        ? 'MAHA INTERIORS'
        : 'MAHA CONSTRUCTIONS';
    $targetTagline = $isToInterior
        ? 'YOUR DREAM. OUR DESIGN.'
        : 'WE BUILD YOUR DREAM HOME';
    $description = $isToInterior
        ? 'At MAHA Interiors, we understand your needs, lifestyle, taste, and budget before we design every space around you.'
        : 'Build your dream space with confidence. Certified structural engineering, premium architectural villas, end-to-end site supervision, and lifelong construction durability.';
    $imageSrc = $isToInterior
        ? 'https://www.nakshastore.com/uploads/article/Luxury%20Modern%20Living%20Room%20Interior%20Design%20India_1765962562.jpg'
        : 'https://static.vecteezy.com/system/resources/thumbnails/067/013/953/small/luxury-house-with-modern-landscape-free-photo.jpg';
    $imageAlt = $isToInterior
        ? 'Maha Luxury Interior Architectural Living Space'
        : 'Maha Constructions Luxury Architectural Villa Masterpiece';
    $badgeText = $isToInterior
        ? 'ARCHITECTURAL INTERIOR STUDIO'
        : 'CIVIL ENGINEERING & LUXURY VILLAS';
    $badgeIcon = $isToInterior
        ? 'fas fa-couch'
        : 'fas fa-building';

    $features = $isToInterior
        ? [
            ['icon' => 'fas fa-compass-drafting', 'text' => 'Understand & Plan'],
            ['icon' => 'fas fa-gem', 'text' => 'Design & Visualise'],
            ['icon' => 'fas fa-shield-halved', 'text' => 'Execute & Transform'],
        ]
        : [
            ['icon' => 'fas fa-drafting-compass', 'text' => 'Architectural Elevation Design'],
            ['icon' => 'fas fa-medal', 'text' => '100% Quality-Tested Concrete'],
            ['icon' => 'fas fa-hard-hat', 'text' => 'Government-Registered Er. Maha Rajan'],
        ];
@endphp

<section class="maha-cross-nav-section {{ $themeClass }}" id="{{ $sectionId }}" aria-label="Cross-Navigation to {{ $targetBrand }}">
    <div class="container">
        <div class="maha-bridge-card">
            
            {{-- Media Column (Left on Desktop, 3rd in flow on Mobile) --}}
            <div class="maha-bridge-media-col">
                <img src="{{ $imageSrc }}" 
                     alt="{{ $imageAlt }}" 
                     width="560" height="380"
                     decoding="async"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='{{ asset('images/placeholder-project.svg') }}';this.classList.add('is-fallback-img');"
                     class="maha-bridge-img">
                <div class="maha-bridge-media-badge">
                    <i class="{{ $badgeIcon }}" style="color:var(--gold, #D4AF37);"></i>
                    <span>{{ $badgeText }}</span>
                </div>
            </div>

            {{-- Content Column (Right on Desktop, Flex-contents on Mobile) --}}
            <div class="maha-bridge-content-col">
                {{-- 1. Kicker Label --}}
                <div class="maha-bridge-kicker">
                    <span class="maha-bridge-kicker-dot"></span>
                    <span>{{ $kicker }}</span>
                </div>

                {{-- 2. Headings & Target Brand --}}
                <div class="maha-bridge-headings">
                    <span class="maha-bridge-pretitle">{{ $pretitle }}</span>
                    <h2 class="maha-bridge-title">{{ $heading }}</h2>
                    <div class="maha-bridge-brand-lockup">
                        <div class="maha-bridge-brand-name">
                            @if($isToInterior)
                                <span class="brand-word-maha">MAHA</span>
                                <span class="brand-word-highlight">INTERIORS</span>
                            @else
                                <span class="brand-word-maha">MAHA</span>
                                <span class="brand-word-highlight">CONSTRUCTIONS</span>
                            @endif
                        </div>
                        <span class="maha-bridge-brand-tagline">{{ $targetTagline }}</span>
                    </div>
                </div>

                {{-- 4. Editorial Description & Feature Chips --}}
                <div class="maha-bridge-body">
                    <p class="maha-bridge-desc">{{ $description }}</p>
                    <div class="maha-bridge-features">
                        @foreach($features as $feat)
                        <div class="maha-bridge-feat-pill">
                            <i class="{{ $feat['icon'] }}"></i>
                            <span>{{ $feat['text'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- 5. Primary CTA Button --}}
                <div class="maha-bridge-cta-wrap">
                    <a href="{{ $destUrl }}" 
                       class="maha-cross-nav-btn" 
                       title="{{ $buttonLabel }}"
                       aria-label="{{ $buttonLabel }}">
                        <span class="btn-text">{{ $buttonText }}</span>
                        <span class="btn-arrow" aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
/* ==========================================================================
   MAHA CROSS-NAVIGATION BRIDGE COMPONENT STYLES
   Provides a seamless, architectural destination card between
   MAHA Construction and MAHA Interior.
   ========================================================================== */

.maha-cross-nav-section {
    width: 100%;
    position: relative;
    box-sizing: border-box;
    padding: 68px 0;
    overflow: hidden;
}

/* ─── Construction Theme (to Interior) ─── */
.maha-cross-nav-section.theme-to-interior {
    background: #050B14;
    border-top: 1px solid rgba(212, 175, 55, 0.15);
    border-bottom: 1px solid rgba(212, 175, 55, 0.15);
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-card {
    background: linear-gradient(135deg, rgba(17, 28, 56, 0.75) 0%, rgba(11, 19, 43, 0.88) 100%);
    border: 1px solid rgba(212, 175, 55, 0.28);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.55), 0 0 30px rgba(212, 175, 55, 0.08);
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-kicker {
    background: rgba(212, 175, 55, 0.10);
    border: 1px solid rgba(212, 175, 55, 0.35);
    color: #D4AF37;
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-kicker-dot {
    background: #D4AF37;
    box-shadow: 0 0 8px rgba(212, 175, 55, 0.8);
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-pretitle {
    color: #F0EBE0;
    opacity: 0.85;
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-title {
    color: #FFFFFF;
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-brand-name {
    background: linear-gradient(135deg, #FFFFFF 15%, #FFFDF0 45%, #FFD700 80%, #D4AF37 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 2px 10px rgba(212, 175, 55, 0.45));
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-brand-name .brand-word-maha {
    background: linear-gradient(135deg, #FFFFFF 0%, #FFFDF0 50%, #F5E6C8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.9));
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-brand-name .brand-word-highlight {
    background: linear-gradient(135deg, #FFD700 0%, #FFF4B8 35%, #FFD700 65%, #D4AF37 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 0 16px rgba(255, 215, 0, 0.65)) drop-shadow(0 2px 8px rgba(0, 0, 0, 0.9));
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-brand-tagline {
    color: #FFD700;
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-desc {
    color: #CBD5E1;
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-feat-pill {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(212, 175, 55, 0.20);
    color: #E2E8F0;
}
.maha-cross-nav-section.theme-to-interior .maha-bridge-feat-pill i {
    color: #D4AF37;
}
.maha-cross-nav-section.theme-to-interior .maha-cross-nav-btn {
    background: linear-gradient(135deg, #FFD700 0%, #D4AF37 50%, #B8960C 100%);
    color: #050B14;
    border: 1px solid #FFD700;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.6), 0 0 24px rgba(212, 175, 55, 0.4);
}
.maha-cross-nav-section.theme-to-interior .maha-cross-nav-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 32px rgba(0, 0, 0, 0.7), 0 0 32px rgba(212, 175, 55, 0.6);
}

/* ─── Interior Theme (to Construction) ─── */
.maha-cross-nav-section.theme-to-construction {
    background: #FAF8F5;
    border-top: 1px solid rgba(200, 149, 43, 0.18);
    border-bottom: 1px solid rgba(200, 149, 43, 0.18);
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-card {
    background: #FFFFFF;
    border: 1.5px solid rgba(200, 149, 43, 0.26);
    box-shadow: 0 16px 44px rgba(0, 0, 0, 0.05), 0 4px 18px rgba(200, 149, 43, 0.08);
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-kicker {
    background: rgba(200, 149, 43, 0.08);
    border: 1px solid rgba(200, 149, 43, 0.32);
    color: #B38222;
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-kicker-dot {
    background: #C8952B;
    box-shadow: 0 0 8px rgba(200, 149, 43, 0.7);
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-pretitle {
    color: #475569;
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-title {
    color: #161922;
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-brand-name {
    color: #161922;
    background: linear-gradient(135deg, #161922 20%, #334155 70%, #C8952B 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-brand-name .brand-word-maha {
    color: #0A0F1D;
    background: linear-gradient(135deg, #0A0F1D 0%, #162447 60%, #0F172A 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.15));
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-brand-name .brand-word-highlight {
    background: linear-gradient(135deg, #A8741A 0%, #C8952B 28%, #FFD700 55%, #D4AF37 80%, #996F15 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 2px 10px rgba(200, 149, 43, 0.45));
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-brand-tagline {
    color: #B38222;
    text-shadow: 0 0 8px rgba(179, 130, 34, 0.25);
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-desc {
    color: #374151;
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-feat-pill {
    background: #F8FAFC;
    border: 1px solid rgba(200, 149, 43, 0.22);
    color: #334155;
}
.maha-cross-nav-section.theme-to-construction .maha-bridge-feat-pill i {
    color: #C8952B;
}
.maha-cross-nav-section.theme-to-construction .maha-cross-nav-btn {
    background: linear-gradient(135deg, #161922 0%, #0B132B 100%);
    color: #FFFFFF;
    border: 1.5px solid #C8952B;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15), 0 2px 10px rgba(200, 149, 43, 0.25);
}
.maha-cross-nav-section.theme-to-construction .maha-cross-nav-btn:hover {
    background: linear-gradient(135deg, #C8952B 0%, #B38222 100%);
    color: #FFFFFF;
    border-color: #C8952B;
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(200, 149, 43, 0.42);
}

/* ─── Bridge Card General Layout ─── */
.maha-bridge-card {
    border-radius: 24px;
    padding: 38px 42px;
    display: grid;
    grid-template-columns: 1fr 1.08fr;
    gap: 40px;
    align-items: center;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* ─── Media Column ─── */
.maha-bridge-media-col {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    aspect-ratio: 16 / 11;
    width: 100%;
    background: #000;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}
.maha-bridge-media-col img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
}
.maha-bridge-card:hover .maha-bridge-media-col img {
    transform: scale(1.035);
}
.maha-bridge-media-badge {
    position: absolute;
    bottom: 14px;
    left: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    border-radius: 20px;
    background: rgba(5, 11, 20, 0.84);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(212, 175, 55, 0.35);
    color: #F0EBE0;
    font-family: var(--font-heading, 'Montserrat', sans-serif);
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

/* ─── Content Typography & Layout ─── */
.maha-bridge-content-col {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.maha-bridge-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 5px 14px;
    border-radius: 20px;
    font-family: var(--font-heading, 'Montserrat', sans-serif);
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    width: fit-content;
    margin-bottom: 14px;
}
.maha-bridge-kicker-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}

.maha-bridge-headings {
    margin-bottom: 14px;
}
.maha-bridge-pretitle {
    display: block;
    font-family: var(--font-heading, 'Montserrat', sans-serif);
    font-size: 0.88rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    margin-bottom: 4px;
}
.maha-bridge-title {
    font-family: var(--font-heading, 'Montserrat', sans-serif);
    font-size: clamp(1.45rem, 2.4vw, 2.05rem);
    font-weight: 800;
    letter-spacing: -0.015em;
    line-height: 1.22;
    margin: 0 0 10px;
}
.maha-bridge-brand-lockup {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 6px;
    margin-top: 8px;
    margin-bottom: 8px;
}
.maha-bridge-brand-name {
    font-family: var(--font-heading, 'Montserrat', sans-serif);
    font-size: clamp(1.65rem, 2.7vw, 2.35rem);
    font-weight: 900;
    letter-spacing: 0.06em;
    line-height: 1.15;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-transform: uppercase;
}
.maha-bridge-brand-tagline {
    font-family: var(--font-heading, 'Montserrat', sans-serif);
    font-size: 0.80rem;
    font-weight: 800;
    letter-spacing: 0.24em;
    text-transform: uppercase;
}

.maha-bridge-body {
    margin-bottom: 20px;
}
.maha-bridge-desc {
    font-family: var(--font-body, 'Inter', sans-serif);
    font-size: 0.94rem;
    line-height: 1.62;
    margin: 0 0 14px;
}

.maha-bridge-features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 6px;
}
.maha-bridge-feat-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 5px 12px;
    border-radius: 8px;
    font-family: var(--font-heading, 'Montserrat', sans-serif);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.02em;
}

/* ─── Button & Interactive Motion ─── */
.maha-bridge-cta-wrap {
    margin-top: 4px;
}
.maha-cross-nav-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 14px 28px;
    min-height: 48px;
    border-radius: 30px;
    font-family: var(--font-heading, 'Montserrat', sans-serif);
    font-size: 0.95rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    box-sizing: border-box;
}
.maha-cross-nav-btn .btn-arrow {
    display: inline-block;
    font-size: 1.18rem;
    line-height: 1;
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.maha-cross-nav-btn:hover .btn-arrow,
.maha-cross-nav-btn:focus .btn-arrow {
    transform: translateX(6px);
}
.maha-cross-nav-btn:focus-visible {
    outline: 2px solid #D4AF37;
    outline-offset: 4px;
}

/* ─── Responsive Adjustments (Tablet & Mobile) ─── */
@media (max-width: 991px) {
    .maha-bridge-card {
        grid-template-columns: 1fr 1fr;
        gap: 28px;
        padding: 30px;
    }
}

@media (max-width: 768px) {
    .maha-cross-nav-section {
        padding: 44px 0;
    }
    .maha-bridge-card {
        display: flex;
        flex-direction: column;
        padding: 24px 18px;
        gap: 0;
        border-radius: 18px;
    }
    /* display: contents allows content-col children to be re-ordered alongside media-col */
    .maha-bridge-content-col {
        display: contents;
    }
    /* Requested mobile order:
       1. Small section label
       2. Heading
       3. Image
       4. Description
       5. CTA
    */
    .maha-bridge-kicker {
        order: 1;
        margin-bottom: 10px;
    }
    .maha-bridge-headings {
        order: 2;
        margin-bottom: 14px;
    }
    .maha-bridge-media-col {
        order: 3;
        margin-bottom: 16px;
        aspect-ratio: 16 / 10;
        border-radius: 14px;
    }
    .maha-bridge-body {
        order: 4;
        margin-bottom: 18px;
    }
    .maha-bridge-features {
        gap: 6px;
    }
    .maha-bridge-feat-pill {
        font-size: 0.68rem;
        padding: 4px 10px;
    }
    .maha-bridge-cta-wrap {
        order: 5;
        width: 100%;
    }
    .maha-cross-nav-btn {
        width: 100%;
        min-height: 48px;
        font-size: 0.92rem;
        padding: 13px 20px;
    }
}
</style>
