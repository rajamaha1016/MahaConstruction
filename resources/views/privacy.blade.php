@extends('layouts.app')
@section('title', 'Privacy Policy | Maha Construction')
@section('content')
<section class="page-hero"><div class="container"><h1 style="margin:16px 0;"><span class="gold">Privacy</span> Policy</h1><p>Last updated: January 2024</p></div></section>
<section class="section"><div class="container" style="max-width:800px;">
<div style="display:flex;flex-direction:column;gap:32px;">
@foreach([
['title'=>'Information We Collect','content'=>'We collect information you provide directly, including name, email, phone number, and project details when you contact us or request a quote. We may also collect technical information about your device and how you use our website.'],
['title'=>'How We Use Your Information','content'=>'We use the information we collect to respond to your inquiries, provide construction services, send updates about your project, improve our website, and send occasional marketing communications (which you can opt out of at any time).'],
['title'=>'Information Sharing','content'=>'We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except when required by law or to trusted partners who assist in operating our business and services.'],
['title'=>'Data Security','content'=>'We implement appropriate security measures to protect your information. However, no method of internet transmission is 100% secure, and we cannot guarantee absolute security.'],
['title'=>'Cookies','content'=>'We use cookies to enhance your experience on our website. You can choose to disable cookies through your browser settings, though this may affect some features of our site.'],
['title'=>'Contact Us','content'=>'If you have questions about this Privacy Policy, please contact us at Mahaconstructions2013@gmail.com or call +91 94430 08095.'],
] as $section)
<div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:28px;">
    <h3 style="font-family:var(--font-sans);font-size:1rem;font-weight:700;color:var(--gold);margin-bottom:12px;">{{ $section['title'] }}</h3>
    <p style="font-size:0.9rem;line-height:1.8;">{{ $section['content'] }}</p>
</div>
@endforeach
</div>
</div></section>
@endsection
