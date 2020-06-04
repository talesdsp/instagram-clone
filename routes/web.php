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




/**----------------------------------
 **             PROFILE
 *-----------------------------------
 *  All routes related to profile page
 */

 
// GET - user's profile page aka `dashboard`
Route::get('/{username}', 'ProfileController@show')->name('profile.show');


// GET - form to edit bio
Route::get('/{username}/edit', 'ProfileController@edit')->name('profile.edit');


// PATCH - updated bio
Route::patch('/{username}', 'ProfileController@update')->name('profile.update'); 




/**----------------------------------
 **             POST
 *-----------------------------------
 *  All routes related to post
 */


// GET - form to create post
Route::get('/p/create', 'PostController@create')->name('post.create');


// POST - new post
Route::post("/p", "PostController@store")->name('post.store');


// GET - clicked post
Route::get('/p/{post_id}', 'PostController@show')->name('post.show');

