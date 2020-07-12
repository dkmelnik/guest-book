<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PostsController@index');

Route::prefix('posts')->group(function () {
    Route::put('/', 'PostsController@send');
    Route::get('/', 'PostsController@getPosts')->name('posts');
});


/**
 * Чтобы сделать редирект тебе нужно роутам прописать имя, например ->name('index') или ->name('auth.post')
 * redirect()->route('posts');
 */

Route::get('/auth', 'AuthController@index');

Route::prefix('auth')->group(function () {
    Route::put('/', 'AuthController@auth');
});

Route::prefix('auth')->group(function () {
//    Route::get('/') TODO: Страница авторизации
//    Route::post('/') TODO: Действие авторизации
    Route::prefix('register')->group(function () {
//      Route::get('/') TODO: Регистрации
//      Route::post('/') TODO: Действие регистрации
    });
});

Route::get('/register', 'RegisterController@index');

Route::prefix('register')->group(function () {
    Route::put('/', 'RegisterController@register');
});
