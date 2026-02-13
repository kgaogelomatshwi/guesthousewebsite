@extends('admin.layouts.app')

@section('content')
    <h1>Add Room</h1>
    <form class="form" method="post" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.rooms.form', ['room' => new \App\Models\Room(), 'amenities' => $amenities, 'media' => $media ?? []])
        <button class="btn btn-primary" type="submit">Create Room</button>
    </form>
@endsection
