@php
    $bookingCom = $siteSettings['bookingcom_url'] ?? null;
    $airbnb = $siteSettings['airbnb_url'] ?? null;
@endphp

@php
    $options = [];
    if ($bookingCom) { $options[] = 'bookingcom'; }
    if ($airbnb) { $options[] = 'airbnb'; }
@endphp

@if(!$bookingCom && !$airbnb)
    <x-alert type="error">OTA links are not configured yet.</x-alert>
@else
    <form class="form" method="post" action="{{ route('booking.ota') }}">
        @csrf
        @if(count($options) === 1)
            <input type="hidden" name="platform" value="{{ $options[0] }}">
        @else
            <div class="form-row">
                <label>Platform</label>
                <select name="platform" required>
                    @if($bookingCom)
                        <option value="bookingcom" @selected(old('platform') === 'bookingcom')>Booking.com</option>
                    @endif
                    @if($airbnb)
                        <option value="airbnb" @selected(old('platform') === 'airbnb')>Airbnb</option>
                    @endif
                </select>
            </div>
        @endif
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
        <div class="form-row">
            <label>Guests</label>
            <input type="number" min="1" name="guests" value="{{ old('guests', 2) }}" required>
        </div>
        <div class="form-row">
            <label>Rooms (optional)</label>
            <input type="number" min="1" name="rooms" value="{{ old('rooms', 1) }}">
        </div>
        <button class="btn btn-primary js-track-cta" data-event="start_booking" type="submit">Book Now</button>
        <p><small>We will redirect you to the selected platform. Dates and guest counts are passed via the URL if supported.</small></p>
    </form>
@endif
