@php
    $bg = null;
    if (!empty($data['background_image'])) {
        $bg = \Illuminate\Support\Str::startsWith($data['background_image'], ['http://', 'https://'])
            ? $data['background_image']
            : asset('storage/' . $data['background_image']);
    }
@endphp
<section class="section section-hero" @if($bg) style="background-image: url('{{ $bg }}');" @endif>
    <div class="container">
        <h1>{{ $data['title'] ?? 'Welcome to Our Guesthouse' }}</h1>
        @if(!empty($data['subtitle']))
            <p>{{ $data['subtitle'] }}</p>
        @endif
        <div class="cta-row">
            @if(!empty($data['button_label']))
                <a class="btn btn-primary js-track-cta" data-event="start_booking" href="{{ $data['button_url'] ?? route('booking.create') }}">{{ $data['button_label'] }}</a>
            @endif
            @if(!empty($data['secondary_button_label']))
                <a class="btn btn-outline js-track-cta" data-event="cta_click" href="{{ $data['secondary_button_url'] ?? route('rooms.index') }}">{{ $data['secondary_button_label'] }}</a>
            @endif
        </div>
    </div>
</section>
