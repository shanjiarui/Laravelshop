<?php
use App\Http\Kernel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return 123;
});
//Route::any('/login_action', function(){  //这里是get,当我们自己要定义POST请求的时候,这要变成post
//    return 123;
//});
Route::get('/login', 'LoginController@home');

Route::any('/login_action', 'LoginController@login_action');
//Route::post('/login_action', 'LoginController@login_action');
Route::get('user', 'UserController@show');
Route::get('/out', 'ShowController@out');
Route::resource('posts', 'PostController');
Route::group(['middleware' => App\Http\Middleware\CheckToken::class,], function () {
    Route::get('/show', 'ShowController@show');
    Route::get('/sel', 'ShowController@sel');
    Route::post('/add', 'ShowController@add');
    Route::post('/del', 'ShowController@del');
    Route::post('/up_action', 'ShowController@up_action');
    Route::post('/my_up', 'ShowController@my_up');
});

//    中间件组web在web.php中自动调用
//    Route::get('form_without_csrf_token', function (){
//        return '<form method="POST" action="hello_from_form"><button type="submit">提交</button></form>';
//    });
//
//    Route::get('form_with_csrf_token', function () {
//        return '<form method="POST" action="hello_from_form">' . csrf_field() . '<button type="submit">提交</button></form>';
//    });
//
//    Route::post('hello_from_form', function (){
//        return 'hello laravel!';
//    });


