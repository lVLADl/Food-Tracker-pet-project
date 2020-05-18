<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['login']]);
    }

    /**
     * @return JsonResponse
     * Get a JWT via given credentials.
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
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
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
