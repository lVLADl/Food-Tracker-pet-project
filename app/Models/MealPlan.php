<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    public static $FORMULAS = null;
    public static $CURR_CALC_FORMULA = 'MSZ';

    public function calculateDailyCaloriesIntake() {
        $formula_set = self::$FORMULAS[self::$CURR_CALC_FORMULA]; # Identifying specific formula to be used
        $formula = $formula_set['function'];
        $formula_title = $formula_set['title'];

        $result = [
            'formula_title' => $formula_title,
            'formula_result' => $formula($this)
        ];
        return $result;
    }
    protected static function boot()
    {
        self::$FORMULAS = [
            'MSZ' => [
                'title' => 'Mifflin-St-Jeor',
                'function' => function(MealPlan $mp) {
                    return ($mr=((($mp->weight*10)+($mp->height*6.25)-(5*$mp->age)+($mp->sex=='m'?5:-161))*$mp->activity_rate))+(($mp->calories_change*$mr)/100);
                }
            ],
        ];
        parent::boot();
    }

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
