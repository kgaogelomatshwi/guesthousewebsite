@extends('admin.layouts.app')

@section('content')
    <h1>Booking {{ $booking->code }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Guest:</strong> {{ $booking->guest_name }}</p>
            <p><strong>Email:</strong> {{ $booking->email }}</p>
            <p><strong>Phone:</strong> {{ $booking->phone }}</p>
            <p><strong>Dates:</strong> {{ $booking->check_in }} - {{ $booking->check_out }}</p>
            <p><strong>Guests:</strong> {{ $booking->guests }}</p>
            <p><strong>Room:</strong> {{ $booking->room?->title ?? 'Any' }}</p>
            <p><strong>Total:</strong> {{ $booking->currency }} {{ number_format($booking->total_amount, 2) }}</p>
            <p><strong>Deposit:</strong> {{ $booking->currency }} {{ number_format($booking->deposit_amount, 2) }}</p>
        </div>
    </div>

    <form method="post" action="{{ route('admin.bookings.status', $booking) }}" class="form">
        @csrf
        <div class="form-row">
            <label>Status</label>
            <select name="status">
                @foreach(['pending','paid','cancelled','refunded'] as $status)
                    <option value="{{ $status }}" @selected($booking->status === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Update Status</button>
    </form>

    <h2>Payments</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Provider</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($booking->payments as $payment)
            <tr>
                <td>{{ $payment->provider }}</td>
                <td>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
