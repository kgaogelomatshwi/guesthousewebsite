<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Page;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(): View
    {
        $rooms = Room::query()
            ->where('status', 'active')
            ->with('images')
            ->orderByDesc('featured')
            ->orderBy('title')
            ->get();

        $page = Page::query()
            ->where('key', 'rooms')
            ->where('is_active', true)
            ->with(['sections' => fn ($query) => $query->where('is_active', true)->orderBy('position')])
            ->first();

        return view('public.rooms.index', compact('rooms', 'page'));
    }

    public function show(string $slug): View
    {
        $room = Room::query()
            ->where('slug', $slug)
            ->with(['images', 'amenities'])
            ->firstOrFail();

        $page = (object) [
            'title' => $room->title,
            'seo_title' => $room->seo_title ?? $room->title,
            'seo_description' => $room->seo_description ?? $room->short_description,
        ];

        return view('public.rooms.show', compact('room', 'page'));
    }
}
