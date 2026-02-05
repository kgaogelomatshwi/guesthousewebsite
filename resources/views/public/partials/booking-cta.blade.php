@php
    $mode = $siteSettings['booking_mode'] ?? 'DIRECT_BOOKING';
    $bookingCom = $siteSettings['bookingcom_url'] ?? null;
    $airbnb = $siteSettings['airbnb_url'] ?? null;
    $directEnabled = ($siteSettings['direct_booking_enabled'] ?? true);
@endphp

<div class="booking-cta {{ $variant ?? '' }}">
    @if($mode === 'OTA_REDIRECT')
        <a class="btn btn-primary js-track-cta" data-event="start_booking" href="{{ route('booking.create') }}">Book Now</a>
        @if($bookingCom)
            <a class="btn btn-outline js-track-cta" data-event="click_bookingcom" href="{{ $bookingCom }}" target="_blank" rel="noopener">Booking.com</a>
        @endif
        @if($airbnb)
            <a class="btn btn-ghost js-track-cta" data-event="click_airbnb" href="{{ $airbnb }}" target="_blank" rel="noopener">Airbnb</a>
        @endif
    @elseif($mode === 'HYBRID')
        @if($directEnabled)
            <a class="btn btn-primary js-track-cta" data-event="start_booking" href="{{ route('booking.create') }}">Book Direct (Best Price)</a>
        @endif
        @if($bookingCom)
            <a class="btn btn-outline js-track-cta" data-event="click_bookingcom" href="{{ $bookingCom }}" target="_blank" rel="noopener">Booking.com</a>
        @endif
        @if($airbnb)
            <a class="btn btn-ghost js-track-cta" data-event="click_airbnb" href="{{ $airbnb }}" target="_blank" rel="noopener">Airbnb</a>
        @endif
    @else
        <a class="btn btn-primary js-track-cta" data-event="start_booking" href="{{ route('booking.create') }}">Book Now</a>
    @endif
</div>
