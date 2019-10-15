<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('/', 'KeyController@index')->name('home');
Route::get('/create', 'KeyController@create')->name('create');
Route::post('/store', 'KeyController@store')->name('store');
Route::get('/edit/{id}', 'KeyController@edit')->name('edit');
Route::put('/update/{id}', 'KeyController@update')->name('update');
Route::delete('/delete/{id}', 'KeyController@destroy')->name('delete');

// Route::resource('keys','HomeController');
