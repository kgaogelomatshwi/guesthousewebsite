@php($bodyEvent = 'payment_success')
@extends('public.layouts.app')

@section('content')
    <section class="py-16 bg-white">
        <div class="container max-w-2xl mx-auto space-y-4">
            <h1 class="text-3xl font-semibold">Booking received</h1>
            <p class="text-neutral-600">Your booking request has been recorded. We will send payment confirmation shortly.</p>
            @if(session('booking_code'))
                <p><strong>Booking code:</strong> {{ session('booking_code') }}</p>
            @endif
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ route('home') }}">Back to Home</a>
        </div>
    </section>
@endsection
