<?php

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

Route::get('/', 'FrontControllers\UserController@initContent');

Route::get('/home', 'FrontControllers\UserController@initContent');

// Authentication Routes...
Route::get('/login', 'FrontControllers\LoginController@showLoginForm')->name('login');
Route::post('login', 'FrontControllers\LoginController@login');
Route::get('logout', 'FrontControllers\LoginController@logout');

// Registration Routes...
Route::get('/register', 'FrontControllers\RegisterController@showRegistrationForm');
Route::post('register', 'FrontControllers\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'FrontControllers\ResetPasswordController@showResetForm');
Route::post('password/email', 'FrontControllers\ResetPasswordController@sendResetLinkEmail');
Route::post('password/reset', 'FrontControllers\ResetPasswordController@reset');


include('admin.php');
Route::get('test', 'FrontControllers\TestController@initContent');
