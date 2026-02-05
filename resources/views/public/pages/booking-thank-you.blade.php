@php($bodyEvent = 'payment_success')
@extends('public.layouts.app')

@section('content')
    <section class="section section-light">
        <div class="container narrow">
            <h1>Booking received</h1>
            <p>Your booking request has been recorded. We will send payment confirmation shortly.</p>
            @if(session('booking_code'))
                <p><strong>Booking code:</strong> {{ session('booking_code') }}</p>
            @endif
            <a class="btn btn-outline" href="{{ route('home') }}">Back to Home</a>
        </div>
    </section>
@endsection
