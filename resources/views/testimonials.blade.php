@extends('layouts.app')
@section('title', 'Client Satisfaction Stories | Maha Construction')
@section('content')

<section class="section-pad" style="padding-bottom:0;">
    <div class="container" style="text-align:center;">
        <span class="sec-tag">WHAT OUR CLIENTS SAY</span>
        <h1 class="sec-title">Client <span class="gold">Satisfaction</span> Stories</h1>
        <p class="sec-sub" style="margin:10px auto 0;">Hear directly from the families whose homes we've had the privilege to build.</p>

        @if($testimonials->count() > 0)
        <div class="stories-stats-row">
            <div class="stories-stat">
                <div class="stories-stat-num">{{ $testimonials->count() }}+</div>
                <div class="stories-stat-label">Stories Shared</div>
            </div>
            <div class="stories-stat">
                <div class="stories-stat-num">100%</div>
                <div class="stories-stat-label">Clients Satisfaction</div>
            </div>
            <div class="stories-stat">
                <div class="stories-stat-num">{{ number_format($testimonials->avg('rating') ?: 5, 1) }}<i class="fas fa-star" style="font-size:1.3rem;"></i></div>
                <div class="stories-stat-label">Avg Rating</div>
            </div>
        </div>
        @endif
    </div>
</section>

<section class="section-pad">
    <div class="container">
        @if($testimonials->count() === 0)
        <div style="text-align:center;padding:80px;color:var(--text-muted);">
            <h3>Client stories coming soon</h3>
        </div>
        @else
        <div class="stories-grid">
            @foreach($testimonials as $i => $t)
                @if($t->video_url)
                <div class="story-card" data-video-url="{{ $t->video_url }}" onclick="window.playVideoModal('{{ $t->video_url }}', '{{ addslashes($t->client_name) }}')" style="cursor:pointer;">
                    <img src="{{ $t->image_url ?? 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $t->client_name }}">
                    <div class="story-card-shade"></div>
                    <span class="story-card-tag">STORY {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="story-card-play"><i class="fas fa-play" style="margin-left:2px;"></i></div>
                    <div class="story-card-info">
                        <div class="story-card-name">{{ $t->client_name }}</div>
                        <div class="story-card-watch"><i class="fas fa-play" style="margin-right:4px;"></i> Watch Story</div>
                    </div>
                </div>
                @else
                <div class="quote-card">
                    <div class="quote-stars">
                        @for($s=0; $s<($t->rating ?? 5); $s++)
                        <i class="fas fa-star"></i>
                        @endfor
                    </div>
                    <p class="quote-text">"{{ $t->feedback }}"</p>
                    @if($t->project_name)
                    <div class="quote-project"><i class="fas fa-building" style="margin-right:4px;color:var(--gold);"></i> {{ $t->project_name }}</div>
                    @endif
                    <div class="quote-author">
                        @if($t->image_url)<img src="{{ $t->image_url }}" alt="{{ $t->client_name }}" class="quote-avatar" loading="lazy">@endif
                        <div>
                            <div class="quote-name">{{ $t->client_name }}</div>
                            <div class="quote-role">{{ $t->client_role }}</div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
