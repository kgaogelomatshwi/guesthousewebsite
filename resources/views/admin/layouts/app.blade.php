<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ $siteSettings['site_name'] ?? 'Guesthouse' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <h2>Admin</h2>
            <nav>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.settings.edit') }}">Settings</a>
                <a href="{{ route('admin.pages.index') }}">Pages</a>
                <a href="{{ route('admin.rooms.index') }}">Rooms</a>
                <a href="{{ route('admin.amenities.index') }}">Amenities</a>
                <a href="{{ route('admin.rates.index') }}">Rates</a>
                <a href="{{ route('admin.gallery.index') }}">Gallery</a>
                <a href="{{ route('admin.attractions.index') }}">Attractions</a>
                <a href="{{ route('admin.testimonials.index') }}">Testimonials</a>
                <a href="{{ route('admin.enquiries.index') }}">Enquiries</a>
                <a href="{{ route('admin.external-bookings.index') }}">OTA Bookings</a>
                <a href="{{ route('admin.bookings.index') }}">Bookings</a>
                <a href="{{ route('admin.booking-blocks.index') }}">Blocked Dates</a>
                <a href="{{ route('admin.blog.index') }}">Blog</a>
                <a href="{{ route('admin.blog-categories.index') }}">Blog Categories</a>
                @if(auth()->user()?->isAdmin())
                    <a href="{{ route('admin.users.index') }}">Users</a>
                @endif
            </nav>
        </aside>
        <div class="admin-content">
            <header class="admin-topbar">
                <div>
                    <strong>{{ $siteSettings['site_name'] ?? 'Guesthouse' }}</strong>
                </div>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-ghost" type="submit">Logout</button>
                </form>
            </header>

            <main>
                @if(session('success'))
                    <x-alert type="success">{{ session('success') }}</x-alert>
                @endif
                @if($errors->any())
                    <x-alert type="error">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
