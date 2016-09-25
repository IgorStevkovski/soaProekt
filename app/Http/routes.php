<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::get('city/belgrade','CityController@belgrade');
Route::post('city/belgrade','CityController@belgradeCreatePost');
Route::get('city/belgrade/createComment','CityController@belgradeShowComment');
Route::post('city/belgrade/createComment','CityController@belgradeCreateComment');
Route::post('city/belgrade/insertLike','CityController@belgradeInsertLike');

Route::controllers([
    'auth'=>'Auth\AuthController',
    'password'=>'Auth\PasswordController'
]);

Route::get('auth/logout', 'Auth\AuthController@getLogout');

