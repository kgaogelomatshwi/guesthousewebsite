@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Blog Posts</h1>
        <a class="btn btn-primary" href="{{ route('admin.blog.create') }}">Add Post</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Published</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->is_published ? 'Published' : 'Draft' }}</td>
                <td>{{ $post->published_at }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.blog.edit', $post) }}">Edit</a>
                    <form method="post" action="{{ route('admin.blog.destroy', $post) }}" class="inline">
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
