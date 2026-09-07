<?php

namespace App\Services;

use App\Models\WebsiteAnalytic;
use App\Models\QuoteRequest;
use App\Models\ContactRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Record an analytics event with strict validation and privacy-conscious metadata.
     */
    public function recordEvent(array $payload, ?Request $request = null): ?WebsiteAnalytic
    {
        $businessType = strtolower(trim($payload['business_type'] ?? ''));
        if (!in_array($businessType, WebsiteAnalytic::BUSINESS_TYPES, true)) {
            return null;
        }

        $eventType = strtolower(trim($payload['event_type'] ?? ''));
        if (!in_array($eventType, WebsiteAnalytic::EVENT_TYPES, true)) {
            return null;
        }

        // Primary visitor identification: client persistent UUID
        $visitorId = trim($payload['visitor_id'] ?? '');
        if (empty($visitorId) && $request) {
            $visitorId = $request->header('X-Visitor-Id') ?: $request->cookie('maha_vid', '');
        }
        if (empty($visitorId)) {
            $visitorId = 'anon_' . bin2hex(random_bytes(16));
        }

        // Session identification: 30-min window UUID
        $sessionId = trim($payload['session_id'] ?? '');
        if (empty($sessionId) && $request) {
            $sessionId = $request->header('X-Session-Id') ?: $request->cookie('maha_sid', '');
        }
        if (empty($sessionId)) {
            $sessionId = 'sess_' . bin2hex(random_bytes(16));
        }

        // Privacy-conscious IP hash (supplementary for security, never storing raw IP)
        $ipHash = null;
        if ($request) {
            $rawIp = $request->ip() ?: '';
            if (!empty($rawIp)) {
                $salt = config('app.key') ?: 'maha_analytics_secret';
                $ipHash = hash_hmac('sha256', $rawIp, $salt);
            }
        }

        // Referrer parsing
        $referrer = $payload['referrer'] ?? ($request?->header('referer') ?: null);
        $referrerHost = $this->parseReferrerHost($referrer, $payload['utm_source'] ?? null);

        // Device type detection
        $deviceType = $payload['device_type'] ?? null;
        if (!$deviceType && $request) {
            $deviceType = $this->detectDeviceType($request->userAgent() ?: '');
        }
        if (!in_array($deviceType, ['mobile', 'desktop', 'tablet'], true)) {
            $deviceType = 'desktop';
        }

        // User Agent snippet (minimized)
        $uaSnippet = null;
        if ($request) {
            $rawUa = $request->userAgent() ?: '';
            $uaSnippet = substr($rawUa, 0, 250);
        }

        return WebsiteAnalytic::create([
            'business_type'    => $businessType,
            'event_type'       => $eventType,
            'visitor_id'       => substr($visitorId, 0, 64),
            'session_id'       => substr($sessionId, 0, 64),
            'page_url'         => isset($payload['page_url']) ? substr($payload['page_url'], 0, 2048) : null,
            'page_name'        => isset($payload['page_name']) ? substr($payload['page_name'], 0, 100) : null,
            'section_name'     => isset($payload['section_name']) ? substr($payload['section_name'], 0, 100) : null,
            'item_id'          => isset($payload['item_id']) ? substr($payload['item_id'], 0, 100) : null,
            'lead_id'          => $payload['lead_id'] ?? null,
            'lead_type'        => $payload['lead_type'] ?? null,
            'referrer'         => $referrer ? substr($referrer, 0, 2048) : null,
            'referrer_host'    => $referrerHost,
            'utm_source'       => isset($payload['utm_source']) ? substr($payload['utm_source'], 0, 100) : null,
            'utm_medium'       => isset($payload['utm_medium']) ? substr($payload['utm_medium'], 0, 100) : null,
            'utm_campaign'     => isset($payload['utm_campaign']) ? substr($payload['utm_campaign'], 0, 100) : null,
            'device_type'      => $deviceType,
            'ip_hash'          => $ipHash,
            'user_agent_short' => $uaSnippet,
            'created_at'       => Carbon::now(),
        ]);
    }

    /**
     * Parse and clean referrer domain.
     */
    protected function parseReferrerHost(?string $referrer, ?string $utmSource): string
    {
        if (!empty($utmSource)) {
            $cleanUtm = strtolower(trim($utmSource));
            if (str_contains($cleanUtm, 'google')) return 'Google';
            if (str_contains($cleanUtm, 'insta')) return 'Instagram';
            if (str_contains($cleanUtm, 'face') || str_contains($cleanUtm, 'fb')) return 'Facebook';
            if (str_contains($cleanUtm, 'youtube')) return 'YouTube';
            if (str_contains($cleanUtm, 'whatsapp')) return 'WhatsApp';
            return ucfirst($cleanUtm);
        }

        if (empty($referrer)) {
            return 'Direct';
        }

        $host = parse_url($referrer, PHP_URL_HOST);
        if (!$host) {
            return 'Direct';
        }

        $host = strtolower($host);
        if (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
            return 'Direct';
        }
        if (str_contains($host, 'google.')) return 'Google';
        if (str_contains($host, 'instagram.')) return 'Instagram';
        if (str_contains($host, 'facebook.') || str_contains($host, 'fb.')) return 'Facebook';
        if (str_contains($host, 'youtube.') || str_contains($host, 'youtu.be')) return 'YouTube';
        if (str_contains($host, 'whatsapp.')) return 'WhatsApp';

        return preg_replace('/^www\./', '', $host);
    }

    /**
     * Broad device categorization.
     */
    protected function detectDeviceType(string $ua): string
    {
        $uaLower = strtolower($ua);
        if (str_contains($uaLower, 'ipad') || str_contains($uaLower, 'tablet') || str_contains($uaLower, 'playbook')) {
            return 'tablet';
        }
        if (str_contains($uaLower, 'mobile') || str_contains($uaLower, 'android') || str_contains($uaLower, 'iphone') || str_contains($uaLower, 'ipod')) {
            return 'mobile';
        }
        return 'desktop';
    }

    /**
     * Calculate start date based on period identifier.
     */
    public function getPeriodStartDate(string $period): Carbon
    {
        $now = Carbon::now();
        return match ($period) {
            'today'    => $now->copy()->startOfDay(),
            '7days'    => $now->copy()->subDays(7)->startOfDay(),
            '30days'   => $now->copy()->subDays(30)->startOfDay(),
            '3months'  => $now->copy()->subMonths(3)->startOfDay(),
            '1year'    => $now->copy()->subYear()->startOfDay(),
            default    => $now->copy()->subDays(30)->startOfDay(),
        };
    }

    /**
     * Fetch consolidated overview analytics.
     */
    public function getOverview(string $division = 'all', string $period = '30days'): array
    {
        $startDate = $this->getPeriodStartDate($period);

        // 1. Base Query with division and period scope
        $query = WebsiteAnalytic::query()
            ->division($division)
            ->where('created_at', '>=', $startDate);

        // Metric Calculations:
        // Unique Visitors = COUNT(DISTINCT visitor_id)
        $uniqueVisitors = (clone $query)->distinct('visitor_id')->count('visitor_id');
        // Sessions / Visits = COUNT(DISTINCT session_id)
        $sessions = (clone $query)->distinct('session_id')->count('session_id');
        // Page Views = COUNT(*) WHERE event_type = 'page_view'
        $pageViews = (clone $query)->where('event_type', 'page_view')->count();
        // Total Events = COUNT(*)
        $totalEvents = (clone $query)->count();

        // New vs Returning Visitors calculation
        $newVisitors = 0;
        $returningVisitors = 0;
        if ($uniqueVisitors > 0) {
            $periodVisitors = (clone $query)->select('visitor_id')->distinct()->pluck('visitor_id');
            if ($periodVisitors->isNotEmpty()) {
                // Find how many of these visitors had an event before the start date
                $priorVisitorCount = WebsiteAnalytic::whereIn('visitor_id', $periodVisitors)
                    ->where('created_at', '<', $startDate)
                    ->distinct('visitor_id')
                    ->count('visitor_id');
                $returningVisitors = $priorVisitorCount;
                $newVisitors = max(0, $uniqueVisitors - $returningVisitors);
            }
        }

        // 2. Division Specific Visitor Metrics (Strict filtering)
        $constVisitorsQuery = WebsiteAnalytic::construction()->where('created_at', '>=', $startDate);
        $constUniqueVisitors = (clone $constVisitorsQuery)->distinct('visitor_id')->count('visitor_id');
        $constSessions = (clone $constVisitorsQuery)->distinct('session_id')->count('session_id');
        $constPageViews = (clone $constVisitorsQuery)->where('event_type', 'page_view')->count();

        $intVisitorsQuery = WebsiteAnalytic::interior()->where('created_at', '>=', $startDate);
        $intUniqueVisitors = (clone $intVisitorsQuery)->distinct('visitor_id')->count('visitor_id');
        $intSessions = (clone $intVisitorsQuery)->distinct('session_id')->count('session_id');
        $intPageViews = (clone $intVisitorsQuery)->where('event_type', 'page_view')->count();

        // 3. Leads & Consultations from actual database lead tables
        $constQuotes = QuoteRequest::where('business_type', 'construction')->where('created_at', '>=', $startDate)->count();
        $constContacts = ContactRequest::where('business_type', 'construction')->where('created_at', '>=', $startDate)->count();
        $constEnquiries = $constQuotes + $constContacts;

        $intConsultations = QuoteRequest::where('business_type', 'interior')->where('created_at', '>=', $startDate)->count();
        $intEnquiries = $intConsultations;

        $totalEnquiries = match ($division) {
            'construction' => $constEnquiries,
            'interior'     => $intEnquiries,
            default        => $constEnquiries + $intEnquiries,
        };

        $totalConsultations = match ($division) {
            'construction' => 0,
            'interior'     => $intConsultations,
            default        => $intConsultations,
        };

        // 4. Safe Conversion Rate Calculation
        $overallConversionRate = $uniqueVisitors > 0 
            ? round(($totalEnquiries / $uniqueVisitors) * 100, 2) 
            : 0.00;
        $constConversionRate = $constUniqueVisitors > 0 
            ? round(($constEnquiries / $constUniqueVisitors) * 100, 2) 
            : 0.00;
        $intConversionRate = $intUniqueVisitors > 0 
            ? round(($intEnquiries / $intUniqueVisitors) * 100, 2) 
            : 0.00;

        // 5. Time Series Data (Grouped by Date)
        $timeSeries = $this->getTimeSeries($division, $startDate);

        // 6. Traffic Sources Breakdown
        $trafficSources = (clone $query)
            ->whereNotNull('referrer_host')
            ->select('referrer_host', DB::raw('count(distinct visitor_id) as visitors'), DB::raw('count(*) as total'))
            ->groupBy('referrer_host')
            ->orderByDesc('visitors')
            ->limit(8)
            ->get();

        // 7. Device Breakdown
        $deviceStats = (clone $query)
            ->select('device_type', DB::raw('count(distinct visitor_id) as count'))
            ->groupBy('device_type')
            ->get();
        $deviceTotal = $deviceStats->sum('count');
        $deviceBreakdown = [];
        foreach ($deviceStats as $item) {
            $deviceBreakdown[$item->device_type] = [
                'count' => $item->count,
                'pct'   => $deviceTotal > 0 ? round(($item->count / $deviceTotal) * 100, 1) : 0,
            ];
        }

        // 8. Interior Section Performance (Funnel Drop-off across the 7 sections)
        $sectionPerformance = $this->getInteriorSectionPerformance($startDate);

        // 9. Top Content (Most viewed pages)
        $topPages = (clone $query)
            ->where('event_type', 'page_view')
            ->whereNotNull('page_name')
            ->select('page_name', DB::raw('count(*) as views'), DB::raw('count(distinct visitor_id) as visitors'))
            ->groupBy('page_name')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // 10. Top Projects and Packages Views
        $topProjects = (clone $query)
            ->where('event_type', 'project_view')
            ->whereNotNull('item_id')
            ->select('item_id', DB::raw('count(*) as views'))
            ->groupBy('item_id')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        $topPackages = (clone $query)
            ->where('event_type', 'package_view')
            ->whereNotNull('item_id')
            ->select('item_id', DB::raw('count(*) as views'))
            ->groupBy('item_id')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        // 11. Recent Leads with Attribution Preview
        $recentLeads = $this->getRecentLeadsAttribution($division);

        return [
            'period'                => $period,
            'division'              => $division,
            'kpis'                  => [
                'visitors'           => $uniqueVisitors, // Unique Visitors = COUNT(DISTINCT visitor_id)
                'unique_visitors'    => $uniqueVisitors,
                'sessions'           => $sessions,
                'page_views'         => $pageViews,
                'total_events'       => $totalEvents,
                'new_visitors'       => $newVisitors,
                'returning_visitors' => $returningVisitors,
                'enquiries'          => $totalEnquiries,
                'consultations'      => $totalConsultations,
                'conversion_rate'    => $overallConversionRate,
            ],
            'division_comparison'   => [
                'construction' => [
                    'visitors'        => $constUniqueVisitors,
                    'sessions'        => $constSessions,
                    'page_views'      => $constPageViews,
                    'enquiries'       => $constEnquiries,
                    'consultations'   => 0,
                    'conversion_rate' => $constConversionRate,
                ],
                'interior' => [
                    'visitors'        => $intUniqueVisitors,
                    'sessions'        => $intSessions,
                    'page_views'      => $intPageViews,
                    'enquiries'       => $intEnquiries,
                    'consultations'   => $intConsultations,
                    'conversion_rate' => $intConversionRate,
                ],
            ],
            'time_series'           => $timeSeries,
            'traffic_sources'       => $trafficSources,
            'device_breakdown'      => $deviceBreakdown,
            'section_performance'   => $sectionPerformance,
            'top_pages'             => $topPages,
            'top_projects'          => $topProjects,
            'top_packages'          => $topPackages,
            'recent_leads'          => $recentLeads,
        ];
    }

    /**
     * Get Interior single-page section view counts.
     */
    public function getInteriorSectionPerformance(Carbon $startDate): array
    {
        $sections = [
            'intro'        => '1. Intro / Hero',
            'services'     => '2. Interior Services',
            'projects'     => '3. Completed Projects',
            'testimonials' => '4. Client Testimonials',
            'engineer'     => '5. Civil Engineering Team',
            'packages'     => '6. Pricing Packages',
            'enquiry'      => '7. Book Consultation',
        ];

        $counts = WebsiteAnalytic::interior()
            ->where('event_type', 'section_view')
            ->where('created_at', '>=', $startDate)
            ->select('section_name', DB::raw('count(distinct session_id) as sessions'), DB::raw('count(*) as total'))
            ->groupBy('section_name')
            ->pluck('sessions', 'section_name')
            ->toArray();

        $result = [];
        foreach ($sections as $key => $label) {
            $cleanKey = ltrim($key, '#');
            $cleanKey = str_replace('interior-', '', $cleanKey);
            $val = $counts[$cleanKey] ?? $counts[$key] ?? $counts['interior-' . $key] ?? 0;
            $result[] = [
                'section_id'   => $key,
                'section_name' => $label,
                'views'        => $val,
            ];
        }

        return $result;
    }

    /**
     * Daily time series data for charts.
     */
    protected function getTimeSeries(string $division, Carbon $startDate): array
    {
        $events = WebsiteAnalytic::query()
            ->division($division)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(distinct visitor_id) as visitors'),
                DB::raw('count(case when event_type = "page_view" then 1 end) as page_views')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        // Lead queries by date
        $quotesQuery = QuoteRequest::where('created_at', '>=', $startDate);
        $contactsQuery = ContactRequest::where('created_at', '>=', $startDate);

        if ($division === 'construction') {
            $quotesQuery->where('business_type', 'construction');
            $contactsQuery->where('business_type', 'construction');
        } elseif ($division === 'interior') {
            $quotesQuery->where('business_type', 'interior');
            $contactsQuery->whereRaw('0 = 1'); // Contact requests are construction only
        }

        $dailyQuotes = $quotesQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')->pluck('total', 'date')->toArray();
        $dailyContacts = $contactsQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')->pluck('total', 'date')->toArray();

        // Generate full date range points
        $labels = [];
        $visitorsData = [];
        $pageViewsData = [];
        $enquiriesData = [];

        $current = $startDate->copy();
        $now = Carbon::now();

        while ($current <= $now) {
            $dateStr = $current->format('Y-m-d');
            $displayLabel = $current->format('d M');
            $labels[] = $displayLabel;

            $dayEvent = $events->get($dateStr);
            $visitorsData[] = $dayEvent ? (int)$dayEvent->visitors : 0;
            $pageViewsData[] = $dayEvent ? (int)$dayEvent->page_views : 0;

            $enquiryCount = ($dailyQuotes[$dateStr] ?? 0) + ($dailyContacts[$dateStr] ?? 0);
            $enquiriesData[] = (int)$enquiryCount;

            $current->addDay();
        }

        return [
            'labels'     => $labels,
            'visitors'   => $visitorsData,
            'page_views' => $pageViewsData,
            'enquiries'  => $enquiriesData,
        ];
    }

    /**
     * Retrieve recent leads with non-sensitive attribution.
     */
    protected function getRecentLeadsAttribution(string $division): array
    {
        $quotesQuery = QuoteRequest::orderBy('id', 'desc')->limit(15);
        if ($division === 'construction') {
            $quotesQuery->where('business_type', 'construction');
        } elseif ($division === 'interior') {
            $quotesQuery->where('business_type', 'interior');
        }

        $quotes = $quotesQuery->get();
        $leads = [];

        foreach ($quotes as $q) {
            // Find linked analytics event if available
            $event = WebsiteAnalytic::where('lead_id', $q->id)
                ->where('lead_type', 'quote_request')
                ->first();

            $leads[] = [
                'id'            => $q->id,
                'division'      => strtoupper($q->business_type ?: 'construction'),
                'name'          => $q->name,
                'phone'         => $q->phone ? substr($q->phone, 0, 3) . '****' . substr($q->phone, -3) : '—',
                'project_type'  => $q->project_type ?: 'Standard Enquiry',
                'source'        => $event?->referrer_host ?: 'Direct',
                'device'        => ucfirst($event?->device_type ?: 'Desktop'),
                'landing_page'  => $event?->page_name ?: ($q->business_type === 'interior' ? '/interior' : '/'),
                'created_at'    => $q->created_at ? $q->created_at->format('d M Y, h:i A') : '—',
                'is_read'       => (bool)$q->is_read,
            ];
        }

        return $leads;
    }
}
