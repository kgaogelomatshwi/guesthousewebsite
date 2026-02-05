<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\Page;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $categories = GalleryCategory::query()
            ->with(['images' => fn ($query) => $query->orderBy('position')])
            ->orderBy('name')
            ->get();

        $page = Page::query()
            ->where('key', 'gallery')
            ->where('is_active', true)
            ->with(['sections' => fn ($query) => $query->where('is_active', true)->orderBy('position')])
            ->first();

        return view('public.gallery.index', compact('categories', 'page'));
    }
}
