@extends('layouts.app')
@section('title', 'About Us | Maha Construction')
@section('content')
<section class="about-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>About</span></div>
        <span class="section-tag" style="margin-top:12px;">Our Story</span>
        <h1 style="margin:16px 0;">Building <span class="gold">Legacies</span><br>Since 2013</h1>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="about-intro-grid">
            <div class="about-image slide-in-left">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" alt="Maha Construction">
            </div>
            <div class="about-text slide-in-right">
                <div class="gold-line"></div>
                <h2 style="margin-bottom:20px;">The <span class="gold">Maha Story</span></h2>
                <p>Founded in 2013 in Nagercoil, Tamil Nadu, Maha Construction was born from a singular vision — to build structures that transcend function and become living works of art.</p>
                <p style="margin-top:16px;">With over a decade of precision craftsmanship, we've grown from a local builder to a trusted name in luxury construction across South India, delivering over 150 premium residential and commercial projects.</p>
                <p style="margin-top:16px;">Our philosophy is rooted in 'honest materialism' — letting premium materials speak for themselves through thoughtful design and meticulous execution.</p>

                <div class="about-values" style="margin-top:32px;">
                    <div class="about-value">
                        <div class="about-value-icon"><i class="fas fa-trophy" style="color:var(--gold);font-size:1.4rem;"></i></div>
                        <h4>Excellence</h4>
                        <p>Uncompromising quality in every project we undertake</p>
                    </div>
                    <div class="about-value">
                        <div class="about-value-icon"><i class="fas fa-microscope" style="color:var(--gold);font-size:1.4rem;"></i></div>
                        <h4>Innovation</h4>
                        <p>Pioneering modern construction techniques and materials</p>
                    </div>
                    <div class="about-value">
                        <div class="about-value-icon"><i class="fas fa-leaf" style="color:var(--gold);font-size:1.4rem;"></i></div>
                        <h4>Sustainability</h4>
                        <p>Building with the environment in mind for future generations</p>
                    </div>
                    <div class="about-value">
                        <div class="about-value-icon"><i class="fas fa-handshake" style="color:var(--gold);font-size:1.4rem;"></i></div>
                        <h4>Integrity</h4>
                        <p>Transparent, honest relationships with every client</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-sm" style="background:var(--dark-2);">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card fade-in"><span class="stat-num">150+</span><span class="stat-lbl">Projects Built</span></div>
            <div class="stat-card fade-in"><span class="stat-num">13+</span><span class="stat-lbl">Years Experience</span></div>
            <div class="stat-card fade-in"><span class="stat-num">₹500Cr+</span><span class="stat-lbl">Projects Value</span></div>
            <div class="stat-card fade-in"><span class="stat-num">98%</span><span class="stat-lbl">Client Satisfaction</span></div>
        </div>
    </div>
</section>

@if($partners->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-header" style="margin-bottom:36px;">
            <span class="section-tag">Our Network</span>
            <h2 class="fade-in">Partner <span class="gold">Ecosystem</span></h2>
        </div>
        <p class="partner-section-label">Banking & Home Loan Partners</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:16px;margin-bottom:32px;">
            @foreach($partners->where('division','banking') as $p)
            <a href="{{ $p->website_url ?? '#' }}" target="_blank" style="background:#0B132B;border:1px solid rgba(212,175,55,0.25);border-radius:14px;padding:14px;display:flex;flex-direction:column;align-items:center;gap:10px;text-decoration:none;transition:all 0.25s ease;" onmouseover="this.style.borderColor='#D4AF37';this.style.transform='translateY(-3px)';" onmouseout="this.style.borderColor='rgba(212,175,55,0.25)';this.style.transform='none';">
                @if(!empty($p->logo_url))
                <div style="background:#fff;border-radius:8px;padding:6px 12px;width:100%;height:52px;display:flex;align-items:center;justify-content:center;box-sizing:border-box;">
                    <img src="{{ asset($p->logo_url) }}" alt="{{ $p->name }}" style="max-width:100%;max-height:40px;object-fit:contain;">
                </div>
                @endif
                <span style="color:#F0EBE0;font-size:0.8rem;font-weight:800;text-align:center;">{{ $p->name }}</span>
            </a>
            @endforeach
        </div>
        <p class="partner-section-label" style="margin-top:28px;">Joint Venture Partners</p>
        <div class="partners-grid">
            @foreach($partners->where('division','joint_venture') as $p)
            <a href="{{ $p->website_url ?? '#' }}" target="_blank" class="partner-pill">{{ $p->name }}</a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section style="padding:60px 0;background:var(--dark-2);">
    <div class="container" style="text-align:center;">
        <h2 class="fade-in">Ready to Start Your <span class="gold">Journey?</span></h2>
        <p style="max-width:480px;margin:16px auto 32px;" class="fade-in">Our team of experts is ready to turn your vision into a landmark.</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <button class="btn-gold" data-open-quote><i class="fas fa-calendar-check" style="margin-right:6px;"></i> Get Free Consultation</button>
            <a href="{{ route('contact') }}" class="btn-outline">Contact Us <i class="fas fa-arrow-right" style="margin-left:6px;"></i></a>
        </div>
    </div>
</section>
@endsection
