<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class YouTubeSyncService
{
    const DEFAULT_CHANNEL_URL = 'https://www.youtube.com/@mahaconstructions2013';
    const CACHE_TTL_SECONDS   = 1800; // 30 minutes

    /**
     * Get the active channel URL from settings or default.
     */
    public static function getActiveChannelUrl(): string
    {
        $setting = Setting::where('key', 'youtube_channel_url')->first();
        if ($setting && !empty(trim($setting->value))) {
            return trim($setting->value);
        }
        return self::DEFAULT_CHANNEL_URL;
    }

    /**
     * Update the active channel URL in settings.
     */
    public static function setActiveChannelUrl(string $url): string
    {
        $url = trim($url);
        if (empty($url)) {
            $url = self::DEFAULT_CHANNEL_URL;
        }

        Setting::updateOrCreate(
            ['key' => 'youtube_channel_url'],
            ['value' => $url]
        );

        // Clear stored channel ID so it can be re-resolved for the new URL
        Setting::where('key', 'youtube_channel_id')->delete();

        return $url;
    }

    /**
     * Get optional YouTube API key from settings or env.
     */
    public static function getApiKey(): ?string
    {
        $setting = Setting::where('key', 'youtube_api_key')->first();
        if ($setting && !empty(trim($setting->value))) {
            return trim($setting->value);
        }
        return env('YOUTUBE_API_KEY') ?: null;
    }

    /**
     * Update the YouTube API key in settings.
     */
    public static function setApiKey(?string $apiKey): void
    {
        Setting::updateOrCreate(
            ['key' => 'youtube_api_key'],
            ['value' => trim($apiKey ?? '')]
        );
    }

    /**
     * Get a setting value safely by key.
     */
    public static function getSetting(string $key, mixed $default = ''): mixed
    {
        $setting = Setting::where('key', $key)->first();
        return ($setting && $setting->value !== '') ? $setting->value : $default;
    }

    /**
     * Extract @handle from channel URL for display.
     */
    public static function getChannelHandle(): string
    {
        $url = self::getActiveChannelUrl();
        if (preg_match('/@([\w.-]+)/', $url, $m)) {
            return '@' . $m[1];
        }
        return '@mahaconstructions2013';
    }

    /**
     * Get persisted channel metadata without triggering a sync.
     */
    public static function getChannelMeta(): array
    {
        return [
            'name'   => self::getSetting('youtube_channel_name', 'Maha Constructions'),
            'url'    => self::getActiveChannelUrl(),
            'avatar' => self::getSetting('youtube_channel_avatar', asset('logo.jpg')),
            'subs'   => self::getSetting('youtube_channel_subs', ''),
            'count'  => (int) self::getSetting('youtube_video_count', 0),
        ];
    }

    /**
     * Normalize various inputs (@handle, handle, URL, channel ID) into a full YouTube URL.
     */
    public static function normalizeUrl(?string $input): string
    {
        $input = trim($input ?? '');
        if (empty($input)) {
            $input = self::getActiveChannelUrl();
        }

        if (str_starts_with($input, 'http://') || str_starts_with($input, 'https://')) {
            return $input;
        }

        if (str_starts_with($input, 'UC') && strlen($input) === 24) {
            return "https://www.youtube.com/channel/{$input}";
        }

        if (str_starts_with($input, '@')) {
            return "https://www.youtube.com/{$input}";
        }

        return "https://www.youtube.com/@{$input}";
    }

    /**
     * Fetch live channel videos with caching, multi-tier sync, and database persistence.
     */
    public function getVideos(?string $channelUrl = null, bool $forceRefresh = false): array
    {
        $targetUrl = self::normalizeUrl($channelUrl);
        $cacheKey = 'yt_live_videos_' . md5($targetUrl);

        if (!$forceRefresh && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $result = $this->syncVideos($targetUrl);

        if ($result['count'] > 0) {
            Cache::put($cacheKey, $result, self::CACHE_TTL_SECONDS);

            // Persist to settings table for offline durability (Only if it corresponds to the active channel)
            if ($targetUrl === self::getActiveChannelUrl()) {
                try {
                    Setting::updateOrCreate(
                        ['key' => 'youtube_synced_videos'],
                        ['value' => json_encode($result['videos'])]
                    );
                    Setting::updateOrCreate(
                        ['key' => 'youtube_last_synced_at'],
                        ['value' => now()->toIso8601String()]
                    );
                    Setting::updateOrCreate(
                        ['key' => 'youtube_video_count'],
                        ['value' => (string)$result['count']]
                    );
                    if (!empty($result['channel_name'])) {
                        Setting::updateOrCreate(
                            ['key' => 'youtube_channel_name'],
                            ['value' => $result['channel_name']]
                        );
                    }
                    if (!empty($result['channel_avatar'])) {
                        Setting::updateOrCreate(
                            ['key' => 'youtube_channel_avatar'],
                            ['value' => $result['channel_avatar']]
                        );
                    }
                    if (!empty($result['channel_subs'])) {
                        Setting::updateOrCreate(
                            ['key' => 'youtube_channel_subs'],
                            ['value' => $result['channel_subs']]
                        );
                    }
                } catch (\Throwable $e) {
                    Log::warning('YouTube persistence error: ' . $e->getMessage());
                }
            }
        } else {
            // Fallback to persisted data in database
            $fallback = $this->getPersistedFallback($targetUrl);
            if (!empty($fallback['videos'])) {
                return $fallback;
            }
        }

        return $result;
    }

    /**
     * Multi-tier synchronization engine.
     */
    public function syncVideos(string $targetUrl): array
    {
        $videos = [];
        $channelMeta = [
            'name'        => 'Maha Constructions',
            'avatar'      => asset('logo.jpg'),
            'subscribers' => '',
            'channel_id'  => '',
        ];

        // Resolve YouTube Channel ID
        $channelId = $this->resolveChannelId($targetUrl);
        if ($channelId) {
            $channelMeta['channel_id'] = $channelId;
        }

        // TIER 1: YouTube Data API v3 (if API key is configured)
        $apiKey = self::getApiKey();
        if ($apiKey && $channelId) {
            $this->fetchChannelMetadataViaApi($channelId, $apiKey, $channelMeta);
            $apiVideos = $this->fetchViaYouTubeApi($channelId, $apiKey, $channelMeta);
            if (!empty($apiVideos)) {
                $videos = $apiVideos;
            }
        }

        // TIER 2: YouTube Official RSS Feed (Fastest real-time sync, zero key required)
        if (empty($videos) && $channelId) {
            $rssVideos = $this->fetchViaRssFeed($channelId, $channelMeta);
            if (!empty($rssVideos)) {
                $videos = $rssVideos;
            }
        }

        // TIER 3: YouTube HTML Web Scraper (Extracts /videos tab + initial data)
        // Run scraper if we don't have API videos, to get real durations/views or fallback videos
        if (empty($apiKey) || empty($videos)) {
            $scrapedVideos = $this->fetchViaScraper($targetUrl, $channelMeta);
            if (!empty($scrapedVideos)) {
                if (empty($videos)) {
                    $videos = $scrapedVideos;
                } else {
                    // Augment RSS videos with scraped details (like durations and views)
                    foreach ($videos as $id => &$rssVideo) {
                        if (isset($scrapedVideos[$id])) {
                            if ($rssVideo['duration'] === 'Site Walkthrough' && $scrapedVideos[$id]['duration'] !== 'Site Walkthrough') {
                                $rssVideo['duration'] = $scrapedVideos[$id]['duration'];
                            }
                            if (empty($rssVideo['views']) && !empty($scrapedVideos[$id]['views'])) {
                                $rssVideo['views'] = $scrapedVideos[$id]['views'];
                            }
                        }
                    }
                    unset($rssVideo); // break reference

                    // Add any scraped videos that were not in the RSS feed
                    foreach ($scrapedVideos as $id => $scrapedVid) {
                        if (!isset($videos[$id])) {
                            $videos[$id] = $scrapedVid;
                        }
                    }
                }
            }
        }

        return [
            'success'        => count($videos) > 0,
            'channel_url'    => $targetUrl,
            'channel_id'     => $channelMeta['channel_id'],
            'channel_name'   => $channelMeta['name'],
            'channel_avatar' => $channelMeta['avatar'],
            'channel_subs'   => $channelMeta['subscribers'],
            'count'          => count($videos),
            'last_synced_at' => now()->toIso8601String(),
            'videos'         => array_values($videos),
        ];
    }

    /**
     * Resolve YouTube Channel ID (UC...) from handle or URL.
     */
    public function resolveChannelId(string $targetUrl): ?string
    {
        // 1. Direct Channel ID in URL
        if (preg_match('/\/channel\/(UC[\w-]{22})/', $targetUrl, $m)) {
            return $m[1];
        }
        if (str_starts_with(trim($targetUrl), 'UC') && strlen(trim($targetUrl)) === 24) {
            return trim($targetUrl);
        }

        // 2. Check Database Cached Channel ID (Only if it corresponds to the active channel URL)
        if ($targetUrl === self::getActiveChannelUrl()) {
            $cachedSetting = Setting::where('key', 'youtube_channel_id')->first();
            if ($cachedSetting && !empty($cachedSetting->value)) {
                return $cachedSetting->value;
            }
        }

        // 3. Fetch Channel Page HTML to extract channelId
        try {
            $html = $this->fetchUrl($targetUrl);
            if (!empty($html)) {
                if (preg_match('/"channelId":"(UC[\w-]{22})"/', $html, $m) ||
                    preg_match('/<meta itemprop="channelId" content="(UC[\w-]{22})"/', $html, $m) ||
                    preg_match('/channel_id=(UC[\w-]{22})/', $html, $m) ||
                    preg_match('/"externalId":"(UC[\w-]{22})"/', $html, $m)) {
                    $channelId = $m[1];
                    Setting::updateOrCreate(
                        ['key' => 'youtube_channel_id'],
                        ['value' => $channelId]
                    );
                    return $channelId;
                }
            }
        } catch (\Throwable $e) {
            Log::warning('YouTube channel ID resolution error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Fetch channel name, avatar, and subscriber count via YouTube Data API.
     */
    protected function fetchChannelMetadataViaApi(string $channelId, string $apiKey, array &$channelMeta): void
    {
        try {
            $apiUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id={$channelId}&key={$apiKey}";
            $responseJson = $this->fetchUrl($apiUrl);
            $data = json_decode($responseJson, true);

            if (!empty($data['items'][0])) {
                $item = $data['items'][0];
                $snippet = $item['snippet'] ?? [];
                $stats = $item['statistics'] ?? [];

                if (!empty($snippet['title'])) {
                    $channelMeta['name'] = $snippet['title'];
                }
                $thumbs = $snippet['thumbnails'] ?? [];
                if (!empty($thumbs['high']['url'])) {
                    $channelMeta['avatar'] = $thumbs['high']['url'];
                } elseif (!empty($thumbs['default']['url'])) {
                    $channelMeta['avatar'] = $thumbs['default']['url'];
                }
                if (isset($stats['subscriberCount'])) {
                    $subs = (int) $stats['subscriberCount'];
                    $channelMeta['subscribers'] = $subs >= 1000000
                        ? round($subs / 1000000, 1) . 'M subscribers'
                        : ($subs >= 1000 ? round($subs / 1000, 1) . 'K subscribers' : "{$subs} subscribers");
                }
            }
        } catch (\Throwable $e) {
            Log::warning('YouTube channel metadata API error: ' . $e->getMessage());
        }
    }

    /**
     * Tier 1: YouTube Data API v3 fetch.
     */
    protected function fetchViaYouTubeApi(string $channelId, string $apiKey, array &$channelMeta): array
    {
        $videos = [];
        try {
            // Uploads playlist ID is channel ID with 'UU' instead of 'UC'
            $uploadsPlaylistId = 'UU' . substr($channelId, 2);
            $apiUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=24&playlistId={$uploadsPlaylistId}&key={$apiKey}";

            $responseJson = $this->fetchUrl($apiUrl);
            $data = json_decode($responseJson, true);

            if (!empty($data['items'])) {
                foreach ($data['items'] as $item) {
                    $videoId = $item['contentDetails']['videoId'] ?? ($item['snippet']['resourceId']['videoId'] ?? null);
                    if (!$videoId) continue;

                    $title = $item['snippet']['title'] ?? 'Maha Construction Video';
                    $published = isset($item['snippet']['publishedAt']) ? substr($item['snippet']['publishedAt'], 0, 10) : '';
                    $thumbnails = $item['snippet']['thumbnails'] ?? [];
                    $thumb = $thumbnails['maxres']['url'] ?? ($thumbnails['high']['url'] ?? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg");

                    $channelMeta['name'] = $item['snippet']['channelTitle'] ?? $channelMeta['name'];

                    $videos[$videoId] = [
                        'id'        => "yt_{$videoId}",
                        'youtubeId' => $videoId,
                        'title'     => $title,
                        'videoUrl'  => "https://www.youtube.com/embed/{$videoId}?autoplay=1",
                        'watchUrl'  => "https://www.youtube.com/watch?v={$videoId}",
                        'thumbnail' => $thumb,
                        'duration'  => 'Site Tour',
                        'published' => $published ? date('M j, Y', strtotime($published)) : 'Recent',
                        'views'     => '',
                    ];
                }

                // Batch fetch actual view counts and durations for the retrieved videos
                if (!empty($videos)) {
                    $videoIds = implode(',', array_keys($videos));
                    $detailsUrl = "https://www.googleapis.com/youtube/v3/videos?part=contentDetails,statistics&id={$videoIds}&key={$apiKey}";
                    $detailsJson = $this->fetchUrl($detailsUrl);
                    $detailsData = json_decode($detailsJson, true);

                    if (!empty($detailsData['items'])) {
                        foreach ($detailsData['items'] as $detail) {
                            $vId = $detail['id'];
                            if (isset($videos[$vId])) {
                                if (isset($detail['contentDetails']['duration'])) {
                                    $videos[$vId]['duration'] = self::parseDuration($detail['contentDetails']['duration']);
                                }
                                if (isset($detail['statistics']['viewCount'])) {
                                    $videos[$vId]['views'] = self::formatViewCount($detail['statistics']['viewCount']);
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('YouTube API error: ' . $e->getMessage());
        }

        return $videos;
    }

    /**
     * Tier 2: Official YouTube RSS feed fetch.
     */
    protected function fetchViaRssFeed(string $channelId, array &$channelMeta): array
    {
        $videos = [];
        try {
            $rssUrl = "https://www.youtube.com/feeds/videos.xml?channel_id={$channelId}";
            $xmlContent = $this->fetchUrl($rssUrl);

            if (!empty($xmlContent) && str_contains($xmlContent, '<feed')) {
                $xml = @simplexml_load_string($xmlContent);
                if ($xml && isset($xml->entry)) {
                    if (isset($xml->author->name)) {
                        $channelMeta['name'] = (string)$xml->author->name;
                    }

                    foreach ($xml->entry as $entry) {
                        $yt = $entry->children('http://www.youtube.com/xml/schemas/2015');
                        $media = $entry->children('http://search.yahoo.com/mrss/');
                        
                        $videoId = (string)($yt->videoId ?? '');
                        if (!$videoId) continue;

                        $title = (string)$entry->title;
                        $publishedRaw = (string)$entry->published;
                        $publishedFormatted = $publishedRaw ? date('M j, Y', strtotime($publishedRaw)) : 'Recent';

                        // Check for media thumbnail or fallback to high-quality YouTube image
                        $thumb = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                        if (isset($media->group->thumbnail)) {
                            $thumbAttr = $media->group->thumbnail->attributes();
                            if (isset($thumbAttr['url'])) {
                                $thumb = (string)$thumbAttr['url'];
                            }
                        }

                        // Check for media community views
                        $views = '';
                        if (isset($media->group->community->statistics)) {
                            $statAttr = $media->group->community->statistics->attributes();
                            if (isset($statAttr['views'])) {
                                $vCount = (int)$statAttr['views'];
                                $views = $vCount >= 1000 ? round($vCount / 1000, 1) . 'K views' : "{$vCount} views";
                            }
                        }

                        $videos[$videoId] = [
                            'id'        => "yt_{$videoId}",
                            'youtubeId' => $videoId,
                            'title'     => $title,
                            'videoUrl'  => "https://www.youtube.com/embed/{$videoId}?autoplay=1",
                            'watchUrl'  => "https://www.youtube.com/watch?v={$videoId}",
                            'thumbnail' => $thumb,
                            'duration'  => 'Site Walkthrough',
                            'published' => $publishedFormatted,
                            'views'     => $views,
                        ];
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('YouTube RSS error: ' . $e->getMessage());
        }

        return $videos;
    }

    /**
     * Tier 3: YouTube HTML Web Scraper.
     */
    protected function fetchViaScraper(string $targetUrl, array &$channelMeta): array
    {
        $videos = [];
        try {
            $videosUrl = rtrim($targetUrl, '/') . '/videos';
            $html = $this->fetchUrl($videosUrl);

            if (empty($html) || strlen($html) < 2000) {
                $html = $this->fetchUrl($targetUrl);
            }

            if (!empty($html)) {
                $initialData = $this->extractInitialData($html);
                if (!empty($initialData)) {
                    $this->extractChannelMetadata($initialData, $channelMeta);
                    $videos = $this->extractVideosFromInitialData($initialData);
                }

                if (empty($videos)) {
                    $videos = $this->extractVideosViaRegex($html);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('YouTube Scraper error: ' . $e->getMessage());
        }

        return $videos;
    }

    /**
     * Extract ytInitialData JSON from HTML.
     */
    protected function extractInitialData(string $html): ?array
    {
        if (preg_match('/var ytInitialData = ({.*?});<\/script>/s', $html, $m) ||
            preg_match('/ytInitialData\s*=\s*({.*?});/s', $html, $m)) {
            $data = json_decode($m[1], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
        }
        return null;
    }

    /**
     * Extract channel metadata (name, subscriber count, avatar).
     */
    protected function extractChannelMetadata(array $data, array &$meta): void
    {
        try {
            $header = $data['header']['pageHeaderRenderer'] ?? ($data['header']['c4TabbedHeaderRenderer'] ?? null);
            if ($header) {
                if (isset($header['pageTitle'])) {
                    $meta['name'] = $header['pageTitle'];
                } elseif (isset($header['title']['simpleText'])) {
                    $meta['name'] = $header['title']['simpleText'];
                }

                $avatarSources = $header['content']['pageHeaderViewModel']['image']['decoratedAvatarViewModel']['avatar']['avatarViewModel']['image']['sources']
                    ?? ($header['avatar']['thumbnails'] ?? []);
                if (!empty($avatarSources)) {
                    $meta['avatar'] = end($avatarSources)['url'];
                }

                $rows = $header['content']['pageHeaderViewModel']['metadata']['contentMetadataViewModel']['metadataRows'] ?? [];
                foreach ($rows as $row) {
                    foreach ($row['metadataParts'] ?? [] as $part) {
                        $txt = $part['text']['content'] ?? '';
                        if (stripos($txt, 'subscriber') !== false) {
                            $meta['subscribers'] = $txt;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Ignore
        }
    }

    /**
     * Extract videos from parsed ytInitialData structure.
     */
    protected function extractVideosFromInitialData(array $data): array
    {
        $videos = [];
        $tabs = $data['contents']['twoColumnBrowseResultsRenderer']['tabs'] ?? [];

        foreach ($tabs as $tab) {
            $items = $tab['tabRenderer']['content']['richGridRenderer']['contents']
                ?? ($tab['tabRenderer']['content']['sectionListRenderer']['contents'] ?? []);

            if (empty($items)) continue;

            foreach ($items as $item) {
                if (isset($item['richItemRenderer']['content']['lockupViewModel'])) {
                    $lvm = $item['richItemRenderer']['content']['lockupViewModel'];
                    $v = $this->parseLockupViewModel($lvm);
                    if ($v && !isset($videos[$v['youtubeId']])) {
                        $videos[$v['youtubeId']] = $v;
                    }
                } elseif (isset($item['richItemRenderer']['content']['videoRenderer'])) {
                    $vr = $item['richItemRenderer']['content']['videoRenderer'];
                    $v = $this->parseVideoRenderer($vr);
                    if ($v && !isset($videos[$v['youtubeId']])) {
                        $videos[$v['youtubeId']] = $v;
                    }
                }
            }
        }

        if (empty($videos)) {
            $this->recursiveFindVideos($data, $videos);
        }

        return $videos;
    }

    /**
     * Parse modern YouTube LockupViewModel.
     */
    protected function parseLockupViewModel(array $lvm): ?array
    {
        $videoId = $lvm['rendererContext']['commandContext']['onTap']['innertubeCommand']['watchEndpoint']['videoId']
            ?? ($lvm['contentId'] ?? null);

        if (!$videoId || strlen($videoId) !== 11) {
            return null;
        }

        $title = $lvm['metadata']['lockupMetadataViewModel']['title']['content'] ?? 'Maha Construction Video';
        $thumbnails = $lvm['contentImage']['thumbnailViewModel']['image']['sources'] ?? [];
        $thumb = !empty($thumbnails) ? end($thumbnails)['url'] : "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";

        $metaRows = $lvm['metadata']['lockupMetadataViewModel']['metadata']['contentMetadataViewModel']['metadataRows'] ?? [];
        $metaParts = [];
        foreach ($metaRows as $row) {
            foreach ($row['metadataParts'] ?? [] as $part) {
                if (isset($part['text']['content'])) {
                    $metaParts[] = trim($part['text']['content']);
                }
            }
        }

        $views = $metaParts[0] ?? '';
        $published = $metaParts[1] ?? ($metaParts[0] ?? '');

        $duration = '';
        $overlays = $lvm['contentImage']['thumbnailViewModel']['overlays'] ?? [];
        foreach ($overlays as $overlay) {
            if (isset($overlay['thumbnailOverlayTimeStatusRenderer']['text']['content'])) {
                $duration = $overlay['thumbnailOverlayTimeStatusRenderer']['text']['content'];
            } elseif (isset($overlay['thumbnailOverlayTimeStatusRenderer']['text']['runs'][0]['text'])) {
                $duration = $overlay['thumbnailOverlayTimeStatusRenderer']['text']['runs'][0]['text'];
            }
        }

        if (empty($duration)) {
            $label = $lvm['rendererContext']['accessibilityContext']['label'] ?? '';
            if (!empty($label) && !empty($title)) {
                $durationText = trim(str_replace($title, '', $label));
                $duration = self::parseTextDuration($durationText);
            }
        }

        return [
            'id'        => "yt_{$videoId}",
            'youtubeId' => $videoId,
            'title'     => $title,
            'videoUrl'  => "https://www.youtube.com/embed/{$videoId}?autoplay=1",
            'watchUrl'  => "https://www.youtube.com/watch?v={$videoId}",
            'thumbnail' => $thumb,
            'duration'  => $duration ?: 'Site Walkthrough',
            'published' => $published,
            'views'     => $views,
        ];
    }

    /**
     * Parse legacy VideoRenderer.
     */
    protected function parseVideoRenderer(array $vr): ?array
    {
        $videoId = $vr['videoId'] ?? null;
        if (!$videoId) return null;

        $title = $vr['title']['runs'][0]['text'] ?? ($vr['title']['simpleText'] ?? 'Maha Construction Video');
        $thumbnails = $vr['thumbnail']['thumbnails'] ?? [];
        $thumb = !empty($thumbnails) ? end($thumbnails)['url'] : "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        $published = $vr['publishedTimeText']['simpleText'] ?? '';
        $duration = $vr['lengthText']['simpleText'] ?? '';
        $views = $vr['viewCountText']['simpleText'] ?? '';

        if (empty($duration)) {
            $label = $vr['title']['accessibility']['accessibilityData']['label'] ?? '';
            if (!empty($label) && !empty($title)) {
                $durationText = trim(str_replace($title, '', $label));
                $duration = self::parseTextDuration($durationText);
            }
        }

        return [
            'id'        => "yt_{$videoId}",
            'youtubeId' => $videoId,
            'title'     => $title,
            'videoUrl'  => "https://www.youtube.com/embed/{$videoId}?autoplay=1",
            'watchUrl'  => "https://www.youtube.com/watch?v={$videoId}",
            'thumbnail' => $thumb,
            'duration'  => $duration ?: 'Site Walkthrough',
            'published' => $published,
            'views'     => $views,
        ];
    }

    /**
     * Recursive search for video structures in raw JSON.
     */
    protected function recursiveFindVideos(array $node, array &$videos): void
    {
        if (isset($node['videoRenderer'])) {
            $v = $this->parseVideoRenderer($node['videoRenderer']);
            if ($v && !isset($videos[$v['youtubeId']])) {
                $videos[$v['youtubeId']] = $v;
            }
        }
        if (isset($node['lockupViewModel'])) {
            $v = $this->parseLockupViewModel($node['lockupViewModel']);
            if ($v && !isset($videos[$v['youtubeId']])) {
                $videos[$v['youtubeId']] = $v;
            }
        }

        foreach ($node as $child) {
            if (is_array($child)) {
                $this->recursiveFindVideos($child, $videos);
            }
        }
    }

    /**
     * Fallback regex extraction of video IDs.
     */
    protected function extractVideosViaRegex(string $html): array
    {
        $videos = [];
        if (preg_match_all('/"videoId":"([a-zA-Z0-9_-]{11})"/i', $html, $matches)) {
            $uniqueIds = array_unique($matches[1]);
            foreach (array_slice($uniqueIds, 0, 16) as $vid) {
                $videos[$vid] = [
                    'id'        => "yt_{$vid}",
                    'youtubeId' => $vid,
                    'title'     => 'Maha Construction Site Video',
                    'videoUrl'  => "https://www.youtube.com/embed/{$vid}?autoplay=1",
                    'watchUrl'  => "https://www.youtube.com/watch?v={$vid}",
                    'thumbnail' => "https://img.youtube.com/vi/{$vid}/hqdefault.jpg",
                    'duration'  => 'Site Walkthrough',
                    'published' => 'Recent',
                    'views'     => '',
                ];
            }
        }
        return $videos;
    }

    /**
     * Safe cURL or stream fetch.
     */
    protected function fetchUrl(string $url): string
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 5,
                CURLOPT_TIMEOUT        => 12,
                CURLOPT_CONNECTTIMEOUT => 6,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                CURLOPT_HTTPHEADER     => [
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                    'Accept-Language: en-US,en;q=0.9',
                    'Cache-Control: no-cache',
                ],
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            if ($response !== false && strlen($response) > 200) {
                return $response;
            }
        }

        $context = stream_context_create([
            'http' => [
                'header'  => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\nAccept-Language: en-US,en;q=0.9\r\n",
                'timeout' => 12,
            ],
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ]);

        return (string)@file_get_contents($url, false, $context);
    }

    /**
     * Tier 4: Retrieve persisted fallback from settings table.
     */
    protected function getPersistedFallback(string $targetUrl): array
    {
        $setting = Setting::where('key', 'youtube_synced_videos')->first();
        $lastSynced = Setting::where('key', 'youtube_last_synced_at')->first()?->value ?? null;
        $channelName   = self::getSetting('youtube_channel_name', 'Maha Constructions');
        $channelId     = self::getSetting('youtube_channel_id', '');
        $channelAvatar = self::getSetting('youtube_channel_avatar', asset('logo.jpg'));
        $channelSubs   = self::getSetting('youtube_channel_subs', '');
        $videos = [];

        if ($setting && !empty($setting->value)) {
            $videos = json_decode($setting->value, true) ?: [];
        }

        return [
            'success'        => count($videos) > 0,
            'channel_url'    => $targetUrl,
            'channel_id'     => $channelId,
            'channel_name'   => $channelName,
            'channel_avatar' => $channelAvatar,
            'channel_subs'   => $channelSubs,
            'count'          => count($videos),
            'last_synced_at' => $lastSynced,
            'videos'         => $videos,
        ];
    }

    /**
     * Parse YouTube ISO 8601 duration (e.g. PT15M33S) into standard H:i:s or i:s.
     */
    public static function parseDuration(string $youtubeDuration): string
    {
        try {
            $interval = new \DateInterval($youtubeDuration);
            $hours = $interval->h;
            $minutes = $interval->i;
            $seconds = $interval->s;

            if ($hours > 0) {
                return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
            }
            return sprintf('%d:%02d', $minutes, $seconds);
        } catch (\Throwable $e) {
            return 'Site Tour';
        }
    }

    /**
     * Format raw views count (e.g. 12450) into a readable string (e.g. 12.4K views).
     */
    public static function formatViewCount(mixed $viewCount): string
    {
        $views = (int)$viewCount;
        if ($views >= 1000000) {
            return round($views / 1000000, 1) . 'M views';
        } elseif ($views >= 1000) {
            return round($views / 1000, 1) . 'K views';
        }
        return $views . ' views';
    }

    /**
     * Parse text duration from YouTube accessibility label (e.g. "2 minutes, 9 seconds") into H:i:s or i:s.
     */
    public static function parseTextDuration(string $text): string
    {
        $text = strtolower(trim($text));
        
        $hours = 0;
        $minutes = 0;
        $seconds = 0;
        
        if (preg_match('/(\d+)\s*hour/', $text, $m)) {
            $hours = (int)$m[1];
        }
        if (preg_match('/(\d+)\s*minute/', $text, $m)) {
            $minutes = (int)$m[1];
        }
        if (preg_match('/(\d+)\s*second/', $text, $m)) {
            $seconds = (int)$m[1];
        }
        
        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }
        if ($minutes > 0 || $seconds > 0) {
            return sprintf('%d:%02d', $minutes, $seconds);
        }
        
        return '';
    }
}
