@extends('layouts.app')
@section('title', $blog->title . ' | Maha Construction Blog')
@section('content')
<section class="page-hero" style="padding:140px 0 40px;">
    <div class="container" style="max-width:800px;">
        <div class="breadcrumb" style="justify-content:center;"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><a href="{{ route('blog') }}">Blog</a><span class="breadcrumb-sep">›</span><span>Article</span></div>
        @if($blog->category)<span class="section-tag" style="margin-top:12px;">{{ $blog->category }}</span>@endif
        <h1 style="margin:16px 0;font-size:clamp(1.8rem,4vw,3rem);">{{ $blog->title }}</h1>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            @if($blog->author)<span style="font-size:0.85rem;color:var(--text-muted);">By {{ $blog->author }}</span>@endif
            <span style="font-size:0.85rem;color:var(--text-muted);">{{ $blog->created_at->format('F d, Y') }}</span>
        </div>
    </div>
</section>
<section class="section" style="padding-top:0;">
    <div class="container" style="max-width:800px;">
        @if($blog->image_url)
        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" style="width:100%;height:400px;object-fit:cover;border-radius:var(--radius-lg);margin-bottom:40px;">
        @endif
        @if($blog->summary)
        <p style="font-size:1.1rem;color:var(--text-primary);line-height:1.8;margin-bottom:32px;padding-bottom:32px;border-bottom:1px solid var(--border);">{{ $blog->summary }}</p>
        @endif
        <div style="font-size:0.95rem;color:var(--text-muted);line-height:1.9;">
            {!! nl2br(e($blog->content)) !!}
        </div>
        @if($blog->tags)
        <div style="margin-top:32px;padding-top:32px;border-top:1px solid var(--border);">
            <span style="font-size:0.72rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-muted);margin-right:12px;">Tags:</span>
            @foreach(explode(',', $blog->tags) as $tag)
            <span style="padding:4px 12px;background:rgba(201,168,76,0.08);border:1px solid var(--border);border-radius:100px;font-size:0.78rem;color:var(--gold);margin-right:6px;">{{ trim($tag) }}</span>
            @endforeach
        </div>
        @endif

        <!-- Back / Related -->
        <div style="margin-top:48px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
            <a href="{{ route('blog') }}" class="btn-outline">← Back to Blog</a>
            <button class="btn-gold" data-open-quote>Build Your Dream →</button>
        </div>

        @if($recent->count() > 0)
        <div style="margin-top:60px;">
            <h3 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:var(--gold);margin-bottom:24px;">Recent Articles</h3>
            <div class="grid-3">
                @foreach($recent as $r)
                <a href="{{ route('blog.show', $r->slug) }}" class="blog-card" style="display:block;">
                    @if($r->image_url)<div class="blog-img"><img src="{{ $r->image_url }}" alt="{{ $r->title }}" loading="lazy"></div>@endif
                    <div class="blog-info">
                        <h3 class="blog-title" style="font-size:1rem;">{{ $r->title }}</h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
