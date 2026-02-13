<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Room;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'rooms' => Room::count(),
            'enquiries' => Enquiry::count(),
            'bookings' => Booking::count(),
        ];

        $windows = [7, 30, 90];
        $analytics = [];

        $hasAnalytics = Schema::hasTable('analytics_events');
        $live = [
            'page_views' => 0,
            'cta_clicks' => 0,
            'enquiries' => 0,
            'bookings' => 0,
        ];
        $hourly = collect();
        $maxHourly = 1;
        $topPagesHour = collect();
        $topReferrersHour = collect();

        foreach ($windows as $days) {
            $events = $hasAnalytics
                ? AnalyticsEvent::query()
                    ->where('created_at', '>=', now()->subDays($days))
                    ->get()
                    ->groupBy('type')
                    ->map->count()
                : collect();

            $analytics[$days] = [
                'events' => $events,
                'enquiries' => Enquiry::where('created_at', '>=', now()->subDays($days))->count(),
                'bookings' => Booking::where('created_at', '>=', now()->subDays($days))->count(),
            ];
        }

        if ($hasAnalytics) {
            $liveEvents = AnalyticsEvent::query()
                ->where('created_at', '>=', now()->subHour())
                ->get()
                ->groupBy('type')
                ->map->count();

            $live = [
                'page_views' => $liveEvents['page_view'] ?? 0,
                'cta_clicks' => ($liveEvents['click_whatsapp'] ?? 0) + ($liveEvents['click_bookingcom'] ?? 0) + ($liveEvents['click_airbnb'] ?? 0),
                'enquiries' => Enquiry::where('created_at', '>=', now()->subHour())->count(),
                'bookings' => Booking::where('created_at', '>=', now()->subHour())->count(),
            ];

            $hourly = collect();
            for ($i = 23; $i >= 0; $i--) {
                $start = now()->subHours($i + 1);
                $end = now()->subHours($i);
                $count = AnalyticsEvent::query()
                    ->where('type', 'page_view')
                    ->whereBetween('created_at', [$start, $end])
                    ->count();
                $hourly->push([
                    'label' => $start->format('H:00'),
                    'count' => $count,
                ]);
            }
            $maxHourly = max(1, (int) $hourly->max('count'));

            $topPagesHour = AnalyticsEvent::query()
                ->where('type', 'page_view')
                ->where('created_at', '>=', now()->subHour())
                ->selectRaw('path, count(*) as total')
                ->groupBy('path')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            $topReferrersHour = AnalyticsEvent::query()
                ->whereNotNull('referrer')
                ->where('referrer', '!=', '')
                ->where('created_at', '>=', now()->subHour())
                ->selectRaw('referrer, count(*) as total')
                ->groupBy('referrer')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        }

        return view('admin.dashboard', [
            'stats' => $stats,
            'analytics' => $analytics,
            'topPages' => AnalyticsEvent::query()
                ->where('type', 'page_view')
                ->where('created_at', '>=', now()->subDays(30))
                ->selectRaw('path, count(*) as total')
                ->groupBy('path')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
            'topReferrers' => AnalyticsEvent::query()
                ->whereNotNull('referrer')
                ->where('referrer', '!=', '')
                ->where('created_at', '>=', now()->subDays(30))
                ->selectRaw('referrer, count(*) as total')
                ->groupBy('referrer')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
            'live' => $live,
            'hourly' => $hourly,
            'maxHourly' => $maxHourly,
            'topPagesHour' => $topPagesHour,
            'topReferrersHour' => $topReferrersHour,
            'hasAnalytics' => $hasAnalytics,
        ]);
    }
}
