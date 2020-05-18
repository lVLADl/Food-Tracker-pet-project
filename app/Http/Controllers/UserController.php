<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function __construct() {
        $this->middleware('api.auth');
    }

    public function testCase(Request $request) {
        return redirect(app('Dingo\Api\Routing\UrlGenerator')->version("v1")->route('p'));
    }
    public function getMealPlan(Request $request) {
        return (Dish::all()->random()->toArray());
//        return redirect(app('Dingo\Api\Routing\UrlGenerator')->version("v1")->route('p'));
    }
}
