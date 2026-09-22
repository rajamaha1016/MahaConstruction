<?php

/**
 * Frontend Asset Optimization Script for Maha Construction & Interiors
 * Converts large images and animation frames to lightweight WebP format.
 */

$rootDir = dirname(__DIR__);
$publicDir = $rootDir . DIRECTORY_SEPARATOR . 'public';

echo "=== Maha Frontend Asset Optimizer ===\n";

if (!extension_loaded('gd')) {
    die("Error: PHP GD extension is not loaded.\n");
}

function optimizeToWebp($sourcePath, $targetPath, $quality = 82, $maxWidth = null, $maxHeight = null) {
    if (!file_exists($sourcePath)) {
        echo "Source not found: {$sourcePath}\n";
        return false;
    }

    $info = getimagesize($sourcePath);
    if (!$info) {
        echo "Could not get image info for: {$sourcePath}\n";
        return false;
    }

    $origWidth = $info[0];
    $origHeight = $info[1];
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $img = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $img = imagecreatefrompng($sourcePath);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            break;
        case 'image/webp':
            $img = imagecreatefromwebp($sourcePath);
            break;
        default:
            echo "Unsupported MIME: {$mime} for {$sourcePath}\n";
            return false;
    }

    if (!$img) {
        echo "Failed to load image: {$sourcePath}\n";
        return false;
    }

    $newWidth = $origWidth;
    $newHeight = $origHeight;

    if ($maxWidth && $newWidth > $maxWidth) {
        $ratio = $maxWidth / $newWidth;
        $newWidth = $maxWidth;
        $newHeight = (int)round($newHeight * $ratio);
    }
    if ($maxHeight && $newHeight > $maxHeight) {
        $ratio = $maxHeight / $newHeight;
        $newHeight = $maxHeight;
        $newWidth = (int)round($newWidth * $ratio);
    }

    if ($newWidth !== $origWidth || $newHeight !== $origHeight) {
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefill($resized, 0, 0, $transparent);
        imagecopyresampled($resized, $img, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        imagedestroy($img);
        $img = $resized;
    }

    $dir = dirname($targetPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $saved = imagewebp($img, $targetPath, $quality);
    imagedestroy($img);

    if ($saved) {
        $origSize = filesize($sourcePath);
        $newSize = filesize($targetPath);
        $savedPct = round((1 - ($newSize / $origSize)) * 100, 1);
        echo "Optimized: " . basename($sourcePath) . " -> " . basename($targetPath) . " (" . round($origSize/1024, 1) . " KB -> " . round($newSize/1024, 1) . " KB, -{$savedPct}%)\n";
        return true;
    }

    return false;
}

// 1. Optimize Hero Engineer Image: maha-rajan.png (1.14 MB)
echo "\n--- Optimizing Engineer Portrait ---\n";
optimizeToWebp(
    $publicDir . DIRECTORY_SEPARATOR . 'maha-rajan.png',
    $publicDir . DIRECTORY_SEPARATOR . 'maha-rajan.webp',
    82,
    840 // High-DPI 2x for max-width 420px
);
optimizeToWebp(
    $publicDir . DIRECTORY_SEPARATOR . 'maha-rajan.png',
    $publicDir . DIRECTORY_SEPARATOR . 'maha-rajan-mobile.webp',
    80,
    480 // 1x mobile
);

// 2. Optimize Hero Background: hero-bg.jpg (908 KB)
echo "\n--- Optimizing Hero Background ---\n";
optimizeToWebp(
    $publicDir . DIRECTORY_SEPARATOR . 'hero-bg.jpg',
    $publicDir . DIRECTORY_SEPARATOR . 'hero-bg.webp',
    80,
    1920
);
optimizeToWebp(
    $publicDir . DIRECTORY_SEPARATOR . 'hero-bg.jpg',
    $publicDir . DIRECTORY_SEPARATOR . 'hero-bg-mobile.webp',
    78,
    768
);

// 3. Optimize Logo images
echo "\n--- Optimizing Logos & Favicons ---\n";
optimizeToWebp(
    $publicDir . DIRECTORY_SEPARATOR . 'logo.jpg',
    $publicDir . DIRECTORY_SEPARATOR . 'logo.webp',
    85,
    300
);
optimizeToWebp(
    $publicDir . DIRECTORY_SEPARATOR . 'logo.png',
    $publicDir . DIRECTORY_SEPARATOR . 'logo.webp',
    85,
    300
);

// Create lightweight favicon PNG (64x64) from logo.png if favicon.png is 900KB
optimizeToWebp(
    $publicDir . DIRECTORY_SEPARATOR . 'logo.png',
    $publicDir . DIRECTORY_SEPARATOR . 'favicon-64.png',
    90,
    64,
    64
);

// 4. Optimize Guidebook Cover (173 KB)
echo "\n--- Optimizing Guidebook Cover ---\n";
optimizeToWebp(
    $publicDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'guidebook-cover.jpg',
    $publicDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'guidebook-cover.webp',
    82,
    560
);

// 5. Generate Local Interior Hero Poster (WebP & JPG)
echo "\n--- Generating Local Interior Hero Poster ---\n";
$heroPosterWebp = $publicDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'interior-hero-poster.webp';
$heroPosterJpg = $publicDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'interior-hero-poster.jpg';

// Download once from sample unsplash or generate if offline
$samplePosterUrl = 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1200&q=80';
$tempPoster = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'int_hero_temp.jpg';
$context = stream_context_create(['http' => ['timeout' => 5]]);
$remoteData = @file_get_contents($samplePosterUrl, false, $context);
if ($remoteData && strlen($remoteData) > 5000) {
    file_put_contents($tempPoster, $remoteData);
    optimizeToWebp($tempPoster, $heroPosterWebp, 80, 1400);
    copy($tempPoster, $heroPosterJpg);
    @unlink($tempPoster);
    echo "Saved local interior hero poster from seed reference.\n";
} else {
    $w = 1200;
    $h = 700;
    $fallbackImg = imagecreatetruecolor($w, $h);
    $bg = imagecolorallocate($fallbackImg, 13, 19, 31);
    imagefill($fallbackImg, 0, 0, $bg);
    for ($y = 0; $y < $h; $y++) {
        $alpha = (int)($y / $h * 60);
        $col = imagecolorallocatealpha($fallbackImg, 5, 11, 20, $alpha);
        imageline($fallbackImg, 0, $y, $w, $y, $col);
    }
    imagewebp($fallbackImg, $heroPosterWebp, 80);
    imagejpeg($fallbackImg, $heroPosterJpg, 80);
    imagedestroy($fallbackImg);
    echo "Generated local interior hero luxury canvas fallback.\n";
}

// 6. Generate SVG Fallback Placeholders (Project & Avatar)
echo "\n--- Generating Resilient SVG Placeholders ---\n";
$projectSvg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 400" width="100%" height="100%">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#0A0F1D"/>
      <stop offset="50%" stop-color="#141E33"/>
      <stop offset="100%" stop-color="#050B14"/>
    </linearGradient>
    <linearGradient id="gold" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#D4AF37"/>
      <stop offset="50%" stop-color="#FFD700"/>
      <stop offset="100%" stop-color="#C8952B"/>
    </linearGradient>
  </defs>
  <rect width="600" height="400" fill="url(#bg)"/>
  <rect x="20" y="20" width="560" height="360" rx="12" fill="none" stroke="rgba(212,175,55,0.2)" stroke-width="1.5"/>
  <circle cx="300" cy="180" r="44" fill="rgba(212,175,55,0.12)" stroke="url(#gold)" stroke-width="1.5"/>
  <path d="M280 205 V165 H300 V155 H320 V205 Z M287 172 H293 V177 H287 Z M287 183 H293 V188 H287 Z M307 165 H313 V170 H307 Z M307 176 H313 V181 H307 Z M307 187 H313 V192 H307 Z" fill="url(#gold)"/>
  <text x="300" y="250" text-anchor="middle" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="14" font-weight="700" letter-spacing="3" fill="#D4AF37">MAHA LUXURY ARCHITECTURE</text>
  <text x="300" y="272" text-anchor="middle" font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" font-size="11" font-weight="500" letter-spacing="1" fill="#94A3B8">IMAGE LOADING FROM ARCHIVE</text>
</svg>
SVG;

$avatarSvg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="100%" height="100%">
  <defs>
    <linearGradient id="avbg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#141E33"/>
      <stop offset="0%" stop-color="#0A0F1D"/>
    </linearGradient>
  </defs>
  <circle cx="60" cy="60" r="58" fill="url(#avbg)" stroke="#D4AF37" stroke-width="2"/>
  <circle cx="60" cy="46" r="20" fill="rgba(212,175,55,0.3)"/>
  <path d="M32 94 C32 76, 44 68, 60 68 C76 68, 88 76, 88 94 Z" fill="rgba(212,175,55,0.3)"/>
</svg>
SVG;

file_put_contents($publicDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'placeholder-project.svg', $projectSvg);
file_put_contents($publicDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'placeholder-avatar.svg', $avatarSvg);
echo "Generated placeholder-project.svg & placeholder-avatar.svg.\n";

// 7. Optimize scroll-construction animation frames
echo "\n--- Optimizing Scroll Construction Animation Frames to WebP ---\n";
$scrollDirs = [
    $publicDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'scroll-construction',
    $publicDir . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'scroll-construction' . DIRECTORY_SEPARATOR . 'mobile',
];

$totalFramesConverted = 0;
$totalOrigBytes = 0;
$totalNewBytes = 0;

foreach ($scrollDirs as $dir) {
    if (!is_dir($dir)) continue;
    $files = glob($dir . DIRECTORY_SEPARATOR . '*.jpg');
    foreach ($files as $file) {
        $webpTarget = preg_replace('/\.jpg$/i', '.webp', $file);
        if (!file_exists($webpTarget) || filemtime($webpTarget) < filemtime($file)) {
            $origSize = filesize($file);
            $isMobileDir = str_contains($dir, 'mobile');
            $maxDim = $isMobileDir ? 720 : 1280;
            if (optimizeToWebp($file, $webpTarget, 74, $maxDim)) {
                $totalFramesConverted++;
                $totalOrigBytes += $origSize;
                $totalNewBytes += filesize($webpTarget);
            }
        }
    }
}

if ($totalFramesConverted > 0) {
    $origMB = round($totalOrigBytes / 1048576, 2);
    $newMB = round($totalNewBytes / 1048576, 2);
    $pct = round((1 - ($totalNewBytes / $totalOrigBytes)) * 100, 1);
    echo "Converted {$totalFramesConverted} animation frames to WebP: {$origMB} MB -> {$newMB} MB (-{$pct}% bandwidth saved!)\n";
} else {
    echo "Animation frames already converted to WebP.\n";
}

echo "\n=== Asset Optimization Complete! ===\n";
