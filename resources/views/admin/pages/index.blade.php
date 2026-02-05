@extends('admin.layouts.app')

@section('content')
    <h1>Pages</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Key</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr>
                <td>{{ $page->key }}</td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->slug }}</td>
                <td>{{ $page->is_active ? 'Active' : 'Hidden' }}</td>
                <td><a class="btn btn-outline" href="{{ route('admin.pages.edit', $page) }}">Edit</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
