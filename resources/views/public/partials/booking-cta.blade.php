@php
    $mode = $siteSettings['booking_mode'] ?? 'DIRECT_BOOKING';
    $bookingCom = $siteSettings['bookingcom_url'] ?? null;
    $airbnb = $siteSettings['airbnb_url'] ?? null;
    $otaMode = $siteSettings['ota_mode'] ?? 'both';

    if ($otaMode === 'bookingcom') {
        $airbnb = null;
    } elseif ($otaMode === 'airbnb') {
        $bookingCom = null;
    }

    $defaultOtaUrl = $bookingCom ?: $airbnb;
    $primaryLabel = ($variant ?? '') === 'header' ? 'BOOK ONLINE' : 'Book Now';
@endphp

<div class="flex flex-wrap gap-3 {{ $variant ?? '' }}">
    @if($mode === 'OTA_REDIRECT')
        @if($defaultOtaUrl)
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg uppercase tracking-wider js-track-cta" data-event="start_booking" href="{{ $defaultOtaUrl }}" target="_blank" rel="noopener">{{ $primaryLabel }}</a>
        @else
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg uppercase tracking-wider" href="{{ route('booking.create') }}">{{ $primaryLabel }}</a>
        @endif
    @elseif($mode === 'HYBRID')
        <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg uppercase tracking-wider js-track-cta" data-event="start_booking" href="{{ route('booking.create') }}">{{ $primaryLabel }}</a>
        @if($bookingCom)
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition js-track-cta" data-event="click_bookingcom" href="{{ $bookingCom }}" target="_blank" rel="noopener">Booking.com</a>
        @endif
        @if($airbnb)
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent text-black bg-transparent transition js-track-cta" data-event="click_airbnb" href="{{ $airbnb }}" target="_blank" rel="noopener">Airbnb</a>
        @endif
    @else
        <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg uppercase tracking-wider js-track-cta" data-event="start_booking" href="{{ route('booking.create') }}">{{ $primaryLabel }}</a>
    @endif
</div>
