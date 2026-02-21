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
        $siteName = $siteSettings['site_name'] ?? 'Rural Villa Guesthouse';
        $siteTagline = $siteSettings['site_tagline'] ?? 'High quality accommodation services';
        $siteIntro = $siteSettings['site_intro'] ?? 'A tranquil countryside guesthouse in Limpopo, close to Blouberg and perfect for value-for-money stays.';
        $contactPhone = $siteSettings['phone'] ?? '+27 61 050 5057';
        $contactEmail = $siteSettings['email'] ?? 'info@ruralvillaguesthouse.co.za';
        $contactAddress = $siteSettings['address'] ?? 'A0038 GA - Broekman, Westphalia Village, Capricorn District Municipality, Limpopo, South Africa';
        $socialLinks = is_array($siteSettings['social_links'] ?? null) ? $siteSettings['social_links'] : [];
        $whatsappRaw = preg_replace('/\D+/', '', (string) ($siteSettings['whatsapp'] ?? ''));
        $whatsappLink = $whatsappRaw ? "https://wa.me/{$whatsappRaw}" : null;
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
<body class="rv-theme" @if(!empty($bodyEvent)) data-track-event="{{ $bodyEvent }}" @endif>
    @if(!empty($siteSettings['gtm_container_id']))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $siteSettings['gtm_container_id'] }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <div class="site-topbar">
        <div class="container site-topbar-inner">
            <p class="site-topline">Tranquil countryside escape in Limpopo</p>
            <div class="site-topbar-right">
                <div class="site-topbar-actions">
                    @if($contactPhone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}">{{ $contactPhone }}</a>
                    @endif
                    @if($contactEmail)
                        <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                    @endif
                </div>
                @auth
                    <div class="site-topbar-auth">
                        <a href="{{ route('guest.dashboard') }}">My Bookings</a>
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="button-link">Logout</button>
                        </form>
                    </div>
                @else
                    @if($bookingMode !== 'OTA_REDIRECT')
                        <div class="site-topbar-auth">
                            <a href="{{ route('login') }}">Sign In</a>
                            <a href="{{ route('register') }}">Create Account</a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <header class="site-header">
        <div class="container header-inner">
            <a class="logo" href="{{ route('home') }}">
                @if($logo)
                    <img class="logo-image" src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }}">
                @else
                    <span class="logo-mark">{{ strtoupper(substr($siteName, 0, 1)) }}</span>
                @endif
                <span class="logo-text">
                    <span class="logo-title">{{ $siteName }}</span>
                    <span class="logo-subtitle">{{ $siteTagline }}</span>
                </span>
            </a>
            <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
                <span class="block w-5 h-0.5 bg-black"></span>
                <span class="block w-5 h-0.5 bg-black"></span>
                <span class="block w-5 h-0.5 bg-black"></span>
            </button>
            <nav class="nav" id="site-nav">
                <a href="{{ route('rooms.index') }}">Rooms</a>
                <a href="{{ route('pages.services') }}">Services</a>
                <a href="{{ route('pages.contact') }}">Contact Us</a>
                @auth
                    <a href="{{ route('guest.dashboard') }}">My Bookings</a>
                @endauth
            </nav>
            <div class="nav-cta">
                @include('public.partials.booking-cta', ['variant' => 'header'])
            </div>
        </div>
    </header>

    <main class="rv-main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-brand">
                <h4>{{ $siteName }}</h4>
                <p>{{ $siteIntro }}</p>
                <div class="footer-actions">
                    <a class="btn btn-primary" href="{{ $primaryBookingUrl }}" @if($bookingMode === 'OTA_REDIRECT') target="_blank" rel="noopener" @endif>Book Online</a>
                    @if($whatsappLink)
                        <a class="btn btn-outline footer-outline" href="{{ $whatsappLink }}" target="_blank" rel="noopener">WhatsApp</a>
                    @endif
                </div>
            </div>
            <div class="footer-column">
                <h5>Useful Links</h5>
                <a href="{{ route('pages.about') }}">About Us</a>
                <a href="{{ route('attractions.index') }}">Location</a>
                <a href="{{ route('pages.contact') }}">Contact Us</a>
                @auth
                    <a href="{{ route('guest.dashboard') }}">My Bookings</a>
                @else
                    @if($bookingMode !== 'OTA_REDIRECT')
                        <a href="{{ route('login') }}">Sign In</a>
                    @endif
                @endauth
            </div>
            <div class="footer-column">
                <h5>Explore</h5>
                <a href="{{ route('rooms.index') }}">Rooms</a>
                <a href="{{ route('pages.services') }}">Services</a>
                <a href="{{ route('gallery.index') }}">Gallery</a>
                <a href="{{ route('pages.policies') }}">Policies</a>
            </div>
            <div class="footer-column">
                <h5>Contact Us</h5>
                <p>{{ $contactAddress }}</p>
                @if($contactPhone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}">{{ $contactPhone }}</a>
                @endif
                @if($contactEmail)
                    <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                @endif
                @foreach($socialLinks as $socialUrl)
                    <a href="{{ $socialUrl }}" target="_blank" rel="noopener">{{ parse_url($socialUrl, PHP_URL_HOST) ?: $socialUrl }}</a>
                @endforeach
            </div>
        </div>
        <div class="container footer-bottom">
            <p>© {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="{{ route('pages.policies') }}">Policies</a>
                <a href="{{ route('sitemap') }}">Sitemap</a>
            </div>
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
