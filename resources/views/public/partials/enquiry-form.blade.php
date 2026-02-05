<form class="form" method="post" action="{{ route('enquiries.store') }}">
    @csrf
    <input type="hidden" name="source" value="{{ $source ?? 'contact' }}">
    <div class="form-row">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
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
        <input type="date" name="check_in" value="{{ old('check_in') }}">
    </div>
    <div class="form-row">
        <label>Check-out</label>
        <input type="date" name="check_out" value="{{ old('check_out') }}">
    </div>
    <div class="form-row">
        <label>Guests</label>
        <input type="number" min="1" name="guests" value="{{ old('guests', 2) }}">
    </div>
    @if(!empty($rooms))
        <div class="form-row">
            <label>Preferred Room</label>
            <select name="room_id">
                <option value="">Any room</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->title }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="form-row">
        <label>Message</label>
        <textarea name="message" rows="4">{{ old('message') }}</textarea>
    </div>
    <button class="btn btn-primary js-track-cta" data-event="submit_enquiry" type="submit">Send Enquiry</button>
</form>
