<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ $siteSettings['site_name'] ?? 'Guesthouse' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-100">
    <div class="grid min-h-screen" style="grid-template-columns: 240px 1fr;">
        <aside class="bg-black text-white p-6">
            <h2 class="text-lg font-semibold">Admin</h2>
            <nav class="grid gap-2 mt-5">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.settings.edit') }}">Settings</a>
                <a href="{{ route('admin.pages.index') }}">Pages</a>
                <a href="{{ route('admin.rooms.index') }}">Rooms</a>
                <a href="{{ route('admin.amenities.index') }}">Amenities</a>
                <a href="{{ route('admin.rates.index') }}">Rates</a>
                <a href="{{ route('admin.gallery.index') }}">Gallery</a>
                <a href="{{ route('admin.media.index') }}">Media Library</a>
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
        <div class="p-6">
            <header class="flex items-center justify-between mb-5">
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
                        <ul class="list-disc pl-5">
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

    <div id="media-picker-modal" class="fixed inset-0 hidden z-[200]">
        <div class="absolute inset-0 bg-black/60" data-media-close></div>
        <div class="relative mx-auto my-8 w-[min(1100px,92%)] bg-white rounded-2xl shadow-2xl p-6 max-h-[85vh] overflow-hidden flex flex-col">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold">Media Library</h3>
                    <p class="text-sm text-neutral-500">Pick a file to insert into your field.</p>
                </div>
                <button class="btn btn-ghost" type="button" data-media-close>Close</button>
            </div>
            <div class="grid gap-3 mt-4 md:grid-cols-3">
                <div class="md:col-span-2 flex flex-wrap gap-2 items-center">
                    <button class="btn btn-outline" type="button" data-media-filter="all">All</button>
                    <button class="btn btn-outline" type="button" data-media-filter="image">Images</button>
                    <button class="btn btn-outline" type="button" data-media-filter="video">Video</button>
                    <button class="btn btn-outline" type="button" data-media-filter="audio">Audio</button>
                    <button class="btn btn-outline" type="button" data-media-filter="pdf">PDF</button>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-sm text-neutral-600">Insert</label>
                    <label class="text-sm"><input type="radio" name="media-insert-mode" value="path" checked> Path</label>
                    <label class="text-sm"><input type="radio" name="media-insert-mode" value="url"> URL</label>
                </div>
            </div>
            <div class="mt-3">
                <input id="media-picker-search" class="w-full" type="text" placeholder="Search media...">
            </div>
            <div class="mt-4 overflow-auto">
                <div id="media-picker-grid" class="media-grid"></div>
            </div>
        </div>
    </div>
</body>
</html>
