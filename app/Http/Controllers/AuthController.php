<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['name', 'password']);
        $name=$credentials['name'];
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['status'=>'error','text' => '账号密码错误！']);
        }

        return $this->respondWithToken($token,$name);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
//        $response=response()->json(auth()->user());
//        var_dump($response);die;
        return $response=response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$name)
    {
        $arr=Db::select("select * from users where `name`='$name'");
        $id=$arr[0]->id;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'status'=>'success',
            'name'=>$name,
            'id'=>$id,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}