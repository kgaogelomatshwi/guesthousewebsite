<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalReview extends Model
{
    protected $fillable = [
        'source',
        'external_id',
        'author_name',
        'rating',
        'comment',
        'reviewed_at',
        'review_url',
        'avatar_url',
        'is_published',
        'raw_payload',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'reviewed_at' => 'datetime',
        'raw_payload' => 'array',
    ];
}
