@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Blog Categories</h1>
        <a class="btn btn-primary" href="{{ route('admin.blog-categories.create') }}">Add Category</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Slug</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.blog-categories.edit', $category) }}">Edit</a>
                    <form method="post" action="{{ route('admin.blog-categories.destroy', $category) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-ghost" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
