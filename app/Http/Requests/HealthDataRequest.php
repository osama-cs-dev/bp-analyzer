<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HealthDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'max:100'],
            'age'    => ['required', 'integer', 'min:1', 'max:120'],
            'weight' => ['required', 'numeric', 'min:1', 'max:500'],
            'height' => ['required', 'numeric', 'min:1', 'max:300'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'   => 'Please enter your full name.',
            'age.required'    => 'Please enter your age.',
            'age.min'         => 'Age must be at least 1.',
            'age.max'         => 'Age cannot exceed 120.',
            'weight.required' => 'Please enter your weight.',
            'weight.min'      => 'Weight must be a positive number.',
            'height.required' => 'Please enter your height.',
            'height.min'      => 'Height must be a positive number.',
        ];
    }
}
