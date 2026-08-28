@extends('layouts.app')
@section('title', 'FAQ | Maha Construction')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>FAQ</span></div>
        <span class="section-tag">Got Questions?</span>
        <h1 style="margin:16px 0;">Frequently Asked <span class="gold">Questions</span></h1>
        <p style="max-width:560px;margin:0 auto;">Everything you need to know about working with Maha Construction.</p>
    </div>
</section>
<section class="section">
    <div class="container" style="max-width:800px;">
        @if($faqs->count() === 0)
        <div style="text-align:center;padding:80px;color:var(--text-muted);">
            <h3>FAQs coming soon</h3>
        </div>
        @else
        <div class="fade-in">
            @foreach($faqs as $faq)
            <div class="faq-item">
                <button class="faq-question">
                    <span>
                        @if($faq->category && $faq->category !== 'General')
                        <span class="faq-category-badge">{{ $faq->category }}</span>
                        @endif
                        {{ $faq->question }}
                    </span>
                    <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                </button>
                <div class="faq-answer">{{ $faq->answer }}</div>
            </div>
            @endforeach
        </div>
        @endif

        <div style="text-align:center;margin-top:48px;padding:32px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);">
            <h3 style="margin-bottom:12px;">Still have questions?</h3>
            <p style="margin-bottom:24px;">Our team is ready to answer any specific questions about your project.</p>
            <a href="{{ route('contact') }}" class="btn-gold">Contact Our Team <i class="fas fa-arrow-right" style="margin-left:6px;"></i></a>
        </div>
    </div>
</section>
@endsection
