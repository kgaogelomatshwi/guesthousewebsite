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
@endphp

<div class="grid gap-6">
    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif
    @if($mode === 'OTA_REDIRECT')
        @if($defaultOtaUrl)
            <div class="grid gap-3">
                <p class="text-neutral-700">Redirecting to your OTA booking page...</p>
                <a class="btn btn-primary w-fit" href="{{ $defaultOtaUrl }}" target="_blank" rel="noopener">Continue to OTA</a>
            </div>
            <script>
                window.location.href = @json($defaultOtaUrl);
            </script>
        @else
            <x-alert type="error">OTA link is not configured yet.</x-alert>
        @endif
    @elseif($mode === 'HYBRID')
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <h3 class="text-xl font-semibold">Book Direct (Best Price)</h3>
                @include('public.partials.booking-direct-form', ['rooms' => $rooms ?? []])
            </div>
            <div>
                <h3 class="text-xl font-semibold">Prefer Booking.com or Airbnb?</h3>
                @include('public.partials.ota-redirect-form')
                <div class="h-4"></div>
                <h3 class="text-xl font-semibold">Already booked?</h3>
                @include('public.partials.external-booking-form')
            </div>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <h3 class="text-xl font-semibold">Book Direct</h3>
                @include('public.partials.booking-direct-form', ['rooms' => $rooms ?? []])
            </div>
            <div>
                <h3 class="text-xl font-semibold">Need help?</h3>
                <p class="text-neutral-600">Send us an enquiry and we will get back to you quickly.</p>
                @include('public.partials.enquiry-form', ['source' => 'booking'])
            </div>
        </div>
    @endif
</div>
