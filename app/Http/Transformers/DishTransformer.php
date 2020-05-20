<?php


namespace App\Http\Transformers;


use App\Models\Dish;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;

class DishTransformer extends TransformerAbstract
{
    public function transform(Dish $dish) {
        return [
            'title' => $dish->title,
            'photo' => $dish->photo,
            'is_approved' => $dish->is_approved,
            'calories' => $dish->calories,
            'proteins' => $dish->proteins,
            'fats' => $dish->fats,
            'carbohydrates' => $dish->carbohydrates,
            'created_at' => $dish->created_at,
            'updated_at' => $dish->updated_at,
        ];
        return $dish->toArray();
    }
}
