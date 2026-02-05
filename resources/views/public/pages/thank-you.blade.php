@extends('public.layouts.app')

@section('content')
    <section class="section section-light">
        <div class="container narrow">
            <h1>Thank you!</h1>
            <p>Your enquiry has been sent. We will get back to you shortly.</p>
            @if(session('whatsapp_link'))
                <p><a class="btn btn-primary js-track-cta" data-event="click_whatsapp" href="{{ session('whatsapp_link') }}" target="_blank" rel="noopener">Message us on WhatsApp</a></p>
            @endif
            <a class="btn btn-outline" href="{{ route('home') }}">Back to Home</a>
        </div>
    </section>
@endsection
