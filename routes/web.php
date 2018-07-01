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
			Route::get('/event/{id}', function ($id)
			{
				$event = App\Event::select('name','description','img','duration','start','end','duration','correctmark','wrongmark','isactive')->where('id', $id)->first();
				if($event->isactive == 1 && $event->start <= date('Y-m-d H:i:s') && $event->end >= date('Y-m-d H:i:s'))
				{
					$req = App\Req::select('status')->where('userid', Auth::id())->where('eventid', $id)->first();
		    		return view('student.event', ['event' => $event, 'id' => $id, 'req' => $req]);
				}
		    	else
		    		return redirect('student');
			});
			Route::post('event/req', 'ReqController@join')->name('RequestUrl');
		});

		Route::group(['prefix' => '/teacher', 'middleware' => 'UserType:teacher'], function()
		{
			Route::get('/', function ()
			{
		    	return view('teacher.home');
			});
			Route::get('/event/create', function ()
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