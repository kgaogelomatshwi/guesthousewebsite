@extends('public.layouts.app')

@section('content')
    @if($page && $page->sections->count())
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach
    @else
        <section class="py-24 text-white bg-black">
            <div class="container">
                <h1 class="text-4xl md:text-5xl uppercase tracking-widest">Stories & Updates</h1>
                <p class="text-lg max-w-xl">Local tips, guesthouse news, and the best of the valley.</p>
            </div>
        </section>
    @endif

    <section class="py-16 bg-white">
        <div class="container grid gap-6 md:grid-cols-3">
            @foreach($posts as $post)
                <x-card>
                    @if($post->cover_image)
                        <img class="w-full h-52 object-cover" src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" loading="lazy">
                    @endif
                    <div class="p-5 space-y-2">
                        <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                        <p class="text-neutral-600">{{ $post->excerpt }}</p>
                        <x-button :href="route('blog.show', $post->slug)">Read More</x-button>
                    </div>
                </x-card>
            @endforeach
        </div>
        <div class="container mt-6">
            {{ $posts->links() }}
        </div>
    </section>
@endsection
