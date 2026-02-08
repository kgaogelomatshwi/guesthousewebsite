<section class="py-16 bg-white">
    <div class="container grid gap-8 lg:grid-cols-[1.2fr,0.8fr]">
        <div class="space-y-4">
            <h2 class="text-2xl font-semibold">{{ $data['title'] ?? 'About Us' }}</h2>
            <div class="space-y-3 leading-relaxed text-neutral-700">{!! $data['body'] ?? '' !!}</div>
            @if(!empty($data['button_label']))
                <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ $data['button_url'] ?? route('pages.about') }}">{{ $data['button_label'] }}</a>
            @endif
        </div>
        <div class="bg-neutral-100 rounded-2xl p-6">
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach($data['stats'] ?? [] as $stat)
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-black/5">
                        <p class="text-2xl font-semibold">{{ $stat['value'] ?? '' }}</p>
                        <p class="text-sm uppercase tracking-wider text-neutral-500">{{ $stat['label'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
