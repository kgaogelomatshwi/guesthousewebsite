<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Room;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $key): View
    {
        $page = Page::query()
            ->where('key', $key)
            ->where('is_active', true)
            ->with(['sections' => fn ($query) => $query->where('is_active', true)->orderBy('position')])
            ->firstOrFail();

        $rooms = null;
        if ($key === 'contact') {
            $rooms = Room::query()->where('status', 'active')->orderBy('title')->get();
        }

        return view('public.pages.show', compact('page', 'rooms'));
    }
}
