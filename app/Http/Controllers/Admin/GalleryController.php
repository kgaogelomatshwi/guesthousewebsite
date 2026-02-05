<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $categories = GalleryCategory::with('images')->orderBy('name')->get();

        return view('admin.gallery.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120'],
        ]);

        GalleryCategory::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Category created.');
    }

    public function edit(GalleryCategory $gallery): View
    {
        $gallery->load('images');

        return view('admin.gallery.edit', ['category' => $gallery]);
    }

    public function update(Request $request, GalleryCategory $gallery): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120'],
        ]);

        $gallery->update($data);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(GalleryCategory $gallery): RedirectResponse
    {
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Category deleted.');
    }

    public function storeImage(Request $request, GalleryCategory $gallery): RedirectResponse
    {
        $data = $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'max:5120'],
        ]);

        $position = $gallery->images()->max('position') ?? 0;
        foreach ($data['images'] as $image) {
            $path = $image->store('gallery', 'public');
            GalleryImage::create([
                'category_id' => $gallery->id,
                'path' => $path,
                'position' => ++$position,
            ]);
        }

        return back()->with('success', 'Images uploaded.');
    }

    public function destroyImage(GalleryImage $image): RedirectResponse
    {
        $image->delete();

        return back()->with('success', 'Image removed.');
    }
}
