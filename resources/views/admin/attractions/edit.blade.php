@extends('admin.layouts.app')

@section('content')
    <h1>Edit Attraction</h1>
    <form class="form" method="post" action="{{ route('admin.attractions.update', $attraction) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid-2">
            <div class="form-row">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $attraction->title) }}" required>
            </div>
            <div class="form-row">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $attraction->slug) }}" required>
            </div>
        </div>
        <div class="form-row">
            <label>Image</label>
            <input type="file" name="image_path">
        </div>
        @if(!empty($media))
            <div class="form-row">
                <label>Or Select from Media Library</label>
                <select class="js-media-picker" data-target="attraction-image-path">
                    <option value="">Choose media</option>
                    @foreach($media as $item)
                        <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                    @endforeach
                </select>
                <input id="attraction-image-path" type="text" name="image_path_existing" value="{{ old('image_path_existing', $attraction->image_path) }}">
                <button class="btn btn-outline js-media-open" type="button" data-media-target="attraction-image-path" data-media-type="image">Pick from Media Library</button>
            </div>
        @endif
        <div class="grid-2">
            <div class="form-row">
                <label>Distance (km)</label>
                <input type="number" step="0.1" name="distance_km" value="{{ old('distance_km', $attraction->distance_km) }}">
            </div>
            <div class="form-row">
                <label>Position</label>
                <input type="number" name="position" value="{{ old('position', $attraction->position) }}">
            </div>
        </div>
        <div class="form-row">
            <label>Description</label>
            <textarea name="description" rows="4">{{ old('description', $attraction->description) }}</textarea>
        </div>
        <div class="form-row">
            <label>Link</label>
            <input type="text" name="link" value="{{ old('link', $attraction->link) }}">
        </div>
        <div class="form-row">
            <label>Active</label>
            <select name="is_active">
                <option value="1" @selected($attraction->is_active)>Yes</option>
                <option value="0" @selected(! $attraction->is_active)>No</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Save</button>
    </form>
@endsection
