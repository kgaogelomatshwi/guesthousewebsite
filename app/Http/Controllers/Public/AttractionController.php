<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Page;
use Illuminate\View\View;

class AttractionController extends Controller
{
    public function index(): View
    {
        $attractions = Attraction::query()
            ->where('is_active', true)
            ->orderBy('position')
            ->get();

        $page = Page::query()
            ->where('key', 'attractions')
            ->where('is_active', true)
            ->with(['sections' => fn ($query) => $query->where('is_active', true)->orderBy('position')])
            ->first();

        return view('public.attractions.index', compact('attractions', 'page'));
    }

    public function show(string $slug): View
    {
        $attraction = Attraction::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $page = (object) [
            'title' => $attraction->title,
            'seo_title' => $attraction->title,
            'seo_description' => $attraction->description,
        ];

        return view('public.attractions.show', compact('attraction', 'page'));
    }
}
