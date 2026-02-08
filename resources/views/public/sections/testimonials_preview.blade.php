@php
    $limit = $data['limit'] ?? 3;
    $testimonials = \App\Models\Testimonial::where('is_published', true)->orderByDesc('date')->limit($limit)->get();
@endphp
<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($testimonials as $testimonial)
                <x-card>
                    <div class="p-5 space-y-2">
                        <p class="font-semibold text-black">{{ str_repeat('*', $testimonial->rating) }}</p>
                        <p class="text-neutral-600">"{{ $testimonial->comment }}"</p>
                        <p><strong>{{ $testimonial->name }}</strong></p>
                    </div>
                </x-card>
            @endforeach
        </div>
        <div class="mt-4">
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ route('pages.about') }}">View all testimonials</a>
        </div>
    </div>
</section>
