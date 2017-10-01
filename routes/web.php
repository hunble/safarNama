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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/


Route::get('/','PagesController@index');
Route::get('/about','PagesController@about');
Route::get('/services','PagesController@services');



Route::resource('posts','PostsController');
Route::resource('comments','CommentsController');
Route::resource('users','UsersController');
Route::resource('cloudinaryRes','CloudinaryController');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
