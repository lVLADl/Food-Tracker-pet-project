<?php

namespace App\Http\Middleware;

use App\Models\Dish;
use App\Models\Meal;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VerifyMealRightsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $meal_id = $request->route('meal');
        $meal = Meal::findOrFail($meal_id);
        $user = Auth::user();

        if($user->id == $meal->user_id) {
            return $next($request);
        } else {
            throw new AccessDeniedHttpException();
        }
    }
}
