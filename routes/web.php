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

Auth::routes();
Route::redirect('/', '/hits');

Route::get('hits/bulk', 'HitController@bulk')->name('hits.bulk')->middleware('auth');
Route::post('hits/bulk/generate', 'HitController@bulkGenerate')->name('hits.bulkGenerate')->middleware('auth');

Route::resource('users', 'UserController')->middleware('auth');
Route::resource('hits', 'HitController')->middleware('auth');





