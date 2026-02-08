@php
    $mode = $data['mode'] ?? 'auto';
    $amenities = $mode === 'custom'
        ? ($data['custom_list'] ?? [])
        : \App\Models\Amenity::orderBy('name')->pluck('name')->toArray();
@endphp
<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <ul class="flex flex-wrap gap-2 list-none p-0">
            @foreach($amenities as $amenity)
                <li class="bg-neutral-100 px-3 py-2 rounded-full">{{ $amenity }}</li>
            @endforeach
        </ul>
    </div>
</section>
