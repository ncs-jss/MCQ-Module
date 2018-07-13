<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Queans;
use App\Option;
use Auth;
use App\Req;

class EventController extends Controller
{
    public function create(Request $request)
    {
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
			    ]
				,[
					'not_in' => 'The :attribute field is required.'
				]);

			    $task = new Event;
			    $task->name = $request->name;
			    $task->description = $request->description;
			    $task->subid = $request->subject;
			    $img = $request->quizimage;
			    if(!is_null($img)){
			    	$path_parts = pathinfo($_FILES["quizimage"]["name"]);
			    	$image_path = $path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
			    	$request->quizimage->move(public_path('img'), $image_path);
			    	$task->img = 'img/'.$image_path;
			    }
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
	public function add(Request $request, $id) {
				$this -> validate($request, [
					'question' => 'required|not_in:<br>',
					'quetype' => 'required',
					'opt1' => 'required|not_in:<br>',
					'opt2' => 'required|not_in:<br>',
					'opt3' => 'sometimes|not_in:<br>',
					'opt4' => 'sometimes|not_in:<br>',
					'opt5' => 'sometimes|not_in:<br>',
					// 'option' => 'required|array|min:1'
				]);
				
				$addque = new Queans;
				$addque->que = $request->question;
				$addque->eventid = $id;
				$addque->quetype = $request->quetype;
				$addque->save();

				$count = $request->count;
				$flag=0;
				for($y=1;$y <= $count; $y++){
					$opti = $request->input('option'.$y);
					if(!is_null($opti)){
						$flag=1;
						break;
					}
				}
				if($flag==0)
					return back()->with('Option', 'Please select atleast 1 correct answer');
				if($flag==0)
					return back()->with('Option', 'Please select atleast 1 correct answer');
				
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
				return back()->with('success','Question added successfully.');
	}
	public function editEvent(Request $request, $id){
		$event = Event::findOrFail($id);
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
				$event->name = $request->name;
			    $event->description = $request->description;
			    $event->subid = $request->subject;
			    $img = $request->quizimage;
			    if(!is_null($img))
			    	$event->img = $img;
			    $event->start = $request->start_time;
			    $event->end = $request->end_time;
			    $event->duration = $request->duration;
			    $event->correctmark = $request->correct_mark;
			    $event->wrongmark = $request->wrong_mark;
			    $event->quedisplay = $request->display_ques;

			    $event->save();
			    return redirect('teacher')->with('edit','Event Edited Successfully');
	}
	public function editQue(Request $request, $id, $qid){
		$editque = Queans::findOrFail($qid);
		$this -> validate($request, [
					'question' => 'required|not_in:<br>',
					'quetype' => 'required',
					// 'opt1' => 'required|not_in:<br>',
					// 'opt2' => 'required|not_in:<br>',
					// 'opt3' => 'sometimes|not_in:<br>',
					// 'opt4' => 'sometimes|not_in:<br>',
					// 'opt5' => 'sometimes|not_in:<br>',
				]);
		$count = $request->count;
				$flag=0;
				for($y=1;$y <= $count; $y++){
					$opti = $request->input('option'.$y);
					if(!is_null($opti)){
						$flag=1;
						break;
					}
				}
				if($flag==0)
					return back()->with('Option', 'Please select atleast 1 correct answer');

		$editque->que = $request->question;
		$editque->quetype = $request->quetype;
		$editque->save();
		$options = Option::where('queid', $qid)->delete();

		
				
				for($x=1; $x<=$count; $x++){
					$option = new Option;
					$option->queid = $qid;
					$optans = $request->input('opt'.$x);
					if(!is_null($optans) && $optans){
						$option->ans = $optans;
						$opt = $request->input('option'.$x);
						if(is_null($opt))
							$option->iscorrect = 0;
						else $option->iscorrect = 1;
						$option->save();
					}
				}
				return back()->with('success','Question edited successfuly');

	}
	public function deleteEvent(Request $request, $id){
		$event = Event::findOrFail($id);
		$event->delete();
		return redirect('teacher')->with('delete','Event Deleted Successfully');
	}
	public function accessEvent(Request $request){
		$allowaccess = $request->input('access');
		if(!is_null($allowaccess))
		$req = Req::whereIn('userid', $allowaccess)->update(['status' => 1]);
		return back(); 
	}
}
