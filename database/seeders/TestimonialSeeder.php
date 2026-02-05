<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Lerato M.', 'rating' => 5, 'comment' => 'The most peaceful stay with incredible views.'],
            ['name' => 'James K.', 'rating' => 5, 'comment' => 'Warm hospitality and a delicious breakfast.'],
            ['name' => 'Sophie N.', 'rating' => 4, 'comment' => 'Beautiful rooms and thoughtful touches everywhere.'],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create(array_merge($data, ['is_published' => true]));
        }
    }
}
