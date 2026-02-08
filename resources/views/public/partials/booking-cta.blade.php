@php
    $mode = $siteSettings['booking_mode'] ?? 'DIRECT_BOOKING';
    $bookingCom = $siteSettings['bookingcom_url'] ?? null;
    $airbnb = $siteSettings['airbnb_url'] ?? null;
    $directEnabled = ($siteSettings['direct_booking_enabled'] ?? true);
@endphp

<div class="flex flex-wrap gap-3 {{ $variant ?? '' }}">
    @if($mode === 'OTA_REDIRECT')
        <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="start_booking" href="{{ route('booking.create') }}">Book Now</a>
        @if($bookingCom)
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition js-track-cta" data-event="click_bookingcom" href="{{ $bookingCom }}" target="_blank" rel="noopener">Booking.com</a>
        @endif
        @if($airbnb)
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent text-black bg-transparent transition js-track-cta" data-event="click_airbnb" href="{{ $airbnb }}" target="_blank" rel="noopener">Airbnb</a>
        @endif
    @elseif($mode === 'HYBRID')
        @if($directEnabled)
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="start_booking" href="{{ route('booking.create') }}">Book Direct (Best Price)</a>
        @endif
        @if($bookingCom)
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition js-track-cta" data-event="click_bookingcom" href="{{ $bookingCom }}" target="_blank" rel="noopener">Booking.com</a>
        @endif
        @if($airbnb)
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent text-black bg-transparent transition js-track-cta" data-event="click_airbnb" href="{{ $airbnb }}" target="_blank" rel="noopener">Airbnb</a>
        @endif
    @else
        <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="start_booking" href="{{ route('booking.create') }}">Book Now</a>
    @endif
</div>
