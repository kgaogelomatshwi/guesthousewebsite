@php
    $slides = $data['slides'] ?? [];
@endphp

<section class="section-hero hero-slider" data-interval="6500">
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
            <div class="container hero-inner">
                <h1>{{ $slide['title'] ?? 'Welcome to Our Guesthouse' }}</h1>
                @if(!empty($slide['subtitle']))
                    <p>{{ $slide['subtitle'] }}</p>
                @endif
                <div class="cta-row">
                    @if(!empty($slide['button_label']))
                        <a class="btn btn-primary js-track-cta" data-event="start_booking" href="{{ $slide['button_url'] ?? route('booking.create') }}">{{ $slide['button_label'] }}</a>
                    @endif
                    @if(!empty($slide['secondary_button_label']))
                        <a class="btn btn-outline js-track-cta" data-event="cta_click" href="{{ $slide['secondary_button_url'] ?? route('rooms.index') }}">{{ $slide['secondary_button_label'] }}</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</section>
