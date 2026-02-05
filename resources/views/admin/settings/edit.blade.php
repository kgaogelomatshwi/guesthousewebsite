@extends('admin.layouts.app')

@section('content')
    <h1>Site Settings</h1>
    <form class="form" method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid-2">
            <div>
                <div class="form-row">
                    <label>Site Name</label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>Logo</label>
                    <input type="file" name="logo">
                </div>
                <div class="form-row">
                    <label>Favicon</label>
                    <input type="file" name="favicon">
                </div>
                <div class="form-row">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $settings['email'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>Address</label>
                    <textarea name="address" rows="3">{{ $settings['address'] ?? '' }}</textarea>
                </div>
                <div class="form-row">
                    <label>Social Links (one per line)</label>
                    <textarea name="social_links" rows="3">{{ is_array($settings['social_links'] ?? null) ? implode("\n", $settings['social_links']) : '' }}</textarea>
                </div>
            </div>
            <div>
                <div class="form-row">
                    <label>Default SEO Title</label>
                    <input type="text" name="default_seo_title" value="{{ $settings['default_seo_title'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>Default SEO Description</label>
                    <textarea name="default_seo_description" rows="3">{{ $settings['default_seo_description'] ?? '' }}</textarea>
                </div>
                <div class="form-row">
                    <label>Booking Mode</label>
                    <select name="booking_mode">
                        @foreach(['OTA_REDIRECT','DIRECT_BOOKING','HYBRID'] as $mode)
                            <option value="{{ $mode }}" @selected(($settings['booking_mode'] ?? 'DIRECT_BOOKING') === $mode)>{{ $mode }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <label>Booking.com URL</label>
                    <input type="text" name="bookingcom_url" value="{{ $settings['bookingcom_url'] ?? '' }}">
                    <small>Use placeholders: <code>{check_in}</code>, <code>{check_out}</code>, <code>{adults}</code>, <code>{rooms}</code>.</small>
                </div>
                <div class="form-row">
                    <label>Airbnb URL</label>
                    <input type="text" name="airbnb_url" value="{{ $settings['airbnb_url'] ?? '' }}">
                    <small>Use placeholders: <code>{check_in}</code>, <code>{check_out}</code>, <code>{adults}</code>, <code>{rooms}</code>.</small>
                </div>
                <div class="form-row">
                    <label>Direct Booking Enabled</label>
                    <select name="direct_booking_enabled">
                        <option value="1" @selected(($settings['direct_booking_enabled'] ?? true))>Yes</option>
                        <option value="0" @selected(!($settings['direct_booking_enabled'] ?? true))>No</option>
                    </select>
                </div>
                <div class="form-row">
                    <label>Currency</label>
                    <input type="text" name="currency" value="{{ $settings['currency'] ?? 'ZAR' }}">
                </div>
                <div class="form-row">
                    <label>Deposit Policy (e.g., 50% or 500)</label>
                    <input type="text" name="deposit_policy" value="{{ $settings['deposit_policy'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>Cancellation Policy</label>
                    <textarea name="cancellation_policy_text" rows="3">{{ $settings['cancellation_policy_text'] ?? '' }}</textarea>
                </div>
                <div class="form-row">
                    <label>GA4 Measurement ID</label>
                    <input type="text" name="ga4_measurement_id" value="{{ $settings['ga4_measurement_id'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>GTM Container ID</label>
                    <input type="text" name="gtm_container_id" value="{{ $settings['gtm_container_id'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>Google Site Verification Meta</label>
                    <input type="text" name="google_site_verification_meta" value="{{ $settings['google_site_verification_meta'] ?? '' }}">
                </div>
                <div class="form-row">
                    <label>Payment Provider</label>
                    <input type="text" name="payment_provider" value="{{ $settings['payment_provider'] ?? 'stub' }}">
                </div>
                <div class="form-row">
                    <label>Custom CSS</label>
                    <textarea name="custom_css" rows="6">{{ $settings['custom_css'] ?? '' }}</textarea>
                </div>
                <div class="form-row">
                    <label>Custom JS</label>
                    <textarea name="custom_js" rows="6">{{ $settings['custom_js'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Save Settings</button>
    </form>
@endsection
