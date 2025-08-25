<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarModelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
