<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="grid gap-6 md:grid-cols-4 mt-6">
            @foreach($data['items'] ?? [] as $item)
                <div class="bg-white rounded-xl p-5 shadow-sm border border-black/5 space-y-2">
                    @if(!empty($item['icon']))
                        <div class="text-2xl">{{ $item['icon'] }}</div>
                    @endif
                    <h3 class="text-lg font-semibold">{{ $item['title'] ?? '' }}</h3>
                    @if(!empty($item['text']))
                        <p class="text-sm text-neutral-600">{{ $item['text'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
