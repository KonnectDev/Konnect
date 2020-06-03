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


// api/users
Route::post('users', 'UserController@index');

// api/user
Route::post('user/{id}', 'UserController@show');
Route::post('user/{id}/{string}', 'UserController@showDetailed');
Route::post('user/login', 'UserController@login');
Route::post('user/register', 'UserController@register');

// api/user/friend
Route::post('user/friend/add', 'UserFriendController@add');
Route::post('user/friend/remove', 'UserFriendController@remove');
Route::post('user/friend/request/accept', 'UserFriendController@accept');
Route::post('user/friend/request/decline', 'UserFriendController@decline');

// api/user/friends
Route::post('user/friends/{id}', 'UserFriendController@userFriends');
Route::post('user/friends', 'UserFriendController@friends');
Route::post('user/friends/{string}', 'UserFriendController@friends');
