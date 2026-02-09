<?php

namespace Database\Seeders;

use App\Models\ExternalReview;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExternalReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'source' => 'google',
                'external_id' => 'google-demo-1',
                'author_name' => 'Lerato M.',
                'rating' => 5,
                'comment' => 'Peaceful stay with friendly hosts. Rooms were clean and quiet.',
                'reviewed_at' => Carbon::now()->subDays(30),
                'review_url' => null,
                'avatar_url' => null,
                'is_published' => true,
            ],
            [
                'source' => 'google',
                'external_id' => 'google-demo-2',
                'author_name' => 'Thabo K.',
                'rating' => 4,
                'comment' => 'Great value for money and lovely countryside views.',
                'reviewed_at' => Carbon::now()->subDays(52),
                'review_url' => null,
                'avatar_url' => null,
                'is_published' => true,
            ],
            [
                'source' => 'bookingcom',
                'external_id' => 'booking-demo-1',
                'author_name' => 'Samantha P.',
                'rating' => 4,
                'comment' => 'Comfortable beds and easy check-in. Will return.',
                'reviewed_at' => Carbon::now()->subDays(40),
                'review_url' => null,
                'avatar_url' => null,
                'is_published' => true,
            ],
        ];

        foreach ($reviews as $review) {
            ExternalReview::updateOrCreate([
                'source' => $review['source'],
                'external_id' => $review['external_id'],
            ], $review);
        }
    }
}
