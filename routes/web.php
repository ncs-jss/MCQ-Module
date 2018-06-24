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
    	return view('pages.home');
	})->middleware('RedirectIfAuthenticated')->name('login');

	Route::post('login', 'InfoConnectApiController@login')->name('LoginUrl');

	Route::get('/logout', 'InfoConnectApiController@logout')->name('logout');

	Route::group(['middleware' => ['auth']], function ()
	{

		Route::group(['prefix' => '/student', 'middleware' => 'UserType:student'], function()
		{
			Route::get('/', function ()
			{
				$events = App\Event::paginate(9);
		    	return view('student.home', ['events' => $events]);
			});
			Route::get('/event/{id}', function ()
			{
				dd("This is event page");
		    	// return view('student.event',);
			});
		});

		Route::group(['prefix' => '/teacher', 'middleware' => 'UserType:teacher'], function()
		{
			Route::get('/', function ()
			{
		    	return view('teacher.home');
			});
		});

		Route::group(['prefix' => '/society', 'middleware' => 'UserType:society'], function()
		{
			Route::get('/', function ()
			{
		    	return view('society.home');
			});
		});

	});
});