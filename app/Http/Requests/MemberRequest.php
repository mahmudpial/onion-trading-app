<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('member')?->id;

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:members,phone,' . ($memberId ?? 'NULL'),
            'market_id' => 'required|exists:markets,id',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'সদস্যের নাম দিন।',
            'phone.required' => 'ফোন নম্বর দিন।',
            'phone.unique' => 'এই ফোন নম্বর ইতিমধ্যে ব্যবহৃত হয়েছে।',
            'market_id.required' => 'বাজার নির্বাচন করুন।',
            'market_id.exists' => 'নির্বাচিত বাজার বিদ্যমান নেই।',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}