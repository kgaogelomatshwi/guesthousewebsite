<section class="py-16 bg-white">
    <div class="container grid gap-8 lg:grid-cols-2">
        <div>
            <h2 class="text-2xl font-semibold">{{ $data['title'] ?? 'Location' }}</h2>
            <p class="text-neutral-600 mt-2">{{ $data['address'] ?? '' }}</p>
            @if(!empty($data['button_label']))
                <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition mt-4" href="{{ $data['button_url'] ?? '#' }}" target="_blank" rel="noopener">{{ $data['button_label'] }}</a>
            @endif
        </div>
        <div class="rounded-xl overflow-hidden">
            {!! $data['embed_code'] ?? '' !!}
        </div>
    </div>
</section>
