@extends('public.layouts.app')

@section('content')
    <section class="py-24 text-white bg-black">
        <div class="container">
            <h1 class="text-4xl md:text-5xl uppercase tracking-widest">{{ $room->title }}</h1>
            <p class="text-lg max-w-xl">{{ $room->short_description }}</p>
            <p class="font-semibold text-white">{{ $room->currency }} {{ number_format($room->base_price, 2) }} / night</p>
            @include('public.partials.booking-cta', ['variant' => 'hero'])
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container grid gap-6 md:grid-cols-2">
            <div>
                <h2 class="text-2xl font-semibold">About this room</h2>
                <div class="space-y-3 leading-relaxed">{!! nl2br(e($room->description)) !!}</div>
                @if($room->amenities->count())
                    <h3 class="text-xl font-semibold mt-4">Amenities</h3>
                    <ul class="flex flex-wrap gap-2 list-none p-0">
                        @foreach($room->amenities as $amenity)
                            <li class="bg-neutral-100 px-3 py-2 rounded-full">{{ $amenity->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="grid gap-4">
                @foreach($room->images as $image)
                    <img class="rounded-xl" src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?? $room->title }}" loading="lazy">
                @endforeach
            </div>
        </div>
    </section>
@endsection
