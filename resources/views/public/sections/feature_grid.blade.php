<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($data['items'] ?? [] as $item)
                <x-card>
                    <div class="p-5 space-y-2">
                        @if(!empty($item['icon']))
                            <div class="text-2xl">{{ $item['icon'] }}</div>
                        @endif
                        <h3 class="text-lg font-semibold">{{ $item['title'] ?? '' }}</h3>
                        <p class="text-neutral-600">{{ $item['text'] ?? '' }}</p>
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
</section>
