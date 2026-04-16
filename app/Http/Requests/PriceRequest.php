<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'market_id' => 'required|exists:markets,id',
            'price' => 'required|numeric|min:0.01|max:99999.99',
            'date' => 'required|date|before_or_equal:today',
            'unit' => 'nullable|string|in:KG,Maund,100KG',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'market_id.required' => 'বাজার নির্বাচন করুন।',
            'market_id.exists' => 'নির্বাচিত বাজার বিদ্যমান নেই।',
            'price.required' => 'দাম লিখুন।',
            'price.numeric' => 'দাম অবশ্যই সংখ্যা হতে হবে।',
            'price.min' => 'দাম ০ এর বেশি হতে হবে।',
            'date.required' => 'তারিখ দিন।',
            'date.before_or_equal' => 'ভবিষ্যতের তারিখ দেওয়া যাবে না।',
        ];
    }
}