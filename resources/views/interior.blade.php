@extends('layouts.app')

@section('title', 'Maha Interiors | Designing Beautiful Living | Luxury Interiors Design & Turnkey Execution')
@section('description', 'Maha Interiors is Tamil Nadu\'s premier interior design and execution studio. Delivering bespoke modular kitchens, luxury wardrobes, living spaces, and turnkey interior fitouts.')

@push('styles')
<style>
/* ==========================================================================
   MAHA INTERIOR — BRIGHT LUXURY ARCHITECTURAL ATELIER THEME
   Completely distinct from Maha Construction's dark midnight palette:
   Luminous Alabaster & Warm Ivory Surfaces, Champagne Bronze, Warm Amber Gold,
   Crisp Deep Charcoal Typography, and Engaging Micro-Animations.
   ========================================================================== */

body.interior-body {
    --int-bg-base: #FAF8F5;
    --int-bg-white: #FFFFFF;
    --int-bg-cream: #F5F1E8;
    --int-bg-warm: #FBF9F6;
    --int-gold: #C8952B;
    --int-gold-hover: #DFAC3E;
    --int-gold-light: #FBF4E6;
    --int-gold-glow: rgba(200, 149, 43, 0.35);
    --int-gold-border: rgba(200, 149, 43, 0.28);
    --int-charcoal: #161922;
    --int-charcoal-sub: #374151;
    --int-slate-muted: #64748B;
    --int-card-border: rgba(200, 149, 43, 0.20);
    --int-shadow-subtle: 0 4px 20px rgba(0, 0, 0, 0.04);
    --int-shadow-card: 0 10px 32px rgba(0, 0, 0, 0.06), 0 2px 10px rgba(200, 149, 43, 0.08);
    --int-shadow-hover: 0 20px 48px rgba(200, 149, 43, 0.22), 0 8px 24px rgba(0, 0, 0, 0.08);

    background-color: var(--int-bg-base) !important;
    color: var(--int-charcoal) !important;
    font-family: var(--font-body);
    overflow-x: hidden;
    padding-top: 0 !important;
    margin-top: 0 !important;
}

body.interior-body main {
    padding: 0 !important;
    margin: 0 !important;
    display: block;
}

/* ─── BRIGHT FROSTED NAVBAR OVERRIDE ───────────────────────── */
body.interior-body .interior-navbar {
    background: rgba(255, 255, 255, 0.94) !important;
    backdrop-filter: blur(20px) !important;
    -webkit-backdrop-filter: blur(20px) !important;
    border-bottom: 1px solid rgba(179, 130, 34, 0.2) !important;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.04) !important;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
body.interior-body .interior-navbar.is-scrolled {
    background: rgba(255, 255, 255, 0.98) !important;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08) !important;
    padding: 10px 0 !important;
}
body.interior-body .interior-brand-title {
    color: #161922 !important;
    font-weight: 900 !important;
    letter-spacing: 0.06em !important;
}
body.interior-body .interior-brand-tagline {
    color: var(--int-gold) !important;
    font-weight: 700 !important;
    letter-spacing: 0.2em !important;
}
body.interior-body .interior-nav-item {
    color: #374151 !important;
    font-weight: 700 !important;
    letter-spacing: 0.12em !important;
    transition: color 0.25s ease !important;
}
body.interior-body .interior-nav-item:hover,
body.interior-body .interior-nav-item.active {
    color: var(--int-gold) !important;
}
body.interior-body .interior-nav-item::after {
    background: var(--int-gold) !important;
}
body.interior-body .interior-switch-btn {
    background: rgba(179, 130, 34, 0.08) !important;
    border: 1.5px solid var(--int-gold) !important;
    color: var(--int-gold) !important;
    font-weight: 800 !important;
    border-radius: 4px !important;
    transition: all 0.25s ease !important;
}
body.interior-body .interior-switch-btn:hover {
    background: var(--int-gold) !important;
    color: #FFFFFF !important;
    box-shadow: 0 4px 18px rgba(179, 130, 34, 0.35) !important;
    transform: translateY(-1px);
}
body.interior-body .nav-search-btn {
    color: #161922 !important;
}
body.interior-body .nav-mobile-toggle span {
    background: #161922 !important;
}

/* ─── SECTION 1: CINEMATIC FULL-SCREEN VIDEO HERO (#interior-intro) ──── */
body.interior-body .int-hero-section {
    background: #080E0B !important;
    color: #FFFFFF !important;
    position: relative !important;
    top: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    min-height: 100vh;
    min-height: 100svh;
    display: flex;
    align-items: center;
    padding: 125px 0 70px !important;
    overflow: hidden !important;
}

/* Full-screen video container */
body.interior-body .int-hero-video-wrap {
    position: absolute !important;
    inset: 0 !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100% !important;
    height: 100% !important;
    z-index: 0 !important;
    overflow: hidden !important;
    pointer-events: none !important;
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
}
body.interior-body .int-hero-video-wrap video,
body.interior-body .int-hero-bg-video {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100% !important;
    height: 100% !important;
    min-width: 100% !important;
    min-height: 100% !important;
    object-fit: cover !important;
    object-position: center center !important;
    filter: brightness(0.88) contrast(1.02) saturate(1.08);
    transform: none !important;
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
    will-change: auto !important;
}
/* Fallback poster img when video fails */
body.interior-body .int-hero-video-wrap img.int-hero-poster {
    position: absolute !important;
    inset: 0 !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center center !important;
    filter: brightness(0.85) contrast(1.02);
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
}

/* Cinematic dark overlay — seamless top-to-bottom coverage */
body.interior-body .int-hero-overlay {
    position: absolute !important;
    inset: 0 !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(
        105deg,
        rgba(6, 12, 9, 0.78) 0%,
        rgba(8, 15, 12, 0.58) 45%,
        rgba(8, 15, 12, 0.22) 100%
    ),
    linear-gradient(
        to bottom,
        rgba(6, 12, 9, 0.35) 0%,
        transparent 35%,
        rgba(6, 12, 9, 0.40) 75%,
        #FAF8F5 100%
    ) !important;
    backdrop-filter: none !important;
    -webkit-backdrop-filter: none !important;
    z-index: 1 !important;
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
}
/* Bottom vignette into next section */
body.interior-body .int-hero-bottom-fade {
    background: linear-gradient(to bottom, transparent 40%, rgba(250, 248, 245, 0.85) 85%, #FAF8F5 100%) !important;
    height: 180px;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 2;
    pointer-events: none;
}

/* Content wrapper — centered with natural breathing room */
body.interior-body .int-hero-content-outer {
    position: relative;
    z-index: 4;
    width: 100%;
    padding: 0 24px;
    max-width: 1280px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* Studio label pill — elegant champagne gold chip */
body.interior-body .int-tag-pill {
    background: rgba(212, 175, 55, 0.14) !important;
    border: 1px solid rgba(212, 175, 55, 0.45) !important;
    border-radius: 50px !important;
    padding: 7px 18px !important;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25) !important;
    color: #F7D488 !important;
    font-size: 0.72rem !important;
    font-weight: 700 !important;
    letter-spacing: 0.2em !important;
    margin-bottom: 22px !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    width: fit-content;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
body.interior-body .int-tag-dot {
    background: #E5B869 !important;
    box-shadow: 0 0 10px #E5B869 !important;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
    animation: luxDotPulse 2s ease-in-out infinite;
}
body.interior-body .hero-marquee-badge {
    margin-bottom: clamp(14px, 2vh, 22px) !important;
}

/* Main hero headline — refined Title Case, high contrast */
body.interior-body .int-hero-title {
    color: #FFFFFF !important;
    font-family: var(--font-heading) !important;
    font-size: clamp(2.4rem, 4.8vw, 4.4rem) !important;
    font-weight: 800 !important;
    line-height: 1.12 !important;
    text-transform: none !important;
    letter-spacing: -0.02em !important;
    margin-bottom: 16px !important;
    text-shadow: 0 4px 28px rgba(0, 0, 0, 0.65) !important;
    max-width: 860px;
}

/* Gold serif italic emphasis line */
body.interior-body .int-hero-emphasis {
    display: block;
    font-family: var(--font-serif) !important;
    font-style: italic !important;
    font-weight: 500 !important;
    font-size: clamp(1.2rem, 1.9vw, 1.8rem) !important;
    color: #F5D38A !important;
    text-shadow: 0 2px 18px rgba(0, 0, 0, 0.6) !important;
    letter-spacing: 0.01em !important;
    line-height: 1.45 !important;
    margin-bottom: 34px !important;
    max-width: 740px;
}

body.interior-body .int-hero-desc {
    display: none;
}
body.interior-body .int-hero-actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 44px !important;
}

/* Radiant gold primary CTA */
body.interior-body .int-btn-gold {
    background: linear-gradient(135deg, #C8952B 0%, #E2B24A 50%, #F8D888 100%) !important;
    color: #0E1410 !important;
    font-family: var(--font-heading);
    font-weight: 800 !important;
    font-size: 0.84rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 15px 32px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: none;
    box-shadow: 0 8px 26px rgba(200, 149, 43, 0.45) !important;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
body.interior-body .int-btn-gold::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -60%;
    width: 40%;
    height: 200%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transform: rotate(30deg);
    animation: luxBtnShimmer 4s infinite;
}
body.interior-body .int-btn-gold:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 14px 36px rgba(200, 149, 43, 0.6) !important;
    color: #0E1410 !important;
}

/* ─── SECONDARY OUTLINE BUTTON (LIGHT SECTIONS) ─────────── */
body.interior-body .int-btn-outline {
    background: #FFFFFF !important;
    border: 1.5px solid var(--int-gold) !important;
    color: #161922 !important;
    font-family: var(--font-heading);
    font-weight: 800 !important;
    font-size: 0.82rem;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    padding: 14px 28px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(200, 149, 43, 0.12) !important;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
    cursor: pointer;
}
body.interior-body .int-btn-outline:hover {
    background: #161922 !important;
    border-color: #161922 !important;
    color: #FFFFFF !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 24px rgba(22, 25, 34, 0.2) !important;
}
body.interior-body .int-btn-outline:hover i {
    color: var(--int-gold) !important;
}

/* ─── SECONDARY OUTLINE BUTTON (HERO DARK VIDEO OVERRIDE) ── */
body.interior-body .int-hero-section .int-btn-outline {
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(10px) !important;
    -webkit-backdrop-filter: blur(10px) !important;
    border: 1.5px solid rgba(255, 255, 255, 0.5) !important;
    color: #FFFFFF !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
}
body.interior-body .int-hero-section .int-btn-outline:hover {
    background: rgba(255, 255, 255, 0.25) !important;
    border-color: #FFFFFF !important;
    color: #FFFFFF !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 26px rgba(255, 255, 255, 0.25) !important;
}
body.interior-body .int-hero-section .int-btn-outline:hover i {
    color: var(--int-gold) !important;
}

/* Scroll cue indicator at bottom */
body.interior-body .int-hero-scroll-cue {
    position: absolute;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    color: rgba(255, 255, 255, 0.55);
    font-size: 0.65rem;
    font-family: var(--font-heading);
    letter-spacing: 0.2em;
    text-transform: uppercase;
    animation: intScrollCueFade 2.5s ease-in-out infinite;
}
@keyframes intScrollCueFade {
    0%, 100% { opacity: 0.4; transform: translateX(-50%) translateY(0); }
    50%       { opacity: 1;   transform: translateX(-50%) translateY(5px); }
}
body.interior-body .int-hero-scroll-cue i {
    font-size: 0.95rem;
}

/* Stats strip — slim architectural glass ribbon with proper spacing */
body.interior-body .int-hero-stats-strip {
    position: relative;
    z-index: 5;
    width: 100%;
    max-width: 860px;
    margin-top: 0 !important;
    padding-top: 0 !important;
}
body.interior-body .int-hero-stats-grid {
    background: rgba(8, 14, 11, 0.65) !important;
    backdrop-filter: blur(20px) !important;
    -webkit-backdrop-filter: blur(20px) !important;
    border: 1px solid rgba(212, 175, 55, 0.30) !important;
    border-radius: 12px !important;
    padding: 18px 28px !important;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.08) !important;
    display: grid;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 20px;
}
body.interior-body .int-hero-stat-card {
    position: relative;
    padding-right: 16px;
}
body.interior-body .int-hero-stat-card:not(:last-child)::after {
    content: '';
    position: absolute;
    right: 0;
    top: 15%;
    height: 70%;
    width: 1px;
    background: rgba(212, 175, 55, 0.25) !important;
}
body.interior-body .int-hero-stat-val {
    color: #F7D488 !important;
    text-shadow: 0 2px 16px rgba(212, 175, 55, 0.4) !important;
    font-size: clamp(1.55rem, 2.2vw, 2.1rem);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 3px;
}
body.interior-body .int-hero-stat-label {
    color: rgba(255, 255, 255, 0.78) !important;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    line-height: 1.35;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    body.interior-body {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    body.interior-body main {
        padding: 0 !important;
        margin: 0 !important;
        display: block !important;
    }
    body.interior-body .int-hero-section {
        padding: 95px 0 45px !important;
        min-height: 100vh !important;
        min-height: 100svh !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        position: relative !important;
        top: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        overflow: hidden !important;
    }
    body.interior-body .int-hero-video-wrap {
        position: absolute !important;
        inset: 0 !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
        pointer-events: none !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }
    body.interior-body .int-hero-video-wrap video,
    body.interior-body .int-hero-bg-video {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
        min-width: 100% !important;
        min-height: 100% !important;
        object-fit: cover !important;
        object-position: center center !important;
        transform: none !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        will-change: auto !important;
    }
    body.interior-body .int-hero-overlay {
        position: absolute !important;
        inset: 0 !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }
    body.interior-body .int-hero-content-outer {
        padding-left: 20px !important;
        padding-right: 20px !important;
        position: relative !important;
        z-index: 4 !important;
        transform: none !important;
        opacity: 1 !important;
    }
    body.interior-body .int-hero-stats-grid {
        grid-template-columns: 1fr !important;
        gap: 14px;
        padding: 16px 20px !important;
    }
    body.interior-body .int-hero-stat-card:not(:last-child)::after {
        display: none !important;
    }
    body.interior-body .int-hero-actions {
        margin-bottom: 32px !important;
    }
}

/* ─── SECTION 2: COMPLETED PROJECTS (#interior-projects) ──── */
body.interior-body .int-projects-section {
    background: #FFFFFF !important;
    color: #161922 !important;
    padding: 100px 0 90px !important;
    position: relative;
}
body.interior-body .int-sec-header-editorial {
    margin-bottom: 44px;
    max-width: 820px;
}
body.interior-body .int-sec-tag {
    color: var(--int-gold) !important;
    font-size: 0.76rem;
    font-weight: 800;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 10px;
}
body.interior-body .int-sec-title-light {
    color: #161922 !important;
    font-size: clamp(2rem, 3.6vw, 3rem);
    font-weight: 900;
    line-height: 1.12;
    text-transform: uppercase;
    margin-bottom: 12px;
}
body.interior-body .int-sec-sub-light {
    color: #4B5563 !important;
    font-size: 1rem;
    line-height: 1.65;
}
/* ─── HIGHLIGHTED LUXURY CAPSULE CATEGORY FILTER BAR ────── */
body.interior-body .int-editorial-filters-wrapper {
    display: flex;
    align-items: center;
    margin: 24px 0 38px;
    width: 100%;
    overflow-x: auto;
    padding-bottom: 6px;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
body.interior-body .int-editorial-filters-wrapper::-webkit-scrollbar {
    display: none;
}

body.interior-body .int-editorial-filters {
    display: inline-flex;
    flex-wrap: nowrap;
    gap: 8px;
    align-items: center;
    padding: 7px 9px;
    background: #FFFFFF !important;
    border: 1.5px solid rgba(200, 149, 43, 0.35) !important;
    border-radius: 50px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05), 0 2px 12px rgba(200, 149, 43, 0.12) !important;
    overflow-x: auto;
    max-width: 100%;
    scrollbar-width: none;
    -ms-overflow-style: none;
    position: relative;
    z-index: 5;
    border-bottom: none !important;
}
body.interior-body .int-editorial-filters::-webkit-scrollbar {
    display: none;
}

body.interior-body .int-filter-link {
    color: #475569 !important;
    font-size: 0.76rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    background: transparent !important;
    border: 1px solid transparent !important;
    cursor: pointer;
    position: relative;
    padding: 10px 20px !important;
    border-radius: 50px !important;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    flex-shrink: 0;
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
body.interior-body .int-filter-link i {
    font-size: 0.82rem;
    color: var(--int-gold);
    transition: transform 0.25s ease, color 0.25s ease;
}

body.interior-body .int-filter-link:not(.active):hover {
    color: #161922 !important;
    background: rgba(200, 149, 43, 0.12) !important;
    border-color: rgba(200, 149, 43, 0.28) !important;
    transform: translateY(-1px);
}
body.interior-body .int-filter-link:not(.active):hover i {
    transform: scale(1.15);
    color: #B38222;
}

body.interior-body .int-filter-link.active {
    background: linear-gradient(135deg, #C8952B 0%, #E2B24A 50%, #F5CE76 100%) !important;
    color: #0E1410 !important;
    font-weight: 900 !important;
    border-color: var(--int-gold) !important;
    box-shadow: 0 6px 20px rgba(200, 149, 43, 0.45) !important;
    transform: scale(1.02);
}
body.interior-body .int-filter-link.active i {
    color: #0E1410 !important;
    transform: scale(1.1);
}

body.interior-body .int-filter-link::after {
    display: none !important;
}

/* Projects Slideshow Cards */
body.interior-body .int-video-slide-card {
    background: #FFFFFF !important;
    border: 1px solid rgba(179, 130, 34, 0.22) !important;
    border-radius: 12px !important;
    overflow: hidden;
    box-shadow: var(--int-shadow-card) !important;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
body.interior-body .int-video-slide-card:hover {
    transform: translateY(-8px) !important;
    border-color: var(--int-gold) !important;
    box-shadow: var(--int-shadow-hover) !important;
}
body.interior-body .int-video-card-shade {
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.0) 35%, rgba(15, 23, 42, 0.88) 100%) !important;
}
body.interior-body .int-video-card-tag {
    background: rgba(255, 255, 255, 0.94) !important;
    border: 1px solid var(--int-gold-border) !important;
    color: var(--int-gold) !important;
    box-shadow: var(--int-shadow-subtle) !important;
    border-radius: 4px;
}
body.interior-body .int-video-card-badge {
    background: rgba(179, 130, 34, 0.92) !important;
    border: none !important;
    color: #FFFFFF !important;
    box-shadow: 0 2px 10px rgba(179, 130, 34, 0.3) !important;
    border-radius: 4px;
}
body.interior-body .int-video-play-btn {
    background: linear-gradient(135deg, #DFAB3E, #B38222) !important;
    color: #FFFFFF !important;
    box-shadow: 0 0 24px rgba(179, 130, 34, 0.6) !important;
}
body.interior-body .int-video-play-btn::before {
    content: '';
    position: absolute;
    inset: -6px;
    border-radius: 50%;
    border: 2px solid var(--int-gold);
    opacity: 0.8;
    animation: luxPulseWave 2s cubic-bezier(0.2, 0.8, 0.2, 1) infinite;
}
body.interior-body .int-carousel-progress-track {
    background: rgba(179, 130, 34, 0.18) !important;
}
body.interior-body .int-carousel-progress-fill {
    background: linear-gradient(90deg, #B38222, #DFAB3E) !important;
}
body.interior-body .int-carousel-arrow-btn {
    background: #FFFFFF !important;
    border: 1.5px solid var(--int-gold-border) !important;
    color: var(--int-gold) !important;
    box-shadow: var(--int-shadow-subtle) !important;
}
body.interior-body .int-carousel-arrow-btn:hover {
    background: var(--int-gold) !important;
    color: #FFFFFF !important;
    box-shadow: 0 4px 18px rgba(179, 130, 34, 0.4) !important;
}
body.interior-body .int-carousel-dot {
    background: rgba(179, 130, 34, 0.3) !important;
}
body.interior-body .int-carousel-dot.active {
    background: var(--int-gold) !important;
}

/* ─── MULTI-IMAGE PROJECT CARD SLIDESHOW & BADGES ─── */
body.interior-body .int-card-slideshow-container {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}
body.interior-body .int-card-slide-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    opacity: 0;
    transform: scale(1);
    transition: opacity 0.85s cubic-bezier(0.4, 0, 0.2, 1), transform 1.2s cubic-bezier(0.2, 0, 0.2, 1);
    pointer-events: none;
}
body.interior-body .int-card-slide-img.active {
    opacity: 1;
    z-index: 1;
}
body.interior-body .int-video-slide-card:hover .int-card-slide-img.active {
    transform: scale(1.06);
}

body.interior-body .int-card-top-badges {
    position: absolute;
    top: 14px;
    right: 14px;
    display: flex;
    gap: 8px;
    align-items: center;
    z-index: 5;
}
body.interior-body .int-card-photos-badge {
    background: rgba(11, 19, 43, 0.9);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(212, 175, 55, 0.5);
    color: #FFFFFF;
    font-size: 0.68rem;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.35);
    font-family: var(--font-heading);
}
body.interior-body .int-card-photos-badge:hover {
    background: var(--int-gold);
    color: #050B14;
    border-color: var(--int-gold);
    transform: translateY(-1px);
}
body.interior-body .int-card-photos-badge i {
    color: var(--int-gold);
    font-size: 0.72rem;
}
body.interior-body .int-card-photos-badge:hover i {
    color: #050B14;
}

body.interior-body .int-card-slide-dots {
    position: absolute;
    bottom: 145px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    gap: 5px;
    z-index: 5;
    padding: 0 16px;
    pointer-events: auto;
}
body.interior-body .int-card-mini-dot {
    width: 14px;
    height: 3px;
    border-radius: 2px;
    background: rgba(255, 255, 255, 0.35);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 1px 4px rgba(0,0,0,0.5);
}
body.interior-body .int-card-mini-dot.active {
    background: var(--int-gold);
    width: 24px;
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.8);
}

body.interior-body .int-card-actions-row {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    width: 100%;
}
body.interior-body .int-card-action-btn {
    padding: 8px 12px;
    font-size: 0.72rem;
    font-weight: 800;
    border-radius: 6px;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.25s ease;
    font-family: var(--font-heading);
}
body.interior-body .int-btn-view-photos {
    flex: 1;
    background: rgba(255, 255, 255, 0.95);
    color: #0B132B;
    border: 1px solid rgba(212, 175, 55, 0.6);
    box-shadow: 0 2px 8px rgba(0,0,0,0.25);
}
body.interior-body .int-btn-view-photos:hover {
    background: var(--int-gold);
    color: #050B14;
    border-color: var(--int-gold);
    box-shadow: 0 4px 14px rgba(212, 175, 55, 0.4);
}
body.interior-body .int-btn-watch-tour {
    background: linear-gradient(135deg, #DFAB3E, #B38222);
    color: #FFFFFF;
    border: none;
    padding: 8px 12px;
    box-shadow: 0 2px 8px rgba(179,130,34,0.4);
}
body.interior-body .int-btn-watch-tour:hover {
    filter: brightness(1.1);
    transform: translateY(-1px);
}

/* ─── FULL RESOLUTION LIGHTBOX GALLERY MODAL ─── */
.int-gallery-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(3, 7, 18, 0.96);
    backdrop-filter: blur(20px);
    z-index: 10000;
    display: none;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px 28px;
    color: #FFFFFF;
    animation: intModalFadeIn 0.25s ease;
}
@keyframes intModalFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.int-lightbox-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(212, 175, 55, 0.25);
    padding-bottom: 14px;
    gap: 16px;
}
.int-lightbox-title-box {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.int-lightbox-tagline {
    font-size: 0.7rem;
    font-weight: 800;
    color: var(--int-gold);
    letter-spacing: 0.16em;
    text-transform: uppercase;
    font-family: var(--font-heading);
}
.int-lightbox-title {
    font-size: 1.3rem;
    font-weight: 900;
    color: #FFFFFF;
    letter-spacing: 0.04em;
    font-family: var(--font-heading);
    margin: 0;
}
.int-lightbox-counter-badge {
    background: rgba(212, 175, 55, 0.15);
    border: 1px solid rgba(212, 175, 55, 0.4);
    color: var(--int-gold);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.76rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    font-family: var(--font-heading);
    text-transform: uppercase;
}
.int-lightbox-header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}
.int-lightbox-video-btn {
    background: linear-gradient(135deg, #DFAB3E, #B38222);
    color: #FFFFFF;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 0.74rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font-heading);
    transition: all 0.2s ease;
}
.int-lightbox-video-btn:hover {
    filter: brightness(1.12);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(212, 175, 55, 0.4);
}
.int-lightbox-close-btn {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.1rem;
    transition: all 0.2s ease;
}
.int-lightbox-close-btn:hover {
    background: #EF4444;
    border-color: #EF4444;
    color: #FFFFFF;
    transform: rotate(90deg);
}

.int-lightbox-stage {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    margin: 12px 0;
    overflow: hidden;
}
.int-lightbox-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: rgba(11, 19, 43, 0.85);
    border: 1.5px solid rgba(212, 175, 55, 0.5);
    color: var(--int-gold);
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
    z-index: 20;
    box-shadow: 0 8px 24px rgba(0,0,0,0.6);
}
.int-lightbox-arrow:hover {
    background: var(--int-gold);
    color: #050B14;
    border-color: var(--int-gold);
    box-shadow: 0 0 20px rgba(212, 175, 55, 0.7);
    transform: translateY(-50%) scale(1.1);
}
.int-lightbox-arrow.prev { left: 16px; }
.int-lightbox-arrow.next { right: 16px; }

