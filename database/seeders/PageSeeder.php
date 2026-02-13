<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['key' => 'home', 'title' => 'Home', 'slug' => '/'],
            ['key' => 'about', 'title' => 'About', 'slug' => 'about'],
            ['key' => 'services', 'title' => 'Services', 'slug' => 'services'],
            ['key' => 'rates', 'title' => 'Rates', 'slug' => 'rates'],
            ['key' => 'policies', 'title' => 'Policies', 'slug' => 'policies'],
            ['key' => 'contact', 'title' => 'Contact', 'slug' => 'contact'],
            ['key' => 'booking', 'title' => 'Booking', 'slug' => 'booking'],
            ['key' => 'rooms', 'title' => 'Rooms', 'slug' => 'rooms'],
            ['key' => 'gallery', 'title' => 'Gallery', 'slug' => 'gallery'],
            ['key' => 'attractions', 'title' => 'Attractions', 'slug' => 'attractions'],
            ['key' => 'blog', 'title' => 'Blog', 'slug' => 'blog'],
        ];

        foreach ($pages as $data) {
            Page::updateOrCreate(
                ['key' => $data['key']],
                [
                    'title' => $data['title'],
                    'slug' => $data['slug'] === '/' ? $data['key'] : $data['slug'],
                    'seo_title' => $data['title'] . ' | Riverside Guesthouse',
                    'seo_description' => 'Learn more about ' . strtolower($data['title']) . ' at Riverside Guesthouse.',
                    'is_active' => true,
                ]
            );
        }

        $home = Page::where('key', 'home')->first();
        if ($home) {
            if (empty($home->custom_html)) {
                $home->update([
                    'custom_html' => '<div class="custom-banner">Winter Special: Stay 3 nights, pay 2. <a href="/booking">Book now</a></div>',
                ]);
            }

            PageSection::where('page_id', $home->id)
                ->where('type', 'hero')
                ->update(['is_active' => false]);

            PageSection::where('page_id', $home->id)
                ->where('type', 'hero_booking')
                ->update(['is_active' => false]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'hero_slider',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'show_booking_form' => true,
                    'slides' => [
                        [
                            'title' => 'Tranquil Countryside Escape in Limpopo',
                            'subtitle' => 'Warm hospitality, fresh air, and value-for-money rooms for families and couples.',
                            'image' => 'https://cdn.pixabay.com/photo/2018/07/23/01/03/landscape-3555890_1280.jpg',
                            'button_label' => 'Book Online',
                            'button_url' => '/booking',
                            'secondary_button_label' => 'View Rooms',
                            'secondary_button_url' => '/rooms',
                        ],
                        [
                            'title' => 'Comfortable Rooms. Honest Value.',
                            'subtitle' => 'Self-catering options, secure parking, and peaceful surroundings.',
                            'image' => 'https://cdn.pixabay.com/photo/2016/11/29/03/53/architecture-1868265_1280.jpg',
                            'button_label' => 'Check Availability',
                            'button_url' => '/booking',
                            'secondary_button_label' => 'Explore Services',
                            'secondary_button_url' => '/services',
                        ],
                        [
                            'title' => 'Relax, Unwind, and Breathe',
                            'subtitle' => 'A calm base for families, couples, and business travelers.',
                            'image' => 'https://cdn.pixabay.com/photo/2015/10/12/14/54/hotel-983280_1280.jpg',
                            'button_label' => 'Book Online',
                            'button_url' => '/booking',
                            'secondary_button_label' => 'Contact Us',
                            'secondary_button_url' => '/contact',
                        ],
                    ],
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'about_highlights',
                'position' => 2,
            ], [
                'content_json' => json_encode([
                    'title' => 'A Welcoming Guesthouse in the Limpopo Countryside',
                    'body' => '<p>Set among rolling hills and quiet farmland, our guesthouse offers a calm, family-friendly stay with honest value and personal service.</p><p>Enjoy comfortable rooms, self-catering options, and easy access to nearby nature trails.</p>',
                    'button_label' => 'Read More',
                    'button_url' => '/about',
                    'stats' => [
                        ['label' => 'Rooms', 'value' => '8'],
                        ['label' => 'Bathrooms', 'value' => '8'],
                        ['label' => 'Staff', 'value' => '6'],
                        ['label' => 'Parking', 'value' => 'Secure'],
                    ],
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'featured_rooms',
                'position' => 3,
            ], [
                'content_json' => json_encode([
                    'title' => 'Featured Rooms',
                    'limit' => 3,
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'services_icons',
                'position' => 4,
            ], [
                'content_json' => json_encode([
                    'title' => 'Services & Amenities',
                    'items' => [
                        ['title' => 'Wi-Fi', 'icon' => '📶', 'text' => 'Stay connected throughout your visit.'],
                        ['title' => 'Secure Parking', 'icon' => '🅿️', 'text' => 'Safe on-site parking for all guests.'],
                        ['title' => 'Self-Catering', 'icon' => '🍳', 'text' => 'Kitchens in select units.'],
                        ['title' => 'Breakfast', 'icon' => '☕', 'text' => 'Fresh, simple breakfast options.'],
                    ],
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'testimonials_preview',
                'position' => 5,
            ], [
                'content_json' => json_encode([
                    'title' => 'Guest Reviews',
                    'limit' => 3,
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'location_preview',
                'position' => 6,
            ], [
                'content_json' => json_encode([
                    'title' => 'Find Us in Limpopo',
                    'address' => '123 Countryside Road, Limpopo, South Africa',
                    'embed_code' => '<iframe src="https://maps.google.com/maps?q=Limpopo&t=&z=9&ie=UTF8&iwloc=&output=embed" loading="lazy"></iframe>',
                    'button_label' => 'Get Directions',
                    'button_url' => 'https://maps.google.com/?q=Limpopo',
                ]),
                'is_active' => true,
            ]);
        }

        $about = Page::where('key', 'about')->first();
        if ($about) {
            PageSection::updateOrCreate([
                'page_id' => $about->id,
                'type' => 'text_block',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Our Story',
                    'body' => '<p>We are a family-run guesthouse offering a quiet, affordable stay in the Limpopo countryside.</p>',
                ]),
                'is_active' => true,
            ]);
        }

        $services = Page::where('key', 'services')->first();
        if ($services) {
            PageSection::updateOrCreate([
                'page_id' => $services->id,
                'type' => 'services_icons',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Services & Amenities',
                    'items' => [
                        ['title' => 'Wi-Fi', 'icon' => '📶', 'text' => 'Free throughout the guesthouse.'],
                        ['title' => 'Secure Parking', 'icon' => '🅿️', 'text' => 'On-site parking for guests.'],
                        ['title' => 'Self-Catering', 'icon' => '🍳', 'text' => 'Selected units include kitchens.'],
                        ['title' => 'Breakfast', 'icon' => '☕', 'text' => 'Optional breakfast available.'],
                    ],
                ]),
                'is_active' => true,
            ]);
        }

        $rates = Page::where('key', 'rates')->first();
        if ($rates) {
            PageSection::updateOrCreate([
                'page_id' => $rates->id,
                'type' => 'text_block',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Rates & Policies',
                    'body' => '<p>Seasonal pricing available. Contact us for group bookings.</p>',
                ]),
                'is_active' => true,
            ]);
        }

        $policies = Page::where('key', 'policies')->first();
        if ($policies) {
            PageSection::updateOrCreate([
                'page_id' => $policies->id,
                'type' => 'faq',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Policies',
                    'items' => [
                        ['question' => 'Check-in time', 'answer' => 'Check-in is from 2pm to 7pm.'],
                        ['question' => 'Check-out time', 'answer' => 'Check-out is by 10am.'],
                    ],
                ]),
                'is_active' => true,
            ]);
        }

        $contact = Page::where('key', 'contact')->first();
        if ($contact) {
            PageSection::updateOrCreate([
                'page_id' => $contact->id,
                'type' => 'hero',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Let us plan your stay',
                    'subtitle' => 'We are happy to help with special requests and local tips.',
                ]),
                'is_active' => true,
            ]);
        }

        $booking = Page::where('key', 'booking')->first();
        if ($booking) {
            PageSection::updateOrCreate([
                'page_id' => $booking->id,
                'type' => 'hero',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Reserve your countryside escape',
                    'subtitle' => 'Secure your dates in minutes.',
                ]),
                'is_active' => true,
            ]);
        }

        $rooms = Page::where('key', 'rooms')->first();
        if ($rooms) {
            PageSection::updateOrCreate([
                'page_id' => $rooms->id,
                'type' => 'hero',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Rooms and Suites',
                    'subtitle' => 'Thoughtfully designed spaces with mountain views.',
                ]),
                'is_active' => true,
            ]);
        }

        $gallery = Page::where('key', 'gallery')->first();
        if ($gallery) {
            PageSection::updateOrCreate([
                'page_id' => $gallery->id,
                'type' => 'hero',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Gallery',
                    'subtitle' => 'A glimpse into the guesthouse experience.',
                ]),
                'is_active' => true,
            ]);
        }

        $attractions = Page::where('key', 'attractions')->first();
        if ($attractions) {
            PageSection::updateOrCreate([
                'page_id' => $attractions->id,
                'type' => 'hero',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Things To Do',
                    'subtitle' => 'Local adventures, curated for you.',
                ]),
                'is_active' => true,
            ]);
        }

        $blog = Page::where('key', 'blog')->first();
        if ($blog) {
            PageSection::updateOrCreate([
                'page_id' => $blog->id,
                'type' => 'hero',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'Stories and Updates',
                    'subtitle' => 'Insider tips from the valley.',
                ]),
                'is_active' => true,
            ]);
        }
    }
}
