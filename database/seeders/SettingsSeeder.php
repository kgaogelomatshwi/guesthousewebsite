<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Riverside Guesthouse'],
            ['key' => 'phone', 'value' => '+27 21 000 0000'],
            ['key' => 'whatsapp', 'value' => '27210000000'],
            ['key' => 'email', 'value' => 'hello@riversideguesthouse.co.za'],
            ['key' => 'address', 'value' => '123 Valley Road, Western Cape, South Africa'],
            ['key' => 'default_seo_title', 'value' => 'Riverside Guesthouse | Countryside Escape'],
            ['key' => 'default_seo_description', 'value' => 'A tranquil guesthouse with scenic views, cozy rooms, and unforgettable experiences.'],
            ['key' => 'booking_mode', 'value' => 'HYBRID'],
            ['key' => 'ota_mode', 'value' => 'both'],
            ['key' => 'bookingcom_url', 'value' => 'https://www.booking.com/hotel/za/rural-villa-guesthouse.html?checkin={check_in}&checkout={check_out}&group_adults={adults}&group_children={children}&no_rooms={rooms}#hp_availability_style_changes'],
            ['key' => 'airbnb_url', 'value' => 'https://www.airbnb.com/rooms/your-listing?check_in={check_in}&check_out={check_out}&adults={adults}'],
            ['key' => 'direct_booking_enabled', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'currency', 'value' => 'ZAR'],
            ['key' => 'deposit_policy', 'value' => '50%'],
            ['key' => 'cancellation_policy_text', 'value' => 'Free cancellation up to 7 days before arrival.'],
            ['key' => 'google_reviews_enabled', 'value' => '0', 'type' => 'boolean'],
            ['key' => 'google_api_key', 'value' => ''],
            ['key' => 'google_place_id', 'value' => ''],
            ['key' => 'google_place_url', 'value' => ''],
            ['key' => 'bookingcom_reviews_url', 'value' => ''],
            ['key' => 'reviews_min_rating', 'value' => '3', 'type' => 'int'],
            ['key' => 'payment_provider', 'value' => 'stub'],
            ['key' => 'social_links', 'value' => json_encode(['https://instagram.com', 'https://facebook.com']), 'type' => 'json'],
            ['key' => 'custom_css', 'value' => ''],
            ['key' => 'custom_js', 'value' => ''],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type'] ?? null]
            );
        }

        $demoCss = <<<CSS
.custom-banner {
    background: #111827;
    color: #ffffff;
    padding: 12px 16px;
    text-align: center;
    font-weight: 600;
    letter-spacing: 0.04em;
}

.custom-banner a {
    color: #f59e0b;
    text-decoration: underline;
}

body.custom-js-active .custom-banner {
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}
CSS;

        $demoJs = "document.body.classList.add('custom-js-active');";

        $customCss = Setting::firstOrNew(['key' => 'custom_css']);
        if (empty($customCss->value)) {
            $customCss->value = $demoCss;
            $customCss->type = null;
            $customCss->save();
        }

        $customJs = Setting::firstOrNew(['key' => 'custom_js']);
        if (empty($customJs->value)) {
            $customJs->value = $demoJs;
            $customJs->type = null;
            $customJs->save();
        }
    }
}
