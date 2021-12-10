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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// remember, with Laravel 8, you need to be explicit, as in 'App\Http\Controllers\TodosController@index', and not just 'TodosController@index' (https://stackoverflow.com/questions/63807930/target-class-controller-does-not-exist-laravel-8)
Route::get('/todos', 'App\Http\Controllers\TodosController@index');

Route::post('/todos', 'App\Http\Controllers\TodosController@store');
Route::patch('/todos/{todo}', 'App\Http\Controllers\TodosController@update');
Route::delete('/todos/{todo}', 'App\Http\Controllers\TodosController@destroy');