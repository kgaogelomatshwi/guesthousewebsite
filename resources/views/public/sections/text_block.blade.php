<section class="section section-light">
    <div class="container narrow">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        <div class="rich-text">{!! $data['body'] ?? '' !!}</div>
    </div>
</section>
