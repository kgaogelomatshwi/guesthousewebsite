@extends('public.layouts.app')

@section('content')
    @if($page && $page->sections->count())
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach
    @else
        <section class="section section-hero">
            <div class="container">
                <h1>Gallery</h1>
                <p>A glimpse of the guesthouse, rooms, and surrounding countryside.</p>
            </div>
        </section>
    @endif

    @foreach($categories as $category)
        <section class="section section-light">
            <div class="container">
                <h2>{{ $category->name }}</h2>
                <div class="grid-4">
                    @foreach($category->images as $image)
                        <img class="gallery-img" src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->caption ?? $category->name }}">
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endsection