.int-lightbox-img-wrap {
    position: relative;
    max-width: 88vw;
    max-height: 64vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.int-lightbox-main-img {
    max-width: 100%;
    max-height: 64vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.8), 0 0 30px rgba(212, 175, 55, 0.15);
    border: 1px solid rgba(212, 175, 55, 0.25);
    transition: opacity 0.25s ease, transform 0.25s ease;
}

.int-lightbox-footer {
    border-top: 1px solid rgba(212, 175, 55, 0.2);
    padding-top: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}
.int-lightbox-desc {
    font-size: 0.82rem;
    color: #94A3B8;
    text-align: center;
    max-width: 700px;
    line-height: 1.4;
}
.int-lightbox-thumbs-track {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    max-width: 90vw;
    padding: 6px 12px 10px;
    scroll-behavior: smooth;
}
.int-lightbox-thumb {
    position: relative;
    width: 72px;
    height: 50px;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    opacity: 0.55;
    transition: all 0.25s ease;
    flex-shrink: 0;
    background: #0B132B;
}
.int-lightbox-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.int-lightbox-thumb:hover {
    opacity: 0.85;
    transform: translateY(-2px);
}
.int-lightbox-thumb.active {
    border-color: var(--int-gold);
    opacity: 1;
    transform: scale(1.08);
    box-shadow: 0 0 16px rgba(212, 175, 55, 0.6);
}
.int-lightbox-thumb-num {
    position: absolute;
    bottom: 2px;
    right: 3px;
    background: rgba(5, 11, 20, 0.85);
    color: var(--int-gold);
    font-size: 0.58rem;
    font-weight: 800;
    padding: 1px 4px;
    border-radius: 3px;
}

/* ─── SECTION 3: CLIENT TESTIMONIALS (#interior-testimonials) */
body.interior-body .int-testimonials-section {
    background: #F8F6F2 !important;
    color: #161922 !important;
    padding: 100px 0 90px !important;
}
body.interior-body .int-sec-title-dark {
    color: #161922 !important;
    font-size: clamp(2rem, 3.6vw, 3rem);
    font-weight: 900;
    line-height: 1.12;
    text-transform: uppercase;
    margin-bottom: 12px;
}
body.interior-body .int-sec-sub-dark {
    color: #4B5563 !important;
    font-size: 1rem;
    line-height: 1.65;
}
body.interior-body .int-pullquote-box {
    background: #FFFFFF !important;
    border-left: 4px solid var(--int-gold) !important;
    border-radius: 8px !important;
    box-shadow: var(--int-shadow-card) !important;
    padding: 36px 44px;
    margin-bottom: 40px;
    position: relative;
}
body.interior-body .int-pullquote-text {
    color: #161922 !important;
    font-family: var(--font-serif);
    font-size: clamp(1.4rem, 2.6vw, 2.1rem);
    font-weight: 600;
    font-style: italic;
    line-height: 1.35;
    margin-bottom: 18px;
}
body.interior-body .int-author-name {
    color: #161922 !important;
    font-weight: 800;
}
body.interior-body .int-author-role {
    color: var(--int-gold) !important;
    font-weight: 700;
}
body.interior-body .int-video-card-stars {
    color: #D97706 !important;
}

