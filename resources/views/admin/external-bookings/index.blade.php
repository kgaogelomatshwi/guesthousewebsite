@extends('admin.layouts.app')

@section('content')
    <div class="flex-between">
        <h1>OTA Bookings</h1>
        <a class="btn btn-outline" href="{{ route('admin.external-bookings.export') }}">Export CSV</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Guest</th>
            <th>Platform</th>
            <th>Reference</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->full_name }}</td>
                <td>{{ $booking->platform }}</td>
                <td>{{ $booking->booking_reference }}</td>
                <td>{{ $booking->status }}</td>
                <td><a class="btn btn-outline" href="{{ route('admin.external-bookings.show', $booking) }}">View</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $bookings->links() }}
@endsection
