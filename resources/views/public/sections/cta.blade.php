<section class="py-16 bg-black text-white">
    <div class="container">
        <div class="flex flex-wrap items-center justify-between gap-8">
            <div>
                <h2 class="text-2xl font-semibold">{{ $data['headline'] ?? 'Ready for a countryside escape?' }}</h2>
                @if(!empty($data['body']))
                    <p class="text-neutral-200">{{ $data['body'] }}</p>
                @endif
            </div>
            <div>
                @if(!empty($data['button_label']))
                    <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-white text-black shadow-lg js-track-cta" data-event="cta_click" href="{{ $data['button_url'] ?? route('booking.create') }}">{{ $data['button_label'] }}</a>
                @else
                    @include('public.partials.booking-cta')
                @endif
            </div>
        </div>
    </div>
</section>
