<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Rooms', 'Garden & Views'];

        foreach ($categories as $index => $name) {
            $category = GalleryCategory::firstOrCreate([
                'slug' => Str::slug($name),
            ], [
                'name' => $name,
            ]);

            for ($i = 1; $i <= 4; $i++) {
                $svg = $this->makeSvg("{$name} {$i}");
                $path = "demo/gallery/" . $category->slug . "-{$i}.svg";
                Storage::disk('public')->put($path, $svg);

                GalleryImage::updateOrCreate([
                    'category_id' => $category->id,
                    'path' => $path,
                ], [
                    'position' => $i,
                ]);
            }
        }
    }

    private function makeSvg(string $label): string
    {
        $safeLabel = htmlspecialchars($label, ENT_QUOTES);

        return "<svg xmlns='http://www.w3.org/2000/svg' width='1200' height='800'>" .
            "<rect width='1200' height='800' fill='#cfe0d2'/>" .
            "<text x='50%' y='50%' font-size='48' text-anchor='middle' fill='#2f3b2f' font-family='Arial'>{$safeLabel}</text>" .
            "</svg>";
    }
}
