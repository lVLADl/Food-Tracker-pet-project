<?php

namespace App\Rules;

use App\Models\Dish;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserHasAccessToDish implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $dish_id)
    {
        $user = Auth::user();
        $dish = Dish::findOrFail($dish_id);

        return ($dish->is_approved) or ($dish->user_id == $user->id);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The chosen dish can\'t be used.';
    }
}
