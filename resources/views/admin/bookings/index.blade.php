@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>Bookings</h1>
        <div>
            <a class="btn btn-outline" href="{{ route('admin.bookings.export') }}">Export CSV</a>
            <a class="btn btn-primary" href="{{ route('admin.bookings.create') }}">Manual Booking</a>
        </div>
    </div>
    <h2>Monthly Calendar ({{ $start->format('F Y') }})</h2>
    @php
        $startOfCalendar = $start->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
        $endOfCalendar = $end->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);
        $cursor = $startOfCalendar->copy();
        $bookingMap = [];
        foreach ($calendarBookings as $booking) {
            $checkIn = \Carbon\Carbon::parse($booking->check_in);
            $checkOut = \Carbon\Carbon::parse($booking->check_out)->subDay();
            for ($day = $checkIn->copy(); $day->lessThanOrEqualTo($checkOut); $day->addDay()) {
                $bookingMap[$day->toDateString()][] = $booking;
            }
        }
    @endphp
    <div class="calendar-grid">
        @while($cursor->lessThanOrEqualTo($endOfCalendar))
            @php $isCurrentMonth = $cursor->month === $start->month; @endphp
            <div class="calendar-cell {{ $isCurrentMonth ? '' : 'is-muted' }}">
                <div class="calendar-date">{{ $cursor->format('j') }}</div>
                @foreach($bookingMap[$cursor->toDateString()] ?? [] as $booking)
                    <div class="calendar-booking">{{ $booking->code }}</div>
                @endforeach
            </div>
            @php $cursor->addDay(); @endphp
        @endwhile
    </div>

    <div class="section-divider"></div>

    <table class="table">
        <thead>
        <tr>
            <th>Code</th>
            <th>Guest</th>
            <th>Dates</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->code }}</td>
                <td>{{ $booking->guest_name }}</td>
                <td>{{ $booking->check_in }} - {{ $booking->check_out }}</td>
                <td>{{ $booking->status }}</td>
                <td><a class="btn btn-outline" href="{{ route('admin.bookings.show', $booking) }}">View</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $bookings->links() }}
@endsection
