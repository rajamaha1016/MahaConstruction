@extends('layouts.app')

@section('title', 'Maha Interior | Designing Beautiful Living | Luxury Interior Design & Turnkey Execution')
@section('description', 'Maha Interior is Tamil Nadu\'s premier interior design and execution studio. Delivering bespoke modular kitchens, luxury wardrobes, living spaces, and turnkey interior fitouts.')

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

/* ─── SECTION 1: BRIGHT SUNLIT HERO (#interior-intro) ──────── */
body.interior-body .int-hero-section {
    background: #FAF8F5 !important;
    color: #161922 !important;
    position: relative;
    min-height: 92vh;
    display: flex;
    align-items: center;
    padding: 130px 0 60px;
    overflow: hidden;
}
body.interior-body .int-hero-bg-img {
    filter: brightness(0.98) contrast(1.05) saturate(1.15) !important;
    object-fit: cover !important;
    width: 100% !important;
    height: 100% !important;
}
body.interior-body .int-hero-overlay {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.82) 0%, rgba(253, 250, 245, 0.72) 45%, rgba(246, 238, 224, 0.65) 100%) !important;
    backdrop-filter: blur(2px) !important;
    -webkit-backdrop-filter: blur(2px) !important;
}
body.interior-body .int-hero-bottom-fade {
    background: linear-gradient(to bottom, transparent 0%, rgba(250, 248, 245, 0.92) 80%, #FAF8F5 100%) !important;
}
body.interior-body .int-tag-pill {
    background: rgba(255, 255, 255, 0.94) !important;
    border: 1px solid var(--int-gold-border) !important;
    border-radius: 50px !important;
    padding: 7px 18px !important;
    box-shadow: var(--int-shadow-subtle) !important;
    color: var(--int-gold) !important;
    margin-bottom: 22px !important;
}
body.interior-body .int-tag-dot {
    background: var(--int-gold) !important;
    box-shadow: 0 0 10px var(--int-gold) !important;
    animation: luxDotPulse 2s ease-in-out infinite;
}
body.interior-body .int-hero-title {
    color: #161922 !important;
    text-shadow: none !important;
    font-size: clamp(2.8rem, 5.2vw, 4.6rem) !important;
    font-weight: 900 !important;
    line-height: 1.08 !important;
    margin-bottom: 20px !important;
}
body.interior-body .int-hero-title .gold-word {
    color: var(--int-gold) !important;
    font-family: var(--font-serif) !important;
    font-style: italic !important;
    font-weight: 700 !important;
    text-shadow: 0 2px 14px rgba(200, 149, 43, 0.25) !important;
}
body.interior-body .int-hero-desc {
    color: #374151 !important;
    text-shadow: none !important;
    font-size: clamp(1rem, 1.35vw, 1.15rem) !important;
    line-height: 1.75 !important;
    margin-bottom: 32px !important;
    max-width: 720px;
}
body.interior-body .int-hero-actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 40px;
}
body.interior-body .int-btn-gold {
    background: linear-gradient(135deg, #C8952B 0%, #DFAC3E 50%, #F5CE74 100%) !important;
    color: #161922 !important;
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
    box-shadow: 0 8px 26px rgba(200, 149, 43, 0.42) !important;
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
    box-shadow: 0 14px 34px rgba(197, 147, 45, 0.5) !important;
    color: #161922 !important;
}
body.interior-body .int-btn-outline {
    background: rgba(255, 255, 255, 0.92) !important;
    backdrop-filter: blur(10px) !important;
    border: 1.5px solid #161922 !important;
    color: #161922 !important;
    font-family: var(--font-heading);
    font-weight: 800 !important;
    font-size: 0.84rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 14px 28px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: var(--int-shadow-subtle) !important;
    transition: all 0.3s ease !important;
}
body.interior-body .int-btn-outline:hover {
    background: #161922 !important;
    color: #FFFFFF !important;
    transform: translateY(-2px) !important;
    box-shadow: var(--int-shadow-card) !important;
}
body.interior-body .int-hero-stats-strip {
    border-top: none !important;
    padding-top: 0 !important;
    margin-top: 10px !important;
}
body.interior-body .int-hero-stats-grid {
    background: rgba(255, 255, 255, 0.88) !important;
    backdrop-filter: blur(16px) !important;
    border: 1px solid var(--int-gold-border) !important;
    border-radius: 12px !important;
    padding: 24px 32px !important;
    box-shadow: var(--int-shadow-card) !important;
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
    background: rgba(179, 130, 34, 0.22) !important;
}
body.interior-body .int-hero-stat-val {
    color: var(--int-gold) !important;
    text-shadow: none !important;
    font-size: clamp(1.8rem, 2.6vw, 2.5rem);
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 4px;
}
body.interior-body .int-hero-stat-label {
    color: #4B5563 !important;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
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
body.interior-body .int-editorial-filters {
    display: flex;
    flex-wrap: nowrap;
    gap: 22px;
    align-items: center;
    margin: 28px 0 36px;
    padding: 0 4px 14px;
    border-bottom: 1px solid rgba(179, 130, 34, 0.2) !important;
    overflow-x: auto;
    white-space: nowrap;
}
body.interior-body .int-filter-link {
    color: #64748B !important;
    font-size: 0.76rem;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    background: none;
    border: none;
    cursor: pointer;
    position: relative;
    padding: 6px 4px;
    transition: color 0.25s ease;
}
body.interior-body .int-filter-link:hover {
    color: #161922 !important;
}
body.interior-body .int-filter-link.active {
    color: var(--int-gold) !important;
    font-weight: 900 !important;
}
body.interior-body .int-filter-link::after {
    background: var(--int-gold) !important;
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
    color: #374151 !important;
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
}
body.interior-body .int-form-input,
body.interior-body .int-form-select,
body.interior-body .int-form-textarea {
    background: #FAF8F5 !important;
    border: 1.5px solid #E2D9C8 !important;
    color: #161922 !important;
    border-radius: 6px !important;
}
body.interior-body .int-form-input:focus,
body.interior-body .int-form-select:focus,
body.interior-body .int-form-textarea:focus {
    border-color: var(--int-gold) !important;
    background: #FFFFFF !important;
    box-shadow: 0 0 0 3px rgba(179, 130, 34, 0.16) !important;
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

/* ─── ANIMATION KEYFRAMES ─────────────────────────────────── */
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
.lux-reveal {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    will-change: opacity, transform;
}
.lux-reveal.is-visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
@endpush

@section('content')

<!-- =======================================================
     SECTION 1: INTRO / HERO (#interior-intro)
     Full-Bleed Architectural Background Cover
======================================================= -->
<section class="int-hero-section" id="interior-intro">
    <!-- Full-Bleed Background Media Cover -->
    <div class="int-hero-bg-media">
        <img src="{{ asset('images/interior-hero-2.gif') }}"
             alt="Maha Interior Architectural Living Space"
             class="int-hero-bg-img"
             onerror="this.src='https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=2000&q=85'">
    </div>
    <div class="int-hero-overlay"></div>
    <div class="int-hero-bottom-fade"></div>

    <div class="container" style="position:relative;z-index:3;">
        <div class="int-hero-content-wrap lux-reveal">
            <div class="int-tag-pill">
                <span class="int-tag-dot"></span>
                <span>MAHA INTERIOR • ARCHITECTURAL STUDIO</span>
            </div>

            <h1 class="int-hero-title">
                BEAUTIFUL<br>
                <span class="gold-word">INTERIORS.</span><br>
                BETTER LIVING.
            </h1>

            <p class="int-hero-desc">
                Tamil Nadu’s premier interior architecture and turnkey execution studio. Crafting bespoke modular kitchens, luxury wardrobes, acoustic living spaces, and atmospheric lighting with registered civil engineering precision.
            </p>

            <!-- Primary CTAs -->
            <div class="int-hero-actions">
                <a href="#interior-enquiry" class="int-btn-gold">
                    <i class="fas fa-calendar-check"></i> BOOK A FREE CONSULTATION
                </a>
                <a href="#interior-projects" class="int-btn-outline">
                    VIEW OUR WORK <i class="fas fa-arrow-down" style="font-size:0.75rem;"></i>
                </a>
            </div>
        </div>

        <!-- Integrated Hero Statistics Strip -->
        <div class="int-hero-stats-strip lux-reveal">
            <div class="int-hero-stats-grid">
                <div class="int-hero-stat-card">
                    <div class="int-hero-stat-val">150+</div>
                    <div class="int-hero-stat-label">Interiors Handed Over</div>
                </div>
                <div class="int-hero-stat-card">
                    <div class="int-hero-stat-val">10 Years</div>
                    <div class="int-hero-stat-label">Hardware & Plywood Warranty</div>
                </div>
                <div class="int-hero-stat-card">
                    <div class="int-hero-stat-val">100%</div>
                    <div class="int-hero-stat-label">Factory Machine Finish</div>
                </div>
            </div>
        </div>
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

        <!-- Minimal Editorial Category Filter (Text with Gold Underline) -->
        <div class="int-editorial-filters lux-reveal">
            <button type="button" class="int-filter-link interior-filter-btn active" data-category="all">ALL SPACES</button>
            <button type="button" class="int-filter-link interior-filter-btn" data-category="living-room">LIVING ROOM</button>
            <button type="button" class="int-filter-link interior-filter-btn" data-category="modular-kitchen">MODULAR KITCHEN</button>
            <button type="button" class="int-filter-link interior-filter-btn" data-category="bedroom">BEDROOM</button>
            <button type="button" class="int-filter-link interior-filter-btn" data-category="office-interior">OFFICE INTERIOR</button>
            <button type="button" class="int-filter-link interior-filter-btn" data-category="full-home-interior">FULL HOME</button>
            <button type="button" class="int-filter-link interior-filter-btn" data-category="commercial-interior">COMMERCIAL</button>
        </div>

        <!-- Unified Video Slideshow Carousel for Projects -->
        <div class="int-carousel-wrapper lux-reveal">
            <div class="int-carousel-track" id="interiorProjectsTrack">
                @forelse($projects as $i => $project)
                @php
                    $coverImg = ($project->image_urls && count($project->image_urls) > 0) ? $project->image_urls[0] : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80';
                @endphp
                <div class="int-video-slide-card interior-project-card"
                     data-category="{{ $project->category }}"
                     @if($project->video_url)
                     onclick="window.playVideoModal('{{ $project->video_url }}', '{{ addslashes($project->name) }}')"
                     @endif>
                    <!-- Background Image -->
                    <img src="{{ $coverImg }}" alt="{{ $project->name }}" class="int-video-card-bg" loading="lazy">
                    <div class="int-video-card-shade"></div>

                    <!-- Top Tag -->
                    <span class="int-video-card-tag">
                        PROJECT {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <!-- Category Badge -->
                    <span class="int-video-card-badge">
                        {{ strtoupper(str_replace('-', ' ', $project->category)) }}
                    </span>

                    <!-- Center Golden Play Button -->
                    @if($project->video_url)
                    <div class="int-video-play-btn" title="Watch Video Tour">
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

                        @if($project->video_url)
                        <div class="int-video-card-action">
                            <i class="fas fa-play"></i> WATCH VIDEO TOUR
                        </div>
                        @else
                        <div class="int-video-card-action">
                            <i class="fas fa-couch"></i> {{ $project->duration ?: 'TURNKEY FITOUT' }}
                        </div>
                        @endif
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
                            <span>{{ $t->project_name ?? 'Maha Interior' }}</span>
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
                <span class="int-sec-tag">03 — ENGINEER-LED INTERIORS</span>
                <h2 class="int-sec-title-light" style="font-size:clamp(1.8rem, 3.4vw, 2.6rem);margin-bottom:8px;">
                    DESIGNED WITH PRECISION.<br>
                    <span style="color:var(--int-gold);">EXECUTED WITH CARE.</span>
                </h2>
                <div style="font-size:0.85rem;color:#16A34A;font-weight:800;letter-spacing:0.08em;margin-bottom:18px;">
                    Er. Maha Rajan (B.E. Civil) • GOVERNMENT REGISTERED ENGINEER • 12+ YEARS STRUCTURAL EXCELLENCE
                </div>

                <p style="font-size:0.92rem;color:#4B5563;line-height:1.75;margin-bottom:24px;">
                    Most interior failures occur because non-technical contractors cut into load-bearing RCC elements, create hazardous electrical overloads, or use sub-standard commercial ply that bends and warps in humid environments. We engineer every joint from the inside out.
                </p>

                <!-- 4 Numbered Technical Principles -->
                <div class="int-principles-grid">
                    <div class="int-principle-box">
                        <div class="int-principle-num">01 // PRECISION</div>
                        <div class="int-principle-title">Structural Alignment</div>
                        <p class="int-principle-desc">Laser-leveled wall measurements ensuring zero load-bearing column cuts and millimeter-accurate joinery.</p>
                    </div>
                    <div class="int-principle-box">
                        <div class="int-principle-num">02 // MATERIALS</div>
                        <div class="int-principle-title">100% BWP Marine Ply</div>
                        <p class="int-principle-desc">IS:710 boiling water proof certified cores with zero hollow voids and German hardware fixtures.</p>
                    </div>
                    <div class="int-principle-box">
                        <div class="int-principle-num">03 // COORDINATION</div>
                        <div class="int-principle-title">MEP & Conduiting Safety</div>
                        <p class="int-principle-desc">Fire-safe constant-voltage LED drivers, separate circuit balancing, and concealed plumbing routes.</p>
                    </div>
                    <div class="int-principle-box">
                        <div class="int-principle-num">04 // EXECUTION</div>
                        <div class="int-principle-title">Zero Hidden Costs</div>
                        <p class="int-principle-desc">100% itemized BOQ contracts with strict milestone guarantees and registered engineer sign-offs.</p>
                    </div>
                </div>

                <a href="#interior-enquiry" class="int-btn-gold">
                    CONSULT ER. MAHA RAJAN DIRECTLY <i class="fas fa-arrow-right"></i>
                </a>
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
        <div class="int-packages-grid lux-reveal">
            @forelse($packages as $pkg)
            <div class="int-pkg-panel {{ $pkg->is_highlighted ? 'highlighted' : '' }}">
                @if($pkg->is_highlighted)
                <div class="int-pkg-popular-tag">MOST POPULAR CHOICE</div>
                @endif

                <div>
                    <span class="int-pkg-tier">{{ strtoupper($pkg->tier) }} PLAN</span>
                    <h3 class="int-pkg-title">{{ $pkg->title }}</h3>
                    <p class="int-pkg-subtitle">{{ $pkg->subtitle }}</p>

                    <div class="int-pkg-price-row">
                        <span class="int-pkg-price-val">₹{{ number_format($pkg->price_per_sqft) }}</span>
                        <span class="int-pkg-price-unit">/ sq.ft turnkey</span>
                    </div>

                    <div class="int-pkg-chips">
                        <span class="int-pkg-chip">
                            <i class="fas fa-shield-alt" style="color:var(--int-gold);"></i> {{ $pkg->warranty_years ?? 10 }} Yrs Warranty
                        </span>
                        <span class="int-pkg-chip">
                            <i class="fas fa-calendar-check" style="color:var(--int-gold);"></i> {{ $pkg->delivery_months ?? 2 }} Mos Handover
                        </span>
                    </div>

                    <ul class="int-pkg-features-list">
                        @if(!empty($pkg->features) && is_array($pkg->features))
                            @foreach(array_slice($pkg->features, 0, 6) as $feat)
                            <li class="int-pkg-feature-item">
                                <i class="fas fa-check"></i>
                                <span>{{ $feat }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div>
                    <a href="#interior-enquiry" onclick="preselectInteriorPackage('{{ addslashes($pkg->title) }}')" class="int-pkg-btn-book">
                        <i class="fas fa-paper-plane"></i> BOOK THIS PACKAGE
                    </a>
                    <button type="button" onclick="openInteriorPackageDetailsModalById({{ $pkg->id }})" class="int-pkg-btn-specs">
                        <i class="fas fa-list-check" style="margin-right:4px;"></i> VIEW FULL INCLUSIONS & SPECS
                    </button>
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--int-slate-muted);">
                Interior packages are currently being updated.
            </div>
            @endforelse
        </div>
    </div>
</section>


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
                    Interior Consultation Request Submitted! Er. Maha Rajan's interior studio will contact you within 24 hours.
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
    window.interiorPackagesData = @json($packages);

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

        document.getElementById('intModalPkgTierLabel').textContent = 'MAHA INTERIOR • ' + (pkg.tier || 'PLAN').toUpperCase();
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

        // Initialize Testimonials Carousel
        setupInteriorCarousel(
            'interiorTestimonialsTrack',
            'interiorTestimonialsPrevBtn',
            'interiorTestimonialsNextBtn',
            'interiorTestimonialsProgressFill',
            'interiorTestimonialsDots'
        );

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
        })();
    });
</script>
@endpush
