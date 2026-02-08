<form class="grid gap-4" method="post" action="{{ route('booking.store') }}">
    @csrf
    <div class="grid gap-2">
        <label>Full Name</label>
        <input type="text" name="guest_name" value="{{ old('guest_name') }}" required>
    </div>
    <div class="grid gap-2">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
    </div>
    <div class="grid gap-2">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone') }}">
    </div>
    <div class="grid gap-2">
        <label>Check-in</label>
        <input type="date" name="check_in" value="{{ old('check_in') }}" required>
    </div>
    <div class="grid gap-2">
        <label>Check-out</label>
        <input type="date" name="check_out" value="{{ old('check_out') }}" required>
    </div>
    <div class="grid gap-2">
        <label>Guests</label>
        <input type="number" min="1" name="guests" value="{{ old('guests', 2) }}" required>
    </div>
    @if(!empty($rooms))
        <div class="grid gap-2">
            <label>Room</label>
            <select name="room_id">
                <option value="">Any room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->title }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="grid gap-2">
        <label>Notes</label>
        <textarea name="notes" rows="3">{{ old('notes') }}</textarea>
    </div>
    <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="payment_initiated" type="submit">Proceed to Payment</button>
</form>
