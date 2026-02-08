<form class="grid gap-4" method="post" action="{{ route('enquiries.store') }}">
    @csrf
    <input type="hidden" name="source" value="{{ $source ?? 'contact' }}">
    <div class="grid gap-2">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
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
    @if(!empty($rooms))
        <div class="grid gap-2">
            <label>Preferred Room</label>
            <select name="room_id">
                <option value="">Any room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->title }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="grid gap-2">
        <label>Message</label>
        <textarea name="message" rows="4">{{ old('message') }}</textarea>
    </div>
    <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="submit_enquiry" type="submit">Send Enquiry</button>
</form>
