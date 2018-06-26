<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;

class EventController extends Controller
{
    //
    public function create(Request $request) {
			    $this -> validate($request, [
			        'name' => 'required|max:255',
			        'description' => 'required',
			        'subject' => 'required|not_in:0',
			        'quiz-image' => 'image|mimes:jpg,png|max:1000',
			        'start_time' => 'required',
			        'end_time' => 'required',
			        'duration' => 'required',
			        'correct_mark' => 'required',
			        'wrong_mark' => 'required',
			        'display_ques' => 'required',
			    ]);

			    $task = new Event;
			    $task->name = $request->name;
			    $task->description = $request->description;
			    $task->subid = $request->subject;
			    $task->start = $request->start_time;
			    $task->end = $request->end_time;
			    $task->duration = $request->duration;
			    $task->correctmark = $request->correct_mark;
			    $task->wrongmark = $request->wrong_mark;
			    $task->quedisplay = $request->display_ques;
			    $task->creator = 1;

			    $task->save();

			    return view('teacher.add-ques');
			}
}
