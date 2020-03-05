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

Route::get('/', 'TasksController@index')->name('index');
Route::get('/create', 'TasksController@form')->name('form');

Route::put('/edit', 'TasksController@edit')->name('edit');

Route::post('/taskdata', 'TasksController@taskData')->name('taskData');
Route::post('/comment/create', 'CommentsController@create')->name('commentCreate');
Route::post('/create', 'TasksController@create')->name('taskCreate');

Route::resource('/tasks', 'TasksResourceController')->only([
    'index'
]);
