<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseDishRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function wantsJson()
    {
        return true;
    }
}
