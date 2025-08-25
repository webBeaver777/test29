<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'mileage' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
        ];
    }
}
