<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'check_in' => ['nullable', 'date'],
            'check_out' => ['nullable', 'date', 'after_or_equal:check_in'],
            'guests' => ['nullable', 'integer', 'min:1'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'message' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:50'],
        ];
    }
}
