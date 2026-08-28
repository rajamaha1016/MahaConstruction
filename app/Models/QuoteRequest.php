<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $table = 'quote_requests';

    protected $fillable = ['name', 'email', 'phone', 'project_type', 'budget_range', 'message', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];
}
