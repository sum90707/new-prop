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

Route::get('/', 'HomeController@index')->name('home');
Route::get('local/{lang}', 'LanguageController@switchLang')->name('lang.switch');


Route::get('/auth', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/registerForm', 'Auth\RegisterController@showRegistrationForm')->name('register.page');


Route::post('/login', 'Auth\LoginController@login')->name('login.action');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('user')->group(function() {

        Route::get('/', 'UserController@index')->name('users.index')->middleware('can:read,App\User');
        Route::get('profile', 'UserController@profile')->name('users.profile')->middleware('can:read,App\User');
        Route::get('list', 'UserController@list')->name('users.list')->middleware('can:superuser,App\User');

        Route::put('{user}', 'UserController@edit')->name('users.edit')->middleware('can:edit,user');
        Route::put('status/{user}', 'UserController@status')->name('users.status')->middleware('can:superuser,App\User');
        Route::put('auth/{user}', 'UserController@auth')->name('users.auth')->middleware('can:superuser,App\User');
        Route::POST('image/{user}', 'UserController@image')->name('users.image')->middleware('can:edit,user');


        // Route::get('{user}', 'UserController@show')->name('users.show');
        // Route::put('{user}', 'UserController@update')->name('users.update');
        // Route::delete('{user}', 'UserController@destroy')->name('users.destroy');
        // Route::get('{user}/edit', 'UserController@edit')->name('users.edit');
    });
});