@extends('layouts.app')
@section('title', 'Projects | Maha Construction')
@section('content')

<section class="page-hero">
    <div class="container">
        <div class="breadcrumb" style="justify-content:center;"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Projects</span></div>
        <span class="section-tag">Our Portfolio</span>
        <h1 style="margin:16px 0;">Our <span class="gold">Projects</span></h1>
        <p style="max-width:560px;margin:0 auto;">Explore our portfolio of luxury residential villas, commercial masterpieces, and iconic architectural landmarks.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <!-- Filter -->
        <div class="filter-bar">
            <button class="filter-btn {{ $category === 'all' ? 'active' : '' }}" data-filter="all">All</button>
            <button class="filter-btn {{ $category === 'residential' ? 'active' : '' }}" data-filter="residential">Residential</button>
            <button class="filter-btn {{ $category === 'commercial' ? 'active' : '' }}" data-filter="commercial">Commercial</button>
            <button class="filter-btn {{ $category === 'villa' ? 'active' : '' }}" data-filter="villa">Villa</button>
        </div>

        @if($projects->count() === 0)
        <div style="text-align:center;padding:80px 0;color:var(--text-muted);">
            <div style="font-size:3rem;margin-bottom:16px;color:var(--gold);"><i class="fas fa-building"></i></div>
            <h3>No projects found</h3>
            <p>Projects will appear here once added.</p>
        </div>
        @else
        <div class="grid-3" id="projectsGrid">
            @foreach($projects as $i => $project)
            <div class="project-card fade-in" data-category="{{ $project->category }}" style="transition-delay:{{ $i*0.08 }}s">
                <div class="project-img" @if($project->video_url) onclick="window.playVideoModal('{{ $project->video_url }}', '{{ addslashes($project->name) }}')" style="cursor:pointer;" @endif>
                    @if($project->image_urls && count($project->image_urls) > 0)
                    <img src="{{ $project->image_urls[0] }}" alt="{{ $project->name }}" loading="lazy">
                    @else
                    <div style="height:100%;background:var(--surface-2);display:flex;align-items:center;justify-content:center;color:var(--text-muted);">No Image</div>
                    @endif
                    <div class="project-img-overlay"></div>
                    @if($project->category)<span class="project-category">{{ ucfirst($project->category) }}</span>@endif
                    @if($project->is_featured)<span class="project-featured"><i class="fas fa-star" style="margin-right:4px;"></i> Featured</span>@endif

                    @if($project->video_url)
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:48px;height:48px;background:var(--gold);color:#050B14;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 20px rgba(212,175,55,0.7);font-size:1rem;z-index:2;">
                        <i class="fas fa-play" style="margin-left:2px;"></i>
                    </div>
                    @endif
                </div>
                <div class="project-info">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                        <h3 class="project-name">{{ $project->name }}</h3>
                        @if($project->video_url)
                        <button onclick="window.playVideoModal('{{ $project->video_url }}', '{{ addslashes($project->name) }}')" class="btn-whatsapp-outline" style="padding:4px 10px;font-size:0.7rem;border-color:rgba(212,175,55,0.4);color:#D4AF37;cursor:pointer;white-space:nowrap;">
                            <i class="fas fa-play" style="margin-right:4px;"></i> Tour
                        </button>
                        @endif
                    </div>
                    <div class="project-meta">
                        @if($project->location)<span><i class="fas fa-map-marker-alt" style="margin-right:4px;color:var(--gold);"></i> {{ $project->location }}</span>@endif
                        @if($project->budget)<span class="project-budget">{{ $project->budget }}</span>@endif
                        @if($project->completion_date)<span><i class="fas fa-calendar-days" style="margin-right:4px;color:var(--gold);"></i> {{ $project->completion_date }}</span>@endif
                    </div>
                    <p style="font-size:0.85rem;color:var(--text-muted);margin:12px 0;">{{ Str::limit($project->description, 110) }}</p>
                    @if($project->timeline && count($project->timeline) > 0)
                    <div style="border-top:1px solid var(--border);margin-top:16px;padding-top:16px;">
                        <p style="font-size:0.72rem;letter-spacing:0.18em;text-transform:uppercase;color:var(--gold);margin-bottom:10px;">Timeline</p>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            @foreach($project->timeline as $phase)
                            <span style="font-size:0.75rem;padding:3px 10px;background:rgba(201,168,76,0.08);border:1px solid var(--border);border-radius:100px;color:var(--text-muted);">
                                {{ $phase['phase'] ?? '' }} · {{ $phase['duration'] ?? '' }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
