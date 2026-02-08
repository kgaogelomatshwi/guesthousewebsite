@extends('public.layouts.app')

@section('content')
    <section class="py-24 text-white bg-black">
        <div class="container">
            <h1 class="text-4xl md:text-5xl uppercase tracking-widest">{{ $post->title }}</h1>
            @if($post->published_at)
                <p class="text-lg">{{ $post->published_at->format('F j, Y') }}</p>
            @endif
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container max-w-3xl mx-auto">
            @if($post->cover_image)
                <img class="w-full h-auto rounded-xl" src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" loading="lazy">
            @endif
            <div class="space-y-3 leading-relaxed">{!! nl2br(e($post->body)) !!}</div>
        </div>
    </section>
@endsection
