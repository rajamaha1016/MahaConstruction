@extends('layouts.app')
@section('title', 'Blog | Maha Construction')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Blog</span></div>
        <span class="section-tag">Insights & Ideas</span>
        <h1 style="margin:16px 0;">Construction <span class="gold">Blog</span></h1>
        <p style="max-width:560px;margin:0 auto;">Expert insights, construction tips, and luxury design trends.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        @if($blogs->count() === 0)
        <div style="text-align:center;padding:80px;color:var(--text-muted);">
            <div style="font-size:3rem;margin-bottom:16px;">📝</div>
            <h3>Blog posts coming soon</h3>
            <p>Our team is crafting insightful articles. Check back soon!</p>
        </div>
        @else
        <div class="grid-3">
            @foreach($blogs as $i => $blog)
            <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card fade-in" style="transition-delay:{{ $i*0.08 }}s;display:block;">
                <div class="blog-img">
                    @if($blog->image_url)
                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" loading="lazy">
                    @else
                    <div style="height:100%;background:var(--surface-2);display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:2rem;">📰</div>
                    @endif
                </div>
                <div class="blog-info">
                    <div class="blog-meta">
                        @if($blog->category)<span class="blog-category">{{ $blog->category }}</span>@endif
                        <span class="blog-date">{{ $blog->created_at->format('M d, Y') }}</span>
                        @if($blog->author)<span class="blog-date">· {{ $blog->author }}</span>@endif
                    </div>
                    <h3 class="blog-title">{{ $blog->title }}</h3>
                    @if($blog->summary)<p class="blog-summary">{{ Str::limit($blog->summary, 120) }}</p>@endif
                    <span class="btn-ghost" style="font-size:0.82rem;font-weight:600;">Read More →</span>
                </div>
            </a>
            @endforeach
        </div>
        <div style="margin-top:40px;">
            {{ $blogs->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
