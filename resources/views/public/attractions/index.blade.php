@extends('public.layouts.app')

@section('content')
    @if($page && $page->sections->count())
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach
    @else
        <section class="py-24 text-white bg-black">
            <div class="container">
                <h1 class="text-4xl md:text-5xl uppercase tracking-widest">Things To Do</h1>
                <p class="text-lg max-w-xl">Explore local vineyards, mountain trails, and scenic drives nearby.</p>
            </div>
        </section>
    @endif

    <section class="py-16 bg-white">
        <div class="container grid gap-6 md:grid-cols-3">
            @foreach($attractions as $attraction)
                <x-card>
                    @if($attraction->image_path)
                        <img class="w-full h-52 object-cover" src="{{ asset('storage/' . $attraction->image_path) }}" alt="{{ $attraction->title }}">
                    @endif
                    <div class="p-5 space-y-2">
                        <h3 class="text-lg font-semibold">{{ $attraction->title }}</h3>
                        @if($attraction->distance_km)
                            <p class="text-sm text-neutral-600">{{ number_format($attraction->distance_km, 1) }} km away</p>
                        @endif
                        <p class="text-neutral-600">{{ \Illuminate\Support\Str::limit(strip_tags($attraction->description), 120) }}</p>
                        <x-button :href="route('attractions.show', $attraction->slug)">View Details</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>
@endsection
