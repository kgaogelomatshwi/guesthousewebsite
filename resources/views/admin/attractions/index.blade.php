@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Attractions</h1>
        <a class="btn btn-primary" href="{{ route('admin.attractions.create') }}">Add Attraction</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Distance</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($attractions as $attraction)
            <tr>
                <td>{{ $attraction->title }}</td>
                <td>{{ $attraction->distance_km }}</td>
                <td>{{ $attraction->is_active ? 'Active' : 'Hidden' }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.attractions.edit', $attraction) }}">Edit</a>
                    <form method="post" action="{{ route('admin.attractions.destroy', $attraction) }}" class="inline">
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
