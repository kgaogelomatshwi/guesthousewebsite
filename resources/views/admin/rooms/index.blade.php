@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Rooms</h1>
        <a class="btn btn-primary" href="{{ route('admin.rooms.create') }}">Add Room</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Price</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($rooms as $room)
            <tr>
                <td>{{ $room->title }}</td>
                <td>{{ $room->status }}</td>
                <td>{{ $room->currency }} {{ number_format($room->base_price, 2) }}</td>
                <td>
                    <a class="btn btn-outline" href="{{ route('admin.rooms.edit', $room) }}">Edit</a>
                    <form method="post" action="{{ route('admin.rooms.destroy', $room) }}" class="inline">
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
