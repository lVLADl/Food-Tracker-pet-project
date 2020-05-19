<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishCreateRequest;
use App\Http\Requests\DishUpdateRequest;
use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends BaseController
{
    /**
     * Create a new DishController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dish::approved()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DishCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DishCreateRequest $request)
    {
        $request['user_id'] = $this->auth->user()->id;
        $request['is_approved'] = false;

        return Dish::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Models\Dish  $dish
     * @return \App\Models\Dish
     */
    public function show(Request $request, string $dish)
    {
        return Dish::findOrFail($dish);
    }

    public function approve(string $dish)
    {
        $dish = Dish::findOrFail($dish);
        if($dish) {
            $dish->is_approved = true;
            $dish->save();
        }

        return $this->response->noContent();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DishUpdateRequest  $request
     * @param  string  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(DishUpdateRequest $request, string $dish)
    {
        return $request->all();
        $dish = Dish::findOrFail($dish);
        $request['is_approved'] = false;
        $dish->update($request->all());
        $dish->save();

        return $dish;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        //
    }
}
