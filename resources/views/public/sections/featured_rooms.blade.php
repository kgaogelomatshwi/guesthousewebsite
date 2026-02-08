@php
    $limit = $data['limit'] ?? 3;
    $rooms = \App\Models\Room::where('featured', true)->where('status', 'active')->with('images')->limit($limit)->get();
@endphp
<section class="py-16 bg-white">
    <div class="container">
        @if(!empty($data['title']))
            <h2 class="text-2xl font-semibold">{{ $data['title'] }}</h2>
        @endif
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($rooms as $room)
                <x-card>
                    @if($room->primary_image)
                        <img class="w-full h-52 object-cover" src="{{ asset('storage/' . $room->primary_image->path) }}" alt="{{ $room->title }}">
                    @endif
                    <div class="p-5 space-y-2">
                        <h3 class="text-lg font-semibold">{{ $room->title }}</h3>
                        <p class="text-neutral-600">{{ $room->short_description }}</p>
                        <p class="font-semibold text-black">{{ $room->currency }} {{ number_format($room->base_price, 2) }}</p>
                        <x-button :href="route('rooms.show', $room->slug)">View Room</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
</section>
