<?php

namespace App\Http\Controllers;

use App\Http\Transformers\MealTransformer;
use App\Models\Dish;
use App\Models\Meal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
     * [1]="date" / Format=YYYY.MM.DD / Example=2020.*.* : all the records which was created at 2020- year
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

            if($f_date = $GET['date']) {
                # YYYY.MM.DD, if no matter what, e.x. day, replace it with [*]: *.08.1
                $f_date = explode('.', $f_date);
                foreach ($f_date as $date_part) {
                    $query = parse_date_part($query, (string) $date_part);
                }
                # return Meal::whereMonth('created_at', 05)->whereDay('created_at', '20')->where('dish_id', '3')->orderByDesc('id')->get();
            }
        }
        # General response ( one for all method)
        return $this->response->collection(collect($query->get()), new MealTransformer);
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
