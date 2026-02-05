@extends('admin.layouts.app')

@section('content')
    <h1>Add Amenity</h1>
    <form class="form" method="post" action="{{ route('admin.amenities.store') }}">
        @csrf
        <div class="form-row">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-row">
            <label>Icon</label>
            <input type="text" name="icon" value="{{ old('icon') }}">
        </div>
        <button class="btn btn-primary" type="submit">Create</button>
    </form>
@endsection
