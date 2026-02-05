@php
    $alignment = $data['alignment'] ?? 'left';
    $image = null;
    if (!empty($data['image'])) {
        $image = \Illuminate\Support\Str::startsWith($data['image'], ['http://', 'https://'])
            ? $data['image']
            : asset('storage/' . $data['image']);
    }
@endphp
<section class="section section-light">
    <div class="container grid-2 {{ $alignment === 'right' ? 'reverse' : '' }}">
        <div>
            @if($image)
                <img class="feature-img" src="{{ $image }}" alt="{{ $data['caption'] ?? '' }}">
            @endif
        </div>
        <div>
            @if(!empty($data['caption']))
                <h3>{{ $data['caption'] }}</h3>
            @endif
        </div>
    </div>
</section>
