<section class="section section-light">
    <div class="container">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        <div class="map-embed">{!! $data['embed_code'] ?? '' !!}</div>
    </div>
</section>
