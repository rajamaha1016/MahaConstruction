@extends('layouts.app')
@section('title', 'Careers | Maha Construction')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Careers</span></div>
        <span class="section-tag">Join Our Team</span>
        <h1 style="margin:16px 0;">Build Your <span class="gold">Career</span> With Us</h1>
        <p style="max-width:560px;margin:0 auto;">Join a team of passionate architects, engineers, and designers building tomorrow's landmarks today.</p>
    </div>
</section>
<section class="section">
    <div class="container" style="max-width:900px;">
        <div class="section-header" style="margin-bottom:40px;">
            <span class="section-tag">Open Positions</span>
            <h2 class="fade-in">Current <span class="gold">Openings</span></h2>
        </div>
        <div style="display:flex;flex-direction:column;gap:16px;">
            @php
            $jobs = [
                ['title'=>'Senior Structural Engineer','type'=>'Full-time','dept'=>'Engineering','exp'=>'5+ Years'],
                ['title'=>'Principal Architect','type'=>'Full-time','dept'=>'Design','exp'=>'8+ Years'],
                ['title'=>'Interior Designer','type'=>'Full-time','dept'=>'Design','exp'=>'3+ Years'],
                ['title'=>'Site Supervisor','type'=>'Full-time','dept'=>'Operations','exp'=>'4+ Years'],
                ['title'=>'Project Manager','type'=>'Full-time','dept'=>'Management','exp'=>'6+ Years'],
                ['title'=>'Civil Estimator','type'=>'Full-time','dept'=>'Commercial','exp'=>'3+ Years'],
                ['title'=>'AutoCAD / Revit Drafter','type'=>'Full-time','dept'=>'Design','exp'=>'2+ Years'],
            ];
            @endphp
            @foreach($jobs as $job)
            <div class="career-card fade-in">
                <div class="career-info">
                    <h3>{{ $job['title'] }}</h3>
                    <div class="career-meta">
                        <span class="career-tag career-type">{{ $job['type'] }}</span>
                        <span class="career-tag career-dept">{{ $job['dept'] }}</span>
                        <span style="font-size:0.78rem;color:var(--text-muted);">Experience: {{ $job['exp'] }}</span>
                    </div>
                </div>
                <a href="mailto:Mahaconstructions2013@gmail.com?subject=Application: {{ $job['title'] }}" class="btn-outline" style="white-space:nowrap;">Apply Now <i class="fas fa-arrow-right" style="margin-left:6px;"></i></a>
            </div>
            @endforeach
        </div>

        <div style="margin-top:48px;padding:32px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);text-align:center;">
            <h3 style="margin-bottom:12px;">Don't see your role?</h3>
            <p style="margin-bottom:24px;">Send us your resume and we'll keep you in mind for future opportunities.</p>
            <a href="mailto:Mahaconstructions2013@gmail.com?subject=Open Application" class="btn-gold">Send Your Resume <i class="fas fa-paper-plane" style="margin-left:6px;"></i></a>
        </div>
    </div>
</section>
@endsection
