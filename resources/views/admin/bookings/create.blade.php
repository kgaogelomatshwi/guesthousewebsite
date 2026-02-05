@extends('admin.layouts.app')

@section('content')
    <h1>Manual Booking</h1>
    <form class="form" method="post" action="{{ route('admin.bookings.store') }}">
        @csrf
        <div class="grid-2">
            <div class="form-row">
                <label>Guest Name</label>
                <input type="text" name="guest_name" value="{{ old('guest_name') }}" required>
            </div>
            <div class="form-row">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="form-row">
                <label>Status</label>
                <input type="text" name="status" value="{{ old('status', 'pending') }}">
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Check-in</label>
                <input type="date" name="check_in" value="{{ old('check_in') }}" required>
            </div>
            <div class="form-row">
                <label>Check-out</label>
                <input type="date" name="check_out" value="{{ old('check_out') }}" required>
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Guests</label>
                <input type="number" name="guests" value="{{ old('guests', 2) }}" required>
            </div>
            <div class="form-row">
                <label>Room</label>
                <select name="room_id">
                    <option value="">Any room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>Total Amount</label>
                <input type="number" step="0.01" name="total_amount" value="{{ old('total_amount', 0) }}" required>
            </div>
            <div class="form-row">
                <label>Deposit Amount</label>
                <input type="number" step="0.01" name="deposit_amount" value="{{ old('deposit_amount', 0) }}">
            </div>
        </div>
        <div class="form-row">
            <label>Currency</label>
            <input type="text" name="currency" value="{{ old('currency', 'ZAR') }}">
        </div>
        <div class="form-row">
            <label>Notes</label>
            <textarea name="notes" rows="3">{{ old('notes') }}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">Create Booking</button>
    </form>
@endsection
