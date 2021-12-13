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

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('local/{lang}', 'LanguageController@switchLang')->name('lang.switch');


Route::get('/registerForm', 'Auth\RegisterController@showRegistrationForm')->name('register.page');

Route::get('/google/auth', 'SocialiteController@redirectToProvider')->name('google.login');
Route::get('/google/auth/callback', 'SocialiteController@handleProviderCallback');


Route::post('/login', 'Auth\LoginController@login')->name('login.action');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::prefix('user')->group(function() {
        Route::get('/', 'UserController@index')->name('users.index')->middleware('can:read,App\User');
        Route::get('profile', 'UserController@profile')->name('users.profile')->middleware('can:read,App\User');
        Route::get('list', 'UserController@list')->name('users.list')->middleware('can:superuser,App\User');
       
        Route::post('image/{user}', 'UserController@image')->name('users.image')->middleware('can:edit,user');

        Route::put('{user}', 'UserController@edit')->name('users.edit')->middleware('can:edit,user');
        Route::put('auth/{user}', 'UserController@auth')->name('users.auth')->middleware('can:superuser,App\User');
        Route::put('status/{user}', 'UserController@status')->name('users.status')->middleware('can:superuser,App\User');
        Route::put('resetpassword/{user}', 'UserController@resetpassword')->name('users.resetpassword')->middleware('can:edit,user');
    });

    Route::prefix('quesition')->group(function() {
        Route::get('/', 'QuesitionController@index')->name('quesition.index')->middleware('can:read,App\Quesition');
        Route::get('list', 'QuesitionController@list')->name('quesition.list')->middleware('can:read,App\Quesition');
        Route::get('{quesition}', 'QuesitionController@get')->name('quesition.get')->middleware('can:read,App\Quesition');
        
        Route::post('type', 'QuesitionController@type')->name('quesition.type')->middleware('can:create,App\Quesition');
        Route::post('create', 'QuesitionController@create')->name('quesition.create')->middleware('can:create,App\Quesition');
        Route::put('status/{quesition}', 'QuesitionController@status')->name('quesition.status')->middleware('can:delete,App\Quesition');
    });

    Route::prefix('paper')->group(function() {
        Route::get('/', 'PaperController@index')->name('paper.index')->middleware('can:read,App\Paper');
        Route::post('create', 'PaperController@create')->name('paper.create')->middleware('can:create,App\Paper');
        Route::post('selected/{paper}', 'PaperController@selected')->name('paper.selected')->middleware('can:edit,paper');
        Route::get('selected/{paper}', 'PaperController@getSelected')->name('paper.getSelected')->middleware('can:read,paper');
        Route::post('multi/{paper}', 'PaperController@multiSave')->name('paper.multiSave')->middleware('can:edit,paper');

        Route::get('dropdwon', 'PaperController@dropdwon')->name('paper.dropdwon')->middleware('can:read,App\Paper');  

        Route::get('list', 'PaperController@list')->name('paper.list')->middleware('can:read,App\Paper');
        Route::put('status/{paper}', 'PaperController@status')->name('paper.status')->middleware('can:delete,App\Paper');
        
        Route::get('download/{paper}', 'ExcelController@paper')->name('paper.dwonload')->middleware('can:read,App\Paper');
    });

    Route::prefix('quiz')->group(function() {
        Route::get('/', 'QuizController@index')->name('quiz.index')->middleware('can:read,App\Quiz');
        Route::get('list', 'QuizController@list')->name('quiz.list')->middleware('can:edit,App\Quiz');
        Route::get('dropdown', 'QuizController@dropdown')->name('quiz.dropdown')->middleware('can:read,App\Quiz');
        
        Route::get('{quiz}', 'QuizController@get')->name('quiz.get')->middleware('can:take,quiz');
        Route::post('{quiz}/grade', 'QuizController@grade')->name('quiz.grade')->middleware('can:take,quiz');
        Route::put('{quiz}/status', 'QuizController@status')->name('quiz.status')->middleware('can:delete,App\Quiz');
        // ->middleware('can:delete,quiz');
        

        
    });

});