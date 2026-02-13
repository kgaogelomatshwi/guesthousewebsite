<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Services\Media\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttractionController extends Controller
{
    public function index(): View
    {
        $attractions = Attraction::orderBy('position')->get();

        return view('admin.attractions.index', compact('attractions'));
    }

    public function create(): View
    {
        return view('admin.attractions.create', [
            'media' => \App\Models\Media::query()
                ->where('mime_type', 'like', 'image/%')
                ->orderByDesc('created_at')
                ->take(200)
                ->get(),
        ]);
    }

    public function store(Request $request, MediaService $mediaService): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150'],
            'image_path' => ['nullable', 'file', 'mimetypes:image/*', 'max:4096'],
            'image_path_existing' => ['nullable', 'string', 'max:255'],
            'distance_km' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'position' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $mediaService->store($request->file('image_path'), 'attractions');
        } elseif (!empty($data['image_path_existing'])) {
            $data['image_path'] = $data['image_path_existing'];
        }

        unset($data['image_path_existing']);

        Attraction::create($data);

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction created.');
    }

    public function edit(Attraction $attraction): View
    {
        return view('admin.attractions.edit', [
            'attraction' => $attraction,
            'media' => \App\Models\Media::query()
                ->where('mime_type', 'like', 'image/%')
                ->orderByDesc('created_at')
                ->take(200)
                ->get(),
        ]);
    }

    public function update(Request $request, Attraction $attraction, MediaService $mediaService): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150'],
            'image_path' => ['nullable', 'file', 'mimetypes:image/*', 'max:4096'],
            'image_path_existing' => ['nullable', 'string', 'max:255'],
            'distance_km' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'position' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $mediaService->store($request->file('image_path'), 'attractions');
        } elseif (!empty($data['image_path_existing'])) {
            $data['image_path'] = $data['image_path_existing'];
        }

        unset($data['image_path_existing']);

        $attraction->update($data);

        return back()->with('success', 'Attraction updated.');
    }

    public function destroy(Attraction $attraction): RedirectResponse
    {
        $attraction->delete();

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction removed.');
    }
}
