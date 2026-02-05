@extends('admin.layouts.app')

@section('content')
    <h1>Booking: {{ $booking->full_name }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Email:</strong> {{ $booking->email }}</p>
            <p><strong>Phone:</strong> {{ $booking->phone }}</p>
            <p><strong>Platform:</strong> {{ $booking->platform }}</p>
            <p><strong>Reference:</strong> {{ $booking->booking_reference }}</p>
            <p><strong>Dates:</strong> {{ $booking->check_in }} - {{ $booking->check_out }}</p>
            <p><strong>Guests:</strong> {{ $booking->guests }}</p>
            <p><strong>Room Type:</strong> {{ $booking->room_type }}</p>
            <p><strong>Notes:</strong> {{ $booking->notes }}</p>
        </div>
    </div>

    <form method="post" action="{{ route('admin.external-bookings.status', $booking) }}" class="form">
        @csrf
        <div class="form-row">
            <label>Status</label>
            <select name="status">
                @foreach(['new','verified','archived'] as $status)
                    <option value="{{ $status }}" @selected($booking->status === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Update Status</button>
    </form>
@endsection
