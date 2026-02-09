@php
    $bookingCom = $siteSettings['bookingcom_url'] ?? null;
    $airbnb = $siteSettings['airbnb_url'] ?? null;
    $otaMode = $siteSettings['ota_mode'] ?? 'both';
    if ($otaMode === 'bookingcom') {
        $airbnb = null;
    } elseif ($otaMode === 'airbnb') {
        $bookingCom = null;
    }
@endphp

@php
    $options = [];
    if ($bookingCom) { $options[] = 'bookingcom'; }
    if ($airbnb) { $options[] = 'airbnb'; }
@endphp

@if(!$bookingCom && !$airbnb)
    <x-alert type="error">OTA links are not configured yet.</x-alert>
@else
    <form class="grid gap-4" method="post" action="{{ route('booking.ota') }}">
        @csrf
        @if(count($options) === 1)
            <input type="hidden" name="platform" value="{{ $options[0] }}">
        @else
            <div class="grid gap-2">
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
        <div class="grid gap-4 md:grid-cols-2">
            <div class="grid gap-2">
                <label>Check-in</label>
                <input type="date" name="check_in" value="{{ old('check_in') }}" required>
            </div>
            <div class="grid gap-2">
                <label>Check-out</label>
                <input type="date" name="check_out" value="{{ old('check_out') }}" required>
            </div>
        </div>
        <div class="grid gap-2">
            <label>Guests</label>
            <input type="number" min="1" name="guests" value="{{ old('guests', 1) }}" required>
        </div>
        <input type="hidden" name="rooms" value="1">
        <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="start_booking" type="submit">Book Now</button>
        <p class="text-sm text-neutral-600">We will redirect you to the selected platform. Dates and guest counts are passed via the URL if supported.</p>
    </form>
@endif
