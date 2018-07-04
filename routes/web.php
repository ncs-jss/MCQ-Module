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
				$events = App\Event::select('id','name','start','end','duration')->where('isactive', '1')->orderBy('id', 'desc')->paginate(9);
		    	return view('student.home', ['events' => $events]);
			});
			Route::group(['middleware' => ['EventAccess']], function ()
			{
				Route::get('/event/{id}', function ($id)
				{
					$event = App\Event::select('name','description','img','duration','correctmark','wrongmark')->where('id', $id)->first();
					$req = App\Req::select('status')->where('userid', Auth::id())->where('eventid', $id)->first();
			    	return view('student.event', ['event' => $event, 'id' => $id, 'req' => $req]);
				});
				Route::post('event/{id}/req', 'EventPlayController@req');
				Route::post('event/{id}/join', 'EventPlayController@join');
				Route::get('event/{id}/play/{queid}', 'EventPlayController@play');
				Route::post('/event/{id}/play/{queid}', 'EventPlayController@play');
			});
		});

		Route::group(['prefix' => '/teacher', 'middleware' => 'UserType:teacher'], function()
		{
			Route::get('/', function ()
			{
				$events = App\Event::select('id','name','start','end','duration')->where('creator', Auth::id())->orderBy('id', 'desc')->paginate(9);
		    	return view('teacher.home', ['events' => $events]);
			});
			Route::get('/event/launch/{id}', function($id))
			Route::get('/event/create', function ()
			{
				$que = App\Queans::get()->where('eventid', $id)->count();
				return return view('teacher.home', ['count' => $que]);
			}
			{
		    	return view('teacher.create-event');
			})->name('teacherCreateEvent');
			Route::post('event/ques', 'EventController@create');
			Route::get('event/{id}', function($id) {
				$event = App\Event::select('creator')->where('id', $id)->first();
				$authe =Auth::id();
				if($authe == $event->creator)
				return view('teacher.add-ques')->with('id',$id);
				else return back();
			});
			Route::post('event/{id}', 'EventController@add');
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