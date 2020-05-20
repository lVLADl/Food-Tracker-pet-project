<?php


namespace App\Http\Transformers;


use App\Models\Dish;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;

class MealTransformer extends TransformerAbstract
{
    public function transform(Meal $meal) {
        $user_transformer = new UserTransformer;
        $dish_transformer = new DishTransformer;

        $dish = $dish_transformer->transform($meal->dish);
        $user = $user_transformer->transform($meal->user);

        return [
            'dish' => $dish,
            'user' => $user,

            'total_calories' => $meal->weight * $meal->dish->calories / 100,
            'total_proteins' => $meal->weight * $meal->dish->proteins / 100,
            'total_fats' => $meal->weight * $meal->dish->fats / 100,
            'total_carbohydrates' => $meal->weight * $meal->dish->carbohydrates / 100,

            'created_at' => $meal->created_at,
            'updated_at' => $meal->updated_at,
        ];
    }
}
