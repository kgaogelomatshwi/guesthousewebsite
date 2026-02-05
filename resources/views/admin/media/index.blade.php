@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Media Library</h1>
    </div>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <form class="form" method="post" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <label>Upload Images</label>
            <input type="file" name="files[]" multiple required>
        </div>
        <button class="btn btn-primary" type="submit">Upload</button>
    </form>

    <div class="section-divider"></div>

    <div class="media-grid">
        @foreach($media as $item)
            <div class="media-card">
                <img src="{{ asset('storage/' . $item->path) }}" alt="{{ $item->alt_text ?? '' }}">
                <div>
                    <strong>{{ $item->title ?? 'Media' }}</strong>
                    <p><small>{{ $item->mime_type }} • {{ number_format(($item->size_bytes ?? 0) / 1024, 1) }} KB</small></p>
                </div>
                <input type="text" readonly value="{{ asset('storage/' . $item->path) }}">
                <div class="media-actions">
                    <button class="btn btn-outline js-copy" type="button" data-copy="{{ asset('storage/' . $item->path) }}">Copy URL</button>
                    <form method="post" action="{{ route('admin.media.destroy', $item) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-ghost" type="submit">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{ $media->links() }}
@endsection
