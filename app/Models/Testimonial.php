<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'rating',
        'comment',
        'date',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'date' => 'date',
    ];
}
