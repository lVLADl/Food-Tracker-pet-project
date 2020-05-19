<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public static $jwt_exp_d = 7;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['login', 'register']]);
    }

    /**
     * @return array
     * Register user
     */
    public function register(UserRegisterRequest $request) {
        return \App\Models\User::create($request->all());
    }

    /**
     * @return array
     * Get menu plan
     */
    public function getMealPlan(Request $request) {
        return $this->auth->user()->meal_plan;
    }

    /**
     * @return array
     * Get menu plan
     **/
    public function calculateDailyCaloriesIntake(Request $request) {
        $user = $this->auth->user();
        $formula_set = $user->meal_plan->calculateDailyCaloriesIntake();

        return $formula_set;
    }

    /**
     * @return array
     * Get a JWT via given credentials.
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials, ['exp' => Carbon::now()->addDays(self::$jwt_exp_d)->timestamp])) {
            return $this->response->errorUnauthorized();
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return array
     */
    public function me()
    {
        $user = $this->auth->user();
        $out = [
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->hasRole('Admin')
        ];

        return $out;
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return array
     */
    public function logout()
    {
        auth()->logout();

        return ['message' => 'Successfully logged out'];
    }

    /**
     * Refresh a token.
     *
     * @return array
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return array
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            #'expires_in' => auth()->factory()->getTTL() * 60*60*24*7
        ];
    }
}

