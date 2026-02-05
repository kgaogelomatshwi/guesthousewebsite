@php
    $mode = $siteSettings['booking_mode'] ?? 'DIRECT_BOOKING';
    $bookingCom = $siteSettings['bookingcom_url'] ?? null;
    $airbnb = $siteSettings['airbnb_url'] ?? null;
    $directEnabled = ($siteSettings['direct_booking_enabled'] ?? true);
@endphp

<div class="booking-options">
    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif
    @if($mode === 'OTA_REDIRECT')
        <div class="grid-2">
            <div>
                <h3>Book on your preferred platform</h3>
                <p>Choose your dates and guests, then we will redirect you to Booking.com or Airbnb.</p>
                @include('public.partials.ota-redirect-form')
            </div>
            <div>
                <h3>Already booked?</h3>
                @include('public.partials.external-booking-form')
            </div>
        </div>
    @elseif($mode === 'HYBRID')
        <div class="grid-2">
            <div>
                <h3>Book Direct (Best Price)</h3>
                @if($directEnabled)
                    @include('public.partials.booking-direct-form', ['rooms' => $rooms ?? []])
                @endif
            </div>
            <div>
                <h3>Prefer Booking.com or Airbnb?</h3>
                @include('public.partials.ota-redirect-form')
                <div class="spacer"></div>
                <h3>Already booked?</h3>
                @include('public.partials.external-booking-form')
            </div>
        </div>
    @else
        <div class="grid-2">
            <div>
                <h3>Book Direct</h3>
                @include('public.partials.booking-direct-form', ['rooms' => $rooms ?? []])
            </div>
            <div>
                <h3>Need help?</h3>
                <p>Send us an enquiry and we will get back to you quickly.</p>
                @include('public.partials.enquiry-form', ['source' => 'booking'])
            </div>
        </div>
    @endif
</div>
