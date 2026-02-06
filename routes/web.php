<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Broadcast;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Registers /broadcasting/auth for private channels
Broadcast::routes(['middleware' => ['auth:api']]);


Route::get('/echo-test', function () {
    return view('echo-test');
});
