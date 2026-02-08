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
                <x-room-card :room="$room" :show-book="false" />
            @endforeach
        </div>
    </div>
</section>
