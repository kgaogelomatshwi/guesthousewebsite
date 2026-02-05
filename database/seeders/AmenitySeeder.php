<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            'Free Wi-Fi',
            'Breakfast Included',
            'Air Conditioning',
            'Mountain View',
            'Swimming Pool',
            'Secure Parking',
            'Fireplace',
        ];

        foreach ($amenities as $name) {
            Amenity::firstOrCreate(['name' => $name]);
        }
    }
}
