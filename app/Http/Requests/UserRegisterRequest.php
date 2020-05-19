<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Dingo\Api\Exception\StoreResourceFailedException;

class UserRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string'
        ];
    }

    /**
     * Handles wrong validation errors
     *
     * @return array
     */
    public function failedValidation(Validator $validator) {
        throw new StoreResourceFailedException('Registering was unsuccessful due to problems with information.', $validator->errors());
    }
}
