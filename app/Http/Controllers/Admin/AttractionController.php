<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
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
        return view('admin.attractions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150'],
            'image_path' => ['nullable', 'image', 'max:4096'],
            'distance_km' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'position' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('attractions', 'public');
        }

        Attraction::create($data);

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction created.');
    }

    public function edit(Attraction $attraction): View
    {
        return view('admin.attractions.edit', compact('attraction'));
    }

    public function update(Request $request, Attraction $attraction): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150'],
            'image_path' => ['nullable', 'image', 'max:4096'],
            'distance_km' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
            'position' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('attractions', 'public');
        }

        $attraction->update($data);

        return back()->with('success', 'Attraction updated.');
    }

    public function destroy(Attraction $attraction): RedirectResponse
    {
        $attraction->delete();

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction removed.');
    }
}
