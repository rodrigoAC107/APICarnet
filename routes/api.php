<?php

use Illuminate\Http\Request;

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

Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
Route::resource('licenses', 'License\LicenseController', ['except' => ['create', 'edit']]);
Route::resource('items', 'Item\ItemController', ['except' => ['create', 'edit']]);
Route::resource('people', 'Person\PersonController', ['except' => ['create', 'edit']]);
