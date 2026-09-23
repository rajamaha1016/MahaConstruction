@extends('layouts.app')
@section('title', '403 — Access Restricted | Maha Construction')
@section('content')
<section style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:80px 24px;">
    <div>
        <div style="font-size:8rem;line-height:1;color:var(--gold);opacity:0.3;font-family:var(--font-heading);font-weight:800;">403</div>
        <h1 style="margin:24px 0 16px;font-size:2rem;">Access <span class="gold">Restricted</span></h1>
        <p style="max-width:440px;margin:0 auto 32px;color:rgba(255,255,255,0.7);line-height:1.6;">You do not have administrative authorization to view this resource.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('home') }}" class="btn-gold">← Return Home</a>
            <a href="{{ route('admin.login') }}" class="btn-outline">Admin Login</a>
        </div>
    </div>
</section>
@endsection
