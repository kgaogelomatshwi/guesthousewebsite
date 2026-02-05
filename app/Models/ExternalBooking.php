<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalBooking extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'platform',
        'booking_reference',
        'check_in',
        'check_out',
        'guests',
        'room_type',
        'notes',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];
}
