<?php

namespace App\Http\Middleware;

use App\Models\Dish;
use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class VerifyDishRightsMiddleware
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
        $dish_id = $request->route('dish');
        $dish = Dish::findOrFail($dish_id);
        $user = Auth::user();

        if($user->hasRole('Admin') || $user->id == $dish->user_id) {
            return $next($request);
        } else {
            throw new AccessDeniedHttpException();
        }
    }
}
