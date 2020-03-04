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
Route::post('/taskdata', 'TasksController@taskData')->name('taskData');
Route::put('/updatetask', 'TasksController@taskData')->name('taskData');
