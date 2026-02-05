@extends('public.layouts.app')

@section('content')
    @if($page && $page->sections->count())
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach
    @else
        <section class="section section-hero">
            <div class="container">
                <h1>Things To Do</h1>
                <p>Explore local vineyards, mountain trails, and scenic drives nearby.</p>
            </div>
        </section>
    @endif

    <section class="section section-light">
        <div class="container grid-3">
            @foreach($attractions as $attraction)
                <x-card>
                    @if($attraction->image_path)
                        <img class="card-img" src="{{ asset('storage/' . $attraction->image_path) }}" alt="{{ $attraction->title }}">
                    @endif
                    <div class="card-body">
                        <h3>{{ $attraction->title }}</h3>
                        @if($attraction->distance_km)
                            <p>{{ number_format($attraction->distance_km, 1) }} km away</p>
                        @endif
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($attraction->description), 120) }}</p>
                        <x-button :href="route('attractions.show', $attraction->slug)">View Details</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>
@endsection
