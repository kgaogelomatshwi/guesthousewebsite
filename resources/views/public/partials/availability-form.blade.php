@php
    $rooms = \App\Models\Room::query()->where('status', 'active')->orderBy('title')->get();
    $bookingMode = $siteSettings['booking_mode'] ?? 'DIRECT_BOOKING';
    $otaMode = $siteSettings['ota_mode'] ?? 'both';
    $bookingCom = $siteSettings['bookingcom_url'] ?? null;
    $airbnb = $siteSettings['airbnb_url'] ?? null;

    if ($otaMode === 'bookingcom') {
        $airbnb = null;
    } elseif ($otaMode === 'airbnb') {
        $bookingCom = null;
    }

    $otaOptions = [];
    if ($bookingCom) { $otaOptions['bookingcom'] = 'Booking.com'; }
    if ($airbnb) { $otaOptions['airbnb'] = 'Airbnb'; }
@endphp

@if($bookingMode === 'OTA_REDIRECT')
    @if(empty($otaOptions))
        <x-alert type="error">OTA links are not configured yet.</x-alert>
    @else
        <form id="booking" class="grid gap-4 md:grid-cols-2 lg:grid-cols-5 bg-white p-6 rounded-2xl shadow-lg border border-black/10" method="post" action="{{ route('booking.ota') }}">
            @csrf
            @if(count($otaOptions) > 1)
                <x-form.select label="Platform" name="platform" :options="$otaOptions" :selected="old('platform')" />
            @else
                <input type="hidden" name="platform" value="{{ array_key_first($otaOptions) }}">
            @endif
            <x-form.field label="Check-in" name="check_in" type="date" :value="old('check_in', request('check_in'))" required />
            <x-form.field label="Check-out" name="check_out" type="date" :value="old('check_out', request('check_out'))" required />
            <x-form.field label="Guests" name="guests" type="number" min="1" :value="old('guests', request('guests', 1))" required />
            <input type="hidden" name="rooms" value="1">
            <div class="md:col-span-2 lg:col-span-5">
                <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg w-full" type="submit">Check Availability</button>
            </div>
        </form>
    @endif
@else
    <form id="booking" class="grid gap-4 md:grid-cols-2 lg:grid-cols-5 bg-white p-6 rounded-2xl shadow-lg border border-black/10" method="get" action="{{ route('search.index') }}">
        <x-form.field label="Check-in" name="check_in" type="date" :value="old('check_in', request('check_in'))" required />
        <x-form.field label="Check-out" name="check_out" type="date" :value="old('check_out', request('check_out'))" required />
        <x-form.field label="Adults" name="adults" type="number" min="1" :value="old('adults', request('adults', 2))" required />
        <x-form.field label="Children" name="children" type="number" min="0" :value="old('children', request('children', 0))" />
        <x-form.select label="Room" name="room_id" :options="['' => 'Any room'] + $rooms->pluck('title', 'id')->toArray()" :selected="request('room_id')" />
        <div class="md:col-span-2 lg:col-span-5">
            <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg w-full" type="submit">Check Availability</button>
        </div>
    </form>
@endif
