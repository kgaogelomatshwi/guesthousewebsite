@php
    $slides = $data['slides'] ?? [];
    $showBooking = $data['show_booking_form'] ?? true;
@endphp

<section class="hero-slider relative min-h-[520px] overflow-hidden text-white bg-black" data-interval="6500">
    @foreach($slides as $index => $slide)
        @php
            $bg = null;
            if (!empty($slide['image'])) {
                $bg = \Illuminate\Support\Str::startsWith($slide['image'], ['http://', 'https://'])
                    ? $slide['image']
                    : asset('storage/' . $slide['image']);
            }
        @endphp
        <div class="hero-slide absolute inset-0 grid items-center opacity-0 transition-opacity duration-700" @if($bg) style="background-image: url('{{ $bg }}'); background-size: cover; background-position: center;" @endif>
            <div class="absolute inset-0 bg-black/55"></div>
            <div class="container relative z-10 py-24 text-white">
                <h1 class="text-4xl md:text-5xl uppercase tracking-widest">{{ $slide['title'] ?? 'Welcome to Our Guesthouse' }}</h1>
                @if(!empty($slide['subtitle']))
                    <p class="text-lg max-w-xl">{{ $slide['subtitle'] }}</p>
                @endif
                <div class="flex flex-wrap gap-4 mt-5">
                    @if(!empty($slide['button_label']))
                        <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="start_booking" href="{{ $slide['button_url'] ?? route('booking.create') }}">{{ $slide['button_label'] }}</a>
                    @endif
                    @if(!empty($slide['secondary_button_label']))
                        <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition js-track-cta" data-event="cta_click" href="{{ $slide['secondary_button_url'] ?? route('rooms.index') }}">{{ $slide['secondary_button_label'] }}</a>
                    @endif
                </div>

                @if($showBooking)
                    <div class="mt-10">
                        @include('public.partials.availability-form')
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    @if(count($slides) > 1)
        <div class="hero-controls">
            <button class="hero-nav" type="button" aria-label="Previous slide" data-hero-prev>&larr;</button>
            <button class="hero-nav" type="button" aria-label="Next slide" data-hero-next>&rarr;</button>
        </div>
        <div class="hero-dots" role="tablist" aria-label="Hero slides">
            @foreach($slides as $index => $slide)
                <button class="hero-dot" type="button" aria-label="Go to slide {{ $index + 1 }}" data-hero-dot="{{ $index }}"></button>
            @endforeach
        </div>
    @endif
</section>
