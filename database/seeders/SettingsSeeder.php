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
            ['key' => 'bookingcom_url', 'value' => 'https://www.booking.com/hotel/za/your-guesthouse.html?checkin={check_in}&checkout={check_out}&group_adults={adults}&no_rooms={rooms}'],
            ['key' => 'airbnb_url', 'value' => 'https://www.airbnb.com/rooms/your-listing?check_in={check_in}&check_out={check_out}&adults={adults}'],
            ['key' => 'direct_booking_enabled', 'value' => '1', 'type' => 'boolean'],
            ['key' => 'currency', 'value' => 'ZAR'],
            ['key' => 'deposit_policy', 'value' => '50%'],
            ['key' => 'cancellation_policy_text', 'value' => 'Free cancellation up to 7 days before arrival.'],
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
    }
}
