@php
    $bg = null;
    if (!empty($data['background_image'])) {
        $bg = \Illuminate\Support\Str::startsWith($data['background_image'], ['http://', 'https://'])
            ? $data['background_image']
            : asset('storage/' . $data['background_image']);
    }
@endphp

<section class="relative bg-black text-white" @if($bg) style="background-image: url('{{ $bg }}'); background-size: cover; background-position: center;" @endif>
    <div class="absolute inset-0 bg-black/55"></div>
    <div class="container relative z-10 py-28">
        <div class="max-w-2xl space-y-4">
            <h1 class="text-4xl md:text-5xl uppercase tracking-widest">{{ $data['title'] ?? 'Countryside Retreat in Limpopo' }}</h1>
            @if(!empty($data['subtitle']))
                <p class="text-lg text-neutral-100">{{ $data['subtitle'] }}</p>
            @endif
            <div class="flex flex-wrap gap-4">
                @if(!empty($data['button_label']))
                    <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-white text-black shadow-lg js-track-cta" data-event="start_booking" href="{{ $data['button_url'] ?? route('booking.create') }}">{{ $data['button_label'] }}</a>
                @endif
                @if(!empty($data['secondary_button_label']))
                    <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-white text-white bg-transparent transition js-track-cta" data-event="cta_click" href="{{ $data['secondary_button_url'] ?? route('rooms.index') }}">{{ $data['secondary_button_label'] }}</a>
                @endif
            </div>
        </div>

        <div class="mt-10">
            @include('public.partials.availability-form')
        </div>
    </div>
</section>
