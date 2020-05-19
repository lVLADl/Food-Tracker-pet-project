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
            'photo' => 'nullable|img',
            'calories' => 'required|float',
            'proteins' => 'required|float',
            'fats' => 'required|float',
            'carbohydrates' => 'required|float',
        ];
    }

    /**
     * Handles wrong validation errors
     *
     * @return array
     */
    public function failedValidation(Validator $validator) {
        throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
    }
}
