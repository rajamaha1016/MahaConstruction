<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'name', 'client', 'location', 'budget', 'completion_date',
        'duration', 'architecture_style', 'description',
        'image_urls', 'video_url', 'timeline', 'category', 'is_featured'
    ];

    protected $casts = [
        'image_urls'  => 'array',
        'timeline'    => 'array',
        'is_featured' => 'boolean',
    ];
}
