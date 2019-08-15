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
    Route::post('add_buycar', 'GoodsController@add_buycar');
    Route::get('buycar', 'BuycarController@buycar');
    Route::post('add_num', 'BuycarController@add_num');
    Route::post('down_num', 'BuycarController@down_num');
    Route::post('all_price', 'BuycarController@all_price');
    Route::get('address', 'AreaController@address');
    Route::post('add_delivery', 'AreaController@add_delivery');
    Route::get('all_detailed', 'AreaController@all_detailed');
    Route::post('default_address', 'AreaController@default_address');
    Route::post('show', 'OrderController@show');
    Route::post('go_address', 'OrderController@go_address');
    Route::post('add_order', 'OrderController@add_order');
    Route::any('/notify', 'ZfbController@notify');
    Route::get('/return', 'ZfbController@return');
    Route::get('/index', 'ZfbController@index');
});
Route::post('/md', 'ShowController@md');
Route::get('/hot', 'GoodsController@is_hot');
Route::get('/tree', 'GoodsController@tree');
Route::get('/home_goods', 'GoodsController@home_goods');
Route::get('/goods', 'GoodsController@goods');
Route::get('/price', 'GoodsController@price');
//Route::post('login', 'AuthController@login');
