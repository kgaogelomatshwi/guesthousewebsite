@props([
    'room',
    'showBook' => true,
    'search' => [],
])

<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-black/5">
    @if($room->primary_image)
        <img class="w-full h-52 object-cover" src="{{ asset('storage/' . $room->primary_image->path) }}" alt="{{ $room->title }}" loading="lazy">
    @endif
    <div class="p-5 space-y-2">
        <h3 class="text-lg font-semibold">{{ $room->title }}</h3>
        <p class="text-neutral-600">{{ $room->short_description }}</p>
        <div class="flex items-center justify-between text-sm text-neutral-600">
            <span class="font-semibold text-black">{{ $room->currency }} {{ number_format($room->base_price, 2) }} / night</span>
            <span>Max {{ $room->max_guests }} guests</span>
        </div>
        <div class="flex flex-wrap gap-2">
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ route('rooms.show', $room->slug) }}">View Room</a>
            @if($showBook)
                <a class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg" href="{{ route('booking.create', array_filter([
                    'room_id' => $room->id,
                    'check_in' => $search['check_in'] ?? null,
                    'check_out' => $search['check_out'] ?? null,
                    'adults' => $search['adults'] ?? null,
                    'children' => $search['children'] ?? null,
                ])) }}">Book Now</a>
            @endif
        </div>
    </div>
</div>
