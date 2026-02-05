@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Amenities</h1>
        <a class="btn btn-primary" href="{{ route('admin.amenities.create') }}">Add Amenity</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Icon</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($amenities as $amenity)
            <tr>
                <td>{{ $amenity->name }}</td>
                <td>{{ $amenity->icon }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.amenities.edit', $amenity) }}">Edit</a>
                    <form method="post" action="{{ route('admin.amenities.destroy', $amenity) }}" class="inline">
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
