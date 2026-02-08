@extends('public.layouts.app')

@section('content')
    <div class="page-wrapper">
        @foreach($page->sections as $section)
            @includeIf('public.sections.' . $section->type, ['data' => $section->content_array, 'section' => $section])
        @endforeach

        @if($page->key === 'rates')
            <section class="py-16 bg-white">
                <div class="container">
                    <h2 class="text-2xl font-semibold">{{ $page->title }}</h2>
                    @php($currency = $siteSettings['currency'] ?? 'ZAR')
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach(\App\Models\Rate::where('is_active', true)->orderByDesc('season_start')->get() as $rate)
                            <x-card>
                                <div class="p-5 space-y-2">
                                    <h3 class="text-lg font-semibold">{{ $rate->title }}</h3>
                                    <p class="text-neutral-600">{{ $rate->description }}</p>
                                    @if($rate->price)
                                        <p class="font-semibold text-black">{{ $currency }} {{ number_format($rate->price, 2) }}</p>
                                    @endif
                                    @if($rate->season_start)
                                        <p class="text-sm text-neutral-600">{{ $rate->season_start }} - {{ $rate->season_end }}</p>
                                    @endif
                                    @if($rate->notes)
                                        <p class="text-sm text-neutral-600">{{ $rate->notes }}</p>
                                    @endif
                                </div>
                            </x-card>
                        @endforeach
                    </div>
                    @if(!empty($siteSettings['cancellation_policy_text']))
                        <div class="h-px bg-black/10 my-7"></div>
                        <p class="text-neutral-600">{{ $siteSettings['cancellation_policy_text'] }}</p>
                    @endif
                </div>
            </section>
        @endif

        @if($page->key === 'contact')
            <section class="py-16 bg-white">
                <div class="container grid gap-6 md:grid-cols-2">
                    <div>
                        <h2 class="text-2xl font-semibold">{{ $page->title }}</h2>
                        @if($page->seo_description)
                            <p class="text-neutral-600">{{ $page->seo_description }}</p>
                        @endif
                        <div class="bg-white p-4 rounded-xl shadow-lg">
                            <p><strong>Phone:</strong> {{ $siteSettings['phone'] ?? '' }}</p>
                            <p><strong>Email:</strong> {{ $siteSettings['email'] ?? '' }}</p>
                            <p><strong>Address:</strong> {{ $siteSettings['address'] ?? '' }}</p>
                            @if(!empty($siteSettings['whatsapp']))
                                <p><a class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-black text-black bg-transparent transition js-track-cta" data-event="click_whatsapp" href="https://wa.me/{{ $siteSettings['whatsapp'] }}" target="_blank" rel="noopener">WhatsApp Us</a></p>
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
            <section class="py-16 bg-white">
                <div class="container">
                    <h2 class="text-2xl font-semibold">{{ $page->title }}</h2>
                    @include('public.partials.booking-options', ['rooms' => $rooms ?? []])
                </div>
            </section>
        @endif
    </div>
@endsection
