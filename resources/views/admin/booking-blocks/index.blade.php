@extends('admin.layouts.app')

@section('content')
    <h1>Blocked Dates</h1>
    <form class="form" method="post" action="{{ route('admin.booking-blocks.store') }}">
        @csrf
        <div class="grid-2">
            <div class="form-row">
                <label>Room (optional)</label>
                <select name="room_id">
                    <option value="">All rooms</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <label>Reason</label>
                <input type="text" name="reason" value="{{ old('reason') }}">
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Start Date</label>
                <input type="date" name="start_date" required>
            </div>
            <div class="form-row">
                <label>End Date</label>
                <input type="date" name="end_date" required>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Add Block</button>
    </form>

    <div class="section-divider"></div>

    <table class="table">
        <thead>
        <tr>
            <th>Room</th>
            <th>Dates</th>
            <th>Reason</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($blocks as $block)
            <tr>
                <td>{{ $block->room?->title ?? 'All rooms' }}</td>
                <td>{{ $block->start_date }} - {{ $block->end_date }}</td>
                <td>{{ $block->reason }}</td>
                <td>
                    <form method="post" action="{{ route('admin.booking-blocks.destroy', $block) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-ghost" type="submit">Remove</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
