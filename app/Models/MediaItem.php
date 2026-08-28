<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    protected $table = 'media';

    protected $fillable = ['filename', 'filepath', 'filetype'];
}
