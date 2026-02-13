@extends('admin.layouts.app')

@section('content')
    <h1>Edit Category: {{ $category->name }}</h1>
    <form class="form" method="post" action="{{ route('admin.gallery.update', $category) }}">
        @csrf
        @method('PUT')
        <div class="grid-2">
            <div class="form-row">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
            </div>
            <div class="form-row">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Save</button>
    </form>

    <div class="section-divider"></div>

    <h2>Upload Images</h2>
    <form class="form" method="post" action="{{ route('admin.gallery.images.store', $category) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <input type="file" name="images[]" multiple>
        </div>
        @if(!empty($media))
            <div class="form-row">
                <label>Or Add from Media Library</label>
                <select id="gallery-existing-images" name="existing_images[]" multiple size="6">
                    @foreach($media as $item)
                        <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline js-media-open" type="button" data-media-target="gallery-existing-images" data-media-type="image">Pick from Media Library</button>
                <small>Hold Ctrl/Cmd to select multiple images.</small>
            </div>
        @endif
        <button class="btn btn-primary" type="submit">Upload</button>
    </form>

    <div class="grid-4">
        @foreach($category->images as $image)
            <div class="card">
                <img class="gallery-img" src="{{ asset('storage/' . $image->path) }}" alt="">
                <form method="post" action="{{ route('admin.gallery.images.destroy', $image) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-ghost" type="submit">Remove</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection
