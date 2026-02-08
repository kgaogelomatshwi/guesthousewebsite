@extends('public.layouts.app')

@section('content')
    <section class="py-24 text-white bg-black">
        <div class="container">
            <h1 class="text-4xl md:text-5xl uppercase tracking-widest">{{ $attraction->title }}</h1>
            @if($attraction->distance_km)
                <p class="text-lg">{{ number_format($attraction->distance_km, 1) }} km away</p>
            @endif
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container grid gap-6 md:grid-cols-2">
            <div>
                <div class="space-y-3 leading-relaxed">{!! nl2br(e($attraction->description)) !!}</div>
                @if($attraction->link)
                    <p><a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ $attraction->link }}" target="_blank" rel="noopener">Visit Website</a></p>
                @endif
            </div>
            <div>
                @if($attraction->image_path)
                    <img class="w-full h-auto rounded-xl" src="{{ asset('storage/' . $attraction->image_path) }}" alt="{{ $attraction->title }}">
                @endif
            </div>
        </div>
    </section>
@endsection
