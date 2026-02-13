@php
    $currentType = old('type', $section->type ?? 'hero');
    $content = old('content', $section->content_array ?? []);
@endphp

<div class="form-row">
    <label>Section Type</label>
    <select name="type" id="section-type" class="w-full border border-black/20 rounded-lg px-3 py-2.5">
        @foreach(['hero','hero_booking','hero_slider','booking_bar','text_block','image_block','feature_grid','about_highlights','services_icons','amenities','featured_rooms','gallery_preview','testimonials_preview','cta','faq','map_embed','location_preview'] as $type)
            <option value="{{ $type }}" @selected($currentType === $type)>{{ $type }}</option>
        @endforeach
    </select>
</div>

<div class="grid gap-2">
    <label>Position</label>
    <input type="number" name="position" value="{{ old('position', $section->position ?? 0) }}">
</div>

<div class="grid gap-2">
    <label>Active</label>
    <select name="is_active">
        <option value="1" @selected(old('is_active', $section->is_active ?? true))>Yes</option>
        <option value="0" @selected(!old('is_active', $section->is_active ?? true))>No</option>
    </select>
</div>

<div class="section-fields" data-type="hero">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Subtitle</label>
        <textarea name="content[subtitle]" rows="2">{{ $content['subtitle'] ?? '' }}</textarea>
    </div>
    <div class="grid gap-2">
        <label>Background Image Path (storage)</label>
        <input id="section-background-image" type="text" name="content[background_image]" value="{{ $content['background_image'] ?? '' }}">
        <button class="btn btn-outline js-media-open" type="button" data-media-target="section-background-image" data-media-type="image">Pick from Media Library</button>
        <small>Use Media Library to upload and copy URLs.</small>
        @if(!empty($media))
            <div class="media-picker">
                <select class="js-media-picker" data-target="section-background-image">
                    <option value="">Select image</option>
                    @foreach($media as $item)
                        <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                    @endforeach
                </select>
                <small>Selected image path will be inserted.</small>
            </div>
        @endif
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="grid gap-2">
            <label>Button Label</label>
            <input type="text" name="content[button_label]" value="{{ $content['button_label'] ?? '' }}">
        </div>
        <div class="grid gap-2">
            <label>Button URL</label>
            <input type="text" name="content[button_url]" value="{{ $content['button_url'] ?? '' }}">
        </div>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="grid gap-2">
            <label>Secondary Button Label</label>
            <input type="text" name="content[secondary_button_label]" value="{{ $content['secondary_button_label'] ?? '' }}">
        </div>
        <div class="grid gap-2">
            <label>Secondary Button URL</label>
            <input type="text" name="content[secondary_button_url]" value="{{ $content['secondary_button_url'] ?? '' }}">
        </div>
    </div>
</div>

<div class="section-fields" data-type="hero_booking">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Subtitle</label>
        <textarea name="content[subtitle]" rows="2">{{ $content['subtitle'] ?? '' }}</textarea>
    </div>
    <div class="grid gap-2">
        <label>Background Image Path (storage)</label>
        <input id="section-hero-booking-bg" type="text" name="content[background_image]" value="{{ $content['background_image'] ?? '' }}">
        <button class="btn btn-outline js-media-open" type="button" data-media-target="section-hero-booking-bg" data-media-type="image">Pick from Media Library</button>
        @if(!empty($media))
            <div class="media-picker">
                <select class="js-media-picker" data-target="section-hero-booking-bg">
                    <option value="">Select image</option>
                    @foreach($media as $item)
                        <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="grid gap-2">
            <label>Button Label</label>
            <input type="text" name="content[button_label]" value="{{ $content['button_label'] ?? '' }}">
        </div>
        <div class="grid gap-2">
            <label>Button URL</label>
            <input type="text" name="content[button_url]" value="{{ $content['button_url'] ?? '' }}">
        </div>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="grid gap-2">
            <label>Secondary Button Label</label>
            <input type="text" name="content[secondary_button_label]" value="{{ $content['secondary_button_label'] ?? '' }}">
        </div>
        <div class="grid gap-2">
            <label>Secondary Button URL</label>
            <input type="text" name="content[secondary_button_url]" value="{{ $content['secondary_button_url'] ?? '' }}">
        </div>
    </div>
</div>

