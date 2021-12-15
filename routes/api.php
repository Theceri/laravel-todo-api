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

// we are making this to work with the Check All button on the front end so that from the front end we get all the id's for the tasks that are checked, and then we can mass-update them on the database
// we are introducing a new uri, /todosCheckAll, and a corresponding updateAll method in the controller
Route::patch('/todosCheckAll', 'App\Http\Controllers\TodosController@updateAll');

Route::delete('/todos/{todo}', 'App\Http\Controllers\TodosController@destroy');

// we are making this to work with the Clear Completed button on the front end so that from the front end we get all the id's for the tasks that are checked, and then we can mass-delete them on the database
Route::delete('/todosDeleteCompleted', 'App\Http\Controllers\TodosController@destroyCompleted');