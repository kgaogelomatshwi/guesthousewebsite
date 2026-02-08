<section class="py-16 bg-white">
    <div class="container max-w-3xl mx-auto">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="space-y-3 leading-relaxed">{!! $data['body'] ?? '' !!}</div>
    </div>
</section>
