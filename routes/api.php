<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

/** Chat routes */
Route::group([
    'prefix' => 'chat',
    'middleware' => [
        'auth',
        'throttle:10,1'
    ]
],function () {
    Route::post('send', 'ChatController@send');
    Route::get('messages/{user_id}', 'ChatController@messages');
    Route::patch('read/{message_id}', 'ChatController@markAsRead');
});
