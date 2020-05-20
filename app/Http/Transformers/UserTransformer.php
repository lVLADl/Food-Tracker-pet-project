<?php


namespace App\Http\Transformers;


use App\Models\Dish;
use App\Models\Meal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user) {

        return [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
