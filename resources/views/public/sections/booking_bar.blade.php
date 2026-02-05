<section class="section section-light">
    <div class="container">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        @if(!empty($data['subtitle']))
            <p>{{ $data['subtitle'] }}</p>
        @endif

        <div class="booking-bar">
            @include('public.partials.ota-redirect-form')
        </div>
    </div>
</section>
