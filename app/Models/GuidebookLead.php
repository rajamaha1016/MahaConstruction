<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuidebookLead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
    ];
}
