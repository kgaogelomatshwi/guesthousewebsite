@php
    $bg = null;
    if (!empty($data['background_image'])) {
        $bg = \Illuminate\Support\Str::startsWith($data['background_image'], ['http://', 'https://'])
            ? $data['background_image']
            : asset('storage/' . $data['background_image']);
    }
@endphp
<section class="py-24 text-white bg-black" @if($bg) style="background-image: url('{{ $bg }}'); background-size: cover; background-position: center;" @endif>
    <div class="container">
        <h1 class="text-4xl md:text-5xl uppercase tracking-widest">{{ $data['title'] ?? 'Welcome to Our Guesthouse' }}</h1>
        @if(!empty($data['subtitle']))
            <p class="text-lg max-w-xl">{{ $data['subtitle'] }}</p>
        @endif
        <div class="flex flex-wrap gap-4 mt-5">
            @if(!empty($data['button_label']))
                <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="start_booking" href="{{ $data['button_url'] ?? route('booking.create') }}">{{ $data['button_label'] }}</a>
            @endif
            @if(!empty($data['secondary_button_label']))
                <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition js-track-cta" data-event="cta_click" href="{{ $data['secondary_button_url'] ?? route('rooms.index') }}">{{ $data['secondary_button_label'] }}</a>
            @endif
        </div>
    </div>
</section>
