@php
    $limit = $data['limit'] ?? 3;
    $minRating = (int) ($siteSettings['reviews_min_rating'] ?? 3);

    $internal = \App\Models\Testimonial::where('is_published', true)
        ->where('rating', '>=', $minRating)
        ->orderByDesc('date')
        ->get()
        ->map(function ($item) {
            return (object) [
                'source' => 'guest',
                'source_label' => 'Guest',
                'name' => $item->name,
                'rating' => (int) $item->rating,
                'comment' => $item->comment,
                'reviewed_at' => $item->date,
                'url' => null,
            ];
        });

    $external = \App\Models\ExternalReview::where('is_published', true)
        ->where('rating', '>=', $minRating)
        ->orderByDesc('reviewed_at')
        ->get()
        ->map(function ($item) {
            $label = $item->source === 'google' ? 'Google' : ($item->source === 'bookingcom' ? 'Booking.com' : ucfirst($item->source));
            return (object) [
                'source' => $item->source,
                'source_label' => $label,
                'name' => $item->author_name ?? 'Guest',
                'rating' => (int) $item->rating,
                'comment' => $item->comment,
                'reviewed_at' => $item->reviewed_at,
                'url' => $item->review_url,
            ];
        });

    $reviews = $external->concat($internal)
        ->sortByDesc(function ($item) {
            return optional($item->reviewed_at)->timestamp ?? 0;
        })
        ->take($limit);

    $bookingReviewsUrl = $siteSettings['bookingcom_reviews_url'] ?? null;
    $googlePlaceUrl = $siteSettings['google_place_url'] ?? null;
@endphp

<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($reviews as $review)
                <x-card>
                    <div class="p-5 space-y-2">
                        <p class="font-semibold text-black">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', max(0, 5 - $review->rating)) }}</p>
                        <p class="text-neutral-600">"{{ $review->comment }}"</p>
                        <div class="flex items-center justify-between text-sm text-neutral-500">
                            <span><strong>{{ $review->name }}</strong></span>
                            <span>{{ $review->source_label }}</span>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
        <div class="mt-4 flex flex-wrap gap-3">
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ route('pages.about') }}">View all testimonials</a>
            @if($bookingReviewsUrl)
                <a class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ $bookingReviewsUrl }}" target="_blank" rel="noopener">Booking.com reviews</a>
            @endif
            @if($googlePlaceUrl)
                <a class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ $googlePlaceUrl }}" target="_blank" rel="noopener">Google reviews</a>
            @endif
        </div>
    </div>
</section>
