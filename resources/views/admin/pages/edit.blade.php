@extends('admin.layouts.app')

@section('content')
    <h1>Edit Page: {{ $page->title }}</h1>

    <form class="form" method="post" action="{{ route('admin.pages.update', $page) }}">
        @csrf
        @method('PUT')
        <div class="grid-2">
            <div class="form-row">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title', $page->title) }}" required>
            </div>
            <div class="form-row">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required>
            </div>
        </div>
        <div class="grid-2">
            <div class="form-row">
                <label>SEO Title</label>
                <input type="text" name="seo_title" value="{{ old('seo_title', $page->seo_title) }}">
            </div>
            <div class="form-row">
                <label>SEO Description</label>
                <textarea name="seo_description" rows="2">{{ old('seo_description', $page->seo_description) }}</textarea>
            </div>
        </div>
        <div class="form-row">
            <label>Active</label>
            <select name="is_active">
                <option value="1" @selected($page->is_active)>Yes</option>
                <option value="0" @selected(! $page->is_active)>No</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Save Page</button>
    </form>

    <div class="section-divider"></div>

    <div class="flex-between">
        <h2>Sections</h2>
        <a class="btn btn-outline" href="{{ route('admin.pages.sections.create', $page) }}">Add Section</a>
    </div>

    <ul class="sortable-list js-sortable" data-input-prefix="positions">
        @foreach($page->sections as $section)
            <li class="sortable-item" draggable="true" data-section-id="{{ $section->id }}">
                <span class="drag-handle" title="Drag to reorder">::</span>
                <div class="sortable-meta">
                    <strong>{{ $section->type }}</strong>
                    <span class="muted">{{ $section->is_active ? 'Active' : 'Hidden' }}</span>
                </div>
                <div class="sortable-actions">
                    <a class="btn btn-outline" href="{{ route('admin.pages.sections.edit', [$page, $section]) }}">Edit</a>
                    <form method="post" action="{{ route('admin.pages.sections.destroy', [$page, $section]) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-ghost" type="submit">Delete</button>
                    </form>
                </div>
                <input type="hidden" name="positions[{{ $section->id }}]" value="{{ $section->position }}" form="reorder-form">
            </li>
        @endforeach
    </ul>
    <form id="reorder-form" method="post" action="{{ route('admin.pages.sections.reorder', $page) }}">
        @csrf
        <button class="btn btn-primary" type="submit">Update Order</button>
    </form>
@endsection
