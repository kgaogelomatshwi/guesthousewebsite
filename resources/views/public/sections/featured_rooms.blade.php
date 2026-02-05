@php
    $limit = $data['limit'] ?? 3;
    $rooms = \App\Models\Room::where('featured', true)->where('status', 'active')->with('images')->limit($limit)->get();
@endphp
<section class="section section-light">
    <div class="container">
        @if(!empty($data['title']))
            <h2>{{ $data['title'] }}</h2>
        @endif
        <div class="grid-3">
            @foreach($rooms as $room)
                <x-card>
                    @if($room->primary_image)
                        <img class="card-img" src="{{ asset('storage/' . $room->primary_image->path) }}" alt="{{ $room->title }}">
                    @endif
                    <div class="card-body">
                        <h3>{{ $room->title }}</h3>
                        <p>{{ $room->short_description }}</p>
                        <p class="price">{{ $room->currency }} {{ number_format($room->base_price, 2) }}</p>
                        <x-button :href="route('rooms.show', $room->slug)">View Room</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
</section>
