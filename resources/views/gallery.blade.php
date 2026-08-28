@extends('layouts.app')
@section('title', 'Gallery | Maha Construction')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Gallery</span></div>
        <span class="section-tag">Visual Portfolio</span>
        <h1 style="margin:16px 0;">Project <span class="gold">Gallery</span></h1>
        <p style="max-width:560px;margin:0 auto;">Explore our portfolio through immersive imagery of completed masterpieces.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="filter-bar">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="residential">Residential</button>
            <button class="filter-btn" data-filter="commercial">Commercial</button>
            <button class="filter-btn" data-filter="interior">Interior</button>
        </div>
        @if($items->count() === 0)
        <div style="text-align:center;padding:80px;color:var(--text-muted);">
            <div style="font-size:3rem;margin-bottom:16px;color:var(--gold);"><i class="fas fa-images"></i></div>
            <h3>Gallery coming soon</h3>
        </div>
        @else
        <div class="gallery-grid">
            @foreach($items as $item)
            <div class="gallery-item" data-category="{{ $item->category }}" data-src="{{ $item->image_url }}">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                <div class="gallery-overlay">
                    <div>
                        <div class="gallery-cat">{{ ucfirst($item->category) }}</div>
                        <div class="gallery-title">{{ $item->title }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Lightbox -->
<div class="lightbox" id="lightbox">
    <button class="lightbox-close" id="lightboxClose"><i class="fas fa-xmark"></i></button>
    <img class="lightbox-img" id="lightboxImg" src="" alt="Gallery Image">
</div>
@endsection
