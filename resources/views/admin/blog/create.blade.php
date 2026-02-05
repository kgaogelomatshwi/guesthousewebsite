@extends('admin.layouts.app')

@section('content')
    <h1>Add Blog Post</h1>
    <form class="form" method="post" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
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
            <label>Excerpt</label>
            <textarea name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
        </div>
        <div class="form-row">
            <label>Body</label>
            <textarea name="body" rows="8">{{ old('body') }}</textarea>
        </div>
        <div class="form-row">
            <label>Cover Image</label>
            <input type="file" name="cover_image">
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Category</label>
                <select name="category_id">
                    <option value="">Uncategorized</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <label>Tags (comma separated)</label>
                <input type="text" name="tags" value="{{ old('tags') }}">
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title') }}">
            </div>
            <div class="form-row">
                <label>SEO Description</label>
                <textarea name="seo_description" rows="2">{{ old('seo_description') }}</textarea>
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Published</label>
                <select name="is_published">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="form-row">
                <label>Published At</label>
                <input type="date" name="published_at" value="{{ old('published_at') }}">
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Create</button>
    </form>
@endsection
