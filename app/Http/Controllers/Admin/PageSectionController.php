<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageSectionRequest;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageSectionController extends Controller
{
    public function create(Page $page): View
    {
        return view('admin.page-sections.create', compact('page'));
    }

    public function store(StorePageSectionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        PageSection::create([
            'page_id' => $data['page_id'],
            'type' => $data['type'],
            'content_json' => json_encode($data['content'] ?? []),
            'position' => $data['position'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.pages.edit', $data['page_id'])
            ->with('success', 'Section created.');
    }

    public function edit(Page $page, PageSection $section): View
    {
        return view('admin.page-sections.edit', compact('page', 'section'));
    }

    public function update(StorePageSectionRequest $request, Page $page, PageSection $section): RedirectResponse
    {
        $data = $request->validated();

        $section->update([
            'type' => $data['type'],
            'content_json' => json_encode($data['content'] ?? []),
            'position' => $data['position'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', 'Section updated.');
    }

    public function destroy(Page $page, PageSection $section): RedirectResponse
    {
        $section->delete();

        return back()->with('success', 'Section removed.');
    }

    public function reorder(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'positions' => ['required', 'array'],
            'positions.*' => ['integer'],
        ]);

        foreach ($data['positions'] as $sectionId => $position) {
            PageSection::where('id', $sectionId)
                ->where('page_id', $page->id)
                ->update(['position' => $position]);
        }

        return back()->with('success', 'Sections reordered.');
    }
}
