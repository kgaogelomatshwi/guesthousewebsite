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
@endsection
