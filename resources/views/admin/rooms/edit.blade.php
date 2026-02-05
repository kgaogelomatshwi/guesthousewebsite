@extends('admin.layouts.app')

@section('content')
    <h1>Edit Room</h1>
    <form class="form" method="post" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.rooms.form', ['room' => $room, 'amenities' => $amenities])
        <button class="btn btn-primary" type="submit">Save Room</button>
    </form>
@endsection
