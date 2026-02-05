@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Gallery</h1>
        <a class="btn btn-primary" href="{{ route('admin.gallery.create') }}">Add Category</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Images</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->images->count() }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.gallery.edit', $category) }}">Manage</a>
                    <form method="post" action="{{ route('admin.gallery.destroy', $category) }}" class="inline">
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
