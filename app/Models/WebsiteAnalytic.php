<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WebsiteAnalytic extends Model
{
    public const UPDATED_AT = null; // Append-only analytics time-series

    protected $table = 'website_analytics';

    public const BUSINESS_CONSTRUCTION = 'construction';
    public const BUSINESS_INTERIOR     = 'interior';

    public const BUSINESS_TYPES = [
        self::BUSINESS_CONSTRUCTION,
        self::BUSINESS_INTERIOR,
    ];

    public const EVENT_TYPES = [
        'page_view',
        'session_start',
        'section_view',
        'project_view',
        'package_view',
        'consultation_click',
        'enquiry_submitted',
        'quote_submitted',
        'contact_submitted',
    ];

    protected $fillable = [
        'business_type',
        'event_type',
        'visitor_id',
        'session_id',
        'page_url',
        'page_name',
        'section_name',
        'item_id',
        'lead_id',
        'lead_type',
        'referrer',
        'referrer_host',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'device_type',
        'ip_hash',
        'user_agent_short',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Scope for strict construction filtering.
     */
    public function scopeConstruction($query)
    {
        return $query->where('business_type', self::BUSINESS_CONSTRUCTION);
    }

    /**
     * Scope for strict interior filtering.
     */
    public function scopeInterior($query)
    {
        return $query->where('business_type', self::BUSINESS_INTERIOR);
    }

    /**
     * Scope for division filtering ('all', 'construction', 'interior').
     * Enforces strict boundaries with no NULL fallback.
     */
    public function scopeDivision($query, ?string $division)
    {
        if ($division === self::BUSINESS_CONSTRUCTION) {
            return $query->where('business_type', self::BUSINESS_CONSTRUCTION);
        }

        if ($division === self::BUSINESS_INTERIOR) {
            return $query->where('business_type', self::BUSINESS_INTERIOR);
        }

        // 'all' includes both valid business types strictly
        return $query->whereIn('business_type', self::BUSINESS_TYPES);
    }

    /**
     * Scope for filtering by date period.
     */
    public function scopePeriod($query, ?string $period)
    {
        $now = Carbon::now();

        return match ($period) {
            'today'    => $query->where('created_at', '>=', $now->copy()->startOfDay()),
            '7days'    => $query->where('created_at', '>=', $now->copy()->subDays(7)->startOfDay()),
            '30days'   => $query->where('created_at', '>=', $now->copy()->subDays(30)->startOfDay()),
            '3months'  => $query->where('created_at', '>=', $now->copy()->subMonths(3)->startOfDay()),
            '1year'    => $query->where('created_at', '>=', $now->copy()->subYear()->startOfDay()),
            default    => $query->where('created_at', '>=', $now->copy()->subDays(30)->startOfDay()),
        };
    }
}
