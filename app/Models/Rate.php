<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'season_start',
        'season_end',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'season_start' => 'date',
        'season_end' => 'date',
        'price' => 'decimal:2',
    ];
}
