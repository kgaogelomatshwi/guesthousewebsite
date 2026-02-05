@extends('public.layouts.app')

@section('content')
    <section class="section section-hero">
        <div class="container">
            <h1>{{ $attraction->title }}</h1>
            @if($attraction->distance_km)
                <p>{{ number_format($attraction->distance_km, 1) }} km away</p>
            @endif
        </div>
    </section>

    <section class="section section-light">
        <div class="container grid-2">
            <div>
                <div class="rich-text">{!! nl2br(e($attraction->description)) !!}</div>
                @if($attraction->link)
                    <p><a class="btn btn-outline" href="{{ $attraction->link }}" target="_blank" rel="noopener">Visit Website</a></p>
                @endif
            </div>
            <div>
                @if($attraction->image_path)
                    <img class="feature-img" src="{{ asset('storage/' . $attraction->image_path) }}" alt="{{ $attraction->title }}">
                @endif
            </div>
        </div>
    </section>
@endsection
