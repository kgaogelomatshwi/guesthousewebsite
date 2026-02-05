<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            SettingsSeeder::class,
            AmenitySeeder::class,
            PageSeeder::class,
            RoomSeeder::class,
            RateSeeder::class,
            GallerySeeder::class,
            AttractionSeeder::class,
            TestimonialSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
