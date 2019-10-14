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

/* ---------------------------------------------------
    Backend Routes 
---------------------------------------------------- */

Route::group(['middleware' => ['auth','is_admin'], 'prefix' => 'admin'], function () {
   
    Route::get('/', 'Backend\HomeController@index')->name('dashboard');

    Route::resource('articles','Backend\ArticlesController');


    // Route::get('user/create','UserController@create')->name('user.create');
    // Route::post('user/store','UserController@store')->name('user.store');
    // Route::put('user/{id}/update','UserController@update')->name('user.update');
    
});


Route::group(
[
	// 'prefix' => LaravelLocalization::setLocale(),
	// 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],
function()
{
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    
    Route::get('faq','Frontend\HomeController@faq')->name('frontend.faq.index');
    Route::get('terms','Frontend\HomeController@terms')->name('frontend.terms.index');
    Route::get('privacy','Frontend\HomeController@privacy')->name('frontend.privacy.index');

});

// Route::get('/home', 'HomeController@index');
