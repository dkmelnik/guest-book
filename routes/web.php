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

Route::get('/', 'PostsController@index')->name('index');

Route::prefix('posts')->group(function () {
    Route::put('/', 'PostsController@send');
    Route::get('/', 'PostsController@getPosts')->name('posts');
    Route::put('/delete', 'PostsController@deletePost');
});



Route::prefix('auth')->group(function () {
    Route::get('/', 'AuthController@index');
    Route::put('/', 'AuthController@auth');
    Route::post('/', 'AuthController@checkAuth');
    Route::get('/logout', 'AuthController@logout');
});



Route::prefix('register')->group(function () {
    Route::get('/', 'RegisterController@index');
    Route::put('/', 'RegisterController@register');
});
