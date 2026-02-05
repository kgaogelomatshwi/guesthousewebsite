@extends('admin.layouts.app')

@section('content')
    <h1>Add Blog Category</h1>
    <form class="form" method="post" action="{{ route('admin.blog-categories.store') }}">
        @csrf
        <div class="form-row">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-row">
            <label>Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}" required>
        </div>
        <button class="btn btn-primary" type="submit">Create</button>
    </form>
@endsection
