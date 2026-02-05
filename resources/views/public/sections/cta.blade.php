<section class="section section-cta">
    <div class="container">
        <div class="cta-inner">
            <div>
                <h2>{{ $data['headline'] ?? 'Ready for a countryside escape?' }}</h2>
                @if(!empty($data['body']))
                    <p>{{ $data['body'] }}</p>
                @endif
            </div>
            <div>
                @if(!empty($data['button_label']))
                    <a class="btn btn-primary js-track-cta" data-event="cta_click" href="{{ $data['button_url'] ?? route('booking.create') }}">{{ $data['button_label'] }}</a>
                @else
                    @include('public.partials.booking-cta')
                @endif
            </div>
        </div>
    </div>
</section>
