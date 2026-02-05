<form class="form" method="post" action="{{ route('booking.store') }}">
    @csrf
    <div class="form-row">
        <label>Full Name</label>
        <input type="text" name="guest_name" value="{{ old('guest_name') }}" required>
    </div>
    <div class="form-row">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div class="form-row">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone') }}">
    </div>
    <div class="form-row">
        <label>Check-in</label>
        <input type="date" name="check_in" value="{{ old('check_in') }}" required>
    </div>
    <div class="form-row">
        <label>Check-out</label>
        <input type="date" name="check_out" value="{{ old('check_out') }}" required>
    </div>
    <div class="form-row">
        <label>Guests</label>
        <input type="number" min="1" name="guests" value="{{ old('guests', 2) }}" required>
    </div>
    @if(!empty($rooms))
        <div class="form-row">
            <label>Room</label>
            <select name="room_id">
                <option value="">Any room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->title }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="form-row">
        <label>Notes</label>
        <textarea name="notes" rows="3">{{ old('notes') }}</textarea>
    </div>
    <button class="btn btn-primary js-track-cta" data-event="payment_initiated" type="submit">Proceed to Payment</button>
</form>
