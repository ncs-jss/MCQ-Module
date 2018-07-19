<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Queans;
use App\Option;
use App\Subject;
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
			        'newsubject' => 'sometimes|not_in:subject',
			    ]
				,[
					'not_in' => 'The :attribute field is required.'
				]);

			    $task = new Event;
			    $task->name = $request->name;
			    $task->description = $request->description;
			    if(!is_null($request->newsubject)){
			    	//Add new Subject to subject table
			    	$subject = new Subject;
			    	$subject->name = $request->newsubject;
			    	$subject->save();
			    	$subject = Subject::select('id')->where('name', $request->newsubject)->first();
			    	$task->subid = $subject->id;
			    }
			    else
			    	$task->subid = $request->subject;
			    // $img = $request->quizimage;
			    if($request->hasFile('quizimage')){
			    	$img = $request->file('quizimage');
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

			    return redirect('teacher/event/'.$task->id)->with('Event','Event added successfully');
			}
	public function add(Request $request, $id) {
				$this -> validate($request, [
					'question' => 'required|not_in:<br>',
					'quetype' => 'required|digits_between:0,1',
					'opt1' => 'required|not_in:<br>',
					'opt2' => 'required|not_in:<br>',
					]
					,[
					'not_in' => 'The :attribute field is required.',
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
					return back()->with('Option', 'Please select atleast 1 correct answer')->withInput($request->all);
				if($flag==0)
					return back()->with('Option', 'Please select atleast 1 correct answer')->withInput($request->all);
				
				$addque = new Queans;
				$addque->que = $request->question;
				$addque->eventid = $id;
				$addque->quetype = $request->quetype;
				$addque->save();
				
				for($x=1; $x<=$count; $x++){
					$option = new Option;
					$option->queid = $addque->id;
					$optans = $request->input('opt'.$x);
					if(!is_null($optans) && $optans != "<br>"){
						$option->ans = $optans;
						$opt = $request->input('option'.$x);
						if(is_null($opt))
							$option->iscorrect = 0;
						else $option->iscorrect = 1;
						$option->save();
					}
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
			    ]
			    ,[
					'not_in' => 'The :attribute field is required.'
					
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
					'quetype' => 'required|digits_between:0,1',
					]
					,[
					'not_in' => 'The :attribute field is required.'
				]);
		$count = $request->count;
		$counter =0;
		for($z=1;$z <= $count; $z++){
			$optin = $request->input('opt'.$z);
			if(!is_null($optin) && $optin != "br")
				$counter++;
			if($counter == 2)
				break;
		}
		if($counter!=2)
			return back()->with('Options', 'Please add atleast two options')->withInput($request->all);

				$flag=0;
				for($y=1;$y <= $count; $y++){
					$opti = $request->input('option'.$y);
					if(!is_null($opti)){
						$flag=1;
						break;
					}
				}
				if($flag==0)
					return back()->with('Option', 'Please select atleast 1 correct answer')->withInput($request->all);

		$editque->que = $request->question;
		$editque->quetype = $request->quetype;
		$editque->save();
		$options = Option::where('queid', $qid)->delete();

		
				
				for($x=1; $x<=$count; $x++){
					$option = new Option;
					$option->queid = $qid;
					$optans = $request->input('opt'.$x);
					if(!is_null($optans) && $optans != "br"){
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
	public function deleteQue(Request $request, $id, $qid){
		$deleteque = Queans::findOrFail($qid)->delete();
		$options = Option::where('queid', $qid)->delete();

		return back();
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

