<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQItem extends Model
{
    protected $table = 'faqs';

    protected $fillable = ['question', 'answer', 'category'];
}
