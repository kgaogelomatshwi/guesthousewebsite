<?php

namespace Database\Seeders;

use App\Models\Attraction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttractionSeeder extends Seeder
{
    public function run(): void
    {
        $attractions = [
            ['title' => 'River Walk', 'distance_km' => 1.5, 'description' => 'A gentle trail along the river banks.'],
            ['title' => 'Wine Estate Tour', 'distance_km' => 12, 'description' => 'Guided tastings at nearby vineyards.'],
            ['title' => 'Mountain Lookout', 'distance_km' => 8, 'description' => 'Panoramic views at golden hour.'],
        ];

        foreach ($attractions as $index => $data) {
            $slug = Str::slug($data['title']);
            $svg = $this->makeSvg($data['title']);
            $path = "demo/attractions/{$slug}.svg";
            Storage::disk('public')->put($path, $svg);

            Attraction::updateOrCreate([
                'slug' => $slug,
            ], [
                'title' => $data['title'],
                'image_path' => $path,
                'distance_km' => $data['distance_km'],
                'description' => $data['description'],
                'position' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    private function makeSvg(string $label): string
    {
        $safeLabel = htmlspecialchars($label, ENT_QUOTES);

        return "<svg xmlns='http://www.w3.org/2000/svg' width='1200' height='800'>" .
            "<rect width='1200' height='800' fill='#f3d7c5'/>" .
            "<text x='50%' y='50%' font-size='48' text-anchor='middle' fill='#7a3f2c' font-family='Arial'>{$safeLabel}</text>" .
            "</svg>";
    }
}
