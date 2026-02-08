<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="rounded-xl overflow-hidden">{!! $data['embed_code'] ?? '' !!}</div>
    </div>
</section>
