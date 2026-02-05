@php
    $limit = $data['limit'] ?? 3;
    $testimonials = \App\Models\Testimonial::where('is_published', true)->orderByDesc('date')->limit($limit)->get();
@endphp
<section class="section section-light">
    <div class="container">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        <div class="grid-3">
            @foreach($testimonials as $testimonial)
                <x-card>
                    <div class="card-body">
                        <p class="stars">{{ str_repeat('*', $testimonial->rating) }}</p>
                        <p>"{{ $testimonial->comment }}"</p>
                        <p><strong>{{ $testimonial->name }}</strong></p>
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
</section>
