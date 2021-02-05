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


Route::post('register',         'User\UserController@register');
Route::post('login',            'User\UserController@login');

Route::middleware('auth:api')->group(function () {
    Route::post('logout',               'User\UserController@logout');
    Route::get('view-profile',          'User\UserController@viewProfile');
    Route::get('products',              'Product\ProductController@index');

});




//https://karjonoblog.wordpress.com/2019/12/15/membuat-rest-api-menggunakan-laravel-6-7-dengan-laravel-passport/
