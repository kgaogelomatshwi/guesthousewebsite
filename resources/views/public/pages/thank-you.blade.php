@extends('public.layouts.app')

@section('content')
    <section class="py-16 bg-white">
        <div class="container max-w-2xl mx-auto space-y-4">
            <h1 class="text-3xl font-semibold">Thank you!</h1>
            <p class="text-neutral-600">Your enquiry has been sent. We will get back to you shortly.</p>
            @if(session('whatsapp_link'))
                <p><a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg js-track-cta" data-event="click_whatsapp" href="{{ session('whatsapp_link') }}" target="_blank" rel="noopener">Message us on WhatsApp</a></p>
            @endif
            <a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ route('home') }}">Back to Home</a>
        </div>
    </section>
@endsection
