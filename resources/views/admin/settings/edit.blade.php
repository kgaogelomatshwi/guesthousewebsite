@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold">Site Settings</h1>
    <form class="grid gap-4 mt-4" method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <div class="grid gap-2">
                    <label>Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>Logo</label>
                    <input type="file" name="logo">
                </div>
                <div class="grid gap-2">
                    <label>Favicon</label>
                    <input type="file" name="favicon">
                </div>
                <div class="grid gap-2">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $settings['email'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>Address</label>
                    <textarea name="address" rows="3">{{ $settings['address'] ?? '' }}</textarea>
                </div>
                <div class="grid gap-2">
                    <label>Social Links (one per line)</label>
                    <textarea name="social_links" rows="3">{{ is_array($settings['social_links'] ?? null) ? implode("\n", $settings['social_links']) : '' }}</textarea>
                </div>
            </div>
            <div>
                <div class="grid gap-2">
                    <label>Default SEO Title</label>
                    <input type="text" name="default_seo_title" value="{{ $settings['default_seo_title'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>Default SEO Description</label>
                    <textarea name="default_seo_description" rows="3">{{ $settings['default_seo_description'] ?? '' }}</textarea>
                </div>
                <div class="grid gap-2">
                    <label>Booking Mode</label>
                    <select name="booking_mode">
                        @foreach(['OTA_REDIRECT','DIRECT_BOOKING','HYBRID'] as $mode)
                            <option value="{{ $mode }}" @selected(($settings['booking_mode'] ?? 'DIRECT_BOOKING') === $mode)>{{ $mode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid gap-2">
                    <label>OTA Selection</label>
                    <select name="ota_mode">
                        @foreach(['bookingcom' => 'Booking.com Only','airbnb' => 'Airbnb Only','both' => 'All OTA (Both)'] as $value => $label)
                            <option value="{{ $value }}" @selected(($settings['ota_mode'] ?? 'both') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid gap-2">
                    <label>Booking.com URL</label>
                    <input type="text" name="bookingcom_url" value="{{ $settings['bookingcom_url'] ?? '' }}">
                    <small>Use placeholders: <code>{check_in}</code>, <code>{check_out}</code>, <code>{adults}</code>, <code>{rooms}</code>.</small>
                </div>
                <div class="grid gap-2">
                    <label>Airbnb URL</label>
                    <input type="text" name="airbnb_url" value="{{ $settings['airbnb_url'] ?? '' }}">
                    <small>Use placeholders: <code>{check_in}</code>, <code>{check_out}</code>, <code>{adults}</code>, <code>{rooms}</code>.</small>
                </div>
                <div class="grid gap-2">
                    <label>Direct Booking Enabled</label>
                    <select name="direct_booking_enabled">
                        <option value="1" @selected(($settings['direct_booking_enabled'] ?? true))>Yes</option>
                        <option value="0" @selected(!($settings['direct_booking_enabled'] ?? true))>No</option>
                    </select>
                </div>
                <div class="grid gap-2">
                    <label>Currency</label>
                    <input type="text" name="currency" value="{{ $settings['currency'] ?? 'ZAR' }}">
                </div>
                <div class="grid gap-2">
                    <label>Deposit Policy (e.g., 50% or 500)</label>
                    <input type="text" name="deposit_policy" value="{{ $settings['deposit_policy'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>Cancellation Policy</label>
                    <textarea name="cancellation_policy_text" rows="3">{{ $settings['cancellation_policy_text'] ?? '' }}</textarea>
                </div>
                <div class="grid gap-2">
                    <label>GA4 Measurement ID</label>
                    <input type="text" name="ga4_measurement_id" value="{{ $settings['ga4_measurement_id'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>GTM Container ID</label>
                    <input type="text" name="gtm_container_id" value="{{ $settings['gtm_container_id'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>Google Site Verification Meta</label>
                    <input type="text" name="google_site_verification_meta" value="{{ $settings['google_site_verification_meta'] ?? '' }}">
                </div>
                <div class="grid gap-2">
                    <label>Payment Provider</label>
                    <input type="text" name="payment_provider" value="{{ $settings['payment_provider'] ?? 'stub' }}">
                </div>
                <div class="grid gap-2">
                    <label>Custom CSS</label>
                    <textarea name="custom_css" rows="6">{{ $settings['custom_css'] ?? '' }}</textarea>
                </div>
                <div class="grid gap-2">
                    <label>Custom JS</label>
                    <textarea name="custom_js" rows="6">{{ $settings['custom_js'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg" type="submit">Save Settings</button>
    </form>
@endsection
