@extends('public.layouts.app')

@section('content')
    @if($page && $page->sections->count())
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach
    @else
        <section class="py-24 text-white bg-black">
            <div class="container">
                <h1 class="text-4xl md:text-5xl uppercase tracking-widest">Gallery</h1>
                <p class="text-lg max-w-xl">A glimpse of the guesthouse, rooms, and surrounding countryside.</p>
            </div>
        </section>
    @endif

    @foreach($categories as $category)
        <section class="py-16 bg-white">
            <div class="container">
                <h2 class="text-2xl font-semibold">{{ $category->name }}</h2>
                <div class="grid gap-4 md:grid-cols-4">
                    @foreach($category->images as $image)
                        <img class="w-full h-44 object-cover rounded-xl" src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?? $category->name }}" loading="lazy">
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endsection
