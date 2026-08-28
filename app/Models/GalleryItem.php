<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $table = 'gallery';

    protected $fillable = [
        'title', 'category', 'image_url', 'is_video', 'video_url', 'three_sixty_url'
    ];

    protected $casts = [
        'is_video' => 'boolean',
    ];
}
