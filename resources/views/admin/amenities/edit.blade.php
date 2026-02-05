@extends('admin.layouts.app')

@section('content')
    <h1>Edit Amenity</h1>
    <form class="form" method="post" action="{{ route('admin.amenities.update', $amenity) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $amenity->name) }}" required>
        </div>
        <div class="form-row">
            <label>Icon</label>
            <input type="text" name="icon" value="{{ old('icon', $amenity->icon) }}">
        </div>
        <button class="btn btn-primary" type="submit">Save</button>
    </form>
@endsection
