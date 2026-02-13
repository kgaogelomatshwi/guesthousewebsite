<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $bookingMode = $siteSettings['booking_mode'] ?? 'DIRECT_BOOKING';
        $otaMode = $siteSettings['ota_mode'] ?? 'both';
        $bookingCom = $siteSettings['bookingcom_url'] ?? null;
        $airbnb = $siteSettings['airbnb_url'] ?? null;
        if ($otaMode === 'bookingcom') {
            $airbnb = null;
        } elseif ($otaMode === 'airbnb') {
            $bookingCom = null;
        }
        $defaultOtaUrl = $bookingCom ?: $airbnb;
        $primaryBookingUrl = ($bookingMode === 'OTA_REDIRECT' && $defaultOtaUrl) ? $defaultOtaUrl : route('booking.create');

        $page = $page ?? null;
        $seoTitle = $page?->seo_title ?? ($siteSettings['default_seo_title'] ?? ($page?->title ?? ($siteSettings['site_name'] ?? 'Guesthouse')));
        $seoDescription = $page?->seo_description ?? ($siteSettings['default_seo_description'] ?? null);
        $logo = $siteSettings['logo'] ?? null;
        $favicon = $siteSettings['favicon'] ?? null;
    @endphp

    <title>{{ $seoTitle }}</title>
    @if($seoDescription)
        <meta name="description" content="{{ $seoDescription }}">
    @endif

    @if($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @endif

    @if(!empty($siteSettings['google_site_verification_meta']))
        <meta name="google-site-verification" content="{{ $siteSettings['google_site_verification_meta'] }}">
    @endif

    <meta property="og:title" content="{{ $seoTitle }}">
    @if($seoDescription)
        <meta property="og:description" content="{{ $seoDescription }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    @if(!empty($siteSettings['ga4_measurement_id']))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['ga4_measurement_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $siteSettings['ga4_measurement_id'] }}');
        </script>
    @endif

    @if(!empty($siteSettings['gtm_container_id']))
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $siteSettings['gtm_container_id'] }}');
        </script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(!empty($siteSettings['custom_css']))
        <style>
            {!! $siteSettings['custom_css'] !!}
        </style>
    @endif
    @if(!empty($page?->custom_css))
        <style>
            {!! $page->custom_css !!}
        </style>
    @endif
    @stack('head')
</head>
<body @if(!empty($bodyEvent)) data-track-event="{{ $bodyEvent }}" @endif>
    @if(!empty($siteSettings['gtm_container_id']))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $siteSettings['gtm_container_id'] }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <div class="bg-neutral-100 text-sm">
        <div class="container flex items-center justify-end gap-4 py-2">
            @auth
                <a href="{{ route('guest.dashboard') }}">My Bookings</a>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                @if($bookingMode !== 'OTA_REDIRECT')
                    <a href="{{ route('login') }}">Sign In</a>
                    <a href="{{ route('register') }}">Create Account</a>
                @endif
            @endauth
        </div>
    </div>

    <header class="sticky top-0 z-50 bg-white border-b border-black/10">
        <div class="container flex items-center justify-between gap-6 py-4">
            <a class="text-sm font-bold tracking-widest uppercase" href="{{ route('home') }}">
                @if($logo)
                    <img class="h-10 md:h-12 w-auto max-w-[180px] object-contain" src="{{ asset('storage/' . $logo) }}" alt="{{ $siteSettings['site_name'] ?? 'Guesthouse' }}">
                @else
                    <span>{{ $siteSettings['site_name'] ?? 'Guesthouse' }}</span>
                @endif
            </a>
            <button class="nav-toggle flex flex-col gap-1.5 border border-black/20 bg-white px-3 py-2 rounded-lg cursor-pointer md:hidden" type="button" aria-expanded="false" aria-controls="site-nav">
                <span class="block w-5 h-0.5 bg-black"></span>
                <span class="block w-5 h-0.5 bg-black"></span>
                <span class="block w-5 h-0.5 bg-black"></span>
            </button>
            <nav class="flex flex-col md:flex-row flex-wrap gap-5 font-semibold uppercase text-sm tracking-wider max-h-0 overflow-hidden md:max-h-none md:overflow-visible transition-all md:py-0 py-0 w-full md:w-auto" id="site-nav">
                <a href="{{ route('rooms.index') }}">Rooms</a>
                <a href="{{ route('pages.services') }}">Services</a>
                <a href="{{ route('pages.contact') }}">Contact Us</a>
                @auth
                    <a href="{{ route('guest.dashboard') }}">My Bookings</a>
                @endauth
            </nav>
            <div class="flex gap-3">
                @include('public.partials.booking-cta', ['variant' => 'header'])
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-black text-white py-14">
        <div class="container grid gap-6" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
            <div>
                <h4>{{ $siteSettings['site_name'] ?? 'Guesthouse' }}</h4>
                <p>{{ $siteSettings['address'] ?? 'Address goes here' }}</p>
            </div>
            <div>
                <h5>Contact</h5>
                <p>{{ $siteSettings['phone'] ?? '' }}</p>
                <p>{{ $siteSettings['email'] ?? '' }}</p>
            </div>
            <div>
                <h5>Explore</h5>
                <a href="{{ route('rooms.index') }}">Rooms</a>
                <a href="{{ route('pages.services') }}">Services</a>
                <a href="{{ route('pages.policies') }}">Policies</a>
                <a href="{{ $primaryBookingUrl }}" @if($bookingMode === 'OTA_REDIRECT') target="_blank" rel="noopener" @endif>Book Now</a>
                @auth
                    <a href="{{ route('guest.dashboard') }}">My Bookings</a>
                @else
                    @if($bookingMode !== 'OTA_REDIRECT')
                        <a href="{{ route('login') }}">Sign In</a>
                        <a href="{{ route('register') }}">Create Account</a>
                    @endif
                @endauth
            </div>
        </div>
        <div class="container mt-8 border-t border-white/20 pt-4 text-sm">
            <p>(c) {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Guesthouse' }}. All rights reserved.</p>
        </div>
    </footer>

    <a href="{{ $primaryBookingUrl }}" class="fixed bottom-4 right-4 md:hidden inline-flex items-center justify-center gap-2 rounded-full px-5 py-3 font-semibold border border-transparent transition bg-black text-white shadow-lg z-[100]" @if($bookingMode === 'OTA_REDIRECT') target="_blank" rel="noopener" @endif>BOOK ONLINE</a>

    @include('public.partials.whatsapp-button')
    @include('public.partials.schema')
    @if(!empty($siteSettings['custom_js']))
        <script>
            {!! $siteSettings['custom_js'] !!}
        </script>
    @endif
    @if(!empty($page?->custom_js))
        <script>
            {!! $page->custom_js !!}
        </script>
    @endif
</body>
</html>
