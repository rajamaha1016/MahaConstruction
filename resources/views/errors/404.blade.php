@extends('layouts.app')
@section('title', '404 — Page Not Found | Maha Construction')
@section('content')
<section style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:80px 24px;">
    <div>
        <div style="font-size:8rem;line-height:1;color:var(--gold);opacity:0.3;font-family:var(--font-serif);">404</div>
        <h1 style="margin:24px 0 16px;font-size:2rem;">Page <span class="gold">Not Found</span></h1>
        <p style="max-width:400px;margin:0 auto 32px;">The page you're looking for doesn't exist or has been moved.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('home') }}" class="btn-gold">← Go Home</a>
            <a href="{{ route('contact') }}" class="btn-outline">Contact Us</a>
        </div>
    </div>
</section>
@endsection
