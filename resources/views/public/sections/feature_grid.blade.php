<section class="section section-light">
    <div class="container">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        <div class="grid-3">
            @foreach($data['items'] ?? [] as $item)
                <x-card>
                    <div class="card-body">
                        @if(!empty($item['icon']))
                            <div class="icon">{{ $item['icon'] }}</div>
                        @endif
                        <h3>{{ $item['title'] ?? '' }}</h3>
                        <p>{{ $item['text'] ?? '' }}</p>
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
</section>
