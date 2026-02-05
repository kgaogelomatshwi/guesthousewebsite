@extends('public.layouts.app')

@section('content')
    @if($page && $page->sections->count())
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach
    @else
        <section class="section section-hero">
            <div class="container">
                <h1>Stories & Updates</h1>
                <p>Local tips, guesthouse news, and the best of the valley.</p>
            </div>
        </section>
    @endif

    <section class="section section-light">
        <div class="container grid-3">
            @foreach($posts as $post)
                <x-card>
                    @if($post->cover_image)
                        <img class="card-img" src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}">
                    @endif
                    <div class="card-body">
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->excerpt }}</p>
                        <x-button :href="route('blog.show', $post->slug)">Read More</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
        <div class="container pagination">
            {{ $posts->links() }}
        </div>
    </section>
@endsection
