<?php

use App\Services\Reviews\GoogleReviewsSync;
use App\Services\SettingsService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reviews:sync-google', function (SettingsService $settings, GoogleReviewsSync $sync) {
    $result = $sync->sync($settings);
    $this->info($result['message'] ?? 'Done.');
    $this->info('Synced: ' . ($result['count'] ?? 0));
})->purpose('Sync Google reviews into external_reviews');
