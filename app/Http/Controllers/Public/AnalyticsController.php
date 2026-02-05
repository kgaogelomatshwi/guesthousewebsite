<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class AnalyticsController extends Controller
{
    public function store(Request $request): Response
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'max:50'],
            'meta' => ['nullable', 'array'],
        ]);

        if (Schema::hasTable('analytics_events')) {
            $sessionId = $request->session()->getId() ?: Str::random(12);
            $meta = $data['meta'] ?? [];

            AnalyticsEvent::create([
                'type' => $data['type'],
                'path' => $meta['path'] ?? $request->path(),
                'referrer' => $request->headers->get('referer'),
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'utm_term' => $request->query('utm_term'),
                'utm_content' => $request->query('utm_content'),
                'session_hash' => hash('sha256', $sessionId),
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip(),
                'meta_json' => $meta ? json_encode($meta) : null,
            ]);
        }

        return response()->noContent();
    }
}
