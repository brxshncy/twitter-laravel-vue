<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('home','TwitterController@tweetFeed');
Route::get('tweets','TwitterController@mountFeeds');
Route::post('home','TwitterController@addTweet');
Route::get('likee','TwitterController@getLikes');
Route::post('like','TwitterController@likeTweet');
Route::get('logout','TwitterController@logout');
Route::post('reply','TwitterController@reply');
Route::get('tweet-content/{tweet_id}','TwitterController@tweetContent');
Route::get('retweet','TwitterController@retweet');
Route::post('retweet','TwitterController@retweet');
Route::get('profile/{user_id}','TwitterController@profile');
Route::get('profile_info/{user_id}','TwitterController@profileInfo');
Route::put('profile_info/{user_id}','TwitterController@profileInfo');
Route::get('twitterUsers/{user_id}','UserController@showUsers');