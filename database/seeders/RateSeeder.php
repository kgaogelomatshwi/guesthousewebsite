<?php

namespace Database\Seeders;

use App\Models\Rate;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    public function run(): void
    {
        $rates = [
            [
                'title' => 'Standard Rate',
                'description' => 'Includes breakfast and daily housekeeping.',
                'price' => 1500,
                'is_active' => true,
            ],
            [
                'title' => 'Peak Season',
                'description' => 'Applies to December and school holidays.',
                'price' => 1900,
                'season_start' => now()->year . '-12-01',
                'season_end' => now()->year . '-12-31',
                'notes' => 'Minimum 2-night stay.',
                'is_active' => true,
            ],
        ];

        foreach ($rates as $rate) {
            Rate::create($rate);
        }
    }
}
