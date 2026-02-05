@extends('public.layouts.app')

@section('content')
    <div class="page-wrapper">
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach

        @if($page->key === 'rates')
            <section class="section section-light">
                <div class="container">
                    <h2>{{ $page->title }}</h2>
                    @php($currency = $siteSettings['currency'] ?? 'ZAR')
                    <div class="grid-3">
                        @foreach(\App\Models\Rate::where('is_active', true)->orderByDesc('season_start')->get() as $rate)
                            <x-card>
                                <div class="card-body">
                                    <h3>{{ $rate->title }}</h3>
                                    <p>{{ $rate->description }}</p>
                                    @if($rate->price)
                                        <p class="price">{{ $currency }} {{ number_format($rate->price, 2) }}</p>
                                    @endif
                                    @if($rate->season_start)
                                        <p>{{ $rate->season_start }} - {{ $rate->season_end }}</p>
                                    @endif
                                    @if($rate->notes)
                                        <p>{{ $rate->notes }}</p>
                                    @endif
                                </div>
                            </x-card>
                        @endforeach
                    </div>
                    @if(!empty($siteSettings['cancellation_policy_text']))
                        <div class="section-divider"></div>
                        <p>{{ $siteSettings['cancellation_policy_text'] }}</p>
                    @endif
                </div>
            </section>
        @endif

        @if($page->key === 'contact')
            <section class="section section-light">
                <div class="container grid-2">
                    <div>
                        <h2>{{ $page->title }}</h2>
                        @if($page->seo_description)
                            <p>{{ $page->seo_description }}</p>
                        @endif
                        <div class="contact-card">
                            <p><strong>Phone:</strong> {{ $siteSettings['phone'] ?? '' }}</p>
                            <p><strong>Email:</strong> {{ $siteSettings['email'] ?? '' }}</p>
                            <p><strong>Address:</strong> {{ $siteSettings['address'] ?? '' }}</p>
                            @if(!empty($siteSettings['whatsapp']))
                                <p><a class="btn btn-outline js-track-cta" data-event="click_whatsapp" href="https://wa.me/{{ $siteSettings['whatsapp'] }}" target="_blank" rel="noopener">WhatsApp Us</a></p>
                            @endif
                        </div>
                    </div>
                    <div>
                        @include('public.partials.enquiry-form', ['source' => 'contact'])
                    </div>
                </div>
            </section>
        @endif

        @if($page->key === 'booking')
            <section class="section section-light">
                <div class="container">
                    <h2>{{ $page->title }}</h2>
                    @include('public.partials.booking-options', ['rooms' => $rooms ?? []])
                </div>
            </section>
        @endif
    </div>
@endsection
