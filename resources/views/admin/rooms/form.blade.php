@php
    $room = $room ?? new \App\Models\Room();
@endphp
<div class="grid-2">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="title" value="{{ old('title', $room->title) }}" required>
    </div>
    <div class="form-row">
        <label>Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $room->slug) }}" required>
    </div>
</div>
<div class="form-row">
    <label>Status</label>
    <input type="text" name="status" value="{{ old('status', $room->status ?? 'active') }}">
</div>
<div class="form-row">
    <label>Short Description</label>
    <textarea name="short_description" rows="2">{{ old('short_description', $room->short_description) }}</textarea>
</div>
<div class="form-row">
    <label>Description</label>
    <textarea name="description" rows="5">{{ old('description', $room->description) }}</textarea>
</div>
<div class="grid-3">
    <div class="form-row">
        <label>Base Price</label>
        <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $room->base_price) }}">
    </div>
    <div class="form-row">
        <label>Currency</label>
        <input type="text" name="currency" value="{{ old('currency', $room->currency ?? 'ZAR') }}">
    </div>
    <div class="form-row">
        <label>Max Guests</label>
        <input type="number" name="max_guests" value="{{ old('max_guests', $room->max_guests ?? 2) }}">
    </div>
</div>
<div class="grid-2">
    <div class="form-row">
        <label>Bed Type</label>
        <input type="text" name="bed_type" value="{{ old('bed_type', $room->bed_type) }}">
    </div>
    <div class="form-row">
        <label>Featured</label>
        <select name="featured">
            <option value="1" @selected(old('featured', $room->featured))>Yes</option>
            <option value="0" @selected(!old('featured', $room->featured))>No</option>
        </select>
    </div>
</div>
<div class="grid-2">
    <div class="form-row">
        <label>SEO Title</label>
        <input type="text" name="seo_title" value="{{ old('seo_title', $room->seo_title) }}">
    </div>
    <div class="form-row">
        <label>SEO Description</label>
        <textarea name="seo_description" rows="2">{{ old('seo_description', $room->seo_description) }}</textarea>
    </div>
</div>

<div class="form-row">
    <label>Amenities</label>
    <div class="checkbox-grid">
        @foreach($amenities as $amenity)
            <label class="checkbox">
                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" @checked($room->amenities?->contains($amenity->id))>
                {{ $amenity->name }}
            </label>
        @endforeach
    </div>
</div>

<div class="form-row">
    <label>Room Images</label>
    <input type="file" name="images[]" multiple>
</div>
@if(!empty($media))
    <div class="form-row">
        <label>Add Existing Images from Media Library</label>
        <select id="room-existing-images" name="existing_images[]" multiple size="6">
            @foreach($media as $item)
                <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline js-media-open" type="button" data-media-target="room-existing-images" data-media-type="image">Pick from Media Library</button>
        <small>Hold Ctrl/Cmd to select multiple images.</small>
    </div>
@endif

@if($room->images && $room->images->count())
    <div class="grid-4">
        @foreach($room->images as $image)
            <img class="gallery-img" src="{{ asset('storage/' . $image->path) }}" alt="">
        @endforeach
    </div>
@endif
