<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'path',
        'title',
        'alt_text',
        'caption',
        'mime_type',
        'size_bytes',
    ];
}
