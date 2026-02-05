<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>weekly</changefreq>
    </url>
    @foreach(\App\Models\Page::where('is_active', true)->where('key', '!=', 'home')->get() as $page)
        <url>
            <loc>{{ url('/' . $page->slug) }}</loc>
            <changefreq>monthly</changefreq>
        </url>
    @endforeach
    @foreach(\App\Models\Room::where('status', 'active')->get() as $room)
        <url>
            <loc>{{ url('/rooms/' . $room->slug) }}</loc>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
    @foreach(\App\Models\BlogPost::where('is_published', true)->get() as $post)
        <url>
            <loc>{{ url('/blog/' . $post->slug) }}</loc>
            <changefreq>monthly</changefreq>
        </url>
    @endforeach
</urlset>
