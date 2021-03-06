<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Dingo\Api\Exception\StoreResourceFailedException;

class DishCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'photo' => 'nullable|image',
            'calories' => 'required|numeric',
            'proteins' => 'required|numeric',
            'fats' => 'required|numeric',
            'carbohydrates' => 'required|numeric',
        ];
    }

    /**
     * Handles wrong validation errors
     *
     * @return array
     */
    public function failedValidation(Validator $validator) {
        throw new StoreResourceFailedException('Adding new dish was unsuccessful due to incorrect information.', $validator->errors());
    }
}
