@props([
    'src'       => '',
    'alt'       => '',
    'class'     => '',
    'width'     => null,
    'height'    => null,
    'lazy'      => true,
    'priority'  => null,
    'fallback'  => '/images/placeholder-project.svg',
    'aspect'    => null,
    'style'     => '',
])

@php
    $origSrc = $src;
    $webpSrc = null;

    // Check if a local WebP version exists for local assets
    if (!empty($origSrc) && !str_starts_with($origSrc, 'http://') && !str_starts_with($origSrc, 'https://')) {
        $cleanPath = ltrim(parse_url($origSrc, PHP_URL_PATH), '/');
        $webpCandidate = preg_replace('/\.(png|jpe?g)$/i', '.webp', $cleanPath);
        if (file_exists(public_path($webpCandidate))) {
            $webpSrc = asset($webpCandidate);
        }
    }

    $fallbackUrl = asset(ltrim($fallback, '/'));
    $inlineStyles = [];
    if ($aspect) {
        $inlineStyles[] = "aspect-ratio: {$aspect};";
    }
    if (!empty($style)) {
        $inlineStyles[] = rtrim($style, ';') . ';';
    }
    $styleAttr = !empty($inlineStyles) ? 'style="' . implode(' ', $inlineStyles) . '"' : '';
@endphp

<picture class="resilient-pic-wrap {{ $class }}" {!! $styleAttr !!}>
    @if($webpSrc)
        <source srcset="{{ $webpSrc }}" type="image/webp">
    @endif
    <img
        src="{{ $origSrc }}"
        alt="{{ $alt }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        @if($lazy)
            loading="lazy"
        @else
            loading="eager"
            @if($priority === 'high') fetchpriority="high" @endif
        @endif
        @if($priority === 'low') fetchpriority="low" @endif
        decoding="async"
        class="resilient-img {{ $class }}"
        onerror="this.onerror=null; this.src='{{ $fallbackUrl }}'; this.classList.add('is-fallback-img');"
        {!! $styleAttr !!}
    >
</picture>
