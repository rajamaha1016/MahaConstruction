@extends('layouts.app')
@section('title', '503 — Maintenance Mode | Maha Construction')
@section('content')
<section style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:80px 24px;">
    <div>
        <div style="font-size:8rem;line-height:1;color:var(--gold);opacity:0.3;font-family:var(--font-heading);font-weight:800;">503</div>
        <h1 style="margin:24px 0 16px;font-size:2rem;">Upgrading <span class="gold">Platform Systems</span></h1>
        <p style="max-width:460px;margin:0 auto 32px;color:rgba(255,255,255,0.7);line-height:1.6;">We are currently executing scheduled system improvements. We will be back online shortly. For urgent inquiries, please reach out via WhatsApp.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="https://wa.me/{{ $mergedSettings['company_whatsapp'] ?? '919095929543' }}" target="_blank" class="btn-gold">
                <i class="fab fa-whatsapp" style="margin-right:6px;"></i> WhatsApp Consultation
            </a>
            <a href="tel:{{ $mergedSettings['company_phone'] ?? '+919095929543' }}" class="btn-outline">
                <i class="fas fa-phone-alt" style="margin-right:6px;"></i> Call Direct
            </a>
        </div>
    </div>
</section>
@endsection
