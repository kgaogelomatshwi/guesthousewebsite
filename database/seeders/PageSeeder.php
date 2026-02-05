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
            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'hero',
                'position' => 1,
            ], [
                'content_json' => json_encode([
                    'title' => 'A Riverside Retreat in the Heart of the Valley',
                    'subtitle' => 'Slow mornings, mountain views, and locally sourced breakfasts.',
                    'button_label' => 'Book Your Stay',
                    'button_url' => '/booking',
                    'secondary_button_label' => 'Explore Rooms',
                    'secondary_button_url' => '/rooms',
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'feature_grid',
                'position' => 2,
            ], [
                'content_json' => json_encode([
                    'title' => 'Why Guests Love Us',
                    'items' => [
                        ['title' => 'Farm-to-table breakfasts', 'icon' => 'breakfast', 'text' => 'Seasonal menus with local produce.'],
                        ['title' => 'Mountain views', 'icon' => 'mountain', 'text' => 'Wake up to soft light and open skies.'],
                        ['title' => 'Quiet and private', 'icon' => 'garden', 'text' => 'Secluded gardens and curated spaces.'],
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
                'type' => 'amenities',
                'position' => 4,
            ], [
                'content_json' => json_encode([
                    'title' => 'Amenities',
                    'mode' => 'auto',
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'gallery_preview',
                'position' => 5,
            ], [
                'content_json' => json_encode([
                    'title' => 'Moments Around the Guesthouse',
                    'limit' => 6,
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'testimonials_preview',
                'position' => 6,
            ], [
                'content_json' => json_encode([
                    'title' => 'Guest Stories',
                    'limit' => 3,
                ]),
                'is_active' => true,
            ]);

            PageSection::updateOrCreate([
                'page_id' => $home->id,
                'type' => 'map_embed',
                'position' => 7,
            ], [
                'content_json' => json_encode([
                    'title' => 'Find Us',
                    'embed_code' => '<iframe src="https://maps.google.com/maps?q=Stellenbosch&t=&z=11&ie=UTF8&iwloc=&output=embed" loading="lazy"></iframe>',
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
                    'body' => '<p>Riverside Guesthouse is a family-run retreat nestled between vineyards and mountains.</p>',
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
