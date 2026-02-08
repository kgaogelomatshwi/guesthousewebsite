<section class="py-16 bg-white">
    <div class="container max-w-3xl mx-auto">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="divide-y divide-black/10">
            @foreach($data['items'] ?? [] as $item)
                <details class="py-3">
                    <summary class="font-semibold">{{ $item['question'] ?? '' }}</summary>
                    <p class="text-neutral-600 mt-2">{{ $item['answer'] ?? '' }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
