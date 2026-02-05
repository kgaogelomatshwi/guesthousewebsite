<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'title' => 'Garden Suite',
                'short_description' => 'Spacious suite with garden patio and king bed.',
                'description' => 'Enjoy a quiet garden-facing suite with natural textures, plush linens, and a private patio.',
                'base_price' => 1800,
                'max_guests' => 2,
                'bed_type' => 'King',
                'featured' => true,
            ],
            [
                'title' => 'Mountain View Room',
                'short_description' => 'Sunrise views over the valley with a queen bed.',
                'description' => 'Wake up to mountain peaks and soft light. Ideal for couples.',
                'base_price' => 1500,
                'max_guests' => 2,
                'bed_type' => 'Queen',
                'featured' => true,
            ],
            [
                'title' => 'Family Cottage',
                'short_description' => 'Two-bedroom cottage with lounge and kitchenette.',
                'description' => 'Perfect for families, with extra space and a cozy lounge area.',
                'base_price' => 2400,
                'max_guests' => 4,
                'bed_type' => 'Queen + Twins',
                'featured' => false,
            ],
        ];

        $amenities = Amenity::all();

        foreach ($rooms as $index => $data) {
            $room = Room::updateOrCreate([
                'slug' => Str::slug($data['title']),
            ], array_merge($data, [
                'currency' => 'ZAR',
                'status' => 'active',
            ]));

            if ($amenities->isNotEmpty()) {
                $room->amenities()->sync($amenities->random(min(4, $amenities->count()))->pluck('id'));
            }

            $svg = $this->makeSvg($data['title']);
            $path = "demo/rooms/room-" . ($index + 1) . ".svg";
            Storage::disk('public')->put($path, $svg);

            RoomImage::updateOrCreate([
                'room_id' => $room->id,
                'path' => $path,
            ], [
                'position' => 1,
            ]);
        }
    }

    private function makeSvg(string $title): string
    {
        $safeTitle = htmlspecialchars($title, ENT_QUOTES);

        return "<svg xmlns='http://www.w3.org/2000/svg' width='1200' height='800'>" .
            "<rect width='1200' height='800' fill='#e7dcc7'/>" .
            "<text x='50%' y='50%' font-size='48' text-anchor='middle' fill='#2f3b2f' font-family='Arial'>{$safeTitle}</text>" .
            "</svg>";
    }
}