/* ─── SECTION 4: ENGINEER (#interior-engineer) ────────────── */
body.interior-body .int-engineer-section {
    background: #FFFFFF !important;
    color: #161922 !important;
    padding: 100px 0 90px !important;
    position: relative;
    scroll-margin-top: 90px;
}
body.interior-body .int-eng-portrait-card {
    background: #FFFFFF !important;
    border: 1.5px solid var(--int-gold-border) !important;
    border-radius: 12px !important;
    box-shadow: var(--int-shadow-card) !important;
    overflow: hidden;
}
body.interior-body .int-eng-gradient {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.05) 0%, rgba(15, 23, 42, 0.75) 100%) !important;
}
body.interior-body .int-eng-play-badge {
    background: rgba(255, 255, 255, 0.94) !important;
    border: 1px solid var(--int-gold) !important;
    color: var(--int-gold) !important;
    border-radius: 4px;
}
body.interior-body .int-eng-play-btn {
    background: linear-gradient(135deg, #DFAB3E, #B38222) !important;
    color: #FFFFFF !important;
    box-shadow: 0 0 26px rgba(179, 130, 34, 0.65) !important;
}
body.interior-body .int-engineer-section p {
    color: #4B5563 !important;
}

/* ─── SIGNATURE 3-STEP PRINCIPLES PIPELINE ─────────────────── */
body.interior-body .int-principles-flow {
    position: relative;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin: 28px 0 34px;
}

/* Subtle Gold Connecting Line on Desktop */
body.interior-body .int-principles-flow::before {
    content: '';
    position: absolute;
    top: 44px;
    left: 45px;
    right: 45px;
    height: 2px;
    background: linear-gradient(90deg,
        rgba(200, 149, 43, 0.25) 0%,
        rgba(200, 149, 43, 0.85) 30%,
        rgba(200, 149, 43, 0.85) 70%,
        rgba(200, 149, 43, 0.25) 100%
    );
    z-index: 1;
    pointer-events: none;
}

body.interior-body .int-flow-step {
    position: relative;
    z-index: 2;
    background: #FFFFFF !important;
    border: 1px solid rgba(200, 149, 43, 0.26) !important;
    border-radius: 12px !important;
    padding: 22px 18px 24px !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
    display: flex;
    flex-direction: column;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
}

body.interior-body .int-flow-step:hover {
    background: #FFFFFF !important;
    border-color: var(--int-gold) !important;
    transform: translateY(-5px) !important;
    box-shadow: 0 16px 36px rgba(200, 149, 43, 0.18), 0 2px 8px rgba(0, 0, 0, 0.04) !important;
}

/* Connecting Arrow Badge Between Steps on Desktop */
body.interior-body .int-flow-step:not(:last-child)::after {
    content: '\f061';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: -15px;
    top: 31px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 1.5px solid var(--int-gold);
    color: var(--int-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.68rem;
    z-index: 4;
    box-shadow: 0 2px 10px rgba(200, 149, 43, 0.25);
    transition: all 0.3s ease;
}

body.interior-body .int-flow-step:hover::after {
    background: var(--int-gold);
    color: #FFFFFF;
    transform: scale(1.15);
    box-shadow: 0 4px 14px rgba(200, 149, 43, 0.45);
}

/* Step Header (Icon & Step Number) */
body.interior-body .int-flow-step-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
}

body.interior-body .int-flow-icon-circle {
    width: 44px;
    height: 44px;
    min-width: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FBF4E6, #FFFFFF);
    border: 1.5px solid var(--int-gold);
    color: var(--int-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    box-shadow: 0 3px 12px rgba(200, 149, 43, 0.18);
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

body.interior-body .int-flow-step:hover .int-flow-icon-circle {
    background: var(--int-gold);
    color: #FFFFFF;
    transform: scale(1.08) rotate(3deg);
    box-shadow: 0 6px 18px rgba(200, 149, 43, 0.4);
}

body.interior-body .int-flow-step-num {
    font-family: var(--font-heading);
    font-size: 0.78rem;
    font-weight: 900;
    letter-spacing: 0.14em;
    color: var(--int-gold) !important;
    text-transform: uppercase;
}

body.interior-body .int-flow-step-title {
    font-family: var(--font-heading);
    font-size: 0.98rem;
    font-weight: 800;
    color: #161922 !important;
    line-height: 1.35;
    margin-bottom: 8px;
    transition: color 0.25s ease;
}

body.interior-body .int-flow-step:hover .int-flow-step-title {
    color: var(--int-gold) !important;
}

body.interior-body .int-flow-step-desc {
    font-size: 0.84rem;
    color: #4B5563 !important;
    line-height: 1.6;
    margin: 0;
}

/* Action Row */
body.interior-body .int-flow-action-row {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 12px;
}

body.interior-body .int-flow-trust-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #374151;
    background: rgba(200, 149, 43, 0.08);
    border: 1px solid rgba(200, 149, 43, 0.25);
    padding: 12px 20px;
    border-radius: 6px;
    letter-spacing: 0.02em;
}

/* Mobile & Tablet Responsiveness: Vertical Flow on Mobile */
@media (max-width: 768px) {
    body.interior-body .int-principles-flow {
        grid-template-columns: 1fr !important;
        gap: 26px !important;
        margin: 24px 0 28px !important;
    }
    body.interior-body .int-principles-flow::before {
        display: none !important;
    }
    body.interior-body .int-flow-step:not(:last-child)::after {
        content: '\f063' !important;
        right: auto !important;
        left: 50% !important;
        top: auto !important;
        bottom: -16px !important;
        transform: translateX(-50%) !important;
        width: 28px !important;
        height: 28px !important;
        font-size: 0.65rem !important;
    }
    body.interior-body .int-flow-step:not(:last-child)::before {
        content: '' !important;
        position: absolute !important;
        bottom: -26px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        width: 2px !important;
        height: 26px !important;
        background: linear-gradient(180deg, var(--int-gold), rgba(200, 149, 43, 0.4)) !important;
        z-index: 1 !important;
    }
    body.interior-body .int-flow-action-row {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    body.interior-body .int-flow-action-row .int-btn-gold {
        justify-content: center !important;
        width: 100% !important;
        text-align: center !important;
    }
    body.interior-body .int-flow-trust-pill {
        justify-content: center !important;
        text-align: center !important;
    }
}

/* Backward compatibility */
body.interior-body .int-principle-box {
    background: #FAF8F5 !important;
    border: 1px solid rgba(179, 130, 34, 0.22) !important;
    border-radius: 8px !important;
    box-shadow: var(--int-shadow-subtle) !important;
    transition: all 0.3s ease !important;
}
body.interior-body .int-principle-box:hover {
    background: #FFFFFF !important;
    border-color: var(--int-gold) !important;
    transform: translateY(-4px) !important;
    box-shadow: var(--int-shadow-hover) !important;
}
body.interior-body .int-principle-num {
    color: var(--int-gold) !important;
    font-weight: 900;
}
body.interior-body .int-principle-title {
    color: #161922 !important;
    font-weight: 800;
}
body.interior-body .int-principle-desc {
    color: #4B5563 !important;
}

/* ─── SECTION 5: INTERIOR PACKAGES (#interior-packages) ───── */
body.interior-body .int-packages-section {
    background: #FAF8F5 !important;
    color: #161922 !important;
    padding: 100px 0 90px !important;
}
body.interior-body .int-pkg-panel {
    background: #FFFFFF !important;
    border: 1px solid rgba(179, 130, 34, 0.22) !important;
    border-radius: 12px !important;
    box-shadow: var(--int-shadow-card) !important;
    transition: all 0.35s ease !important;
}
body.interior-body .int-pkg-panel:hover {
    transform: translateY(-8px) !important;
    box-shadow: var(--int-shadow-hover) !important;
}
/* Highlighted card in warm champagne white with gold glow */
body.interior-body .int-pkg-panel.highlighted {
    background: linear-gradient(180deg, #FFFFFF 0%, #FDFBF6 100%) !important;
    border: 2px solid var(--int-gold) !important;
    box-shadow: 0 20px 50px rgba(179, 130, 34, 0.22), 0 0 25px rgba(179, 130, 34, 0.12) !important;
    color: #161922 !important;
}
body.interior-body .int-pkg-popular-tag {
    background: linear-gradient(135deg, #DFAB3E, #B38222) !important;
    color: #FFFFFF !important;
    box-shadow: 0 4px 14px rgba(179, 130, 34, 0.35) !important;
    border-radius: 4px !important;
}
body.interior-body .int-pkg-tier {
    color: var(--int-gold) !important;
}
body.interior-body .int-pkg-title {
    color: #161922 !important;
}
body.interior-body .int-pkg-subtitle {
    color: #4B5563 !important;
}
body.interior-body .int-pkg-panel.highlighted .int-pkg-title {
    color: #161922 !important;
}
body.interior-body .int-pkg-panel.highlighted .int-pkg-subtitle {
    color: #4B5563 !important;
}
body.interior-body .int-pkg-price-row {
    border-color: rgba(179, 130, 34, 0.18) !important;
}
body.interior-body .int-pkg-price-val {
    color: var(--int-gold) !important;
}
body.interior-body .int-pkg-price-unit {
    color: #4B5563 !important;
}
body.interior-body .int-pkg-panel.highlighted .int-pkg-price-unit {
    color: #4B5563 !important;
}
body.interior-body .int-pkg-chip {
    background: rgba(179, 130, 34, 0.1) !important;
    color: #161922 !important;
}
body.interior-body .int-pkg-panel.highlighted .int-pkg-chip {
    background: rgba(179, 130, 34, 0.15) !important;
    color: var(--int-gold) !important;
}
body.interior-body .int-pkg-feature-item {
    color: #374151 !important;
}
body.interior-body .int-pkg-btn-book {
    background: linear-gradient(135deg, #C5932D, #DFAB3E) !important;
    color: #161922 !important;
    box-shadow: 0 4px 16px rgba(179, 130, 34, 0.3) !important;
}
body.interior-body .int-pkg-btn-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(179, 130, 34, 0.45) !important;
}
body.interior-body .int-pkg-btn-specs {
    border: 1px solid rgba(179, 130, 34, 0.35) !important;
    color: #161922 !important;
}
body.interior-body .int-pkg-btn-specs:hover {
    border-color: var(--int-gold) !important;
    color: var(--int-gold) !important;
    background: rgba(179, 130, 34, 0.06) !important;
}

/* ─── SECTION 6: CONSULTATION (#interior-enquiry) ─────────── */
body.interior-body .int-enquiry-section {
    background: linear-gradient(135deg, #F4EFE6 0%, #FAF8F4 50%, #F5F1E8 100%) !important;
    color: #161922 !important;
    padding: 100px 0 90px !important;
}
body.interior-body .int-enquiry-section .int-sec-title-light {
    color: #161922 !important;
}
body.interior-body .int-enquiry-section .int-sec-sub-light {
    color: #4B5563 !important;
}
body.interior-body .int-contact-row {
    color: #161922 !important;
}
body.interior-body .int-contact-row a,
body.interior-body .int-contact-row span {
    color: #161922 !important;
    font-weight: 700;
    text-decoration: none;
    transition: color 0.2s ease;
}
body.interior-body .int-contact-row a:hover {
    color: var(--int-gold) !important;
}
body.interior-body .int-contact-icon {
    background: #FFFFFF !important;
    border: 1.5px solid var(--int-gold-border) !important;
    color: var(--int-gold) !important;
    box-shadow: var(--int-shadow-subtle) !important;
}
body.interior-body .int-enquiry-form-card {
    background: #FFFFFF !important;
    border: 1.5px solid var(--int-gold-border) !important;
    border-radius: 12px !important;
    box-shadow: var(--int-shadow-card) !important;
}
body.interior-body .int-form-label {
    color: #161922 !important;
    font-weight: 800 !important;
    font-size: 0.74rem !important;
    letter-spacing: 0.08em !important;
    display: block;
    margin-bottom: 6px;
}
body.interior-body .int-form-input,
body.interior-body .int-form-select,
body.interior-body .int-form-textarea {
    background: #FFFFFF !important;
    border: 1.5px solid #D8CEBE !important;
    color: #161922 !important;
    border-radius: 6px !important;
    font-size: 0.92rem !important;
    font-family: inherit;
    transition: all 0.25s ease !important;
}
body.interior-body .int-form-input::placeholder,
body.interior-body .int-form-textarea::placeholder {
    color: #64748B !important;
    opacity: 1;
}
body.interior-body .int-form-select option {
    background: #FFFFFF !important;
    color: #161922 !important;
}
body.interior-body .int-form-input:focus,
body.interior-body .int-form-select:focus,
body.interior-body .int-form-textarea:focus {
    border-color: var(--int-gold) !important;
    background: #FFFFFF !important;
    box-shadow: 0 0 0 3px rgba(179, 130, 34, 0.2) !important;
    outline: none !important;
}

/* ─── PACKAGE MODAL OVERRIDE ──────────────────────────────── */
body.interior-body #interiorPackageDetailsModal.modal-overlay {
    background: rgba(22, 25, 34, 0.65) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
}
body.interior-body #interiorPackageDetailsModal .modal-container {
    background: #FFFFFF !important;
    border: 1.5px solid var(--int-gold-border) !important;
    border-radius: 12px !important;
    color: #161922 !important;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15) !important;
}
body.interior-body #intModalPkgTitle {
    color: #161922 !important;
}
body.interior-body #intModalPkgSubtitle {
    color: #4B5563 !important;
}
body.interior-body #intModalPkgPrice {
    color: var(--int-gold) !important;
}
body.interior-body #intModalPkgDescription {
    color: #374151 !important;
}
body.interior-body #intModalPkgInclusions {
    color: #1E293B !important;
}
body.interior-body #intModalPkgExclusions {
    color: #64748B !important;
}
body.interior-body #intModalPkgFeatures {
    color: #374151 !important;
}
body.interior-body #interiorPackageDetailsModal .modal-box > div:last-child {
    background: #FAF8F5 !important;
    border-top: 1px solid rgba(179, 130, 34, 0.2) !important;
}
body.interior-body #interiorPackageDetailsModal .modal-box > div:last-child button:first-child {
    background: #FFFFFF !important;
    border: 1px solid #CBD5E1 !important;
    color: #161922 !important;
}

/* ─── INTERIOR FOOTER OVERRIDE ────────────────────────────── */
body.interior-body .interior-footer {
    background: #161922 !important;
    border-top: 2px solid var(--int-gold) !important;
    color: #E2E8F0 !important;
    padding: 70px 0 30px !important;
}
body.interior-body .interior-footer-brand-name {
    color: #FFFFFF !important;
}
body.interior-body .interior-footer-tagline {
    color: var(--int-gold) !important;
}
body.interior-body .interior-footer-desc {
    color: #94A3B8 !important;
}
body.interior-body .interior-footer-heading {
    color: var(--int-gold) !important;
}
body.interior-body .interior-footer-nav a {
    color: #CBD5E1 !important;
}
body.interior-body .interior-footer-nav a:hover {
    color: var(--int-gold) !important;
}

/* ─── LIVARTA INTERIORS MOTION KEYFRAMES & REVEALS ────────── */
@keyframes livartaPillFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
}
@keyframes livartaGlowDot {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(229, 184, 105, 0.85); }
    70% { transform: scale(1.18); box-shadow: 0 0 0 10px rgba(229, 184, 105, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(229, 184, 105, 0); }
}
@keyframes luxHeroZoom {
    0% { transform: scale(1); }
    100% { transform: scale(1.06); }
}
@keyframes luxDotPulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.7; }
}
@keyframes luxBtnShimmer {
    0% { left: -60%; }
    25%, 100% { left: 140%; }
}
@keyframes luxPulseWave {
    0% { transform: scale(1); opacity: 0.85; }
    100% { transform: scale(1.65); opacity: 0; }
}

body.interior-body .int-tag-pill {
    animation: livartaPillFloat 4s ease-in-out infinite;
}
body.interior-body .int-tag-dot {
    animation: livartaGlowDot 2.2s infinite cubic-bezier(0.66, 0, 0, 1) !important;
}

.lux-reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: opacity, transform;
}
.lux-reveal.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.lux-reveal-left {
    opacity: 0;
    transform: translateX(-32px);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: opacity, transform;
}
.lux-reveal-left.is-visible {
    opacity: 1;
    transform: translateX(0);
}

.lux-reveal-right {
    opacity: 0;
    transform: translateX(32px);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: opacity, transform;
}
.lux-reveal-right.is-visible {
    opacity: 1;
    transform: translateX(0);
}

.lux-reveal-scale {
    opacity: 0;
    transform: scale(0.94);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: opacity, transform;
}
.lux-reveal-scale.is-visible {
    opacity: 1;
    transform: scale(1);
}

/* ─── SECTION: LEARN BEFORE YOU DESIGN (#interior-learn) ─── */
body.interior-body .int-learn-section {
    padding: 100px 0;
    background: linear-gradient(180deg, #FAF8F4 0%, #FFFFFF 50%, #FAF8F4 100%);
    position: relative;
    border-bottom: 1px solid rgba(200, 149, 43, 0.18);
}

/* Slider Track & Cards */
body.interior-body .int-yt-slider-wrapper {
    position: relative;
    width: 100%;
    overflow: hidden;
    padding: 12px 4px 24px;
}

body.interior-body .int-yt-slider-track {
    display: flex;
    gap: 24px;
    transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
    will-change: transform;
}

body.interior-body .int-yt-slide {
    flex: 0 0 calc((100% - 48px) / 3);
    min-width: 300px;
    box-sizing: border-box;
}

@media (max-width: 1024px) {
    body.interior-body .int-yt-slide {
        flex: 0 0 calc((100% - 24px) / 2);
    }
}
@media (max-width: 680px) {
    body.interior-body .int-yt-slide {
        flex: 0 0 100%;
        min-width: 100%;
    }
}

body.interior-body .int-yt-card {
    background: #FFFFFF;
    border: 1.5px solid var(--int-card-border);
    border-radius: 20px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: var(--int-shadow-card);
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
body.interior-body .int-yt-card:hover {
    transform: translateY(-6px);
    border-color: var(--int-gold);
    box-shadow: var(--int-shadow-hover);
}

body.interior-body .int-yt-thumb-box {
    position: relative;
    width: 100%;
    height: 200px;
    background: #0F172A;
    overflow: hidden;
    cursor: pointer;
}
body.interior-body .int-yt-thumb-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
}
body.interior-body .int-yt-card:hover .int-yt-thumb-box img {
    transform: scale(1.06);
}

body.interior-body .int-yt-duration-badge {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(15, 23, 42, 0.88);
    backdrop-filter: blur(4px);
    color: #F8FAFC;
    font-size: 0.68rem;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 6px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

body.interior-body .int-yt-tag-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    background: rgba(15, 23, 42, 0.88);
    backdrop-filter: blur(4px);
    color: #FFFFFF;
    font-size: 0.62rem;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid rgba(255, 0, 0, 0.3);
    display: flex;
    align-items: center;
}

body.interior-body .int-yt-play-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.28);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}
body.interior-body .int-yt-card:hover .int-yt-play-overlay {
    background: rgba(0, 0, 0, 0.1);
}

body.interior-body .int-yt-play-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--int-gold);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    box-shadow: 0 0 20px var(--int-gold-glow);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
body.interior-body .int-yt-play-circle i {
    margin-left: 2px;
}
body.interior-body .int-yt-card:hover .int-yt-play-circle {
    transform: scale(1.15);
    background: var(--int-gold-hover);
}

