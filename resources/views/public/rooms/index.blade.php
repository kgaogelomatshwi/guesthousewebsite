@extends('public.layouts.app')

@section('content')
    @if($page && $page->sections->count())
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach
    @else
        <section class="section section-hero">
            <div class="container">
                <h1>Rooms & Suites</h1>
                <p>Find your perfect stay with spacious rooms and countryside views.</p>
            </div>
        </section>
    @endif

    <section class="section section-light">
        <div class="container grid-3">
            @foreach($rooms as $room)
                <x-card>
                    @if($room->primary_image)
                        <img class="card-img" src="{{ asset('storage/' . $room->primary_image->path) }}" alt="{{ $room->title }}">
                    @endif
                    <div class="card-body">
                        <h3>{{ $room->title }}</h3>
                        <p>{{ $room->short_description }}</p>
                        <p class="price">From {{ $room->currency }} {{ number_format($room->base_price, 2) }}</p>
                        <x-button :href="route('rooms.show', $room->slug)">View Room</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>
@endsection
