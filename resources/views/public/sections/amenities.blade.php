@php
    $mode = $data['mode'] ?? 'auto';
    $amenities = $mode === 'custom'
        ? ($data['custom_list'] ?? [])
        : \App\Models\Amenity::orderBy('name')->pluck('name')->toArray();
@endphp
<section class="section section-light">
    <div class="container">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        <ul class="chip-list">
            @foreach($amenities as $amenity)
                <li>{{ $amenity }}</li>
            @endforeach
        </ul>
    </div>
</section>
