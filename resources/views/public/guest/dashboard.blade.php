@extends('public.layouts.app')

@section('content')
    <section class="py-16 bg-white">
        <div class="container grid gap-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-semibold">My Bookings</h1>
                <a class="btn btn-primary" href="{{ route('booking.create') }}">New Booking</a>
            </div>

            <div class="grid gap-4">
                <h2 class="text-xl font-semibold">Direct Bookings</h2>
                @if($bookings->count() === 0)
                    <x-alert type="info">No direct bookings yet.</x-alert>
                @else
                    <div class="overflow-auto">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Room</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->code }}</td>
                                    <td>{{ $booking->room?->title ?? 'Any room' }}</td>
                                    <td>{{ optional($booking->check_in)->format('Y-m-d') }}</td>
                                    <td>{{ optional($booking->check_out)->format('Y-m-d') }}</td>
                                    <td>{{ ucfirst($booking->status) }}</td>
                                    <td>{{ $booking->currency }} {{ number_format((float) $booking->total_amount, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $bookings->links() }}
                @endif
            </div>

            <div class="grid gap-4">
                <h2 class="text-xl font-semibold">OTA Bookings You Logged</h2>
                @if($externalBookings->count() === 0)
                    <x-alert type="info">No OTA records yet.</x-alert>
                @else
                    <div class="overflow-auto">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Platform</th>
                                <th>Reference</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Guests</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($externalBookings as $record)
                                <tr>
                                    <td>{{ ucfirst($record->platform) }}</td>
                                    <td>{{ $record->booking_reference }}</td>
                                    <td>{{ optional($record->check_in)->format('Y-m-d') }}</td>
                                    <td>{{ optional($record->check_out)->format('Y-m-d') }}</td>
                                    <td>{{ $record->guests }}</td>
                                    <td>{{ ucfirst($record->status) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $externalBookings->links() }}
                @endif
            </div>
        </div>
    </section>
@endsection
