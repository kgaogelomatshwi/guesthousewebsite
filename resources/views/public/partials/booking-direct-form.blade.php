@if(!auth()->check())
    <div class="grid gap-4">
        <p class="text-neutral-700">Direct booking requires a guest account.</p>
        <div class="flex flex-wrap gap-3">
            <a class="btn btn-primary" href="{{ route('login') }}">Sign In</a>
            <a class="btn btn-outline" href="{{ route('register') }}">Create Account</a>
        </div>
    </div>
@else
    <form class="grid gap-4" method="post" action="{{ route('booking.store') }}">
        @csrf
        <div class="grid gap-2">
            <label>Full Name</label>
            <input type="text" name="guest_name" value="{{ old('guest_name', auth()->user()->name) }}" required>
        </div>
        <div class="grid gap-2">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" readonly required>
        </div>
        <div class="grid gap-2">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="grid gap-2">
            <label>Check-in</label>
            <input type="date" name="check_in" value="{{ old('check_in', request('check_in')) }}" required>
        </div>
        <div class="grid gap-2">
            <label>Check-out</label>
            <input type="date" name="check_out" value="{{ old('check_out', request('check_out')) }}" required>
        </div>
        <div class="grid gap-2">
            <label>Adults</label>
            <input type="number" min="1" name="adults" value="{{ old('adults', request('adults', 2)) }}" required>
        </div>
        <div class="grid gap-2">
            <label>Children</label>
            <input type="number" min="0" name="children" value="{{ old('children', request('children', 0)) }}">
        </div>
        @if(!empty($rooms))
            <div class="grid gap-2">
                <label>Room</label>
                <select name="room_id">
                    <option value="">Any room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" @selected((string) request('room_id') === (string) $room->id)>{{ $room->title }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="grid gap-2">
            <label>Special Requests</label>
            <textarea name="notes" rows="3">{{ old('notes') }}</textarea>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="payment_initiated" type="submit">Proceed to Payment</button>
        <p class="text-sm text-neutral-600">Signed in as {{ auth()->user()->email }}. <a class="underline" href="{{ route('guest.dashboard') }}">My Bookings</a></p>
    </form>
@endif
