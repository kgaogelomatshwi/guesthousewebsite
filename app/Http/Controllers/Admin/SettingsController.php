<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Media\MediaService;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(SettingsService $settings): View
    {
        return view('admin.settings.edit', [
            'settings' => $settings->all(),
            'media' => \App\Models\Media::query()
                ->where('mime_type', 'like', 'image/%')
                ->orderByDesc('created_at')
                ->take(200)
                ->get(),
        ]);
    }

    public function update(Request $request, SettingsService $settings, MediaService $mediaService): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['nullable', 'string', 'max:150'],
            'site_tagline' => ['nullable', 'string', 'max:180'],
            'site_intro' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'max:4096'],
            'favicon' => ['nullable', 'image', 'max:2048'],
            'logo_path' => ['nullable', 'string', 'max:255'],
            'favicon_path' => ['nullable', 'string', 'max:255'],
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
            'google_reviews_enabled' => ['nullable', 'boolean'],
            'google_api_key' => ['nullable', 'string', 'max:255'],
            'google_place_id' => ['nullable', 'string', 'max:255'],
            'google_place_url' => ['nullable', 'string', 'max:2048'],
            'bookingcom_reviews_url' => ['nullable', 'string', 'max:2048'],
            'reviews_min_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'ga4_measurement_id' => ['nullable', 'string', 'max:30'],
            'gtm_container_id' => ['nullable', 'string', 'max:30'],
            'google_site_verification_meta' => ['nullable', 'string', 'max:255'],
            'payment_provider' => ['nullable', 'string', 'max:50'],
            'theme_bg' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_text' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_muted' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_brand' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_brand_2' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_surface' => ['nullable', 'string', 'max:60', 'regex:/^[#(),.%\sa-zA-Z0-9-]+$/'],
            'theme_surface_2' => ['nullable', 'string', 'max:60', 'regex:/^[#(),.%\sa-zA-Z0-9-]+$/'],
            'theme_line' => ['nullable', 'string', 'max:60', 'regex:/^[#(),.%\sa-zA-Z0-9-]+$/'],
            'theme_shadow' => ['nullable', 'string', 'max:120', 'regex:/^[#(),.%\sa-zA-Z0-9-]+$/'],
            'theme_radius' => ['nullable', 'integer', 'min:8', 'max:40'],
            'theme_maxw' => ['nullable', 'integer', 'min:900', 'max:1600'],
            'theme_font' => ['nullable', Rule::in(['montserrat', 'poppins', 'nunito', 'lato', 'inter'])],
            'theme_base_size' => ['nullable', 'integer', 'min:14', 'max:22'],
            'theme_section_gap' => ['nullable', 'integer', 'min:10', 'max:40'],
            'custom_css' => ['nullable', 'string'],
            'custom_js' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $mediaService->store($request->file('logo'), 'branding');
        } elseif (!empty($data['logo_path'])) {
            $data['logo'] = $data['logo_path'];
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = $mediaService->store($request->file('favicon'), 'branding');
        } elseif (!empty($data['favicon_path'])) {
            $data['favicon'] = $data['favicon_path'];
        }

        unset($data['logo_path'], $data['favicon_path']);

        foreach ($data as $key => $value) {
            $type = in_array($key, ['direct_booking_enabled', 'google_reviews_enabled'], true) ? 'boolean' : null;
            if ($key === 'reviews_min_rating') {
                $type = 'int';
            }

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
