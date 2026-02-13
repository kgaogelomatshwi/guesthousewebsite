<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Room;
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

        foreach ($windows as $days) {
            $events = AnalyticsEvent::query()
                ->where('created_at', '>=', now()->subDays($days))
                ->get()
                ->groupBy('type')
                ->map->count();

            $analytics[$days] = [
                'events' => $events,
                'enquiries' => Enquiry::where('created_at', '>=', now()->subDays($days))->count(),
                'bookings' => Booking::where('created_at', '>=', now()->subDays($days))->count(),
            ];
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
        ]);
    }
}
