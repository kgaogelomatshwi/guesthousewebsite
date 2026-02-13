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
            <label>Upload Media (images, video, audio, PDF)</label>
            <input type="file" name="files[]" multiple required accept="image/*,video/*,audio/*,application/pdf">
        </div>
        <button class="btn btn-primary" type="submit">Upload</button>
    </form>

    <div class="section-divider"></div>

    <div class="media-grid">
        @foreach($media as $item)
            @php
                $mime = $item->mime_type ?? '';
                $isImage = \Illuminate\Support\Str::startsWith($mime, 'image/');
                $isVideo = \Illuminate\Support\Str::startsWith($mime, 'video/');
                $isAudio = \Illuminate\Support\Str::startsWith($mime, 'audio/');
                $isPdf = $mime === 'application/pdf';
                $sizeKb = number_format(($item->size_bytes ?? 0) / 1024, 1);
                $path = $item->path;
                $url = asset('storage/' . $path);
            @endphp
            <div class="media-card">
                @if($isImage)
                    <img src="{{ $url }}" alt="{{ $item->alt_text ?? '' }}">
                @elseif($isVideo)
                    <video class="w-full h-36 object-cover rounded-lg" controls src="{{ $url }}"></video>
                @elseif($isAudio)
                    <audio class="w-full" controls src="{{ $url }}"></audio>
                @elseif($isPdf)
                    <div class="p-4 bg-neutral-100 rounded-lg text-sm">
                        <strong>PDF file</strong>
                        <p class="text-neutral-500">Click to open</p>
                        <a class="underline" href="{{ $url }}" target="_blank" rel="noopener">Open PDF</a>
                    </div>
                @else
                    <div class="p-4 bg-neutral-100 rounded-lg text-sm">
                        <strong>File</strong>
                        <p class="text-neutral-500">{{ $mime ?: 'unknown' }}</p>
                    </div>
                @endif
                <div>
                    <strong>{{ $item->title ?? 'Media' }}</strong>
                    <p><small>{{ $mime ?: 'unknown' }} • {{ $sizeKb }} KB</small></p>
                </div>
                <input type="text" readonly value="{{ $path }}">
                <input type="text" readonly value="{{ $url }}">
                <div class="media-actions">
                    <button class="btn btn-outline js-copy" type="button" data-copy="{{ $path }}">Copy Path</button>
                    <button class="btn btn-outline js-copy" type="button" data-copy="{{ $url }}">Copy URL</button>
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
