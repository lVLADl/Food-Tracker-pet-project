<?php

namespace App\Http\Requests;

use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Dingo\Api\Exception\StoreResourceFailedException;

class DishUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'nullable|string',
            'photo' => 'nullable|image',
            'calories' => 'nullable|numeric',
            'proteins' => 'nullable|numeric',
            'fats' => 'nullable|numeric',
            'carbohydrates' => 'nullable|numeric',
        ];
    }

    /**
     * Handles wrong validation errors
     *
     * @return array
     */
    public function failedValidation(Validator $validator) {
        throw new UpdateResourceFailedException('Could not create new user.', $validator->errors());
    }
}
