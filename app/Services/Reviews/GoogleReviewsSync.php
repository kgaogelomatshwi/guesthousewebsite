<?php

namespace App\Services\Reviews;

use App\Models\ExternalReview;
use App\Services\SettingsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleReviewsSync
{
    public function sync(SettingsService $settings): array
    {
        $apiKey = (string) $settings->get('google_api_key', '');
        $placeId = (string) $settings->get('google_place_id', '');

        if ($apiKey === '' || $placeId === '') {
            return [
                'status' => 'missing',
                'message' => 'Google API key or Place ID is missing.',
                'count' => 0,
            ];
        }

        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $placeId,
            'fields' => 'name,rating,reviews,url',
            'language' => 'en',
            'key' => $apiKey,
        ]);

        if (! $response->ok()) {
            return [
                'status' => 'error',
                'message' => 'Google API request failed.',
                'count' => 0,
            ];
        }

        $payload = $response->json();
        if (($payload['status'] ?? 'ERROR') !== 'OK') {
            return [
                'status' => 'error',
                'message' => 'Google API returned status: ' . ($payload['status'] ?? 'UNKNOWN'),
                'count' => 0,
            ];
        }

        $result = $payload['result'] ?? [];
        $reviews = $result['reviews'] ?? [];
        $placeUrl = $result['url'] ?? null;

        $count = 0;
        foreach ($reviews as $review) {
            $externalId = sha1($placeId . '|' . ($review['author_name'] ?? '') . '|' . ($review['time'] ?? ''));

            ExternalReview::updateOrCreate([
                'source' => 'google',
                'external_id' => $externalId,
            ], [
                'author_name' => $review['author_name'] ?? null,
                'rating' => (int) ($review['rating'] ?? 0),
                'comment' => $review['text'] ?? null,
                'reviewed_at' => isset($review['time']) ? Carbon::createFromTimestamp((int) $review['time']) : null,
                'review_url' => $placeUrl,
                'avatar_url' => $review['profile_photo_url'] ?? null,
                'is_published' => true,
                'raw_payload' => $review,
            ]);
            $count++;
        }

        return [
            'status' => 'ok',
            'message' => 'Google reviews synced.',
            'count' => $count,
        ];
    }
}
