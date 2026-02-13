@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold">Site Settings</h1>

    <div class="flex flex-wrap gap-2 mt-4">
        <button type="button" class="btn btn-outline" data-tab-button="general">General</button>
        <button type="button" class="btn btn-outline" data-tab-button="booking">Booking</button>
        <button type="button" class="btn btn-outline" data-tab-button="seo">SEO + Integrations</button>
        <button type="button" class="btn btn-outline" data-tab-button="reviews">Reviews</button>
        <button type="button" class="btn btn-outline" data-tab-button="custom">Custom Code</button>
    </div>

    <form class="grid gap-6 mt-4" method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid gap-6 md:grid-cols-2" data-tab-panel="general">
            <div class="grid gap-2">
                <label>Site Name</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
            </div>
            <div class="grid gap-2">
                <label>Logo</label>
                <input type="file" name="logo">
            </div>
            @if(!empty($media))
                <div class="grid gap-2">
                    <label>Select Logo from Media Library</label>
                    <select class="js-media-picker" data-target="logo-path">
                        <option value="">Choose media</option>
                        @foreach($media as $item)
                            <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                        @endforeach
                    </select>
                    <input id="logo-path" type="text" name="logo_path" value="{{ old('logo_path', $settings['logo'] ?? '') }}">
                    <button class="btn btn-outline js-media-open" type="button" data-media-target="logo-path" data-media-type="image">Pick from Media Library</button>
                    <small>Use a media path (storage).</small>
                </div>
            @endif
            <div class="grid gap-2">
                <label>Favicon</label>
                <input type="file" name="favicon">
            </div>
            @if(!empty($media))
                <div class="grid gap-2">
                    <label>Select Favicon from Media Library</label>
                    <select class="js-media-picker" data-target="favicon-path">
                        <option value="">Choose media</option>
                        @foreach($media as $item)
                            <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                        @endforeach
                    </select>
                    <input id="favicon-path" type="text" name="favicon_path" value="{{ old('favicon_path', $settings['favicon'] ?? '') }}">
                    <button class="btn btn-outline js-media-open" type="button" data-media-target="favicon-path" data-media-type="image">Pick from Media Library</button>
                    <small>Use a media path (storage).</small>
                </div>
            @endif
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
            <div class="grid gap-2 md:col-span-2">
                <label>Address</label>
                <textarea name="address" rows="3">{{ $settings['address'] ?? '' }}</textarea>
            </div>
            <div class="grid gap-2 md:col-span-2">
                <label>Social Links (one per line)</label>
                <textarea name="social_links" rows="3">{{ is_array($settings['social_links'] ?? null) ? implode("\n", $settings['social_links']) : '' }}</textarea>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 hidden" data-tab-panel="booking">
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
            <div class="grid gap-2 md:col-span-2">
                <label>Booking.com URL</label>
                <input type="text" name="bookingcom_url" value="{{ $settings['bookingcom_url'] ?? '' }}">
                <small>Use placeholders: <code>{check_in}</code>, <code>{check_out}</code>, <code>{adults}</code>, <code>{children}</code>, <code>{rooms}</code>, <code>{guests}</code>.</small>
                <small>Example: <code>https://www.booking.com/hotel/za/your-property.html?checkin={check_in}&checkout={check_out}&group_adults={adults}&group_children={children}&no_rooms={rooms}</code></small>
            </div>
            <div class="grid gap-2 md:col-span-2">
                <label>Airbnb URL</label>
                <input type="text" name="airbnb_url" value="{{ $settings['airbnb_url'] ?? '' }}">
                <small>Use placeholders: <code>{check_in}</code>, <code>{check_out}</code>, <code>{adults}</code>, <code>{children}</code>, <code>{rooms}</code>, <code>{guests}</code>.</small>
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
            <div class="grid gap-2 md:col-span-2">
                <label>Cancellation Policy</label>
                <textarea name="cancellation_policy_text" rows="3">{{ $settings['cancellation_policy_text'] ?? '' }}</textarea>
            </div>
            <div class="grid gap-2">
                <label>Payment Provider</label>
                <input type="text" name="payment_provider" value="{{ $settings['payment_provider'] ?? 'stub' }}">
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 hidden" data-tab-panel="seo">
            <div class="grid gap-2">
                <label>Default SEO Title</label>
                <input type="text" name="default_seo_title" value="{{ $settings['default_seo_title'] ?? '' }}">
            </div>
            <div class="grid gap-2 md:col-span-2">
                <label>Default SEO Description</label>
                <textarea name="default_seo_description" rows="3">{{ $settings['default_seo_description'] ?? '' }}</textarea>
            </div>
            <div class="grid gap-2">
                <label>GA4 Measurement ID</label>
                <input type="text" name="ga4_measurement_id" value="{{ $settings['ga4_measurement_id'] ?? '' }}">
            </div>
            <div class="grid gap-2">
                <label>GTM Container ID</label>
                <input type="text" name="gtm_container_id" value="{{ $settings['gtm_container_id'] ?? '' }}">
            </div>
            <div class="grid gap-2 md:col-span-2">
                <label>Google Site Verification Meta</label>
                <input type="text" name="google_site_verification_meta" value="{{ $settings['google_site_verification_meta'] ?? '' }}">
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 hidden" data-tab-panel="reviews">
            <div class="grid gap-2">
                <label>Enable Google Reviews Sync</label>
                <select name="google_reviews_enabled">
                    <option value="1" @selected(($settings['google_reviews_enabled'] ?? false))>Yes</option>
                    <option value="0" @selected(!($settings['google_reviews_enabled'] ?? false))>No</option>
                </select>
            </div>
            <div class="grid gap-2">
                <label>Minimum Rating to Show</label>
                <select name="reviews_min_rating">
                    @foreach([3,4,5] as $rating)
                        <option value="{{ $rating }}" @selected((int) ($settings['reviews_min_rating'] ?? 3) === $rating)>{{ $rating }} stars+</option>
                    @endforeach
                </select>
            </div>
            <div class="grid gap-2 md:col-span-2">
                <label>Google API Key</label>
                <input type="text" name="google_api_key" value="{{ $settings['google_api_key'] ?? '' }}">
            </div>
            <div class="grid gap-2 md:col-span-2">
                <label>Google Place ID</label>
                <input type="text" name="google_place_id" value="{{ $settings['google_place_id'] ?? '' }}">
            </div>
            <div class="grid gap-2 md:col-span-2">
                <label>Google Place URL (for “Read more” link)</label>
                <input type="text" name="google_place_url" value="{{ $settings['google_place_url'] ?? '' }}">
            </div>
            <div class="grid gap-2 md:col-span-2">
                <label>Booking.com Reviews URL (optional)</label>
                <input type="text" name="bookingcom_reviews_url" value="{{ $settings['bookingcom_reviews_url'] ?? '' }}">
            </div>
            <div class="grid gap-2 md:col-span-2">
                <p class="text-sm text-neutral-600">Run <code>php artisan reviews:sync-google</code> after adding your API key and Place ID.</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2 hidden" data-tab-panel="custom">
            <div class="grid gap-2">
                <label>Custom CSS</label>
                <textarea name="custom_css" rows="10" data-custom-css>{{ $settings['custom_css'] ?? '' }}</textarea>
            </div>
            <div class="grid gap-2">
                <label>Custom JS</label>
                <textarea name="custom_js" rows="10" data-custom-js>{{ $settings['custom_js'] ?? '' }}</textarea>
            </div>
            <div class="lg:col-span-2 grid gap-2">
                <label>Live Preview</label>
                <iframe id="custom-code-preview" class="w-full min-h-[320px] rounded-xl border border-black/10 bg-white"></iframe>
                <p class="text-sm text-neutral-600">Preview uses sample content. Your CSS and JS apply instantly.</p>
            </div>
        </div>

        <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg" type="submit">Save Settings</button>
    </form>

    <script>
        (() => {
            const buttons = Array.from(document.querySelectorAll('[data-tab-button]'));
            const panels = Array.from(document.querySelectorAll('[data-tab-panel]'));

            const setActive = (name) => {
                buttons.forEach((btn) => {
                    const active = btn.dataset.tabButton === name;
                    btn.classList.toggle('btn-primary', active);
                    btn.classList.toggle('btn-outline', !active);
                    btn.setAttribute('aria-pressed', active ? 'true' : 'false');
                });
                panels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.tabPanel !== name);
                });
            };

            buttons.forEach((btn) => {
                btn.addEventListener('click', () => setActive(btn.dataset.tabButton));
            });

            setActive('general');

            const cssField = document.querySelector('[data-custom-css]');
            const jsField = document.querySelector('[data-custom-js]');
            const preview = document.getElementById('custom-code-preview');

            if (cssField && jsField && preview) {
                const baseStyles = `
                    body { font-family: 'Montserrat', sans-serif; padding: 24px; background: #f8fafc; }
                    .card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #e5e7eb; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08); }
                    .title { font-size: 24px; font-weight: 700; margin-bottom: 8px; }
                    .muted { color: #6b7280; }
                    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 999px; padding: 10px 18px; font-weight: 600; background: #111827; color: #fff; border: 0; }
                    .pill { display: inline-block; padding: 6px 12px; border-radius: 999px; background: #fef3c7; color: #92400e; font-weight: 600; font-size: 12px; }
                    .grid { display: grid; gap: 16px; }
                `;

                const sampleMarkup = `
                    <div class="grid">
                        <div class="pill">Custom Code Preview</div>
                        <div class="card">
                            <div class="title">Riverside Guesthouse</div>
                            <p class="muted">Try changing colors, fonts, spacing, and buttons.</p>
                            <div style="margin-top: 16px;">
                                <button class="btn" type="button">Book Online</button>
                            </div>
                        </div>
                    </div>
                `;

                const renderPreview = () => {
                    const css = cssField.value || '';
                    const js = jsField.value || '';
                    const src = `
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>${baseStyles}</style>
<style>${css}</style>
</head>
<body>
${sampleMarkup}
<script>${js}<\/script>
</body>
</html>`;
                    preview.srcdoc = src;
                };

                renderPreview();
                cssField.addEventListener('input', renderPreview);
                jsField.addEventListener('input', renderPreview);
            }
        })();
    </script>
@endsection
