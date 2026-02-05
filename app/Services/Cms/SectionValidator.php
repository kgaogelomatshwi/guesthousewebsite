<?php

namespace App\Services\Cms;

class SectionValidator
{
    public function rulesFor(string $type): array
    {
        return match ($type) {
            'hero' => [
                'title' => ['required', 'string', 'max:150'],
                'subtitle' => ['nullable', 'string'],
                'background_image' => ['nullable', 'string'],
                'button_label' => ['nullable', 'string', 'max:80'],
                'button_url' => ['nullable', 'string', 'max:255'],
                'secondary_button_label' => ['nullable', 'string', 'max:80'],
                'secondary_button_url' => ['nullable', 'string', 'max:255'],
            ],
            'text_block' => [
                'title' => ['nullable', 'string', 'max:150'],
                'body' => ['required', 'string'],
            ],
            'image_block' => [
                'image' => ['nullable', 'string'],
                'caption' => ['nullable', 'string', 'max:150'],
                'alignment' => ['nullable', 'in:left,right,center'],
            ],
            'feature_grid' => [
                'title' => ['nullable', 'string', 'max:150'],
                'items' => ['required', 'array'],
                'items.*.title' => ['required', 'string', 'max:120'],
                'items.*.icon' => ['nullable', 'string', 'max:120'],
                'items.*.text' => ['required', 'string'],
            ],
            'amenities' => [
                'title' => ['nullable', 'string', 'max:150'],
                'mode' => ['nullable', 'in:auto,custom'],
                'custom_list' => ['nullable', 'array'],
            ],
            'featured_rooms' => [
                'title' => ['nullable', 'string', 'max:150'],
                'limit' => ['nullable', 'integer', 'min:1', 'max:6'],
            ],
            'gallery_preview' => [
                'title' => ['nullable', 'string', 'max:150'],
                'category_id' => ['nullable', 'integer'],
                'limit' => ['nullable', 'integer', 'min:1', 'max:30'],
            ],
            'testimonials_preview' => [
                'title' => ['nullable', 'string', 'max:150'],
                'limit' => ['nullable', 'integer', 'min:1', 'max:20'],
            ],
            'cta' => [
                'headline' => ['required', 'string', 'max:150'],
                'body' => ['nullable', 'string'],
                'button_label' => ['nullable', 'string', 'max:80'],
                'button_url' => ['nullable', 'string', 'max:255'],
            ],
            'faq' => [
                'title' => ['nullable', 'string', 'max:150'],
                'items' => ['required', 'array'],
                'items.*.question' => ['required', 'string', 'max:180'],
                'items.*.answer' => ['required', 'string'],
            ],
            'map_embed' => [
                'title' => ['nullable', 'string', 'max:150'],
                'embed_code' => ['required', 'string'],
            ],
            default => [],
        };
    }
}
