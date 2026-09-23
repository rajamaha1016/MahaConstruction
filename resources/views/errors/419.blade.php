@extends('layouts.app')
@section('title', '419 — Page Expired | Maha Construction')
@section('content')
<section style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:80px 24px;">
    <div>
        <div style="font-size:8rem;line-height:1;color:var(--gold);opacity:0.3;font-family:var(--font-heading);font-weight:800;">419</div>
        <h1 style="margin:24px 0 16px;font-size:2rem;">Session <span class="gold">Expired</span></h1>
        <p style="max-width:440px;margin:0 auto 32px;color:rgba(255,255,255,0.7);line-height:1.6;">Your security token or session has expired due to inactivity. Please refresh the page or return home to continue.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="javascript:location.reload()" class="btn-gold">↻ Refresh Page</a>
            <a href="{{ route('home') }}" class="btn-outline">← Return Home</a>
        </div>
    </div>
</section>
@endsection
