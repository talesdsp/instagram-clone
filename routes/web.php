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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



/** ---------------------------------|
 *                                   |
 *              PROFILE              |
 *                                   |
 *  ---------------------------------|
 */


/**
 * GET - user's profile page aka `dashboard`
 */
Route::get('/{username}', 'ProfileController@show')->name('profile.show');

/**
 * GET - form to edit bio
 */
Route::get('/{username}/edit', 'ProfileController@edit')->name('profile.edit');

/**
 * PATCH - updated bio
 */
Route::patch('/{username}', 'ProfileController@update')->name('profile.update');



/** ---------------------------------|
 *                                   |
 *                POST               |
 *                                   |
 *  ---------------------------------|
 */

/**
 * GET - form to create post
 */
Route::get('/p/create', 'PostController@create')->name('post.create');

/**
 * POST - new post
 */
Route::post("/p", "PostController@store")->name('post.store');

/**
 * GET - Show clicked post
 */
Route::get('/p/{post}', 'PostController@show')->name('post.show');

