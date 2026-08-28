@extends('layouts.app')
@section('title', 'Terms of Service | Maha Construction')
@section('content')
<section class="page-hero"><div class="container"><h1 style="margin:16px 0;"><span class="gold">Terms</span> of Service</h1><p>Last updated: January 2024</p></div></section>
<section class="section"><div class="container" style="max-width:800px;">
<div style="display:flex;flex-direction:column;gap:24px;">
@foreach([
['title'=>'Agreement to Terms','content'=>'By accessing our website and services, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree, please do not use our services.'],
['title'=>'Our Services','content'=>'Maha Construction provides luxury residential and commercial construction, architectural design, and interior design services. All services are subject to a separate contractual agreement.'],
['title'=>'Intellectual Property','content'=>'All content on this website, including designs, images, text, and logos, is the property of Maha Construction and is protected by copyright laws. You may not reproduce or distribute our content without permission.'],
['title'=>'Project Agreements','content'=>'Construction projects are governed by separate contracts that outline scope, timeline, payment terms, and warranties. These Terms of Service supplement but do not replace project-specific agreements.'],
['title'=>'Limitation of Liability','content'=>'Maha Construction is not liable for any indirect, incidental, or consequential damages arising from the use of our services beyond the scope of the specific project contract.'],
['title'=>'Changes to Terms','content'=>'We reserve the right to update these terms at any time. Continued use of our services after changes constitutes acceptance of the new terms.'],
] as $s)
<div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:28px;">
    <h3 style="font-family:var(--font-heading);font-size:1rem;font-weight:700;color:var(--gold);margin-bottom:12px;">{{ $s['title'] }}</h3>
    <p style="font-size:0.9rem;line-height:1.8;">{{ $s['content'] }}</p>
</div>
@endforeach
</div>
</div></section>
@endsection
