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
        $request->start_time = date('Y-m-d h:i:s', strtotime($request->start_time));
        $request->end_time = date('Y-m-d h:i:s', strtotime($request->end_time));
                $this -> validate($request, [
                    'name' => 'required|max:100',
                    'description' => 'required|not_in:<br>',
                    'subject' => 'required|not_in:null',
                    'quizimage' => 'image|max:1000',
                    'start_time' => 'required|after:Current_Date_Time',
                    'end_time' => 'required|after:start_time',
                    'duration' => 'required|numeric|min:1',
                    'correct_mark' => 'required|numeric|min:0',
                    'wrong_mark' => 'required|numeric|max:0',
                    'display_ques' => 'required|numeric|min:1',
                    'othersubject' => 'sometimes|required',
                ], [
                    'not_in' => 'The :attribute field is required.'
                ]);

        $task = new Event;
        $task->name = $request->name;
        $task->description = $request->description;
        if (!is_null($request->othersubject)) {
            //Add new Subject to subject table
            $subject = new Subject;
            $subject->name = $request->othersubject;
            $subject->save();
            $task->subid = $subject->id;
        } else {
            $sub = Subject::select('id')->where('id', $request->subject)->first();
            if ($sub->count()) {
                $task->subid = $request->subject;
            } else {
                return back()->with(['msg' => 'The subject you are trying to add is invalid', 'class' => 'alert-danger'])->withInput($request->all);
            }
        }
        if ($request->hasFile('quizimage')) {
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

        $eventIDs = session('TeacherEvent');
        array_push($eventIDs, $task->id);
        session(['TeacherEvent' => $eventIDs]);

        return redirect('teacher/event/'.$task->id)->with(['msg' =>'Event added successfully', 'class' => 'alert-success']);
    }

    public function add(Request $request, $id)
    {
        $this -> validate(
            $request,
            [
                'question' => 'required|not_in:<br>',
                'quetype' => 'required|digits_between:0,1',
                'opt1' => 'required|not_in:<br>',
                'opt2' => 'required|not_in:<br>',
            ],
            [
                'not_in' => 'The :attribute field is required.',
            ]
        );
        
        $count = $request->count;
        $flag=0;
        for ($y=1; $y <= $count; $y++) {
            $opti = $request->input('option'.$y);
            if (!is_null($opti)) {
                $flag=1;
                break;
            }
        }
        if ($flag==0) {
            return back()->with(['msg' => 'Please select atleast 1 correct answer', 'class' => 'alert-danger'])->withInput($request->all);
        }
        
        $addque = new Queans;
        $addque->que = $request->question;
        $addque->eventid = $id;
        $addque->quetype = $request->quetype;
        $addque->save();
        
        for ($x=1; $x<=$count; $x++) {
            $option = new Option;
            $option->queid = $addque->id;
            $optans = $request->input('opt'.$x);
            if (!is_null($optans) && $optans != "<br>") {
                $option->ans = $optans;
                $opt = $request->input('option'.$x);
                if (is_null($opt)) {
                    $option->iscorrect = 0;
                } else {
                    $option->iscorrect = 1;
                }
                $option->save();
            }
        }
        return back()->with(['msg' =>'Question added successfully.', 'class' => 'alert-success']);
    }

    public function editEvent(Request $request, $id)
    {
        $event = Event::find($id);
        if ($event->count() == 0) {
            return back()->with(['msg' => 'The Event you are trying to edit does not exist.', 'class' => 'alert-danger'])->withInput($request->all);
        }
        $request->start_time = date('Y-m-d h:i:s', strtotime($request->start_time));
        $request->end_time = date('Y-m-d h:i:s', strtotime($request->end_time));
                $this -> validate($request, [
                    'name' => 'required|max:100',
                    'description' => 'required|not_in:<br>',
                    'subject' => 'required|not_in:null',
                    'quizimage' => 'image|max:1000',
                    'start_time' => 'required|after:Current_Date_Time',
                    'end_time' => 'required|after:start_time',
                    'duration' => 'required|numeric|min:1',
                    'correct_mark' => 'required|numeric|min:0',
                    'wrong_mark' => 'required|numeric|max:0',
                    'display_ques' => 'required|numeric|min:1',
                    'othersubject' => 'sometimes|required',
                ], [
                    'not_in' => 'The :attribute field is required.'
                ]);
                $event->name = $request->name;
                $event->description = $request->description;
        if (!is_null($request->othersubject)) {
            //Add new Subject to subject table
            $subject = new Subject;
            $subject->name = $request->othersubject;
            $subject->save();
            $event->subid = $subject->id;
        } else {
            $sub = Subject::select('id')->where('id', $request->subject)->first();
            if ($sub->count()) {
                $event->subid = $request->subject;
            } else {
                return back()->with(['msg' => 'The subject you are trying to add is invalid', 'class' => 'alert-danger'])->withInput($request->all);
            }
        }
        if ($request->hasFile('quizimage')) {
            $img = $request->file('quizimage');
            $path_parts = pathinfo($_FILES["quizimage"]["name"]);
            $image_path = $path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
            $request->quizimage->move(public_path('img'), $image_path);
            $event->img = 'img/'.$image_path;
        }
                $event->start = $request->start_time;
                $event->end = $request->end_time;
                $event->duration = $request->duration;
                $event->correctmark = $request->correct_mark;
                $event->wrongmark = $request->wrong_mark;
                $event->quedisplay = $request->display_ques;

                $event->save();
                return redirect('teacher')->with(['msg' =>'Event Edited Successfully', 'class' => 'alert-success']);
    }
    public function editQue(Request $request, $id, $qid)
    {
        $editque = Queans::find($qid);
        if ($editque->count() == 0) {
            return back()->with(['msg' => 'The question you are trying to edit does not exist.', 'class' => 'alert-danger'])->withInput($request->all);
        }
        $this -> validate($request, [
                    'question' => 'required|not_in:<br>',
                    'quetype' => 'required|digits_between:0,1',
                    ], [
                    'not_in' => 'The :attribute field is required.'
                    ]);
        $count = $request->count;
        $counter =0;
        for ($z=1; $z <= $count; $z++) {
            $optin = $request->input('opt'.$z);
            if (!is_null($optin) && $optin != "br") {
                $counter++;
            }
            if ($counter == 2) {
                break;
            }
        }
        if ($counter!=2) {
            return back()->with(['msg' => 'Please add atleast two options', 'class' => 'alert-danger'])->withInput($request->all);
        }

                $flag=0;
        for ($y=1; $y <= $count; $y++) {
            $opti = $request->input('option'.$y);
            if (!is_null($opti)) {
                $flag=1;
                break;
            }
        }
        if ($flag==0) {
            return back()->with(['msg' => 'Please select atleast 1 correct answer', 'class' => 'alert-danger'])->withInput($request->all);
        }

        $editque->que = $request->question;
        $editque->quetype = $request->quetype;
        $editque->save();
        $options = Option::where('queid', $qid)->delete();

        
                
        for ($x=1; $x<=$count; $x++) {
            $option = new Option;
            $option->queid = $qid;
            $optans = $request->input('opt'.$x);
            if (!is_null($optans) && $optans != "br") {
                $option->ans = $optans;
                $opt = $request->input('option'.$x);
                if (is_null($opt)) {
                    $option->iscorrect = 0;
                } else {
                    $option->iscorrect = 1;
                }
                $option->save();
            }
        }
                return back()->with(['msg' =>'Question edited successfuly', 'class' => 'alert-success']);
    }
    public function deleteQue(Request $request, $id, $qid)
    {
        $deleteque = Queans::find($qid)->delete();
        if ($deleteque->count() == 0) {
            return back()->with(['msg' => 'The question you are trying to delete does not exist.', 'class' => 'alert-danger'])->withInput($request->all);
        }
        $options = Option::where('queid', $qid)->delete();

        return back();
    }
    public function deleteEvent(Request $request, $id)
    {
        $event = Event::find($id);
        if ($event->count() == 0) {
            return back()->with(['msg' => 'The Event you are trying to delete does not exist.', 'class' => 'alert-danger'])->withInput($request->all);
        }
        $event->delete();
        return redirect('teacher')->with(['msg' =>'Event Deleted Successfully', 'class' => 'alert-success']);
    }
    public function accessEvent(Request $request)
    {
        $allowaccess = $request->input('access');
        if (!is_null($allowaccess)) {
            $req = Req::whereIn('userid', $allowaccess)->update(['status' => 1]);
        }
        return back();
    }
}
