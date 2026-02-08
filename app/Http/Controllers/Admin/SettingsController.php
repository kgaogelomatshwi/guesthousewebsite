<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(SettingsService $settings): View
    {
        return view('admin.settings.edit', [
            'settings' => $settings->all(),
        ]);
    }

    public function update(Request $request, SettingsService $settings): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:150'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'favicon' => ['nullable', 'image', 'max:2048'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string'],
            'social_links' => ['nullable', 'string'],
            'default_seo_title' => ['nullable', 'string', 'max:160'],
            'default_seo_description' => ['nullable', 'string', 'max:255'],
            'booking_mode' => ['nullable', 'in:OTA_REDIRECT,DIRECT_BOOKING,HYBRID'],
            'ota_mode' => ['nullable', 'in:bookingcom,airbnb,both'],
            'bookingcom_url' => ['nullable', 'string', 'max:2048'],
            'airbnb_url' => ['nullable', 'string', 'max:2048'],
            'direct_booking_enabled' => ['nullable', 'boolean'],
            'currency' => ['nullable', 'string', 'size:3'],
            'deposit_policy' => ['nullable', 'string', 'max:20'],
            'cancellation_policy_text' => ['nullable', 'string'],
            'ga4_measurement_id' => ['nullable', 'string', 'max:30'],
            'gtm_container_id' => ['nullable', 'string', 'max:30'],
            'google_site_verification_meta' => ['nullable', 'string', 'max:255'],
            'payment_provider' => ['nullable', 'string', 'max:50'],
            'custom_css' => ['nullable', 'string'],
            'custom_js' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('branding', 'public');
            $data['logo'] = $path;
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('branding', 'public');
            $data['favicon'] = $path;
        }

        foreach ($data as $key => $value) {
            $type = in_array($key, ['direct_booking_enabled'], true) ? 'boolean' : null;

            if (in_array($key, ['social_links'], true) && is_string($value)) {
                $value = json_encode(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
                $type = 'json';
            }

            Setting::updateOrCreate([
                'key' => $key,
            ], [
                'value' => is_bool($value) ? ($value ? '1' : '0') : $value,
                'type' => $type,
            ]);
        }

        $settings->clearCache();

        return back()->with('success', 'Settings updated successfully.');
    }
}
