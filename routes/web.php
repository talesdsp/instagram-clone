<?php

use App\Mail\NewUserWelcomeMail;
use Illuminate\Support\Facades\Auth;
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

Route::get('/mail', function () {
  return new NewUserWelcomeMail();
});

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
 **             FAVORITES
 *-----------------------------------
 *  All routes related to follow
 */

Route::get('/fav', "FavoritesController@index")->name('favorite.getPost');
Route::post('/fav/{post}', "FavoritesController@store")->name('favorite.post');;

/**----------------------------------
 **             LIKES
 *-----------------------------------
 *  All routes related to follow
 */

Route::get('/like/c/{comment}', "LikesController@getComments")->name('like.getComment');
Route::post('/like/c/{comment}', "LikesController@comment")->name("like.comment");

Route::get('/like/p/{post}', "LikesController@getPosts")->name('like.getPost');
Route::post('/like/p/{post}', "LikesController@post")->name('like.post');


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
Route::put('/{username}', 'ProfileController@update')->name('profile.update');

/**----------------------------------
 **             POSTS
 *-----------------------------------
 *  All routes related to post
 */
Route::get('/', 'PostController@index')->name('post.index');

Route::get('/p/create', 'PostController@create')->name('post.create');

Route::post("/p", "PostController@store")->name('post.store');

Route::get('/p/{post}', 'PostController@show')->name('post.show');

Route::get('/p/{post}/edit', 'PostController@edit')->name('post.edit');

Route::patch('/p/{post}', 'PostController@update')->name('post.update');

Route::delete('/p/{post}', 'PostController@destroy')->name('post.destroy');

/**----------------------------------
 **             STORIES
 *-----------------------------------
 *  All routes related to stories
 */

Route::get('/s/create', 'StoryController@create')->name('story.create');

Route::post("/s", "StoryController@store")->name('story.store');

Route::get('/s/{story}', 'StoryController@show')->name('story.show');

Route::delete('/s/{story}', 'StoryController@destroy')->name('story.destroy');

/**----------------------------------
 **             USER_SEES_STORIES
 *-----------------------------------
 *  All routes related to stories
 */

Route::get('/watch/{story}', 'WatchController@getWatched')->name('watch.getStory');

Route::post('/watch/{story}', 'WatchController@story')->name('watch.story');

/**----------------------------------
 **             Comments
 *-----------------------------------
 *  All routes related to post
 */
Route::get('/c', 'CommentController@index')->name('comment.index');

Route::post("/c", "CommentController@store")->name('comment.store');

Route::get('/c/{comment}', 'CommentController@show')->name('comment.show');

Route::patch('/c/{comment}', 'CommentController@update')->name('comment.update');

Route::delete('/c/{comment}', 'CommentController@destroy')->name('comment.destroy');
