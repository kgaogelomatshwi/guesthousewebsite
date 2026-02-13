@extends('admin.layouts.app')

@section('content')
    <h1>Dashboard</h1>
    <div class="grid-3">
        <x-card>
            <div class="card-body">
                <h3>Rooms</h3>
                <p class="stat">{{ $stats['rooms'] }}</p>
            </div>
        </x-card>
        <x-card>
            <div class="card-body">
                <h3>Enquiries</h3>
                <p class="stat">{{ $stats['enquiries'] }}</p>
            </div>
        </x-card>
        <x-card>
            <div class="card-body">
                <h3>Bookings</h3>
                <p class="stat">{{ $stats['bookings'] }}</p>
            </div>
        </x-card>
    </div>

    <h2>Performance (7 / 30 / 90 Days)</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Window</th>
            <th>Page Views</th>
            <th>CTA Clicks</th>
            <th>Enquiries</th>
            <th>Bookings</th>
        </tr>
        </thead>
        <tbody>
        @foreach([7, 30, 90] as $days)
            @php
                $events = $analytics[$days]['events'] ?? collect();
                $ctaClicks = ($events['click_whatsapp'] ?? 0) + ($events['click_bookingcom'] ?? 0) + ($events['click_airbnb'] ?? 0);
            @endphp
            <tr>
                <td>Last {{ $days }} days</td>
                <td>{{ $events['page_view'] ?? 0 }}</td>
                <td>{{ $ctaClicks }}</td>
                <td>{{ $analytics[$days]['enquiries'] ?? 0 }}</td>
                <td>{{ $analytics[$days]['bookings'] ?? 0 }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2 class="mt-10">Live Analytics (Last 60 Minutes)</h2>
    @if(!($hasAnalytics ?? false))
        <x-alert type="error">Analytics table not found. Run migrations.</x-alert>
    @else
        <div class="grid-4">
            <x-card>
                <div class="card-body">
                    <h3>Page Views</h3>
                    <p class="stat">{{ $live['page_views'] ?? 0 }}</p>
                </div>
            </x-card>
            <x-card>
                <div class="card-body">
                    <h3>CTA Clicks</h3>
                    <p class="stat">{{ $live['cta_clicks'] ?? 0 }}</p>
                </div>
            </x-card>
            <x-card>
                <div class="card-body">
                    <h3>Enquiries</h3>
                    <p class="stat">{{ $live['enquiries'] ?? 0 }}</p>
                </div>
            </x-card>
            <x-card>
                <div class="card-body">
                    <h3>Bookings</h3>
                    <p class="stat">{{ $live['bookings'] ?? 0 }}</p>
                </div>
            </x-card>
        </div>

        <div class="grid-2 mt-8">
            <x-card>
                <div class="card-body">
                    <h3>Page Views by Hour (Last 24h)</h3>
                    <div class="flex items-end gap-1 mt-4" style="height: 120px;">
                        @forelse($hourly ?? [] as $row)
                            @php
                                $height = (int) round((($row['count'] ?? 0) / max(1, $maxHourly ?? 1)) * 100) + 6;
                            @endphp
                            <div class="flex-1 bg-neutral-200 rounded-t" title="{{ $row['label'] }}: {{ $row['count'] }}" style="height: {{ $height }}px;"></div>
                        @empty
                            <p>No data yet.</p>
                        @endforelse
                    </div>
                    @if(!empty($hourly))
                        <div class="flex justify-between text-xs text-neutral-500 mt-2">
                            <span>{{ $hourly[0]['label'] ?? '' }}</span>
                            <span>{{ $hourly[11]['label'] ?? '' }}</span>
                            <span>{{ $hourly[23]['label'] ?? '' }}</span>
                        </div>
                    @endif
                </div>
            </x-card>

            <x-card>
                <div class="card-body">
                    <h3>Top Pages (Last 60m)</h3>
                    <ul class="list-disc pl-5">
                        @forelse($topPagesHour ?? [] as $row)
                            <li>{{ $row->path }} — {{ $row->total }}</li>
                        @empty
                            <li>No data yet.</li>
                        @endforelse
                    </ul>
                    <div class="section-divider"></div>
                    <h3>Top Referrers (Last 60m)</h3>
                    <ul class="list-disc pl-5">
                        @forelse($topReferrersHour ?? [] as $row)
                            <li>{{ $row->referrer }} — {{ $row->total }}</li>
                        @empty
                            <li>No data yet.</li>
                        @endforelse
                    </ul>
                </div>
            </x-card>
        </div>
    @endif

    <div class="grid-2 mt-8">
        <x-card>
            <div class="card-body">
                <h3>Top Pages (30 days)</h3>
                <ul class="list-disc pl-5">
                    @forelse($topPages as $row)
                        <li>{{ $row->path }} — {{ $row->total }}</li>
                    @empty
                        <li>No data yet.</li>
                    @endforelse
                </ul>
            </div>
        </x-card>
        <x-card>
            <div class="card-body">
                <h3>Top Referrers (30 days)</h3>
                <ul class="list-disc pl-5">
                    @forelse($topReferrers as $row)
                        <li>{{ $row->referrer }} — {{ $row->total }}</li>
                    @empty
                        <li>No data yet.</li>
                    @endforelse
                </ul>
            </div>
        </x-card>
    </div>
@endsection
