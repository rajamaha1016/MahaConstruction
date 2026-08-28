<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $table = 'contact_requests';

    protected $fillable = ['name', 'email', 'phone', 'message', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];
}
