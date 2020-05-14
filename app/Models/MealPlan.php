<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    public static $SEX = [
        'MEN' => 'm',
        'WOMAN' => 'w',
    ];
    public static $COEFFICIENTS = [
        'XL' => 1.2, # 0 no physical activity / sitting work
        'L' => 1.375, # 1-3 times per week
        'M' => 1.55, # 3-5 medium tension workouts
        'H' => 1.725, # 6-7 normal workouts
        'XH' => 1.9, # 2 times / day, high tension workouts
    ];

    public function user() {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    protected $fillable = [
        'sex',
        'weight',
        'height',
        'weight_goal',
        'age',
        'activity_rate',
        'calories_change',
        'user_id'
    ];
}
