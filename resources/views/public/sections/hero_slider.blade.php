@php
    $slides = $data['slides'] ?? [];
@endphp

<section class="relative min-h-[420px] overflow-hidden text-white bg-black" data-interval="6500">
    @foreach($slides as $index => $slide)
        @php
            $bg = null;
            if (!empty($slide['image'])) {
                $bg = \Illuminate\Support\Str::startsWith($slide['image'], ['http://', 'https://'])
                    ? $slide['image']
                    : asset('storage/' . $slide['image']);
            }
        @endphp
        <div class="hero-slide @if($index === 0) is-active @endif" @if($bg) style="background-image: url('{{ $bg }}');" @endif>
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
            </div>
        </div>
    @endforeach
</section>
