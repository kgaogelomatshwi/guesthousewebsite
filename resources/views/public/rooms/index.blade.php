@extends('public.layouts.app')

@section('content')
    @if($page && $page->sections->count())
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach
    @else
        <section class="py-24 text-white bg-black">
            <div class="container">
                <h1 class="text-4xl md:text-5xl uppercase tracking-widest">Rooms & Suites</h1>
                <p class="text-lg max-w-xl">Find your perfect stay with spacious rooms and countryside views.</p>
            </div>
        </section>
    @endif

    <section class="py-16 bg-white">
        <div class="container grid gap-6 md:grid-cols-3">
            @foreach($rooms as $room)
                <x-card>
                    @if($room->primary_image)
                        <img class="w-full h-52 object-cover" src="{{ asset('storage/' . $room->primary_image->path) }}" alt="{{ $room->title }}">
                    @endif
                    <div class="p-5 space-y-2">
                        <h3 class="text-lg font-semibold">{{ $room->title }}</h3>
                        <p class="text-neutral-600">{{ $room->short_description }}</p>
                        <p class="font-semibold text-black">From {{ $room->currency }} {{ number_format($room->base_price, 2) }}</p>
                        <x-button :href="route('rooms.show', $room->slug)">View Room</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>
@endsection
