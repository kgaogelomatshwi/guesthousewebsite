@extends('admin.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold">Edit Page: {{ $page->title }}</h1>

    <form class="grid gap-4 mt-4" method="post" action="{{ route('admin.pages.update', $page) }}">
        @csrf
        @method('PUT')
        <div class="grid gap-4 md:grid-cols-2">
            <div class="grid gap-2">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $page->title) }}" required>
            </div>
            <div class="grid gap-2">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="grid gap-2">
                <label>SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title', $page->seo_title) }}">
            </div>
            <div class="grid gap-2">
                <label>SEO Description</label>
                <textarea name="seo_description" rows="2">{{ old('seo_description', $page->seo_description) }}</textarea>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="grid gap-2">
                <label>Custom HTML</label>
                <textarea name="custom_html" rows="6">{{ old('custom_html', $page->custom_html) }}</textarea>
            </div>
            <div class="grid gap-2">
                <label>Custom CSS</label>
                <textarea name="custom_css" rows="6">{{ old('custom_css', $page->custom_css) }}</textarea>
            </div>
        </div>
        <div class="grid gap-2">
            <label>Custom JS</label>
            <textarea name="custom_js" rows="6">{{ old('custom_js', $page->custom_js) }}</textarea>
        </div>
        <div class="grid gap-2">
            <label>Active</label>
            <select name="is_active">
                <option value="1" @selected($page->is_active)>Yes</option>
                <option value="0" @selected(! $page->is_active)>No</option>
            </select>
        </div>
        <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg" type="submit">Save Page</button>
    </form>

    <div class="h-px bg-black/10 my-7"></div>

    <div class="flex items-center justify-between gap-4">
        <h2 class="text-xl font-semibold">Sections</h2>
        <a class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ route('admin.pages.sections.create', $page) }}">Add Section</a>
    </div>

    <ul class="sortable-list js-sortable mt-4" data-input-prefix="positions">
        @foreach($page->sections as $section)
            <li class="sortable-item" draggable="true" data-section-id="{{ $section->id }}">
                <span class="drag-handle" title="Drag to reorder">::</span>
                <div class="sortable-meta">
                    <strong>{{ $section->type }}</strong>
                    <span class="text-black/60 text-sm">{{ $section->is_active ? 'Active' : 'Hidden' }}</span>
                </div>
                <div class="sortable-actions">
                    <a class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-black text-black bg-transparent transition" href="{{ route('admin.pages.sections.edit', [$page, $section]) }}">Edit</a>
                    <form method="post" action="{{ route('admin.pages.sections.destroy', [$page, $section]) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="inline-flex items-center justify-center gap-2 rounded-full px-4 py-2.5 font-semibold border border-transparent text-black bg-transparent transition" type="submit">Delete</button>
                    </form>
                </div>
                <input type="hidden" name="positions[{{ $section->id }}]" value="{{ $section->position }}" form="reorder-form">
            </li>
        @endforeach
    </ul>
    <form id="reorder-form" method="post" action="{{ route('admin.pages.sections.reorder', $page) }}">
        @csrf
        <button class="inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 font-semibold border border-transparent transition bg-black text-white shadow-lg mt-4" type="submit">Update Order</button>
    </form>
@endsection