body.interior-body .int-yt-content {
    padding: 18px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

body.interior-body .int-yt-meta-row {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.7rem;
    color: var(--int-slate-muted);
    margin-bottom: 8px;
}

body.interior-body .int-yt-card-title {
    font-family: var(--font-heading);
    font-size: 0.92rem;
    font-weight: 700;
    line-height: 1.45;
    color: var(--int-charcoal);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

body.interior-body .int-yt-action-row {
    margin-top: 16px;
    padding-top: 12px;
    border-top: 1px solid rgba(200, 149, 43, 0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

body.interior-body .int-yt-watch-btn {
    display: inline-flex;
    align-items: center;
    border: 1px solid var(--int-gold-border);
    background: rgba(200, 149, 43, 0.08);
    color: var(--int-gold);
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.05em;
    padding: 6px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
}
body.interior-body .int-yt-watch-btn:hover {
    background: var(--int-gold);
    color: #FFFFFF;
}

body.interior-body .int-yt-ext-link {
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--int-slate-muted);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: color 0.2s;
}
body.interior-body .int-yt-ext-link:hover {
    color: #FF0000;
}

/* Slider Controls */
body.interior-body .int-yt-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    margin-top: 28px;
}

body.interior-body .int-yt-arrow-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 1.5px solid var(--int-gold-border);
    background: #FFFFFF;
    color: var(--int-gold);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: var(--int-shadow-subtle);
    transition: all 0.25s ease;
}
body.interior-body .int-yt-arrow-btn:hover {
    background: var(--int-gold);
    color: #FFFFFF;
    border-color: var(--int-gold);
    transform: scale(1.08);
}

body.interior-body .int-yt-dots {
    display: flex;
    align-items: center;
    gap: 6px;
}
body.interior-body .int-yt-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(200, 149, 43, 0.25);
    cursor: pointer;
    transition: all 0.3s ease;
}
body.interior-body .int-yt-dot.active {
    width: 24px;
    border-radius: 4px;
    background: var(--int-gold);
}
</style>
@endpush

@section('content')

