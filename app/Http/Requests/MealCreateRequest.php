<?php

namespace App\Http\Requests;

use App\Rules\UserHasAccessToDish;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MealCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'weight' => 'required|numeric',
            'dish_id' => new UserHasAccessToDish,
            'created_at' => 'nullable|date',
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
