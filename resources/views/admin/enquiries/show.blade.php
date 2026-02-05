@extends('admin.layouts.app')

@section('content')
    <h1>Enquiry from {{ $enquiry->name }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Email:</strong> {{ $enquiry->email }}</p>
            <p><strong>Phone:</strong> {{ $enquiry->phone }}</p>
            <p><strong>Dates:</strong> {{ $enquiry->check_in }} - {{ $enquiry->check_out }}</p>
            <p><strong>Guests:</strong> {{ $enquiry->guests }}</p>
            <p><strong>Room:</strong> {{ $enquiry->room?->title ?? 'Any' }}</p>
            <p><strong>Message:</strong> {{ $enquiry->message }}</p>
        </div>
    </div>

    <form method="post" action="{{ route('admin.enquiries.status', $enquiry) }}" class="form">
        @csrf
        <div class="form-row">
            <label>Status</label>
            <select name="status">
                @foreach(['new','in_progress','closed'] as $status)
                    <option value="{{ $status }}" @selected($enquiry->status === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Update Status</button>
    </form>
@endsection