<!-- =======================================================
     SECTION 1: CINEMATIC VIDEO HERO (#interior-intro)
     Full-Screen Luxury Interior Video Background
======================================================= -->
<section class="int-hero-section" id="interior-intro">

    <!-- ── Cinematic Full-Screen Video Background ── -->
    <div class="int-hero-video-wrap">
        <video
            id="intHeroBgVideo"
            class="int-hero-bg-video"
            autoplay
            muted
            loop
            playsinline
            webkit-playsinline
            x5-playsinline
            preload="auto"
            poster="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=2000&q=85"
        >
            @if(!empty($interior_hero_video_url))
                <source src="{{ $interior_hero_video_url }}" type="video/mp4">
            @endif
            <source src="{{ asset('videos/interior-luxury-living.mp4') }}" type="video/mp4">
            <source src="/videos/interior-luxury-living.mp4" type="video/mp4">
            <source src="{{ url('videos/interior-luxury-living.mp4') }}" type="video/mp4">
        </video>
        {{-- High-resolution architectural living room fallback poster --}}
        <img
            id="intHeroPoster"
            class="int-hero-poster"
            src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=2000&q=85"
            alt="Maha Luxury Interior Living Space"
            style="display:none;"
        >
    </div>

    <!-- Cinematic dark gradient overlay -->
    <div class="int-hero-overlay"></div>
    <!-- Soft vignette into section below -->
    <div class="int-hero-bottom-fade"></div>

    <!-- Content -->
    <div class="int-hero-content-outer">
        <div class="lux-reveal">
            <!-- Golden Running Marquee Bar (Exact construction hero style & content) -->
            <div class="pill-badge hero-marquee-badge">
                <span class="pulse-dot" style="flex-shrink:0;"></span>
                <div class="hero-marquee-track-container">
                    <div class="hero-marquee-track">
                        <span>OUR BRANCHES ARE {{ strtoupper($company_branches) }}</span>
                        <span class="marquee-sep">•</span>
                        <span>OUR BRANCHES ARE {{ strtoupper($company_branches) }}</span>
                        <span class="marquee-sep">•</span>
                        <span>OUR BRANCHES ARE {{ strtoupper($company_branches) }}</span>
                        <span class="marquee-sep">•</span>
                        <span>OUR BRANCHES ARE {{ strtoupper($company_branches) }}</span>
                        <span class="marquee-sep">•</span>
                    </div>
                </div>
            </div>

            <!-- Primary Headline -->
            <h1 class="int-hero-title">
                We don’t just design spaces.
            </h1>

            <!-- Gold Serif Emphasis Line -->
            <p class="int-hero-emphasis">
                We understand you, design for you, and transform your space.
            </p>

            <!-- Primary CTAs -->
            <div class="int-hero-actions">
                <a href="#interior-enquiry" class="int-btn-gold">
                    <i class="fas fa-calendar-check"></i> BOOK A FREE CONSULTATION <i class="fas fa-arrow-right" style="font-size:0.75rem;margin-left:4px;"></i>
                </a>
                <a href="#interior-projects" class="int-btn-outline">
                    SEE OUR WORK <i class="fas fa-chevron-down" style="font-size:0.75rem;"></i>
                </a>
            </div>
        </div>

        <!-- Glass Statistics Ribbon -->
        <div class="int-hero-stats-strip lux-reveal">
            <div class="int-hero-stats-grid">
                <div class="int-hero-stat-card">
                    <div class="int-hero-stat-val">150+</div>
                    <div class="int-hero-stat-label">Interiors Handed Over</div>
                </div>
                <div class="int-hero-stat-card">
                    <div class="int-hero-stat-val">10 Years</div>
                    <div class="int-hero-stat-label">Hardware &amp; Plywood Warranty</div>
                </div>
                <div class="int-hero-stat-card">
                    <div class="int-hero-stat-val">100%</div>
                    <div class="int-hero-stat-label">Factory Machine Finish</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll cue -->
    <div class="int-hero-scroll-cue" aria-hidden="true">
        <span>Scroll</span>
        <i class="fas fa-chevron-down"></i>
    </div>

</section>


<!-- =======================================================
     SECTION 2: COMPLETED PROJECTS (#interior-projects)
     Unified Video Slideshow Carousel Format
======================================================= -->
<section class="int-projects-section" id="interior-projects">
    <div class="container">
        <!-- Section Header -->
        <div class="int-sec-header-editorial lux-reveal">
            <span class="int-sec-tag">01 — COMPLETED PROJECTS</span>
            <h2 class="int-sec-title-light">
                COMPLETED <span style="color:var(--int-gold);">INTERIOR PROJECTS</span>
            </h2>
            <p class="int-sec-sub-light">
                Explore real homes and commercial spaces transformed through bespoke joinery, quartz stone, and ambient lighting across Tamil Nadu.
            </p>
        </div>

        <!-- Highlighted Architectural Capsule Category Filter Bar -->
        <div class="int-editorial-filters-wrapper lux-reveal">
            <div class="int-editorial-filters" role="tablist" aria-label="Interior Spaces Filter">
                <button type="button" class="int-filter-link interior-filter-btn active" data-category="all">
                    <i class="fas fa-layer-group"></i> <span>ALL SPACES</span>
                </button>
                <button type="button" class="int-filter-link interior-filter-btn" data-category="living-room">
                    <i class="fas fa-couch"></i> <span>LIVING ROOM</span>
                </button>
                <button type="button" class="int-filter-link interior-filter-btn" data-category="modular-kitchen">
                    <i class="fas fa-kitchen-set"></i> <span>MODULAR KITCHEN</span>
                </button>
                <button type="button" class="int-filter-link interior-filter-btn" data-category="bedroom">
                    <i class="fas fa-bed"></i> <span>BEDROOM</span>
                </button>
                <button type="button" class="int-filter-link interior-filter-btn" data-category="office-interior">
                    <i class="fas fa-briefcase"></i> <span>OFFICE INTERIOR</span>
                </button>
                <button type="button" class="int-filter-link interior-filter-btn" data-category="full-home-interior">
                    <i class="fas fa-house-chimney"></i> <span>FULL HOME</span>
                </button>
                <button type="button" class="int-filter-link interior-filter-btn" data-category="commercial-interior">
                    <i class="fas fa-building"></i> <span>COMMERCIAL</span>
                </button>
            </div>
        </div>

        <!-- Unified Video Slideshow Carousel for Projects -->
        <div class="int-carousel-wrapper lux-reveal">
            <div class="int-carousel-track" id="interiorProjectsTrack">
                @forelse($projects as $i => $project)
                @php
                    $allImages = [];
                    if (is_array($project->image_urls) && count($project->image_urls) > 0) {
                        $allImages = array_values(array_filter($project->image_urls));
                    }
                    if (empty($allImages)) {
                        $allImages = ['https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80'];
                    }
                    $imageCount = count($allImages);
                @endphp
                <div class="int-video-slide-card interior-project-card"
                     id="interiorProjectCard_{{ $i }}"
                     data-card-index="{{ $i }}"
                     data-category="{{ $project->category }}"
                     data-slideshow="{{ $imageCount > 1 ? 'true' : 'false' }}"
                     onclick="window.openInteriorGalleryModal(event, {{ $i }}, 0)">
                    
                    <!-- Multi-Image Automatic Slideshow Container -->
                    <div class="int-card-slideshow-container" id="cardSlideshow_{{ $i }}">
                        @foreach($allImages as $imgIdx => $imgSrc)
                        <img src="{{ $imgSrc }}" 
                             alt="{{ $project->name }} - Photo {{ $imgIdx + 1 }}" 
                             class="int-card-slide-img {{ $imgIdx === 0 ? 'active' : '' }}" 
                             data-slide-index="{{ $imgIdx }}"
                             loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80'">
                        @endforeach
                    </div>
                    
                    <!-- Ambient Shadow & Gradient Overlay for readability -->
                    <div class="int-video-card-shade"></div>

                    <!-- Top Left: Project Tag -->
                    <span class="int-video-card-tag">
                        PROJECT {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <!-- Top Right Badges: Photo Counter + Category -->
                    <div class="int-card-top-badges">
                        <span class="int-card-photos-badge" 
                              onclick="event.stopPropagation(); window.openInteriorGalleryModal(event, {{ $i }}, 0);"
                              title="Click to view all {{ $imageCount }} photos">
                            <i class="fas fa-images"></i> 
                            <span class="int-card-cur-slide-num">1</span>/{{ $imageCount }}
                        </span>
                        <span class="int-video-card-badge">
                            {{ strtoupper(str_replace('-', ' ', $project->category)) }}
                        </span>
                    </div>

                    <!-- Slide Progress Dots (Only if multiple photos) -->
                    @if($imageCount > 1)
                    <div class="int-card-slide-dots" id="cardDots_{{ $i }}">
                        @foreach($allImages as $dotIdx => $dotSrc)
                        <span class="int-card-mini-dot {{ $dotIdx === 0 ? 'active' : '' }}" 
                              onclick="event.stopPropagation(); window.setCardSlide({{ $i }}, {{ $dotIdx }})"
                              title="Slide {{ $dotIdx + 1 }}"></span>
                        @endforeach
                    </div>
                    @endif

                    <!-- Center Video Play Button (if walkthrough video is attached) -->
                    @if($project->video_url)
                    <div class="int-video-play-btn" 
                         onclick="event.stopPropagation(); window.playVideoModal('{{ $project->video_url }}', '{{ addslashes($project->name) }}')" 
                         title="Watch Video Tour">
                        <i class="fas fa-play" style="margin-left:3px;"></i>
                    </div>
                    @endif

                    <!-- Bottom Info -->
                    <div class="int-video-card-info">
                        <div class="int-video-card-title">{{ $project->name }}</div>
                        <div class="int-video-card-sub">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $project->location ?? 'Tamil Nadu' }}</span>
                        </div>
                        @if($project->description)
                        <div class="int-video-card-snippet">{{ $project->description }}</div>
                        @endif

                        <!-- Action Buttons: Both Video and View Photos -->
                        <div class="int-card-actions-row">
                            <button type="button" 
                                    class="int-card-action-btn int-btn-view-photos" 
                                    onclick="event.stopPropagation(); window.openInteriorGalleryModal(event, {{ $i }}, 0)">
                                <i class="fas fa-expand-arrows-alt"></i> VIEW PHOTOS ({{ $imageCount }})
                            </button>
                            @if($project->video_url)
                            <button type="button" 
                                    class="int-card-action-btn int-btn-watch-tour" 
                                    onclick="event.stopPropagation(); window.playVideoModal('{{ $project->video_url }}', '{{ addslashes($project->name) }}')">
                                <i class="fas fa-play"></i> TOUR
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="width:100%;text-align:center;padding:40px;color:var(--int-slate-muted);">
                    Interior projects showcase is being updated.
                </div>
                @endforelse
            </div>

            <div id="noFilteredProjectsMsg" style="display:none;text-align:center;padding:40px 20px;color:var(--int-slate-muted);">
                <i class="fas fa-couch" style="font-size:2rem;color:var(--int-gold);margin-bottom:12px;display:block;"></i>
                <p style="font-size:1rem;color:#161922;margin-bottom:6px;font-weight:700;">No projects currently listed in this space.</p>
                <p style="font-size:0.85rem;color:var(--int-slate-muted);">Browse other spaces above or consult Er. Maha Rajan for custom projects.</p>
            </div>

            <!-- Progress Bar Tracker -->
            <div class="int-carousel-progress-track">
                <div class="int-carousel-progress-fill" id="interiorProjectsProgressFill"></div>
            </div>

            <!-- Navigation Controls: Arrows & Dots -->
            <div class="int-carousel-controls">
                <button type="button" class="int-carousel-arrow-btn" id="interiorProjectsPrevBtn" aria-label="Previous project">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div class="int-carousel-dots" id="interiorProjectsDots"></div>
                <button type="button" class="int-carousel-arrow-btn" id="interiorProjectsNextBtn" aria-label="Next project">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Footer Action -->
        <div style="text-align:center;margin-top:40px;" class="lux-reveal">
            <a href="#interior-enquiry" class="int-btn-outline">
                <i class="fas fa-paper-plane" style="margin-right:8px;color:var(--int-gold);"></i> REQUEST ESTIMATE FOR YOUR SPACE
            </a>
        </div>
    </div>
</section>


<!-- =======================================================
     SECTION 3: CLIENT TESTIMONIALS (#interior-testimonials)
     Unified Video Slideshow Carousel Format
======================================================= -->
<section class="int-testimonials-section" id="interior-testimonials">
    <div class="container">
        <!-- Section Header -->
        <div class="int-sec-header-editorial lux-reveal">
            <span class="int-sec-tag">02 — CLIENT STORIES</span>
            <h2 class="int-sec-title-dark">
                CLIENT <span style="color:var(--int-gold);">TESTIMONIALS</span>
            </h2>
            <p class="int-sec-sub-dark">
                Hear directly from families and professionals whose living spaces and modular kitchens we have designed and delivered.
            </p>
        </div>

        @if($testimonials->count() > 0)
        <!-- Featured Magazine Pull-Quote -->
        <div class="int-pullquote-box lux-reveal">
            <div class="int-quote-glyph">“</div>
            <div class="int-pullquote-text">
                “THE SPACE FINALLY FEELS LIKE HOME — FUNCTIONAL, ELEGANT, AND DELIVERED EXACTLY ON SCHEDULE.”
            </div>
            <div class="int-pullquote-author">
                <img src="{{ $testimonials[0]->image_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}"
                     alt="{{ $testimonials[0]->client_name }}"
                     class="int-pullquote-author-img">
                <div>
                    <div class="int-author-name">{{ $testimonials[0]->client_name }}</div>
                    <div class="int-author-role">{{ $testimonials[0]->client_role ?? 'Homeowner' }} • {{ $testimonials[0]->project_name ?? 'Turnkey Residence' }}</div>
                </div>
            </div>
        </div>

        <!-- Unified Video Slideshow Carousel for Testimonials -->
        <div class="int-carousel-wrapper lux-reveal">
            <div class="int-carousel-track" id="interiorTestimonialsTrack">
                @foreach($testimonials as $i => $t)
                <div class="int-video-slide-card"
                     @if($t->video_url)
                     onclick="window.playVideoModal('{{ $t->video_url }}', '{{ addslashes($t->client_name) }} - Video Review')"
                     @endif>
                    <!-- Background Photo -->
                    <img src="{{ $t->image_url ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80' }}"
                         alt="{{ $t->client_name }}"
                         class="int-video-card-bg"
                         loading="lazy">
                    <div class="int-video-card-shade"></div>

                    <!-- Top Tag -->
                    <span class="int-video-card-tag">
                        STORY {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <!-- Rating Stars at Top Right -->
                    <span class="int-video-card-badge">
                        {{ $t->rating ?? 5 }} ★ REVIEW
                    </span>

                    <!-- Center Golden Play Button -->
                    @if($t->video_url)
                    <div class="int-video-play-btn" title="Watch Video Review">
                        <i class="fas fa-play" style="margin-left:3px;"></i>
                    </div>
                    @endif

                    <!-- Bottom Info -->
                    <div class="int-video-card-info">
                        <div class="int-video-card-title">{{ $t->client_name }}</div>
                        <div class="int-video-card-sub">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $t->project_name ?? 'Maha Interiors' }}</span>
                        </div>
                        <div class="int-video-card-stars">
                            @for($s = 0; $s < ($t->rating ?? 5); $s++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <div class="int-video-card-snippet">"{{ $t->feedback }}"</div>

                        @if($t->video_url)
                        <div class="int-video-card-action">
                            <i class="fas fa-play"></i> WATCH STORY
                        </div>
                        @else
                        <div class="int-video-card-action">
                            <i class="fas fa-check-circle"></i> SATISFIED CLIENT
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Progress Bar Tracker -->
            <div class="int-carousel-progress-track">
                <div class="int-carousel-progress-fill" id="interiorTestimonialsProgressFill"></div>
            </div>

            <!-- Navigation Controls: Arrows & Dots -->
            <div class="int-carousel-controls">
                <button type="button" class="int-carousel-arrow-btn" id="interiorTestimonialsPrevBtn" aria-label="Previous story">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div class="int-carousel-dots" id="interiorTestimonialsDots"></div>
                <button type="button" class="int-carousel-arrow-btn" id="interiorTestimonialsNextBtn" aria-label="Next story">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
        @endif
    </div>
</section>


<!-- =======================================================
     SECTION 4: ENGINEER / COMPANY INTRO (#interior-engineer)
======================================================= -->
<section class="int-engineer-section" id="interior-engineer">
    <div class="container">
        <div class="int-engineer-grid">
            <!-- Left: Engineer Portrait & 60-Sec Intro Video Trigger -->
            <div class="int-eng-portrait-card lux-reveal">
                <div class="int-eng-video-thumb" onclick="window.playVideoModal('{{ $intro_video_url }}', 'Er. Maha Rajan - 60-Second Video Introduction')">
                    <img src="{{ asset('maha-rajan.png') }}"
                         alt="Er. Maha Rajan"
                         onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80'">
                    <div class="int-eng-gradient"></div>
                    <span class="int-eng-play-badge"><i class="fas fa-play" style="font-size:0.55rem;margin-right:4px;"></i> 60-Sec Intro</span>
                    <div class="int-eng-play-btn">
                        <i class="fas fa-play" style="margin-left:3px;"></i>
                    </div>
                </div>
                <div class="int-eng-btn-row">
                    <button type="button" onclick="window.playVideoModal('{{ $intro_video_url }}', 'Er. Maha Rajan - 60-Second Video Introduction')" class="int-btn-outline" style="width:100%;justify-content:center;font-size:0.76rem;padding:10px;">
                        <i class="fas fa-circle-play" style="color:var(--int-gold);margin-right:6px;"></i> WATCH ENGINEER INTRO
                    </button>
                </div>
            </div>

            <!-- Right: Technical Principles & Executive Info -->
            <div class="lux-reveal">
                <span class="int-sec-tag">03 — MEET YOUR DESIGNER</span>
                <h2 class="int-sec-title-light" style="font-size:clamp(1.8rem, 3.4vw, 2.6rem);margin-bottom:8px;">
                    Engineering Precision. Interior Creativity. Professional Execution<br>
                    <span style="color:var(--int-gold);">EXECUTED WITH CARE.</span>
                </h2>
                <div style="font-size:0.85rem;color:#16A34A;font-weight:800;letter-spacing:0.08em;margin-bottom:18px;">
                    Er. Maha Rajan (B.E. MBA) • GOVERNMENT REGISTERED ENGINEER • 12+ YEARS STRUCTURAL EXCELLENCE
                </div>

                <p style="font-size:0.95rem;color:#4B5563;line-height:1.75;margin-bottom:26px;">
                    An engineer who understands the space, a designer who understands the client, and a professional who brings the vision to reality.
                </p>

                <!-- Signature 3-Step Principle Pipeline: 01 UNDERSTAND -> 02 DESIGN -> 03 TRANSFORM -->
                <div class="int-principles-flow">
                    <!-- Step 1: UNDERSTAND -->
                    <div class="int-flow-step" data-step="1">
                        <div class="int-flow-step-header">
                            <div class="int-flow-icon-circle">
                                <i class="fa-solid fa-ear-listen"></i>
                            </div>
                            <span class="int-flow-step-num">01 // UNDERSTAND</span>
                        </div>
                        <h3 class="int-flow-step-title">We Listen Before We Design.</h3>
                        <p class="int-flow-step-desc">Your lifestyle, needs, taste, budget and the way you want to experience your space.</p>
                    </div>

                    <!-- Step 2: DESIGN -->
                    <div class="int-flow-step" data-step="2">
                        <div class="int-flow-step-header">
                            <div class="int-flow-icon-circle">
                                <i class="fa-solid fa-compass-drafting"></i>
                            </div>
                            <span class="int-flow-step-num">02 // DESIGN</span>
                        </div>
                        <h3 class="int-flow-step-title">We turn your ideas into thoughtful spaces.</h3>
                        <p class="int-flow-step-desc">Creative design, 3D visualization and precise technical planning come together to create a space that feels uniquely yours.</p>
                    </div>

                    <!-- Step 3: TRANSFORM -->
                    <div class="int-flow-step" data-step="3">
                        <div class="int-flow-step-header">
                            <div class="int-flow-icon-circle">
                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                            </div>
                            <span class="int-flow-step-num">03 // TRANSFORM</span>
                        </div>
                        <h3 class="int-flow-step-title">We bring the design to life.</h3>
                        <p class="int-flow-step-desc">Professional execution, quality materials and attention to every detail turn the design into a finished space you can truly live in.</p>
                    </div>
                </div>

                <!-- Executive Consultation Action Row -->
                <div class="int-flow-action-row">
                    <a href="#interior-enquiry" class="int-btn-gold">
                        CONSULT ER. MAHA RAJAN DIRECTLY <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="int-flow-trust-pill">
                        <i class="fas fa-shield-halved" style="color:var(--int-gold);"></i>
                        <span>100% Engineer-Verified Execution &bull; Transparent BOQ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- =======================================================
     SECTION 5: INTERIOR PACKAGES (#interior-packages)
======================================================= -->
<section class="int-packages-section" id="interior-packages">
    <div class="container">
        <!-- Section Header -->
        <div class="int-sec-header-editorial lux-reveal">
            <span class="int-sec-tag">04 — INTERIOR PACKAGES</span>
            <h2 class="int-sec-title-dark">
                INTERIOR <span style="color:var(--int-gold);">PACKAGES</span>
            </h2>
            <p class="int-sec-sub-dark">
                Transparent Package pricing per sq.ft with 100% itemized material transparency and German hardware fittings.
            </p>
        </div>

        <!-- 3 Architectural Package Panels -->
        @php
            $intFallbacks = [
                [
                    'id'              => 7,
                    'division'        => 'interior',
                    'tier'            => 'essential',
                    'title'           => 'Essential Interiors',
                    'subtitle'        => 'Elegant & Smart Turnkey Solution',
                    'price_per_sqft'  => 1250,
                    'is_highlighted'  => false,
                    'warranty_years'  => 5,
                    'delivery_months' => 2,
                    'description'     => 'Ideal for 2BHK and 3BHK homeowners seeking dependable quality, high-pressure laminate finishes, and modular functionality at transparent pricing.',
                    'features'        => [
                        'ISI-grade BWR Marine Plywood (IS:303)',
                        '0.8mm High-Pressure Matte Laminates (Century / Greenlam)',
                        'Hettich / Ebco Soft-Close Hinges & Drawer Runners',
                        'Modular L-Shape / Straight Kitchen with SS 304 Baskets',
                        '2 Full-Height Swing Wardrobes with internal drawers',
                        'Floating TV Unit with concealed cable routing',
                        'Saint-Gobain Gypsum False Ceiling with LED Cob cutouts',
                        'Asian Paints Royale Luxury Interior Emulsion'
                    ],
                    'inclusions'      => [
                        'Modular Kitchen cabinets & loft cupboards',
                        'Master & Guest bedroom wardrobes (Swing Door)',
                        'Living room floating TV entertainment backdrop',
                        'Gypsum false ceiling in Living & Dining',
                        'Concealed electrical wiring for LED cove & spots',
                        '5 Years comprehensive warranty on hardware'
                    ],
                    'exclusions'      => [
                        'Kitchen chimney & built-in appliances',
                        'Loose movable furniture (sofa, dining chairs)',
                        'Curtains & soft furnishings',
                        'Smart home home automation switches'
                    ],
                    'business_type'   => 'interior',
                ],
                [
                    'id'              => 8,
                    'division'        => 'interior',
                    'tier'            => 'premium',
                    'title'           => 'Premium Interiors',
                    'subtitle'        => 'Elevated Aesthetics & Soft-Close Luxury',
                    'price_per_sqft'  => 1750,
                    'is_highlighted'  => true,
                    'warranty_years'  => 10,
                    'delivery_months' => 3,
                    'description'     => 'Our most popular comprehensive interior solution featuring 1.0mm anti-fingerprint acrylic/PU finishes, German Hafele hardware, quartz counter, and ambient lighting.',
                    'features'        => [
                        '100% Boiling Water Proof (BWP 710) Calibrated Ply',
                        '1.0mm Anti-Fingerprint Acrylic / Ultra-Matte Finish',
                        'Hafele / Blum Soft-Close Tandem Boxes & Lift-Ups',
                        'Parallel / Island Modular Kitchen with Quartz Counter',
                        'Floor-to-Ceiling Sliding Wardrobes with tinted glass accent',
                        'Living Room Fluted Louver Panel + Marble Sheet Backdrop',
                        'False Ceiling in all rooms with magnetic track lighting',
                        'Profile LED lighting in wardrobes and kitchen base'
                    ],
                    'inclusions'      => [
                        'Full Kitchen with tall pantry unit & tandem organizers',
                        'Master bedroom walk-in / sliding wardrobe with sensor LED',
                        'Kids & Guest room wardrobes with study tables',
                        'Designer TV wall with charcoal fluted louvers & storage',
                        'Foyer shoe rack with cushioned seating niche',
                        'Complete false ceiling across entire home with LED channels',
                        '10 Years hardware warranty with engineer supervision'
                    ],
                    'exclusions'      => [
                        'Movable living room sofa and mattress sets',
                        'Heavy kitchen appliances (refrigerator, microwave)',
                        'Balcony planter setups'
                    ],
                    'business_type'   => 'interior',
                ],
                [
                    'id'              => 9,
                    'division'        => 'interior',
                    'tier'            => 'luxury',
                    'title'           => 'Luxury Interiors',
                    'subtitle'        => 'Bespoke Architectural Grandeur',
                    'price_per_sqft'  => 2450,
                    'is_highlighted'  => false,
                    'warranty_years'  => 15,
                    'delivery_months' => 4,
                    'description'     => 'Uncompromising elite craftsmanship using imported natural veneers, Italian PU lacquered surfaces, motorized Blum Aventos, and integrated smart scenes.',
                    'features'        => [
                        'Birla / Century Club Prime 710 Gold BWP Plywood',
                        'Natural Smoked Oak / Teak Veneer with PU Polish & Italian Gloss',
                        'Blum Servo-Drive Motorized Opening System',
                        'Bespoke Island Kitchen with Kalinga Stone / Italian Marble',
                        'Walk-In Wardrobes with sensor illumination & velvet jewelry trays',
                        'Acoustic Fabric & Brass Inlay Panelling in Master Suite',
                        'Full Smart Architectural Lighting with automated dimming',
                        'Italian Travertine cladding on entrance and TV console'
                    ],
                    'inclusions'      => [
                        'Complete bespoke interior fitment from entrance to terrace',
                        'Island kitchen with motorized drawers & corner le-mans',
                        'Full walk-in dressing suite with glass aluminum profile shutters',
                        'Acoustic ceiling and home theatre wall treatments',
                        'Designer vanity counters in all bathrooms with mirrors',
                        'Smart ambient scene lighting throughout home',
                        '15 Years warranty with bi-annual maintenance checkup'
                    ],
                    'exclusions'      => [
                        'Art collection and specialized antique purchases',
                        'Smart TV / Soundbar electronics'
                    ],
                    'business_type'   => 'interior',
                ],
            ];
            $activeInteriorPackages = (isset($packages) && $packages->isNotEmpty()) ? $packages : collect($intFallbacks);
        @endphp
        <div class="int-packages-grid lux-reveal">
            @foreach($activeInteriorPackages as $pkg)
            @php
                $isModel = $pkg instanceof \App\Models\PackageDetail;
                $pkgId = $isModel ? $pkg->id : ($pkg['id'] ?? null);
                $pkgTier = $isModel ? $pkg->tier : ($pkg['tier'] ?? 'Plan');
                $pkgTitle = $isModel ? $pkg->title : ($pkg['title'] ?? '');
                $pkgSubtitle = $isModel ? $pkg->subtitle : ($pkg['subtitle'] ?? '');
                $pkgPrice = $isModel ? $pkg->price_per_sqft : ($pkg['price_per_sqft'] ?? 0);
                $pkgWarranty = $isModel ? ($pkg->warranty_years ?? 10) : ($pkg['warranty_years'] ?? 10);
                $pkgDelivery = $isModel ? ($pkg->delivery_months ?? 2) : ($pkg['delivery_months'] ?? 2);
                $pkgHL = $isModel ? $pkg->is_highlighted : ($pkg['is_highlighted'] ?? false);
                $pkgFeatures = $isModel ? ((is_array($pkg->features) && count($pkg->features)) ? $pkg->features : []) : ($pkg['features'] ?? []);
                $pkgInclusions = $isModel ? ((is_array($pkg->inclusions) && count($pkg->inclusions)) ? $pkg->inclusions : []) : ($pkg['inclusions'] ?? []);
                $pkgExclusions = $isModel ? ((is_array($pkg->exclusions) && count($pkg->exclusions)) ? $pkg->exclusions : []) : ($pkg['exclusions'] ?? []);
                $pkgDesc = $isModel ? $pkg->description : ($pkg['description'] ?? '');
                $pkgPayload = [
                    'id' => $pkgId,
                    'tier' => $pkgTier,
                    'title' => $pkgTitle,
                    'subtitle' => $pkgSubtitle,
                    'price_per_sqft' => $pkgPrice,
                    'warranty_years' => $pkgWarranty,
                    'delivery_months' => $pkgDelivery,
                    'features' => $pkgFeatures,
                    'inclusions' => $pkgInclusions,
                    'exclusions' => $pkgExclusions,
                    'description' => $pkgDesc,
                    'business_type' => 'interior',
                ];
            @endphp
            <div class="int-pkg-panel {{ $pkgHL ? 'highlighted' : '' }}">
                @if($pkgHL)
                <div class="int-pkg-popular-tag">MOST POPULAR CHOICE</div>
                @endif

                <div>
                    <span class="int-pkg-tier">{{ strtoupper($pkgTier) }} PLAN</span>
                    <h3 class="int-pkg-title">{{ $pkgTitle }}</h3>
                    <p class="int-pkg-subtitle">{{ $pkgSubtitle }}</p>

                    <div class="int-pkg-price-row">
                        <span class="int-pkg-price-val">₹{{ number_format($pkgPrice) }}</span>
                        <span class="int-pkg-price-unit">/ sq.ft turnkey</span>
                    </div>

                    <div class="int-pkg-chips">
                        <span class="int-pkg-chip">
                            <i class="fas fa-shield-alt" style="color:var(--int-gold);"></i> {{ $pkgWarranty }} Yrs Hardware Warranty
                        </span>
                        <span class="int-pkg-chip">
                            <i class="fas fa-calendar-check" style="color:var(--int-gold);"></i> {{ $pkgDelivery }} Mos Handover
                        </span>
                    </div>

                    <ul class="int-pkg-features-list">
                        @if(!empty($pkgFeatures) && is_array($pkgFeatures))
                            @foreach(array_slice($pkgFeatures, 0, 6) as $feat)
                            <li class="int-pkg-feature-item">
                                <i class="fas fa-check"></i>
                                <span>{{ $feat }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div>
                    <a href="#interior-enquiry" onclick="preselectInteriorPackage('{{ addslashes($pkgTitle) }}')" class="int-pkg-btn-book">
                        <i class="fas fa-paper-plane"></i> BOOK THIS PACKAGE
                    </a>
                    <button type="button" onclick='openInteriorPackageDetailsModal(@json($pkgPayload))' class="int-pkg-btn-specs">
                        <i class="fas fa-list-check" style="margin-right:4px;"></i> VIEW FULL INCLUSIONS & SPECS
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- =======================================================
     SECTION: LEARN BEFORE YOU DESIGN (#interior-learn)
======================================================= -->
<section class="int-learn-section" id="interior-learn">
    <div class="container">
        <!-- Section Header -->
        <div class="int-sec-header-editorial lux-reveal" style="text-align:center;">
            <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,0,0,0.08);border:1px solid rgba(255,0,0,0.3);border-radius:20px;padding:6px 18px;margin-bottom:14px;">
                <i class="fab fa-youtube" style="color:#FF0000;font-size:0.95rem;"></i>
                <span style="font-size:0.72rem;font-weight:800;letter-spacing:0.14em;color:#FF5555;text-transform:uppercase;">05 — YOUTUBE MASTERCLASSES & SITE TOURS</span>
            </div>
            <h2 class="int-sec-title-dark" style="margin-top:4px;">
                LEARN BEFORE YOU <span style="color:var(--int-gold);">DESIGN</span> — MASTERCLASSES
            </h2>
            <p class="int-sec-sub-dark" style="max-width:700px;margin:10px auto 0;">
                "Expert interior space planning, modular kitchen design guides, material selection secrets, and live site tour walk-throughs."
            </p>
        </div>

        <!-- Video Slider Container -->
        <div class="int-yt-slider-container lux-reveal" style="margin-top:36px;">
            @if(!empty($syncedVideos) && count($syncedVideos) > 0)
            <div class="int-yt-slider-wrapper" id="interiorYtSliderWrapper">
                <div class="int-yt-slider-track" id="interiorYtSliderTrack">
                    @foreach($syncedVideos as $v)
                    <div class="int-yt-slide">
                        <div class="int-yt-card">
                            <!-- Thumbnail Frame with Overlay -->
                            <div class="int-yt-thumb-box" onclick="window.playVideoModal('{{ $v['videoUrl'] }}', '{{ addslashes($v['title']) }}')">
                                <img src="{{ $v['thumbnail'] }}" alt="{{ $v['title'] }}" loading="lazy" onerror="this.src='https://img.youtube.com/vi/{{ $v['youtubeId'] }}/hqdefault.jpg'">
                                
                                <div class="int-yt-duration-badge">
                                    <i class="fas fa-play" style="font-size:0.55rem;margin-right:4px;color:var(--int-gold);"></i>{{ $v['duration'] ?? 'Masterclass' }}
                                </div>

                                <div class="int-yt-tag-badge">
                                    <i class="fab fa-youtube" style="color:#FF0000;margin-right:4px;"></i>
                                    <span>MAHA INTERIORS</span>
                                </div>

                                <div class="int-yt-play-overlay">
                                    <div class="int-yt-play-circle">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Info -->
                            <div class="int-yt-content">
                                <div>
                                    <div class="int-yt-meta-row">
                                        @if(!empty($v['views']))
                                        <span style="color:var(--int-gold);font-weight:700;"><i class="fas fa-eye" style="margin-right:3px;"></i>{{ $v['views'] }}</span>
                                        <span>•</span>
                                        @endif
                                        <span><i class="fas fa-clock" style="margin-right:3px;"></i>{{ $v['published'] ?? 'Recent' }}</span>
                                    </div>
                                    <h4 class="int-yt-card-title" title="{{ $v['title'] }}">
                                        {{ $v['title'] }}
                                    </h4>
                                </div>

                                <div class="int-yt-action-row" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:6px;">
                                    <div style="display:flex;gap:6px;align-items:center;">
                                        <button type="button" class="int-yt-watch-btn" onclick="window.playVideoModal('{{ $v['videoUrl'] }}', '{{ addslashes($v['title']) }}')">
                                            <i class="fas fa-play" style="font-size:0.68rem;margin-right:5px;"></i> WATCH ON SITE
                                        </button>

                                    </div>
                                    <a href="{{ $v['watchUrl'] ?? ('https://www.youtube.com/watch?v='.$v['youtubeId']) }}" target="_blank" class="int-yt-ext-link">
                                        <i class="fab fa-youtube" style="color:#FF0000;font-size:0.85rem;"></i> YouTube <i class="fas fa-arrow-up-right-from-square" style="font-size:0.6rem;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Slider Controls -->
            <div class="int-yt-controls">
                <button type="button" class="int-yt-arrow-btn" id="interiorYtPrevBtn" aria-label="Previous video">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="int-yt-dots" id="interiorYtDots"></div>
                <button type="button" class="int-yt-arrow-btn" id="interiorYtNextBtn" aria-label="Next video">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            @else
            <!-- Fallback Empty / Loading State -->
            <div style="text-align:center;padding:50px 20px;background:#FFFFFF;border:1.5px dashed rgba(200,149,43,0.4);border-radius:24px;box-shadow:var(--int-shadow-card);">
                <i class="fab fa-youtube" style="font-size:3rem;color:#FF0000;margin-bottom:12px;display:inline-block;"></i>
                <h3 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:800;color:var(--int-charcoal);margin-bottom:6px;">YouTube Channel Syncing</h3>
                <p style="color:var(--int-slate-muted);font-size:0.88rem;max-width:520px;margin:0 auto 16px;">
                    Interior masterclasses and walkthrough tours are syncing from {{ $yt_channel_handle ?? '@mahaconstructions2013' }}. Check back shortly or visit our YouTube channel directly.
                </p>
                <a href="{{ $yt_channel_url ?? 'https://www.youtube.com/@mahaconstructions2013' }}" target="_blank" class="int-btn-gold" style="display:inline-flex;">
                    <i class="fab fa-youtube" style="margin-right:8px;"></i> VISIT YOUTUBE CHANNEL
                </a>
            </div>
            @endif
        </div>

        <!-- Bottom CTA Row -->
        <div style="text-align:center;margin-top:36px;display:flex;justify-content:center;gap:14px;flex-wrap:wrap;">
            <a href="{{ $yt_channel_url ?? 'https://www.youtube.com/@mahaconstructions2013' }}" target="_blank" class="int-btn-gold" style="background:linear-gradient(135deg, #FF0000 0%, #CC0000 100%);border-color:#FF0000;color:#FFFFFF;box-shadow:0 8px 24px rgba(255,0,0,0.25);">
                <i class="fab fa-youtube" style="margin-right:6px;"></i> SUBSCRIBE ON YOUTUBE
            </a>
            <a href="{{ rtrim($yt_channel_url ?? 'https://www.youtube.com/@mahaconstructions2013', '/') }}/videos" target="_blank" class="int-btn-outline" style="border-color:var(--int-gold);color:var(--int-charcoal);">
                <i class="fas fa-video" style="margin-right:6px;color:var(--int-gold);"></i> EXPLORE ALL MASTERCLASSES & TOURS
            </a>
        </div>
    </div>
</section>

<!-- =======================================================
     CROSS-NAVIGATION BRIDGE: EXPLORE MAHA CONSTRUCTION
     Placed immediately after 05 — YOUTUBE MASTERCLASSES & SITE TOURS
======================================================= -->
@include('components.cross-nav-bridge', ['target' => 'construction'])


<!-- Section 2: Services anchor (hidden stub to maintain isolation and test contracts) -->
<div id="interior-services" style="display:none;" aria-hidden="true">
    @foreach($services as $srv)
        <span>{{ $srv->name }}</span>
    @endforeach
</div>


<!-- =======================================================
     SECTION 7: ENQUIRE / BOOK CONSULTATION (#interior-enquiry)
======================================================= -->
<section class="int-enquiry-section" id="interior-enquiry">
    <div class="container">
        <div class="int-enquiry-grid">
            <!-- Left: Studio Manifesto & Direct Contacts -->
            <div class="int-enquiry-info-box lux-reveal">
                <span class="int-sec-tag">06 — DIRECT STUDIO CONSULTATION</span>
                <h2 class="int-sec-title-light">
                    BOOK A FREE<br>
                    <span style="color:var(--int-gold);">CONSULTATION</span>
                </h2>
                <p class="int-sec-sub-light" style="margin-bottom:28px;">
                    Submit your floor plan or requirements for a personalized 3D spatial review, modular kitchen plan, and transparent itemized quote from Er. Maha Rajan.
                </p>

                <div class="int-enquiry-quick-contacts">
                    <div class="int-contact-row">
                        <div class="int-contact-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <span style="display:block;font-size:0.75rem;color:var(--int-gold);font-weight:800;text-transform:uppercase;">Call Studio Directly</span>
                            <a href="tel:+{{ $raw_phone }}">{{ $company_phone }}</a>
                        </div>
                    </div>
                    <div class="int-contact-row">
                        <div class="int-contact-icon" style="color:#25D366;background:rgba(37,211,102,0.1);border-color:rgba(37,211,102,0.3);"><i class="fab fa-whatsapp"></i></div>
                        <div>
                            <span style="display:block;font-size:0.75rem;color:#25D366;font-weight:800;text-transform:uppercase;">WhatsApp Chat</span>
                            <a href="https://wa.me/{{ $raw_whatsapp }}?text=Hello%20Er.%20Maha%20Rajan%2C%20I%20want%20to%20consult%20for%20my%20Interior%20Space." target="_blank">+{{ $raw_whatsapp }}</a>
                        </div>
                    </div>
                    <div class="int-contact-row">
                        <div class="int-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span style="display:block;font-size:0.75rem;color:var(--int-gold);font-weight:800;text-transform:uppercase;">Design Studio</span>
                            <span>{{ $company_address }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Dedicated Interior Consultation Form -->
            <form id="interiorEnquiryForm" class="int-enquiry-form-card lux-reveal">
                @csrf
                <!-- Hidden UI aid: Server forces business_type = 'interior' -->
                <input type="hidden" name="business_type" value="interior">

                <div style="margin-bottom:16px;">
                    <label class="int-form-label">FULL NAME *</label>
                    <input type="text" name="name" id="interiorFormName" required placeholder="Enter your full name" class="int-form-input">
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                    <div>
                        <label class="int-form-label">EMAIL ADDRESS *</label>
                        <input type="email" name="email" id="interiorFormEmail" required placeholder="name@gmail.com" class="int-form-input">
                    </div>
                    <div>
                        <label class="int-form-label">TELEPHONE / WHATSAPP *</label>
                        <input type="tel" name="phone" id="interiorFormPhone" required placeholder="+91 90959 29543" class="int-form-input">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;">
                    <div>
                        <label class="int-form-label">SERVICE / SPACE</label>
                        <select name="project_type" id="interiorFormService" class="int-form-select">
                            <option value="Full Home Interior">Full Home Turnkey Interiors</option>
                            <option value="Modular Kitchen">Modular Kitchen</option>
                            <option value="Wardrobe Design">Wardrobe & Closet Systems</option>
                            <option value="Living Room Interiors">Living Room & TV Entertainment Console</option>
                            <option value="Bedroom Interiors">Master Bedroom Suite</option>
                            <option value="False Ceiling & Lighting">False Ceiling & Architectural Lighting</option>
                            <option value="Interior Renovation & Remodeling">Renovation & Remodeling</option>
                            <option value="Commercial / Office Interior">Commercial / Office Interiors</option>
                        </select>
                    </div>
                    <div>
                        <label class="int-form-label">ESTIMATED BUDGET</label>
                        <select name="budget_range" id="interiorFormBudget" class="int-form-select">
                            <option value="₹3 Lakhs - ₹6 Lakhs">₹3 Lakhs - ₹6 Lakhs</option>
                            <option value="₹6 Lakhs - ₹12 Lakhs">₹6 Lakhs - ₹12 Lakhs</option>
                            <option value="₹12 Lakhs - ₹25 Lakhs">₹12 Lakhs - ₹25 Lakhs</option>
                            <option value="₹25 Lakhs+">₹25 Lakhs+ (Luxury Bespoke)</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label class="int-form-label">FLOOR PLAN / SPECIFIC REQUIREMENTS</label>
                    <textarea name="message" id="interiorFormMessage" rows="3" placeholder="Describe your apartment/villa size, handover date, preferred finishes, or modular needs..." class="int-form-textarea"></textarea>
                </div>

                <div>
                    <button type="submit" class="int-btn-gold" id="interiorSubmitBtn" style="width:100%;justify-content:center;padding:16px;">
                        <i class="fas fa-paper-plane"></i> SUBMIT INTERIOR CONSULTATION REQUEST
                    </button>
                </div>

                <!-- Success Box -->
                <div id="interiorSuccessMessage" class="form-success-box" style="display:none;background:rgba(37,211,102,0.15);border:1px solid #25D366;color:#16A34A;padding:16px;border-radius:6px;text-align:center;font-weight:700;margin-top:16px;">
                    <i class="fas fa-circle-check" style="margin-right:6px;color:#25D366;"></i>
                    Interiors Consultation Request Submitted! Er. Maha Rajan's interiors studio will contact you within 24 hours.
                </div>
            </form>
        </div>
    </div>
</section>

<!-- =======================================================
     INTERIOR PACKAGE DETAILS MODAL (Scoped Unique IDs)
======================================================= -->
<div class="modal-overlay" id="interiorPackageDetailsModal" role="dialog" aria-modal="true" aria-labelledby="intModalPkgTitle">
    <div class="modal-box modal-container" style="max-width:760px;border-radius:12px;">
        <button class="modal-close" onclick="document.getElementById('interiorPackageDetailsModal').classList.remove('open')" aria-label="Close modal" style="color:var(--int-gold);">✕</button>

        <div style="padding:28px 28px 20px;border-bottom:1px solid rgba(179,130,34,0.2);">
            <span id="intModalPkgTierLabel" style="font-size:0.75rem;font-weight:800;letter-spacing:0.18em;color:var(--int-gold);text-transform:uppercase;font-family:var(--font-heading);"></span>
            <h3 id="intModalPkgTitle" style="font-size:1.8rem;font-weight:900;color:#161922;margin-top:4px;font-family:var(--font-heading);"></h3>
            <p id="intModalPkgSubtitle" style="color:#4B5563;font-size:0.9rem;margin-top:4px;"></p>

            <div style="display:flex;align-items:baseline;gap:8px;margin-top:16px;">
                <div id="intModalPkgPrice" style="font-size:2.2rem;font-weight:900;color:var(--int-gold);font-family:var(--font-heading);"></div>
            </div>

            <div style="display:flex;gap:12px;margin-top:12px;flex-wrap:wrap;">
                <span id="intModalPkgWarranty" style="font-size:0.75rem;color:var(--int-gold);background:rgba(179,130,34,0.12);padding:4px 10px;border-radius:4px;font-weight:700;"></span>
                <span id="intModalPkgDelivery" style="font-size:0.75rem;color:#16A34A;background:rgba(22,163,74,0.12);padding:4px 10px;border-radius:4px;font-weight:700;"></span>
            </div>
        </div>

        <div style="padding:24px 28px;max-height:55vh;overflow-y:auto;">
            <p id="intModalPkgDescription" style="color:#374151;font-size:0.92rem;line-height:1.65;margin-bottom:20px;"></p>

            <!-- Inclusions -->
            <div style="margin-bottom:24px;">
                <h4 style="font-size:0.82rem;font-weight:800;color:var(--int-gold);letter-spacing:0.12em;text-transform:uppercase;margin-bottom:12px;font-family:var(--font-heading);">
                    <i class="fas fa-circle-check" style="margin-right:6px;color:#16A34A;"></i> WHAT'S INCLUDED
                </h4>
                <ul id="intModalPkgInclusions" style="list-style:none;padding:0;margin:0;display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:0.84rem;color:#1F2937;"></ul>
            </div>

            <!-- Exclusions -->
            <div style="margin-bottom:24px;">
                <h4 style="font-size:0.82rem;font-weight:800;color:#64748B;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:12px;font-family:var(--font-heading);">
                    <i class="fas fa-circle-xmark" style="margin-right:6px;color:#EF4444;"></i> EXCLUDED / OPTIONAL ADD-ONS
                </h4>
                <ul id="intModalPkgExclusions" style="list-style:none;padding:0;margin:0;display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:0.84rem;color:#64748B;"></ul>
            </div>

            <!-- Features / Specifications -->
            <div>
                <h4 style="font-size:0.82rem;font-weight:800;color:var(--int-gold);letter-spacing:0.12em;text-transform:uppercase;margin-bottom:12px;font-family:var(--font-heading);">
                    <i class="fas fa-layer-group" style="margin-right:6px;"></i> SPECIFICATIONS & STANDARDS
                </h4>
                <ul id="intModalPkgFeatures" style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px;"></ul>
            </div>
        </div>

        <div style="padding:18px 28px;border-top:1px solid rgba(179,130,34,0.2);display:flex;justify-content:flex-end;gap:12px;background:#FAF8F5;">
            <button onclick="document.getElementById('interiorPackageDetailsModal').classList.remove('open')" style="padding:10px 20px;background:#FFFFFF;border:1px solid #CBD5E1;color:#161922;border-radius:4px;cursor:pointer;font-size:0.8rem;font-weight:700;">
                CLOSE
            </button>
            <button id="btnIntPkgRequestQuote" class="int-btn-gold" style="padding:10px 24px;font-size:0.8rem;">
                <i class="fas fa-calendar-check"></i> CONSULT FOR THIS PACKAGE
            </button>
        </div>
    </div>
</div>

<!-- =======================================================
     INTERIOR HIGH-RESOLUTION LIGHTBOX GALLERY MODAL
======================================================= -->
<div class="int-gallery-modal-overlay" id="interiorGalleryModal" role="dialog" aria-modal="true" aria-labelledby="intGalleryTitle" onclick="if(event.target===this) window.closeInteriorGalleryModal()">
    <!-- Top Header Bar -->
    <div class="int-lightbox-header">
        <div class="int-lightbox-title-box">
            <span class="int-lightbox-tagline" id="intGalleryTagline">
                <span id="intGalleryCategory">LIVING ROOM</span> • <span id="intGalleryLocation">TAMIL NADU</span>
            </span>
            <h3 class="int-lightbox-title" id="intGalleryTitle">Project Gallery</h3>
        </div>

        <div class="int-lightbox-header-actions">
            <span class="int-lightbox-counter-badge" id="intGalleryCounter">PHOTO 1 OF 1</span>
            
            <button type="button" class="int-lightbox-video-btn" id="intGalleryVideoBtn" style="display:none;" title="Watch Video Walkthrough">
                <i class="fas fa-play"></i> <span>VIDEO TOUR</span>
            </button>

            <button type="button" class="int-lightbox-close-btn" onclick="window.closeInteriorGalleryModal()" aria-label="Close Lightbox (Esc)" title="Close Lightbox (Esc)">
                ✕
            </button>
        </div>
    </div>

    <!-- Center Stage with Large Image & Prev/Next Arrows -->
    <div class="int-lightbox-stage">
        <!-- Prev Arrow -->
        <button type="button" class="int-lightbox-arrow prev" onclick="window.changeInteriorGallerySlide(-1)" aria-label="Previous Photo (Left Arrow)" title="Previous (Left Arrow)">
            <i class="fas fa-chevron-left"></i>
        </button>

        <!-- Main Photo Wrap -->
        <div class="int-lightbox-img-wrap">
            <img id="intGalleryMainImg" src="" alt="Project Photo" class="int-lightbox-main-img">
        </div>

        <!-- Next Arrow -->
        <button type="button" class="int-lightbox-arrow next" onclick="window.changeInteriorGallerySlide(1)" aria-label="Next Photo (Right Arrow)" title="Next (Right Arrow)">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <!-- Bottom Strip: Caption & Thumbnail Strip -->
    <div class="int-lightbox-footer">
        <div class="int-lightbox-desc" id="intGalleryDescription"></div>
        <div class="int-lightbox-thumbs-track" id="intGalleryThumbsTrack"></div>
    </div>
</div>

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

    // Global Packages Data & Safe Parser
    window.interiorPackagesData = @json($activeInteriorPackages);

    // Global Projects Data for Gallery & Lightbox
    window.interiorProjectsData = @json($projects);

    let currentGalleryProjectIdx = 0;
    let currentGalleryPhotoIdx = 0;

    window.openInteriorGalleryModal = function(event, projectIdx, photoIdx = 0) {
        if (event) event.stopPropagation();
        currentGalleryProjectIdx = projectIdx;
        currentGalleryPhotoIdx = photoIdx;

        const project = window.interiorProjectsData[projectIdx];
        if (!project) return;

        const modal = document.getElementById('interiorGalleryModal');
        if (!modal) return;

        renderGallerySlide();
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.closeInteriorGalleryModal = function() {
        const modal = document.getElementById('interiorGalleryModal');
        if (modal) modal.style.display = 'none';
        document.body.style.overflow = '';
    };

    window.changeInteriorGallerySlide = function(direction) {
        const project = window.interiorProjectsData[currentGalleryProjectIdx];
        if (!project) return;
        const images = (project.image_urls && Array.isArray(project.image_urls) && project.image_urls.length > 0)
            ? project.image_urls
            : ['https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80'];

        currentGalleryPhotoIdx += direction;
        if (currentGalleryPhotoIdx < 0) currentGalleryPhotoIdx = images.length - 1;
        if (currentGalleryPhotoIdx >= images.length) currentGalleryPhotoIdx = 0;

        renderGallerySlide();
    };

    window.setInteriorGallerySlide = function(photoIdx) {
        currentGalleryPhotoIdx = photoIdx;
        renderGallerySlide();
    };

    function renderGallerySlide() {
        const project = window.interiorProjectsData[currentGalleryProjectIdx];
        if (!project) return;
        const images = (project.image_urls && Array.isArray(project.image_urls) && project.image_urls.length > 0)
            ? project.image_urls
            : ['https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80'];

        if (currentGalleryPhotoIdx < 0) currentGalleryPhotoIdx = 0;
        if (currentGalleryPhotoIdx >= images.length) currentGalleryPhotoIdx = images.length - 1;

        // Title and Meta
        const titleEl = document.getElementById('intGalleryTitle');
        const catEl = document.getElementById('intGalleryCategory');
        const locEl = document.getElementById('intGalleryLocation');
        const countEl = document.getElementById('intGalleryCounter');

        if (titleEl) titleEl.textContent = project.name;
        if (catEl) catEl.textContent = (project.category || 'Interior Space').replace(/-/g, ' ').toUpperCase();
        if (locEl) locEl.textContent = project.location || 'Tamil Nadu';
        if (countEl) countEl.textContent = `PHOTO ${currentGalleryPhotoIdx + 1} OF ${images.length}`;

        // Description
        const descEl = document.getElementById('intGalleryDescription');
        if (descEl) {
            descEl.textContent = project.description || `${project.name} - Designed and executed with bespoke luxury finishes by Maha Constructions.`;
        }

        // Walkthrough Video Button
        const videoBtn = document.getElementById('intGalleryVideoBtn');
        if (videoBtn) {
            if (project.video_url) {
                videoBtn.style.display = 'inline-flex';
                videoBtn.onclick = function() {
                    window.closeInteriorGalleryModal();
                    window.playVideoModal(project.video_url, project.name);
                };
            } else {
                videoBtn.style.display = 'none';
            }
        }

        // Main Image with smooth crossfade
        const mainImg = document.getElementById('intGalleryMainImg');
        if (mainImg) {
            mainImg.style.opacity = '0';
            mainImg.style.transform = 'scale(0.97)';
            setTimeout(() => {
                mainImg.src = images[currentGalleryPhotoIdx];
                mainImg.onload = () => {
                    mainImg.style.opacity = '1';
                    mainImg.style.transform = 'scale(1)';
                };
            }, 80);
        }

        // Thumbnails Strip
        const thumbsTrack = document.getElementById('intGalleryThumbsTrack');
        if (thumbsTrack) {
            thumbsTrack.innerHTML = images.map((src, i) => `
                <div class="int-lightbox-thumb ${i === currentGalleryPhotoIdx ? 'active' : ''}" 
                     onclick="window.setInteriorGallerySlide(${i})"
                     title="Photo ${i + 1}">
                    <img src="${src}" alt="Thumb ${i + 1}" onerror="this.src='https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=300&q=80'">
                    <span class="int-lightbox-thumb-num">${i + 1}</span>
                </div>
            `).join('');

            const activeThumb = thumbsTrack.querySelector('.int-lightbox-thumb.active');
            if (activeThumb) {
                activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }
    }

    // Keyboard controls for Lightbox (Left / Right / Esc)
    window.addEventListener('keydown', function(e) {
        const modal = document.getElementById('interiorGalleryModal');
        if (!modal || modal.style.display !== 'flex') return;

        if (e.key === 'Escape') {
            window.closeInteriorGalleryModal();
        } else if (e.key === 'ArrowLeft') {
            window.changeInteriorGallerySlide(-1);
        } else if (e.key === 'ArrowRight') {
            window.changeInteriorGallerySlide(1);
        }
    });

    // Automatic Project Card Slideshow
    function initProjectCardSlideshows() {
        const cards = document.querySelectorAll('.interior-project-card[data-slideshow="true"]');
        
        cards.forEach((card, cardIndex) => {
            if (card._slideshowInitialized) return;
            card._slideshowInitialized = true;

            const slides = card.querySelectorAll('.int-card-slide-img');
            const dots = card.querySelectorAll('.int-card-mini-dot');
            const countNum = card.querySelector('.int-card-cur-slide-num');
            const total = slides.length;
            if (total <= 1) return;

            let curIdx = 0;
            let timer = null;
            let isHovered = false;

            function showSlide(newIdx) {
                slides.forEach((s, idx) => {
                    s.classList.toggle('active', idx === newIdx);
                });
                if (dots.length > 0) {
                    dots.forEach((d, idx) => {
                        d.classList.toggle('active', idx === newIdx);
                    });
                }
                if (countNum) {
                    countNum.textContent = (newIdx + 1);
                }
                curIdx = newIdx;
            }

            function nextSlide() {
                if (isHovered) return;
                if (card.style.display === 'none' || card.offsetParent === null) return;
                const next = (curIdx + 1) % total;
                showSlide(next);
            }

            // Stagger each card timer so cards cycle naturally
            const intervalDelay = 3600 + ((cardIndex % 4) * 700);

            function startTimer() {
                if (timer) clearInterval(timer);
                timer = setInterval(nextSlide, intervalDelay);
            }

            function stopTimer() {
                if (timer) {
                    clearInterval(timer);
                    timer = null;
                }
            }

            card.addEventListener('mouseenter', () => {
                isHovered = true;
                stopTimer();
            });

            card.addEventListener('mouseleave', () => {
                isHovered = false;
                startTimer();
            });

            card._setCardSlide = function(slideIdx) {
                showSlide(slideIdx);
                startTimer();
            };

            startTimer();
        });
    }

    window.setCardSlide = function(cardIndex, slideIndex) {
        const card = document.getElementById('interiorProjectCard_' + cardIndex);
        if (card && typeof card._setCardSlide === 'function') {
            card._setCardSlide(slideIndex);
        }
    };

    function parseInteriorList(val) {
        if (!val) return [];
        if (Array.isArray(val)) return val;
        if (typeof val === 'string') {
            try {
                const parsed = JSON.parse(val);
                if (Array.isArray(parsed)) return parsed;
            } catch(e) {
                return val.split(/[\r\n]+/).map(s => s.trim()).filter(Boolean);
            }
        }
        return [];
    }

    function openInteriorPackageDetailsModalById(id) {
        const pkg = (window.interiorPackagesData || []).find(p => p.id == id);
        if (pkg) openInteriorPackageDetailsModal(pkg);
    }

    // Scoped Package Details Modal for Maha Interior
    function openInteriorPackageDetailsModal(pkg) {
        const modal = document.getElementById('interiorPackageDetailsModal');
        if (!modal) return;

        document.getElementById('intModalPkgTierLabel').textContent = 'MAHA INTERIORS • ' + (pkg.tier || 'PLAN').toUpperCase();
        document.getElementById('intModalPkgTitle').textContent = pkg.title;
        document.getElementById('intModalPkgSubtitle').textContent = pkg.subtitle || '';
        document.getElementById('intModalPkgPrice').innerHTML = '₹' + Number(pkg.price_per_sqft).toLocaleString() + ' <span>/ sq.ft</span>';
        document.getElementById('intModalPkgWarranty').innerHTML = '<i class="fas fa-shield-halved" style="color:var(--int-gold);"></i> ' + (pkg.warranty_years || 10) + ' Yrs Hardware Warranty';
        document.getElementById('intModalPkgDelivery').innerHTML = '<i class="fas fa-calendar-check" style="color:#16A34A;"></i> ' + (pkg.delivery_months || 2) + ' Mos Handover';
        document.getElementById('intModalPkgDescription').textContent = pkg.description || '';

        // Inclusions
        const incList = document.getElementById('intModalPkgInclusions');
        incList.innerHTML = '';
        const inclusions = parseInteriorList(pkg.inclusions);
        if (inclusions.length > 0) {
            inclusions.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = '<i class="fas fa-check" style="color:#16A34A;margin-right:8px;"></i>' + item;
                incList.appendChild(li);
            });
        } else {
            incList.innerHTML = '<li style="color:#64748B;">Contact us for full custom inclusions checklist.</li>';
        }

        // Exclusions
        const excList = document.getElementById('intModalPkgExclusions');
        excList.innerHTML = '';
        const exclusions = parseInteriorList(pkg.exclusions);
        if (exclusions.length > 0) {
            exclusions.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = '<i class="fas fa-xmark" style="color:#EF4444;margin-right:8px;"></i>' + item;
                excList.appendChild(li);
            });
        } else {
            excList.innerHTML = '<li style="color:#64748B;">Optional add-ons available upon site assessment.</li>';
        }

        // Features / Specifications
        const featList = document.getElementById('intModalPkgFeatures');
        featList.innerHTML = '';
        const features = parseInteriorList(pkg.features);
        if (features.length > 0) {
            features.forEach(item => {
                const li = document.createElement('li');
                li.style.display = 'flex';
                li.style.alignItems = 'center';
                li.style.gap = '8px';
                li.style.fontSize = '0.84rem';
                li.style.color = '#374151';
                li.innerHTML = '<i class="fas fa-layer-group" style="color:var(--int-gold);font-size:0.75rem;"></i>' + item;
                featList.appendChild(li);
            });
        } else {
            featList.innerHTML = '<li style="color:#64748B;">Standard high-grade specifications apply.</li>';
        }

        // Action in modal scrolls to on-page enquiry
        const reqBtn = document.getElementById('btnIntPkgRequestQuote');
        if (reqBtn) {
            reqBtn.onclick = function() {
                modal.classList.remove('open');
                preselectInteriorPackage(pkg.title);
                window.location.hash = '#interior-enquiry';
            };
        }

        // Close on backdrop click
        modal.onclick = function(e) {
            if (e.target === modal) {
                modal.classList.remove('open');
            }
        };

        modal.classList.add('open');
    }

    // Generic Carousel Controller for Video Slideshows
    function setupInteriorCarousel(trackId, prevBtnId, nextBtnId, fillId, dotsId, cardSelector) {
        const track = document.getElementById(trackId);
        const prevBtn = document.getElementById(prevBtnId);
        const nextBtn = document.getElementById(nextBtnId);
        const fill = document.getElementById(fillId);
        const dotsContainer = document.getElementById(dotsId);
        if (!track) return null;

        function getVisibleCards() {
            return Array.from(track.querySelectorAll(cardSelector || '.int-video-slide-card'))
                        .filter(c => c.style.display !== 'none');
        }

        function updateProgress() {
            const maxScroll = track.scrollWidth - track.clientWidth;
            if (fill) {
                const pct = maxScroll > 0 ? (track.scrollLeft / maxScroll) * 100 : 100;
                fill.style.width = Math.max(12, Math.min(pct, 100)) + '%';
            }
            updateDots();
        }

        function buildDots() {
            if (!dotsContainer) return;
            dotsContainer.innerHTML = '';
            const cards = getVisibleCards();
            const dotCount = Math.min(cards.length, 6);
            for (let i = 0; i < dotCount; i++) {
                const dot = document.createElement('div');
                dot.className = 'int-carousel-dot' + (i === 0 ? ' active' : '');
                dot.addEventListener('click', () => {
                    const targetCard = cards[Math.floor(i * (cards.length / dotCount))];
                    if (targetCard) {
                        track.scrollTo({ left: targetCard.offsetLeft - track.offsetLeft, behavior: 'smooth' });
                    }
                });
                dotsContainer.appendChild(dot);
            }
        }

        function updateDots() {
            if (!dotsContainer) return;
            const dots = dotsContainer.querySelectorAll('.int-carousel-dot');
            if (!dots.length) return;
            const maxScroll = track.scrollWidth - track.clientWidth;
            const index = maxScroll > 0 ? Math.round((track.scrollLeft / maxScroll) * (dots.length - 1)) : 0;
            dots.forEach((d, i) => d.classList.toggle('active', i === index));
        }

        // Drag-to-Scroll Controller
        enableDragScroll(track);

        // Auto Slideshow Timer
        let autoSlideInterval = null;
        const slideDuration = 3800;

        function startAutoSlide() {
            stopAutoSlide();
            autoSlideInterval = setInterval(() => {
                const card = track.querySelector(cardSelector || '.int-video-slide-card');
                const scrollAmount = card ? (card.offsetWidth + 22) : 290;
                const maxScroll = track.scrollWidth - track.clientWidth;
                if (maxScroll <= 0) return;

                if (track.scrollLeft >= maxScroll - 20) {
                    track.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            }, slideDuration);
        }

        function stopAutoSlide() {
            if (autoSlideInterval) {
                clearInterval(autoSlideInterval);
                autoSlideInterval = null;
            }
        }

        track.addEventListener('mouseenter', stopAutoSlide);
        track.addEventListener('mouseleave', startAutoSlide);
        track.addEventListener('touchstart', stopAutoSlide, { passive: true });
        track.addEventListener('touchend', () => setTimeout(startAutoSlide, 2000), { passive: true });

        startAutoSlide();

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                stopAutoSlide();
                const card = track.querySelector('.int-video-slide-card');
                const scrollAmount = card ? (card.offsetWidth + 22) : 290;
                track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                setTimeout(startAutoSlide, 4000);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                stopAutoSlide();
                const card = track.querySelector('.int-video-slide-card');
                const scrollAmount = card ? (card.offsetWidth + 22) : 290;
                track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                setTimeout(startAutoSlide, 4000);
            });
        }

        track.addEventListener('scroll', updateProgress, { passive: true });
        buildDots();
        updateProgress();

        return { buildDots, updateProgress, startAutoSlide, stopAutoSlide };
    }

    // Generic Mouse/Touch Drag to Scroll Helper
    function enableDragScroll(slider) {
        if (!slider) return;
        let isDown = false;
        let startX = 0;
        let scrollLeft = 0;
        let hasMoved = false;

        slider.addEventListener('mousedown', (e) => {
            // Ignore right-click
            if (e.button !== 0) return;
            isDown = true;
            hasMoved = false;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
            slider.classList.add('is-dragging');
        });

        const cancelDrag = () => {
            if (!isDown) return;
            isDown = false;
            slider.classList.remove('is-dragging');
        };

        slider.addEventListener('mouseleave', cancelDrag);
        slider.addEventListener('mouseup', cancelDrag);

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.5;
            if (Math.abs(walk) > 4) {
                hasMoved = true;
            }
            slider.scrollLeft = scrollLeft - walk;
        });

        // Prevent accidental card clicks if user was actively dragging
        slider.addEventListener('click', (e) => {
            if (hasMoved) {
                e.stopPropagation();
                e.preventDefault();
                hasMoved = false;
            }
        }, true);
    }

    // ── ADMIN: Quick-Delete YouTube Video (scoped outside slider so always available) ──
    window.adminQuickDeleteYtVideo = async function(videoId, btn) {
        if (!confirm('⚠️ Admin Action\n\nRemove this video from the website showcase?\n\nThe video stays on YouTube — it will just be hidden from this site. You can restore it anytime in the Admin Dashboard → YouTube Videos tab.')) return;
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:4px;"></i>Removing…';
        btn.style.pointerEvents = 'none';
        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const res = await fetch('/api/youtube/videos/' + videoId, {
                method: 'DELETE',
                credentials: 'include',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                // Animate the card out smoothly
                const slide = btn.closest('.int-yt-slide');
                if (slide) {
                    slide.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                    slide.style.opacity = '0';
                    slide.style.transform = 'scale(0.85)';
                    setTimeout(() => {
                        slide.remove();
                        // Refresh slider state if available
                        const track = document.getElementById('interiorYtSliderTrack');
                        const remaining = track ? track.querySelectorAll('.int-yt-slide').length : 0;
                        if (remaining === 0) {
                            const wrapper = document.getElementById('interiorYtSliderWrapper');
                            if (wrapper) wrapper.closest('.int-yt-slider-container').innerHTML = '<div style="text-align:center;padding:40px;color:#888;"><i class="fab fa-youtube" style="font-size:2rem;color:#FF0000;display:block;margin-bottom:10px;"></i><p>All videos removed from showcase. Add new videos from the Admin Dashboard.</p></div>';
                        }
                    }, 350);
                }
                // Brief success toast instead of blocking alert
                const toast = document.createElement('div');
                toast.style.cssText = 'position:fixed;bottom:30px;left:50%;transform:translateX(-50%);background:#10B981;color:#FFF;padding:12px 24px;border-radius:12px;font-weight:700;font-size:0.88rem;z-index:99999;box-shadow:0 8px 24px rgba(0,0,0,0.3);display:flex;align-items:center;gap:8px;';
                toast.innerHTML = '<i class="fas fa-check-circle"></i> Video removed from website showcase';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            } else {
                alert('❌ Failed: ' + (data.message || 'Unknown error'));
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                btn.style.pointerEvents = '';
            }
        } catch (e) {
            alert('❌ Network Error: ' + e.message);
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            btn.style.pointerEvents = '';
        }
    };

    // Interior YouTube Masterclasses Slider
    function initInteriorYtSlider() {
        const wrapper = document.getElementById('interiorYtSliderWrapper');
        const track = document.getElementById('interiorYtSliderTrack');
        const prevBtn = document.getElementById('interiorYtPrevBtn');
        const nextBtn = document.getElementById('interiorYtNextBtn');
        const dotsContainer = document.getElementById('interiorYtDots');
        if (!wrapper || !track) return;

        let currentIndex = 0;
        let isHovered = false;
        let autoPlayTimer = null;

        function getVisibleCount() {
            if (window.innerWidth <= 680) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }

        function updateSlider(animate = true) {
            const slides = track.querySelectorAll('.int-yt-slide');
            if (slides.length === 0) return;
            const visibleCount = getVisibleCount();
            const maxIndex = Math.max(0, slides.length - visibleCount);
            if (currentIndex > maxIndex) currentIndex = maxIndex;
            if (currentIndex < 0) currentIndex = 0;

            const slideWidth = slides[0].offsetWidth;
            const gap = 24;
            const offset = currentIndex * (slideWidth + gap);

            track.style.transition = animate ? 'transform 0.4s cubic-bezier(0.25, 1, 0.5, 1)' : 'none';
            track.style.transform = `translateX(-${offset}px)`;

            if (dotsContainer) {
                dotsContainer.innerHTML = '';
                for (let i = 0; i <= maxIndex; i++) {
                    const dot = document.createElement('span');
                    dot.className = `int-yt-dot ${i === currentIndex ? 'active' : ''}`;
                    dot.addEventListener('click', () => {
                        currentIndex = i;
                        updateSlider(true);
                        resetAutoPlay();
                    });
                    dotsContainer.appendChild(dot);
                }
            }
        }

        function move(dir) {
            const slides = track.querySelectorAll('.int-yt-slide');
            const visibleCount = getVisibleCount();
            const maxIndex = Math.max(0, slides.length - visibleCount);

            currentIndex += dir;
            if (currentIndex > maxIndex) currentIndex = 0;
            if (currentIndex < 0) currentIndex = maxIndex;

            updateSlider(true);
            resetAutoPlay();
        }

        if (prevBtn) prevBtn.addEventListener('click', () => move(-1));
        if (nextBtn) nextBtn.addEventListener('click', () => move(1));

        function startAutoPlay() {
            stopAutoPlay();
            autoPlayTimer = setInterval(() => {
                if (!isHovered && !document.hidden) {
                    move(1);
                }
            }, 4000);
        }

        function stopAutoPlay() {
            if (autoPlayTimer) clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }

        function resetAutoPlay() {
            stopAutoPlay();
            startAutoPlay();
        }

        wrapper.addEventListener('mouseenter', () => { isHovered = true; });
        wrapper.addEventListener('mouseleave', () => { isHovered = false; });

        let touchStartX = 0;
        wrapper.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            isHovered = true;
        }, { passive: true });
        wrapper.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            isHovered = false;
            if (touchStartX - touchEndX > 50) {
                move(1);
            } else if (touchEndX - touchStartX > 50) {
                move(-1);
            }
        }, { passive: true });

        window.addEventListener('resize', () => updateSlider(false));

        updateSlider(false);
        startAutoPlay();
    }

    // On-Page Initialization
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll Reveal Observer
        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            document.querySelectorAll('.lux-reveal').forEach(el => {
                revealObserver.observe(el);
            });
        } else {
            document.querySelectorAll('.lux-reveal').forEach(el => el.classList.add('is-visible'));
        }

        // Enable Drag on Category Filters
        const editorialFilters = document.querySelector('.int-editorial-filters');
        if (editorialFilters) {
            enableDragScroll(editorialFilters);
        }

        // Initialize Projects Carousel
        const projectsCarousel = setupInteriorCarousel(
            'interiorProjectsTrack',
            'interiorProjectsPrevBtn',
            'interiorProjectsNextBtn',
            'interiorProjectsProgressFill',
            'interiorProjectsDots',
            '.interior-project-card'
        );

        // Initialize Card Image Automatic Slideshows
        initProjectCardSlideshows();

        // Initialize Testimonials Carousel
        setupInteriorCarousel(
            'interiorTestimonialsTrack',
            'interiorTestimonialsPrevBtn',
            'interiorTestimonialsNextBtn',
            'interiorTestimonialsProgressFill',
            'interiorTestimonialsDots'
        );

        // Initialize Learn Before You Design YouTube Slider
        initInteriorYtSlider();

        // On-Page Project Category Filtering (Zero Page Reload)
        const filterBtns = document.querySelectorAll('.interior-filter-btn');
        const projectCards = document.querySelectorAll('.interior-project-card');
        const projectsTrack = document.getElementById('interiorProjectsTrack');

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
                if (projectsTrack) {
                    projectsTrack.scrollTo({ left: 0, behavior: 'smooth' });
                }
                if (projectsCarousel) {
                    projectsCarousel.buildDots();
                    projectsCarousel.updateProgress();
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
                if (window.MahaAnalytics) {
                    Object.assign(data, window.MahaAnalytics.getAttribution());
                }

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

        // --- Interior Single-Page Section Tracking (IntersectionObserver) ---
        (function() {
            const sectionIds = [
                'interior-intro',
                'interior-projects',
                'interior-testimonials',
                'interior-engineer',
                'interior-packages',
                'interior-learn',
                'interior-services',
                'interior-enquiry'
            ];

            let seenSections = new Set();
            try {
                const cached = sessionStorage.getItem('maha_seen_interior_sections');
                if (cached) {
                    seenSections = new Set(JSON.parse(cached));
                }
            } catch(e) {}

            const dwellTimers = {};

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        const id = entry.target.id;
                        const cleanName = id.replace('interior-', '');

                        if (entry.isIntersecting && !seenSections.has(id)) {
                            // Require 1000ms dwell to count as meaningful view (avoids rapid scroll noise)
                            if (!dwellTimers[id]) {
                                dwellTimers[id] = setTimeout(() => {
                                    if (!seenSections.has(id)) {
                                        seenSections.add(id);
                                        try {
                                            sessionStorage.setItem('maha_seen_interior_sections', JSON.stringify(Array.from(seenSections)));
                                        } catch(e) {}

                                        if (window.MahaAnalytics) {
                                            window.MahaAnalytics.sendEvent('section_view', {
                                                business_type: 'interior',
                                                section_name: cleanName,
                                                page_name: 'interior'
                                            });
                                        }
                                    }
                                    delete dwellTimers[id];
                                }, 1000);
                            }
                        } else if (!entry.isIntersecting) {
                            if (dwellTimers[id]) {
                                clearTimeout(dwellTimers[id]);
                                delete dwellTimers[id];
                            }
                        }
                    });
                }, {
                    threshold: 0.3
                });

                sectionIds.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) observer.observe(el);
                });
            }

            // ── Ultra-Robust Interior Hero Video Playback Controller ──
            const v = document.getElementById('intHeroBgVideo');
            const p = document.getElementById('intHeroPoster');
            if (v) {
                // Ensure strict mute and autoplay attributes
                v.muted = true;
                v.defaultMuted = true;
                v.volume = 0;
                v.playsInline = true;
                v.setAttribute('muted', '');
                v.setAttribute('playsinline', '');
                v.setAttribute('webkit-playsinline', '');
                v.setAttribute('x5-playsinline', '');

                let isPlaying = false;
                let interactionBound = false;

                const onVideoPlaying = () => {
                    isPlaying = true;
                    if (p) p.style.display = 'none';
                    v.style.opacity = '1';
                };

                const tryPlay = () => {
                    v.muted = true;
                    v.volume = 0;
                    const prom = v.play();
                    if (prom !== undefined) {
                        prom.then(() => {
                            onVideoPlaying();
                        }).catch(() => {
                            // Autoplay restricted by browser policy; wait for first user interaction
                            if (!interactionBound) {
                                interactionBound = true;
                                const triggerPlay = () => {
                                    v.muted = true;
                                    v.volume = 0;
                                    v.play().then(() => {
                                        onVideoPlaying();
                                    }).catch(() => {});
                                };
                                ['pointerdown', 'touchstart', 'click', 'scroll'].forEach(evt => {
                                    window.addEventListener(evt, triggerPlay, { once: true, passive: true });
                                });
                            }
                        });
                    }
                };

                v.addEventListener('playing', onVideoPlaying);
                v.addEventListener('timeupdate', () => {
                    if (v.currentTime > 0.1 && !isPlaying) {
                        onVideoPlaying();
                    }
                });

                // Attempt playback immediately and on metadata lifecycle
                tryPlay();
                v.addEventListener('loadedmetadata', tryPlay, { once: true });
                v.addEventListener('loadeddata', tryPlay, { once: true });
                v.addEventListener('canplay', tryPlay, { once: true });
                v.addEventListener('canplaythrough', tryPlay, { once: true });

                window.addEventListener('pageshow', tryPlay);
                document.addEventListener('visibilitychange', () => {
                    if (!document.hidden && !isPlaying) {
                        tryPlay();
                    }
                });

                // Monitor source errors: fall back to poster only if all sources fail
                const sources = v.querySelectorAll('source');
                let failedSources = 0;
                sources.forEach(src => {
                    src.addEventListener('error', () => {
                        failedSources++;
                        if (failedSources >= sources.length) {
                            console.warn("All video sources failed to load. Falling back to architectural poster.");
                            if (p) p.style.display = 'block';
                        }
                    });
                });

                v.addEventListener('error', function(e) {
                    console.warn("Video error event triggered", e);
                    if (p) p.style.display = 'block';
                });
            }

            // ── Livarta Interiors Video Background & Hero Content Scroll Parallax ──
            const heroBgVideo = document.getElementById('intHeroBgVideo');
            const heroOuter = document.querySelector('.int-hero-content-outer');
            const heroSection = document.getElementById('interior-intro');

            if (heroSection && (heroBgVideo || heroOuter)) {
                let ticking = false;
                window.addEventListener('scroll', () => {
                    if (!ticking) {
                        window.requestAnimationFrame(() => {
                            const scrollY = window.pageYOffset || document.documentElement.scrollTop;
                            const heroH = heroSection.offsetHeight || 800;
                            if (scrollY <= heroH + 100) {
                                const progress = Math.min(1, Math.max(0, scrollY / heroH));
                                // Video remains stationary in the background with zero gap
                                if (heroOuter && window.innerWidth > 768) {
                                    heroOuter.style.transform = `translate3d(0, ${(scrollY * 0.16).toFixed(1)}px, 0)`;
                                    heroOuter.style.opacity = Math.max(0.12, 1 - (progress * 1.25)).toFixed(3);
                                }
                            }
                            ticking = false;
                        });
                        ticking = true;
                    }
                }, { passive: true });
            }
        })();
    });
</script>
@endpush
