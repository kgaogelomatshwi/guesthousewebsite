@extends('admin.layouts.app')

@section('content')
    <h1>Edit Blog Category</h1>
    <form class="form" method="post" action="{{ route('admin.blog-categories.update', $category) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="form-row">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required>
        </div>
        <button class="btn btn-primary" type="submit">Save</button>
    </form>
@endsection
