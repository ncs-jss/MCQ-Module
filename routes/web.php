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

	Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

	Route::group(['middleware' => ['auth']], function ()
	{

		Route::group(['prefix' => '/student', 'middleware' => 'UserType:student'], function()
		{
			Route::group(['middleware' => ['EventPlay']], function ()
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
				});
			});
			Route::post('/ajax/event/req', 'AjaxController@event_req');
			Route::get('event/play/{queid}', 'EventPlayController@play');
			Route::post('/event/play/{queid}', 'EventPlayController@response');
			Route::post('/event/submit/{val?}', 'EventPlayController@submit');
		});

		Route::group(['prefix' => '/teacher', 'middleware' => 'UserType:teacher'], function()
		{
			Route::get('/', function ()
			{
				$events = App\Event::select('id','name','start','end','duration','quedisplay','isactive')->where('creator', Auth::id())->orderBy('id', 'desc');
				$eventarrey = $events->get()->toArray();
				$events = $events->paginate(9);
				$quecount = App\Queans::select('eventid',DB::raw('count(id) as total'))->whereIn('eventid',array_column($eventarrey, 'id'))->groupBy('eventid')->get()->toArray();
				return view('teacher.home', ['events' => $events, 'quecount' => $quecount]);
			});
			Route::get('/event/create', function ()
			{
				$subject = App\Subject::select('*')->orderBy('name' , 'asc')->get()->toArray();
		    	return view('teacher.create-event')->with('subject',$subject);
			})->name('teacherCreateEvent');
			Route::post('event/ques', 'EventController@create');
			Route::get('event/view/{id}', function($id){
				$event = App\Event::select('name','description','subid','img','start','end','duration','correctmark','wrongmark','quedisplay','isactive','creator')->where('id', $id)->first();
				$authe =Auth::id();
				$subject = App\Subject::select('*')->orderBy('name', 'asc')->get()->toArray();
				if($authe == $event->creator)
					return view('teacher.view-event',['event' =>$event, 'id'=>$id, 'subject'=>$subject]);
			});
			Route::get('event/edit/{id}', function($id){
				$event = App\Event::findOrFail($id);
				$subject = App\Subject::select('*')->get()->toArray();
				return view('teacher.create-event',['event' =>$event, 'id'=>$id, 'subject'=>$subject]);
			});
			Route::post('event/edit/{id}', 'EventController@editEvent');
			Route::get('event/launch/{id}', function($id){
				$quecount = App\Queans::where('eventid' , $id)->get()->count();
				$event = App\Event::select('quedisplay', 'isactive', 'id', 'name')->findOrFail($id);
				$req = App\Req::select('userid', 'status')->where('eventid', $id)->get()->toArray();
				$user = App\User::select('name', 'admno', 'rollno')->whereIn('id' , array_column($req, 'userid'))->get()->toArray();
				if($quecount >= $event->quedisplay){
					$event->isactive = 1;
					$event->save();
					return view('teacher.launched-event', ['request' => $req, 'user' => $user, 'event' => $event])
;				}
				else return back();
			});
			Route::get('event/{id}', function($id) {
				$event = App\Event::select('creator')->where('id', $id)->first();
				$authe =Auth::id();
				if($authe == $event->creator)
					return view('teacher.add-ques')->with('id',$id);
				else return back();
			});
			Route::post('event/delete/{id}', 'EventController@deleteEvent');
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
