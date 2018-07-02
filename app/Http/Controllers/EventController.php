<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Queans;
use App\Option;
use Auth;

class EventController extends Controller
{
    //
    public function create(Request $request) {
			    $this -> validate($request, [
			        'name' => 'required|max:100',
			        'description' => 'required|not_in:<br>',
			        'subject' => 'required|not_in:0',
			        'quizimage' => 'image|max:1000',
			        'start_time' => 'required|after:Current_Date_Time',
			        'end_time' => 'required|after:start_time',
			        'duration' => 'required|numeric|not_in:0',
			        'correct_mark' => 'required|numeric|not_in:0',
			        'wrong_mark' => 'required|numeric',
			        'display_ques' => 'required|numeric|not_in:0',
			    ]);

			    $task = new Event;
			    $task->name = $request->name;
			    $task->description = $request->description;
			    $task->subid = $request->subject;
			    $task->img = $request->quizimage;
			    $task->start = $request->start_time;
			    $task->end = $request->end_time;
			    $task->duration = $request->duration;
			    $task->correctmark = $request->correct_mark;
			    $task->wrongmark = $request->wrong_mark;
			    $task->quedisplay = $request->display_ques;
			    $task->creator = auth::id();
			    $task->isactive = '0';

			    $task->save();

			    return redirect('teacher/event/'.$task->id);
			}
	public function add(Request $request) {
				// $this -> validate($request, [
				// 	'ques' => 'required|not_in:<br>',
				// 	'opt1' => 'required|not_in:<br>',
				// 	'opt2' => 'required|not_in:<br>',
				// 	'opt3' => 'sometimes|not_in:<br>',
				// 	'opt4' => 'sometimes|not_in:<br>',
				// 	'opt5' => 'sometimes|not_in:<br>',
				// ]);
				

				$addque = new Queans;
				$addque->que = $request->ques;
				$addque->eventid = $request->route('id');
				$addque->save();


				$count = $request->count;
				for($x=1; $x<=$count; $x++){
					$option = new Option;
					$option->queid = $addque->id;
					$option->ans = $request->input('opt'.$x);
					$opt = $request->input('option'.$x);
					if(is_null($opt))
						$option->iscorrect = 0;
					else $option->iscorrect = 1;
					$option->save();
				}

				return back();
	}
}