<div class="section-fields" data-type="hero_slider">
    @php($slides = $content['slides'] ?? [])
    <div class="form-row">
        <label>Slides</label>
        <div id="hero-slider-list" class="slider-list">
            @forelse($slides as $index => $slide)
                <div class="slider-item" data-index="{{ $index }}">
                    <div class="slider-header">
                        <strong>Slide {{ $index + 1 }}</strong>
                        <button class="btn btn-ghost js-remove-slide" type="button">Remove</button>
                    </div>
                    <div class="grid-2">
                        <div class="form-row">
                            <label>Title</label>
                            <input type="text" name="content[slides][{{ $index }}][title]" value="{{ $slide['title'] ?? '' }}">
                        </div>
                        <div class="form-row">
                            <label>Subtitle</label>
                            <input type="text" name="content[slides][{{ $index }}][subtitle]" value="{{ $slide['subtitle'] ?? '' }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <label>Image Path (storage)</label>
                        <input id="slide-image-{{ $index }}" type="text" name="content[slides][{{ $index }}][image]" value="{{ $slide['image'] ?? '' }}">
                        <button class="btn btn-outline js-media-open" type="button" data-media-target="slide-image-{{ $index }}" data-media-type="image">Pick from Media Library</button>
                        @if(!empty($media))
                            <div class="media-picker">
                                <select class="js-media-picker" data-target="slide-image-{{ $index }}">
                                    <option value="">Select image</option>
                                    @foreach($media as $item)
                                        <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="grid-2">
                        <div class="form-row">
                            <label>Button Label</label>
                            <input type="text" name="content[slides][{{ $index }}][button_label]" value="{{ $slide['button_label'] ?? '' }}">
                        </div>
                        <div class="form-row">
                            <label>Button URL</label>
                            <input type="text" name="content[slides][{{ $index }}][button_url]" value="{{ $slide['button_url'] ?? '' }}">
                        </div>
                    </div>
                    <div class="grid-2">
                        <div class="form-row">
                            <label>Secondary Button Label</label>
                            <input type="text" name="content[slides][{{ $index }}][secondary_button_label]" value="{{ $slide['secondary_button_label'] ?? '' }}">
                        </div>
                        <div class="form-row">
                            <label>Secondary Button URL</label>
                            <input type="text" name="content[slides][{{ $index }}][secondary_button_url]" value="{{ $slide['secondary_button_url'] ?? '' }}">
                        </div>
                    </div>
                </div>
            @empty
                <p class="muted">No slides yet. Add one below.</p>
            @endforelse
        </div>
        <button class="btn btn-outline js-add-slide" type="button" data-template-target="hero-slide-template">Add Slide</button>
    </div>
    <template id="hero-slide-template">
        <div class="slider-item" data-index="__INDEX__">
            <div class="slider-header">
                <strong>Slide __NUMBER__</strong>
                <button class="btn btn-ghost js-remove-slide" type="button">Remove</button>
            </div>
            <div class="grid-2">
                <div class="form-row">
                    <label>Title</label>
                    <input type="text" name="content[slides][__INDEX__][title]" value="">
                </div>
                <div class="form-row">
                    <label>Subtitle</label>
                    <input type="text" name="content[slides][__INDEX__][subtitle]" value="">
                </div>
            </div>
            <div class="form-row">
                <label>Image Path (storage)</label>
                <input id="slide-image-__INDEX__" type="text" name="content[slides][__INDEX__][image]" value="">
                <button class="btn btn-outline js-media-open" type="button" data-media-target="slide-image-__INDEX__" data-media-type="image">Pick from Media Library</button>
                @if(!empty($media))
                    <div class="media-picker">
                        <select class="js-media-picker" data-target="slide-image-__INDEX__">
                            <option value="">Select image</option>
                            @foreach($media as $item)
                                <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="grid-2">
                <div class="form-row">
                    <label>Button Label</label>
                    <input type="text" name="content[slides][__INDEX__][button_label]" value="">
                </div>
                <div class="form-row">
                    <label>Button URL</label>
                    <input type="text" name="content[slides][__INDEX__][button_url]" value="">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-row">
                    <label>Secondary Button Label</label>
                    <input type="text" name="content[slides][__INDEX__][secondary_button_label]" value="">
                </div>
                <div class="form-row">
                    <label>Secondary Button URL</label>
                    <input type="text" name="content[slides][__INDEX__][secondary_button_url]" value="">
                </div>
            </div>
        </div>
    </template>
</div>

<div class="section-fields" data-type="booking_bar">
    <div class="form-row">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="form-row">
        <label>Subtitle</label>
        <input type="text" name="content[subtitle]" value="{{ $content['subtitle'] ?? '' }}">
    </div>
</div>

