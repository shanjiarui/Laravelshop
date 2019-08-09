<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('users/{user}', function (App\User $user) {
    dd($user);
});
Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('add_buycar', 'HotController@add_buycar');

});
Route::post('/md', 'ShowController@md');
Route::get('/hot', 'HotController@is_hot');
Route::get('/tree', 'HotController@tree');
Route::get('/home_goods', 'HotController@home_goods');
Route::get('/goods', 'HotController@goods');
Route::get('/price', 'HotController@price');

//Route::post('login', 'AuthController@login');
