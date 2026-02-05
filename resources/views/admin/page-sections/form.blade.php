@php
    $currentType = old('type', $section->type ?? 'hero');
    $content = old('content', $section->content_array ?? []);
@endphp

<div class="form-row">
    <label>Section Type</label>
    <select name="type" id="section-type">
        @foreach(['hero','text_block','image_block','feature_grid','amenities','featured_rooms','gallery_preview','testimonials_preview','cta','faq','map_embed'] as $type)
            <option value="{{ $type }}" @selected($currentType === $type)>{{ $type }}</option>
        @endforeach
    </select>
</div>

<div class="form-row">
    <label>Position</label>
    <input type="number" name="position" value="{{ old('position', $section->position ?? 0) }}">
</div>

<div class="form-row">
    <label>Active</label>
    <select name="is_active">
        <option value="1" @selected(old('is_active', $section->is_active ?? true))>Yes</option>
        <option value="0" @selected(!old('is_active', $section->is_active ?? true))>No</option>
    </select>
</div>

<div class="section-fields" data-type="hero">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Subtitle</label>
        <textarea name="content[subtitle]" rows="2">{{ $content['subtitle'] ?? '' }}</textarea>
    </div>
    <div class="form-row">
        <label>Background Image Path (storage)</label>
        <input type="text" name="content[background_image]" value="{{ $content['background_image'] ?? '' }}">
    </div>
    <div class="grid-2">
        <div class="form-row">
            <label>Button Label</label>
            <input type="text" name="content[button_label]" value="{{ $content['button_label'] ?? '' }}">
        </div>
        <div class="form-row">
            <label>Button URL</label>
            <input type="text" name="content[button_url]" value="{{ $content['button_url'] ?? '' }}">
        </div>
    </div>
    <div class="grid-2">
        <div class="form-row">
            <label>Secondary Button Label</label>
            <input type="text" name="content[secondary_button_label]" value="{{ $content['secondary_button_label'] ?? '' }}">
        </div>
        <div class="form-row">
            <label>Secondary Button URL</label>
            <input type="text" name="content[secondary_button_url]" value="{{ $content['secondary_button_url'] ?? '' }}">
        </div>
    </div>
</div>

<div class="section-fields" data-type="text_block">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Body (HTML allowed)</label>
        <textarea name="content[body]" rows="6">{{ $content['body'] ?? '' }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="image_block">
    <div class="form-row">
        <label>Image Path (storage)</label>
        <input type="text" name="content[image]" value="{{ $content['image'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Caption</label>
        <input type="text" name="content[caption]" value="{{ $content['caption'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Alignment</label>
        <select name="content[alignment]">
            @foreach(['left','right','center'] as $align)
                <option value="{{ $align }}" @selected(($content['alignment'] ?? 'left') === $align)>{{ $align }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="section-fields" data-type="feature_grid">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Items JSON (array of {title, icon, text})</label>
        <textarea name="items_json" rows="6">{{ json_encode($content['items'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="amenities">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Mode</label>
        <select name="content[mode]">
            <option value="auto" @selected(($content['mode'] ?? 'auto') === 'auto')>Auto (from amenities)</option>
            <option value="custom" @selected(($content['mode'] ?? 'auto') === 'custom')>Custom List</option>
        </select>
    </div>
    <div class="form-row">
        <label>Custom List (one per line)</label>
        <textarea name="custom_list_text" rows="4">{{ isset($content['custom_list']) ? implode("\n", $content['custom_list']) : '' }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="featured_rooms">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Limit</label>
        <input type="number" name="content[limit]" value="{{ $content['limit'] ?? 3 }}">
    </div>
</div>

<div class="section-fields" data-type="gallery_preview">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Category ID (optional)</label>
        <input type="number" name="content[category_id]" value="{{ $content['category_id'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Limit</label>
        <input type="number" name="content[limit]" value="{{ $content['limit'] ?? 6 }}">
    </div>
</div>

<div class="section-fields" data-type="testimonials_preview">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Limit</label>
        <input type="number" name="content[limit]" value="{{ $content['limit'] ?? 3 }}">
    </div>
</div>

<div class="section-fields" data-type="cta">
    <div class="form-row">
        <label>Headline</label>
        <input type="text" name="content[headline]" value="{{ $content['headline'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Body</label>
        <textarea name="content[body]" rows="3">{{ $content['body'] ?? '' }}</textarea>
    </div>
    <div class="grid-2">
        <div class="form-row">
            <label>Button Label</label>
            <input type="text" name="content[button_label]" value="{{ $content['button_label'] ?? '' }}">
        </div>
        <div class="form-row">
            <label>Button URL</label>
            <input type="text" name="content[button_url]" value="{{ $content['button_url'] ?? '' }}">
        </div>
    </div>
</div>

<div class="section-fields" data-type="faq">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>FAQ Items JSON (array of {question, answer})</label>
        <textarea name="items_json" rows="6">{{ json_encode($content['items'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="map_embed">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Embed Code</label>
        <textarea name="content[embed_code]" rows="4">{{ $content['embed_code'] ?? '' }}</textarea>
    </div>
</div>
