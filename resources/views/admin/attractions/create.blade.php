@extends('admin.layouts.app')

@section('content')
    <h1>Add Attraction</h1>
    <form class="form" method="post" action="{{ route('admin.attractions.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid-2">
            <div class="form-row">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="form-row">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" required>
            </div>
        </div>
        <div class="form-row">
            <label>Image</label>
            <input type="file" name="image_path">
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Distance (km)</label>
                <input type="number" step="0.1" name="distance_km" value="{{ old('distance_km') }}">
            </div>
            <div class="form-row">
                <label>Position</label>
                <input type="number" name="position" value="{{ old('position', 0) }}">
            </div>
        </div>
        <div class="form-row">
            <label>Description</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
        </div>
        <div class="form-row">
            <label>Link</label>
            <input type="text" name="link" value="{{ old('link') }}">
        </div>
        <div class="form-row">
            <label>Active</label>
            <select name="is_active">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Create</button>
    </form>
@endsection
