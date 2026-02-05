<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $bookingMode = $siteSettings['booking_mode'] ?? 'DIRECT_BOOKING';
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
    @stack('head')
</head>
<body @if(!empty($bodyEvent)) data-track-event="{{ $bodyEvent }}" @endif>
    @if(!empty($siteSettings['gtm_container_id']))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $siteSettings['gtm_container_id'] }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <header class="site-header">
        <div class="container header-inner">
            <a class="logo" href="{{ route('home') }}">
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteSettings['site_name'] ?? 'Guesthouse' }}">
                @else
                    <span>{{ $siteSettings['site_name'] ?? 'Guesthouse' }}</span>
                @endif
            </a>
            <nav class="nav">
                <a href="{{ route('rooms.index') }}">Rooms</a>
                <a href="{{ route('pages.about') }}">About</a>
                <a href="{{ route('pages.rates') }}">Rates</a>
                <a href="{{ route('gallery.index') }}">Gallery</a>
                <a href="{{ route('attractions.index') }}">Things To Do</a>
                <a href="{{ route('pages.contact') }}">Contact</a>
                <a href="{{ route('blog.index') }}">Blog</a>
            </nav>
            <div class="nav-cta">
                @include('public.partials.booking-cta', ['variant' => 'header'])
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
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
                <a href="{{ route('pages.rates') }}">Rates</a>
                <a href="{{ route('pages.policies') }}">Policies</a>
                <a href="{{ route('booking.create') }}">Book Now</a>
            </div>
        </div>
        <div class="container footer-bottom">
            <p>(c) {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Guesthouse' }}. All rights reserved.</p>
        </div>
    </footer>

    @include('public.partials.whatsapp-button')
    @include('public.partials.schema')
</body>
</html>
