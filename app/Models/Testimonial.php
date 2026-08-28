<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $table = 'testimonials';

    protected $fillable = [
        'client_name', 'client_role', 'rating', 'feedback',
        'image_url', 'video_url', 'project_name', 'duration'
    ];

    protected $casts = ['rating' => 'integer'];
}
