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


Auth::routes();

/**----------------------------------
 **             FOLLOWERS
 *-----------------------------------
 *  All routes related to follow
 */


// GET - fresh followers count 
Route::get('/follow/{username}', "FollowsController@index")->name('follow.index');


// POST - new follower
Route::post('/follow/{username}', "FollowsController@store")->name('follow.store');




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
 **             POSTS
 *-----------------------------------
 *  All routes related to post
 */


// GET - list of posts
Route::get('/', 'PostController@index')->name('post.index');


// GET - form to create post
Route::get('/p/create', 'PostController@create')->name('post.create');


// POST - new post
Route::post("/p", "PostController@store")->name('post.store');


// GET - clicked post
Route::get('/p/{post}', 'PostController@show')->name('post.show');

