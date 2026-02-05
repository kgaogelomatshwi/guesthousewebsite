<?php

namespace App\Http\Middleware;

use App\Models\AnalyticsEvent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackAnalytics
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->method() !== 'GET') {
            return $response;
        }

        if ($request->is('admin*') || $request->is('login') || $request->is('logout') || $request->is('analytics/*')) {
            return $response;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return $response;
        }

        if (Schema::hasTable('analytics_events')) {
            $sessionId = $request->session()->getId() ?: Str::random(12);
            $sessionHash = hash('sha256', $sessionId);

            AnalyticsEvent::create([
                'type' => 'page_view',
                'path' => $request->path(),
                'referrer' => $request->headers->get('referer'),
                'utm_source' => $request->query('utm_source'),
                'utm_medium' => $request->query('utm_medium'),
                'utm_campaign' => $request->query('utm_campaign'),
                'utm_term' => $request->query('utm_term'),
                'utm_content' => $request->query('utm_content'),
                'session_hash' => $sessionHash,
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip(),
            ]);
        }

        return $response;
    }
}