<div class="section-fields" data-type="text_block">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Body (HTML allowed)</label>
        <textarea name="content[body]" rows="6">{{ $content['body'] ?? '' }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="image_block">
    <div class="grid gap-2">
        <label>Image Path (storage)</label>
        <input id="section-image" type="text" name="content[image]" value="{{ $content['image'] ?? '' }}">
        <button class="btn btn-outline js-media-open" type="button" data-media-target="section-image" data-media-type="image">Pick from Media Library</button>
        <small>Use Media Library to upload and copy URLs.</small>
        @if(!empty($media))
            <div class="media-picker">
                <select class="js-media-picker" data-target="section-image">
                    <option value="">Select image</option>
                    @foreach($media as $item)
                        <option value="{{ $item->path }}">{{ $item->title ?? $item->path }}</option>
                    @endforeach
                </select>
                <small>Selected image path will be inserted.</small>
            </div>
        @endif
    </div>
    <div class="grid gap-2">
        <label>Caption</label>
        <input type="text" name="content[caption]" value="{{ $content['caption'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Alignment</label>
        <select name="content[alignment]">
            @foreach(['left','right','center'] as $align)
                <option value="{{ $align }}" @selected(($content['alignment'] ?? 'left') === $align)>{{ $align }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="section-fields" data-type="feature_grid">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Items JSON (array of {title, icon, text})</label>
        <textarea name="items_json" rows="6">{{ json_encode($content['items'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="about_highlights">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Body (HTML allowed)</label>
        <textarea name="content[body]" rows="6">{{ $content['body'] ?? '' }}</textarea>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="grid gap-2">
            <label>Button Label</label>
            <input type="text" name="content[button_label]" value="{{ $content['button_label'] ?? '' }}">
        </div>
        <div class="grid gap-2">
            <label>Button URL</label>
            <input type="text" name="content[button_url]" value="{{ $content['button_url'] ?? '' }}">
        </div>
    </div>
    <div class="grid gap-2">
        <label>Stats JSON (array of {label, value})</label>
        <textarea name="stats_json" rows="6">{{ json_encode($content['stats'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="services_icons">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Items JSON (array of {title, icon, text})</label>
        <textarea name="items_json" rows="6">{{ json_encode($content['items'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="amenities">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Mode</label>
        <select name="content[mode]">
            <option value="auto" @selected(($content['mode'] ?? 'auto') === 'auto')>Auto (from amenities)</option>
            <option value="custom" @selected(($content['mode'] ?? 'auto') === 'custom')>Custom List</option>
        </select>
    </div>
    <div class="grid gap-2">
        <label>Custom List (one per line)</label>
        <textarea name="custom_list_text" rows="4">{{ isset($content['custom_list']) ? implode("\n", $content['custom_list']) : '' }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="featured_rooms">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Limit</label>
        <input type="number" name="content[limit]" value="{{ $content['limit'] ?? 3 }}">
    </div>
</div>

<div class="section-fields" data-type="gallery_preview">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Category ID (optional)</label>
        <input type="number" name="content[category_id]" value="{{ $content['category_id'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Limit</label>
        <input type="number" name="content[limit]" value="{{ $content['limit'] ?? 6 }}">
    </div>
</div>

<div class="section-fields" data-type="testimonials_preview">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Limit</label>
        <input type="number" name="content[limit]" value="{{ $content['limit'] ?? 3 }}">
    </div>
</div>

<div class="section-fields" data-type="cta">
    <div class="grid gap-2">
        <label>Headline</label>
        <input type="text" name="content[headline]" value="{{ $content['headline'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Body</label>
        <textarea name="content[body]" rows="3">{{ $content['body'] ?? '' }}</textarea>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="grid gap-2">
            <label>Button Label</label>
            <input type="text" name="content[button_label]" value="{{ $content['button_label'] ?? '' }}">
        </div>
        <div class="grid gap-2">
            <label>Button URL</label>
            <input type="text" name="content[button_url]" value="{{ $content['button_url'] ?? '' }}">
        </div>
    </div>
</div>

<div class="section-fields" data-type="faq">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>FAQ Items JSON (array of {question, answer})</label>
        <textarea name="items_json" rows="6">{{ json_encode($content['items'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="map_embed">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Embed Code</label>
        <textarea name="content[embed_code]" rows="4">{{ $content['embed_code'] ?? '' }}</textarea>
    </div>
</div>

<div class="section-fields" data-type="location_preview">
    <div class="grid gap-2">
        <label>Title</label>
        <input type="text" name="content[title]" value="{{ $content['title'] ?? '' }}">
    </div>
    <div class="grid gap-2">
        <label>Address</label>
        <textarea name="content[address]" rows="3">{{ $content['address'] ?? '' }}</textarea>
    </div>
    <div class="grid gap-2">
        <label>Embed Code</label>
        <textarea name="content[embed_code]" rows="4">{{ $content['embed_code'] ?? '' }}</textarea>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div class="grid gap-2">
            <label>Button Label</label>
            <input type="text" name="content[button_label]" value="{{ $content['button_label'] ?? '' }}">
        </div>
        <div class="grid gap-2">
            <label>Button URL</label>
            <input type="text" name="content[button_url]" value="{{ $content['button_url'] ?? '' }}">
        </div>
    </div>
</div>
