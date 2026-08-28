@extends('layouts.app')
@section('title', 'Services | Maha Construction')
@section('content')

<section class="page-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;margin-bottom:16px;">
            <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Services</span>
        </div>
        <span class="section-tag">What We Offer</span>
        <h1 style="margin:16px 0;">Our <span class="gold">Services</span></h1>
        <p style="max-width:560px;margin:0 auto;">End-to-end construction services from design to handover — residential, commercial, architectural, and interior.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid-2" style="gap:32px;">
            @foreach($services as $i => $service)
            <div class="service-card fade-in" style="transition-delay:{{ $i*0.1 }}s" id="service-{{ $service->slug }}">
                <div class="service-img" style="height:260px;">
                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}" loading="lazy">
                </div>
                <div class="service-info">
                    <span class="service-category">{{ $service->category }}</span>
                    <h2 class="service-name" style="font-size:1.6rem;margin-bottom:16px;">{{ $service->name }}</h2>
                    <p class="service-overview" style="margin-bottom:24px;">{{ $service->overview }}</p>
                    @if($service->benefits)
                    <div style="margin-bottom:24px;">
                        <h4 style="font-family:var(--font-sans);font-size:0.75rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gold);margin-bottom:12px;">Key Benefits</h4>
                        <ul class="service-benefits">
                            @foreach($service->benefits as $b)
                            <li>{{ $b }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if($service->process)
                    <div>
                        <h4 style="font-family:var(--font-sans);font-size:0.75rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gold);margin-bottom:12px;">Our Process</h4>
                        <div class="process-steps">
                            @foreach($service->process as $step)
                            <div class="process-step">
                                <div class="step-number">{{ $step['step'] ?? '' }}</div>
                                <div class="step-content">
                                    <h4>{{ $step['title'] ?? '' }}</h4>
                                    <p style="font-size:0.83rem;">{{ $step['description'] ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section style="padding:60px 0;background:var(--dark-2);">
    <div class="container" style="text-align:center;">
        <h2 class="fade-in">Ready to Get Started?</h2>
        <p style="max-width:480px;margin:16px auto 32px;" class="fade-in">Contact us today for a free consultation and project estimate.</p>
        <button class="btn-gold" data-open-quote><i class="fas fa-file-invoice" style="margin-right:6px;"></i> Request a Free Quote</button>
    </div>
</section>
@endsection
