<?php

namespace App\Http\Requests\Admin;

use App\Services\Cms\SectionValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePageSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $content = $this->input('content', []);

        if ($this->filled('items_json')) {
            $decoded = json_decode($this->input('items_json'), true);
            if (is_array($decoded)) {
                $content['items'] = $decoded;
            }
        }

        if ($this->filled('custom_list_text')) {
            $items = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $this->input('custom_list_text')))));
            $content['custom_list'] = $items;
        }

        if ($this->filled('slides_json')) {
            $decoded = json_decode($this->input('slides_json'), true);
            if (is_array($decoded)) {
                $content['slides'] = $decoded;
            }
        }

        $this->merge([
            'content' => $content,
        ]);
    }

    public function rules(): array
    {
        $type = $this->input('type');
        $allowedTypes = [
            'hero',
            'hero_slider',
            'booking_bar',
            'text_block',
            'image_block',
            'feature_grid',
            'amenities',
            'featured_rooms',
            'gallery_preview',
            'testimonials_preview',
            'cta',
            'faq',
            'map_embed',
        ];

        $rules = [
            'page_id' => ['required', 'exists:pages,id'],
            'type' => ['required', Rule::in($allowedTypes)],
            'position' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];

        $sectionRules = app(SectionValidator::class)->rulesFor((string) $type);
        foreach ($sectionRules as $key => $rule) {
            $rules['content.' . $key] = $rule;
        }

        return $rules;
    }
}
