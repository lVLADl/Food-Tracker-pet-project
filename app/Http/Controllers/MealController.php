<?php

namespace App\Http\Controllers;

use App\Http\Transformers\MealTransformer;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends BaseController
{
    /**
     * Find meal-instance or raise error.
     *
     * @param  string $meal_id
     * @return Meal
     */
    public static function getMeal(string $meal_id) {
        return Meal::findOrFail($meal_id);
    }

    /**
     * Display a listing of the meals.
     * Additionally, it's possible to set some parameters
     * [1]="date" / Format=YYYY.MM.DD / Example= date=2020.*.* : all the records which was created at 2020- year
     * [2]="title"
     * [3]="approved"
     * [4]="[calories/proteins/fats/carbohydrates]_[exact/gt/gte/lt/lte]" (greater then, greater then or equal, ...) Example= proteins_gte=120.0
     * [5]="total_[calories/proteins/fats/carbohydrates]_[exact/gt/gte/lt/lte]" (greater then, greater then or equal, ...) Example= total_proteins_exact=88.0
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Meal::where('user_id', $this->auth->user()->id);
        $GET = $request->all();
        if($GET) {
            function parse_date_part($query, $date_part) {
                static $times_called = 0;
                $times_called++;

                if($date_part!='*') {
                    switch ($times_called) {
                        case 1:
                            return $query->whereYear('created_at', $date_part);
                            break;
                        case 2:
                            return $query->whereMonth('created_at', $date_part);
                            break;
                        case 3:
                            return $query->whereDay('created_at', $date_part);
                            break;
                    }
                }
                return $query;
            }
            # Place filters here
            # Place sorting here

            if(@$f_date = $GET['date']) {
                # YYYY.MM.DD, if no matter what, e.x. day, replace it with [*]: *.08.1
                $f_date = explode('.', $f_date);
                foreach ($f_date as $date_part) {
                    $query = parse_date_part($query, (string) $date_part);
                }
                # return Meal::whereMonth('created_at', 05)->whereDay('created_at', '20')->where('dish_id', '3')->orderByDesc('id')->get();
            }
            $query = collect($query->get());

            if(@$f_title = $_GET['title']) {
                $query = $query->where('dish.title', $f_title);
            }
            if(@$f_approved = $_GET['approved']) {
                $query = $query->where('dish.is_approved', (bool) $f_approved);
            }

            # Dish- numbers
                # Calories
                if(@$f_calories_exact = $_GET['calories_exact']) {
                    $query = $query->where('dish.calories', '=', $f_calories_exact);
                }
                if(@$f_calories_gt = $_GET['calories_gt']) {
                    $query = $query->where('dish.calories', '>', $f_calories_gt);
                }
                if(@$f_calories_gte = $_GET['calories_gte']) {
                    $query = $query->where('dish.calories', '>=', $f_calories_gte);
                }
                if(@$f_calories_lt = $_GET['calories_lt']) {
                    $query = $query->where('dish.calories', '<', $f_calories_lt);
                }
                if(@$f_calories_lte = $_GET['calories_lte']) {
                    $query = $query->where('dish.calories', '<=', $f_calories_lte);
                }

                # Proteins
                if(@$f_proteins_exact = $_GET['proteins_exact']) {
                    $query = $query->where('dish.proteins', '=', $f_proteins_exact);
                }
                if(@$f_proteins_gt = $_GET['proteins_gt']) {
                    $query = $query->where('dish.proteins', '>', $f_proteins_gt);
                }
                if(@$f_proteins_gte = $_GET['proteins_gte']) {
                    $query = $query->where('dish.proteins', '>=', $f_proteins_gte);
                }
                if(@$f_proteins_lt = $_GET['proteins_lt']) {
                    $query = $query->where('dish.proteins', '<', $f_proteins_lt);
                }
                if(@$f_proteins_lte = $_GET['proteins_lte']) {
                    $query = $query->where('dish.proteins', '<=', $f_proteins_lte);
                }

                # Fats
                if(@$f_fats_exact = $_GET['fats_exact']) {
                    $query = $query->where('dish.fats', '=', $f_fats_exact);
                }
                if(@$f_fats_gt = $_GET['fats_gt']) {
                    $query = $query->where('dish.fats', '>', $f_fats_gt);
                }
                if(@$f_fats_gte = $_GET['fats_gte']) {
                    $query = $query->where('dish.fats', '>=', $f_fats_gte);
                }
                if(@$f_fats_lt = $_GET['fats_lt']) {
                    $query = $query->where('dish.fats', '<', $f_fats_lt);
                }
                if(@$f_fats_lte = $_GET['fats_lte']) {
                    $query = $query->where('dish.fats', '<=', $f_fats_lte);
                }

                # Carbohydrates
                if(@$f_carbohydrates_exact = $_GET['carbohydrates_exact']) {
                    $query = $query->where('dish.carbohydrates', '=', $f_carbohydrates_exact);
                }
                if(@$f_carbohydrates_gt = $_GET['carbohydrates_gt']) {
                    $query = $query->where('dish.carbohydrates', '>', $f_carbohydrates_gt);
                }
                if(@$f_carbohydrates_gte = $_GET['carbohydrates_gte']) {
                    $query = $query->where('dish.carbohydrates', '>=', $f_carbohydrates_gte);
                }
                if(@$f_carbohydrates_lt = $_GET['carbohydrates_lt']) {
                    $query = $query->where('dish.carbohydrates', '<', $f_carbohydrates_lt);
                }
                if(@$f_carbohydrates_lte = $_GET['carbohydrates_lte']) {
                    $query = $query->where('dish.carbohydrates', '<=', $f_carbohydrates_lte);
                }

            # Total- numbers
                # Calories
                if(@$f_total_calories_exact = $_GET['total_calories_exact']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_calories_exact){
                        return ($instance->dish->calories*$instance->weight/100) == $f_total_calories_exact;
                    });
                }
                if(@$f_total_calories_gt = $_GET['total_calories_gt']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_calories_gt){
                        return ($instance->dish->calories*$instance->weight/100) > $f_total_calories_gt;
                    });
                }
                if(@$f_total_calories_gte = $_GET['total_calories_gte']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_calories_gte){
                        return ($instance->dish->calories*$instance->weight/100) >= $f_total_calories_gte;
                    });
                }
                if(@$f_total_calories_lt = $_GET['total_calories_lt']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_calories_lt){
                        return ($instance->dish->calories*$instance->weight/100) < $f_total_calories_lt;
                    });
                }
                if(@$f_total_calories_lte = $_GET['total_calories_lte']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_calories_lte){
                        return ($instance->dish->calories*$instance->weight/100) <= $f_total_calories_lte;
                    });
                }


                # Proteins
                if(@$f_total_proteins_exact = $_GET['total_proteins_exact']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_proteins_exact){
                        return ($instance->dish->proteins*$instance->weight/100) == $f_total_proteins_exact;
                    });
                }
                if(@$f_total_proteins_gt = $_GET['total_proteins_gt']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_proteins_gt){
                        return ($instance->dish->proteins*$instance->weight/100) > $f_total_proteins_gt;
                    });
                }
                if(@$f_total_proteins_gte = $_GET['total_proteins_gte']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_proteins_gte){
                        return ($instance->dish->proteins*$instance->weight/100) >= $f_total_proteins_gte;
                    });
                }
                if(@$f_total_proteins_lt = $_GET['total_proteins_lt']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_proteins_lt){
                        return ($instance->dish->proteins*$instance->weight/100) < $f_total_proteins_lt;
                    });
                }
                if(@$f_total_proteins_lte = $_GET['total_proteins_lte']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_proteins_lte){
                        return ($instance->dish->proteins*$instance->weight/100) <= $f_total_proteins_lte;
                    });
                }

                # Fats
                if(@$f_total_fats_exact = $_GET['total_fats_exact']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_fats_exact){
                        return ($instance->dish->fats*$instance->weight/100) == $f_total_fats_exact;
                    });
                }
                if(@$f_total_fats_gt = $_GET['total_fats_gt']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_fats_gt){
                        return ($instance->dish->fats*$instance->weight/100) > $f_total_fats_gt;
                    });
                }
                if(@$f_total_fats_gte = $_GET['total_fats_gte']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_fats_gte){
                        return ($instance->dish->fats*$instance->weight/100) >= $f_total_fats_gte;
                    });
                }
                if(@$f_total_fats_lt = $_GET['total_fats_lt']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_fats_lt){
                        return ($instance->dish->fats*$instance->weight/100) < $f_total_fats_lt;
                    });
                }
                if(@$f_total_fats_lte = $_GET['total_fats_lte']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_fats_lte){
                        return ($instance->dish->fats*$instance->weight/100) <= $f_total_fats_lte;
                    });
                }

                # Carbohydrates
                if(@$f_total_carbohydrates_exact = $_GET['total_carbohydrates_exact']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_carbohydrates_exact){
                        return ($instance->dish->carbohydrates*$instance->weight/100) == $f_total_carbohydrates_exact;
                    });
                }
                if(@$f_total_carbohydrates_gt = $_GET['total_carbohydrates_gt']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_carbohydrates_gt){
                        return ($instance->dish->carbohydrates*$instance->weight/100) > $f_total_carbohydrates_gt;
                    });
                }
                if(@$f_total_carbohydrates_gte = $_GET['total_carbohydrates_gte']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_carbohydrates_gte){
                        return ($instance->dish->carbohydrates*$instance->weight/100) >= $f_total_carbohydrates_gte;
                    });
                }
                if(@$f_total_carbohydrates_lt = $_GET['total_carbohydrates_lt']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_carbohydrates_lt){
                        return ($instance->dish->carbohydrates*$instance->weight/100) >= $f_total_carbohydrates_lt;
                    });
                }
                if(@$f_total_carbohydrates_lte = $_GET['total_carbohydrates_lte']) {
                    $query = $query->filter(function(Meal $instance) use($f_total_carbohydrates_lte){
                        return ($instance->dish->carbohydrates*$instance->weight/100) >= $f_total_carbohydrates_lte;
                    });
                }

        } else {
            $query = collect($query->get());
        }
        # General response ( one for all method)
        return $this->response->collection($query, new MealTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified meal.
     *
     * @param  string $meal
     * @return \Illuminate\Http\Response
     */
    public function show(string $meal)
    {
        $meal = self::getMeal($meal);
        return $this->response->item($meal, new MealTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $meal)
    {
        self::getMeal($meal)->delete();
        return $this->response->noContent();
    }
}
