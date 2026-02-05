<section class="section section-light">
    <div class="container narrow">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        <div class="faq">
            @foreach($data['items'] ?? [] as $item)
                <details>
                    <summary>{{ $item['question'] ?? '' }}</summary>
                    <p>{{ $item['answer'] ?? '' }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>
