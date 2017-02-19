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


Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::post('passwordmail', 'Auth\PasswordController@sendMail');
Route::post('authmail', 'Auth\AuthController@sendMail');
Route::get('authLoginProcess/{id}', 'Auth\AuthController@authLoginProcess');

Route::get('auth/{oauth}', 'Auth\AuthController@redirectToAuth');
Route::get('auth/{oauth}/callback', 'Auth\AuthController@handleAuthCallback');

Route::controller('user', 'UserController');
Route::controller('admin', 'AdminController');
Route::controller('rate', 'RateController');
