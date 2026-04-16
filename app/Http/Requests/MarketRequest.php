<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'division' => 'required|string|in:' . implode(',', \App\Models\Market::divisions()),
            'open_days' => 'nullable|array',
            'open_days.*' => 'string|in:' . implode(',', \App\Models\Market::weekdays()),
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'বাজারের নাম দিন।',
            'division.required' => 'বিভাগ নির্বাচন করুন।',
            'division.in' => 'অবৈধ বিভাগ নির্বাচন করা হয়েছে।',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}