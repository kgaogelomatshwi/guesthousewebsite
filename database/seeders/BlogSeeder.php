<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $category = BlogCategory::firstOrCreate([
            'slug' => 'local-tips',
        ], [
            'name' => 'Local Tips',
        ]);

        BlogPost::updateOrCreate([
            'slug' => 'best-valley-stops',
        ], [
            'title' => 'Best Valley Stops for a Weekend',
            'excerpt' => 'From farm stalls to sunset hikes, here is our local list.',
            'body' => 'Spend the morning on the river path, followed by a vineyard tasting and a sunset drive.',
            'category_id' => $category->id,
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
