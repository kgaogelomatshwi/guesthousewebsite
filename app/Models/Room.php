<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'status',
        'short_description',
        'description',
        'base_price',
        'currency',
        'max_guests',
        'bed_type',
        'featured',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(RoomImage::class)->orderBy('position');
    }

    public function getPrimaryImageAttribute(): ?RoomImage
    {
        return $this->images->first();
    }
}
