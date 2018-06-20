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

Route::group(['middleware' => ['web']], function ()
{
	Route::get('/', function ()
	{
    	return view('home');
	})->name('login');

	Route::post('login', 'InfoConnectApiController@login')->name('LoginUrl');

	Route::get('/logout', 'InfoConnectApiController@logout')->name('LogoutinUrl');

	Route::group(['middleware' => ['auth']], function ()
	{

		Route::group(['prefix' => '/student'], function()
		{
			Route::get('/', function ()
			{
		    	//return view('home');
		    	dd("Student Dashboard");
			});
		});

		Route::group(['prefix' => '/teacher'], function()
		{
			Route::get('/', function ()
			{
		    	//return view('home');
		    	dd("Teacher Dashboard");
			});
		});

		Route::group(['prefix' => '/society'], function()
		{
			Route::get('/', function ()
			{
		    	return view('student/home');
		    	// dd("Society Dashboard");
			});
		});

	});
});
