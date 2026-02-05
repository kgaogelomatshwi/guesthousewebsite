@extends('public.layouts.app')

@section('content')
    <section class="section section-hero">
        <div class="container">
            <h1>{{ $post->title }}</h1>
            @if($post->published_at)
                <p>{{ $post->published_at->format('F j, Y') }}</p>
            @endif
        </div>
    </section>

    <section class="section section-light">
        <div class="container narrow">
            @if($post->cover_image)
                <img class="feature-img" src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}">
            @endif
            <div class="rich-text">{!! nl2br(e($post->body)) !!}</div>
        </div>
    </section>
@endsection
