@php
    $alignment = $data['alignment'] ?? 'left';
    $image = !empty($data['image']) ? asset('storage/' . $data['image']) : null;
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
