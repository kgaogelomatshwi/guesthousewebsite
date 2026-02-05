@extends('public.layouts.app')

@section('content')
    <section class="section section-hero">
        <div class="container">
            <h1>{{ $room->title }}</h1>
            <p>{{ $room->short_description }}</p>
            <p class="price">{{ $room->currency }} {{ number_format($room->base_price, 2) }} / night</p>
            @include('public.partials.booking-cta', ['variant' => 'hero'])
        </div>
    </section>

    <section class="section section-light">
        <div class="container grid-2">
            <div>
                <h2>About this room</h2>
                <div class="rich-text">{!! nl2br(e($room->description)) !!}</div>
                @if($room->amenities->count())
                    <h3>Amenities</h3>
                    <ul class="chip-list">
                        @foreach($room->amenities as $amenity)
                            <li>{{ $amenity->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="gallery-stack">
                @foreach($room->images as $image)
                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?? $room->title }}">
                @endforeach
            </div>
        </div>
    </section>
@endsection
