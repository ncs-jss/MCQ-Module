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
			Route::get('profile/{val?}',function($val = NULL){
				return view('student.profile', ['val' => $val]);
			});
			Route::post('profile','ProfileController@edit');
			Route::group(['middleware' => ['EventPlay','ProfileUpdate']], function ()
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
			Route::post('event/allowaccess', 'EventController@accessEvent');
			Route::get('event/launch/{id}', function($id){
				$quecount = App\Queans::where('eventid' , $id)->get()->count();
				$event = App\Event::select('quedisplay', 'isactive', 'id', 'name')->findOrFail($id);
				$req = App\Req::join('user', 'req.userid', '=', 'user.id')->select('userid', 'name',  'admno' ,  'rollno', 'status') ->where('eventid', $id)->get()->toArray();
				if($quecount >= $event->quedisplay){
					$event->isactive = 1;
					$event->save();
					return view('teacher.launched-event', ['req' => $req, 'event' => $event]);				}
					else return back();
			});
			Route::get('event/{id}', function($id) {
				$event = App\Event::select('creator')->where('id', $id)->first();
				$queans = App\Queans::select('id','que')->where('eventid', $id)->get()->toArray();
				$authe =Auth::id();
				if($authe == $event->creator)
					return view('teacher.add-ques', ['id'=>$id, 'queans'=>$queans]);
				else return back();
			});
			Route::get('event/{id}/que/{qid}', function($id, $qid){
				$que = App\Queans::findOrFail($qid);
				$options = App\Option::select('id', 'ans', 'iscorrect')->where('queid', $qid)->get()->toArray();
				return view('teacher.edit-ques', ['id'=>$id ,'options' => $options, 'qid' => $qid, 'que' => $que]);
			});
			// Route::post('event/{id}/edit/que/{qid}', 'EventController@editque');
			Route::post('event/delete/{id}', 'EventController@deleteEvent');
			Route::post('event/{id}/edit/que/{qid}', 'EventController@editQue');
			Route::post('event/{id}', 'EventController@add');
			Route::post('/ajax/event/req', 'AjaxController@event_reqs');
			Route::get('result/{id}', 'ResultController@view');
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
