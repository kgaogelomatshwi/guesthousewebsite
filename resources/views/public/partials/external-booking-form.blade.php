<form class="grid gap-4" method="post" action="{{ route('external-bookings.store') }}">
    @csrf
    <div class="grid gap-2">
        <label>Full Name</label>
        <input type="text" name="full_name" value="{{ old('full_name') }}" required>
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
        <label>Platform</label>
        <select name="platform" required>
            <option value="booking.com">Booking.com</option>
            <option value="airbnb">Airbnb</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="grid gap-2">
        <label>Booking Reference</label>
        <input type="text" name="booking_reference" value="{{ old('booking_reference') }}" required>
    </div>
    <div class="grid gap-2">
        <label>Check-in</label>
        <input type="date" name="check_in" value="{{ old('check_in') }}">
    </div>
    <div class="grid gap-2">
        <label>Check-out</label>
        <input type="date" name="check_out" value="{{ old('check_out') }}">
    </div>
    <div class="grid gap-2">
        <label>Guests</label>
        <input type="number" min="1" name="guests" value="{{ old('guests', 2) }}">
    </div>
    <div class="grid gap-2">
        <label>Room Type (optional)</label>
        <input type="text" name="room_type" value="{{ old('room_type') }}">
    </div>
    <div class="grid gap-2">
        <label>Notes</label>
        <textarea name="notes" rows="3">{{ old('notes') }}</textarea>
    </div>
    <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg" type="submit">Log Booking</button>
</form>
