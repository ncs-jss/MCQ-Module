@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
    @if($errors->any())
        <div class="alert alert-danger">
        <strong>There is/are errors in {{ implode(', ', $errors->keys()) }} feilds</strong>
        </div>
    @endif
  <div class="card">
    <div class="card-header text-white bg-purple shadow">
      <h2>
            @if(isset($id))
                Edit Event
            @else
                Add Event
            @endif
      </h2>
    </div>
        <div class="card-body">
            @php
                $sub = array_column($subject, 'name','id'); 
            @endphp
    
            @if(isset($id))
                <form action="{{url('teacher/event/edit/'.$id)}}" method="POST" enctype="multipart/form-data">
            @else
                <form action="ques" method="POST" enctype="multipart/form-data">
            @endif
        
            {{ csrf_field() }}
            <!-- Event Name -->
                    <div class="form-group">
                        <label for="name" class="control-label">Name/Title <font color="red">*</font></label>
                        @if ($errors->has('name'))
                            <div class="alert alert-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="@if(isset($id)){{$event->name}}@else{{old('name')}}@endif" required>
                    </div>
                
                    <div class="form-group">
                        <label for="description" class="control-label">Description <font color="red">*</font></label>
                        @if ($errors->has('description'))
                            <div class="alert alert-danger">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" rows="5" id="description" name="description">@if(isset($id)){{$event->description}}@else{{ old('description') }}@endif</textarea>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="control-label">Subject <font color="red">*</font></label>
                        @if ($errors->has('subject'))
                            <div class="alert alert-danger">
                                {{ $errors->first('subject') }}
                            </div>
                        @endif
                        <select name="subject" id="subject" class="custom-select mb-3 {{ $errors->has('subject') ? ' is-invalid' : '' }}" required>
                            <option selected @if(isset($id)) value="{{$event->subid}}" @else value="0" disabled @endif>@if(isset($id)) {{$sub[$event->subid]}} @else Choose Subject @endif</option>
                            @foreach($sub as $sid => $subname) {
                            <option value="{{$sid}}">{{$subname}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quizimage" class="control-label">Image (Max: 1MB)</label>
                        @if ($errors->has('quizimage'))
                            <div class="alert alert-danger">
                                @foreach ($errors->get('quizimage') as $valimg)
                                    <li>{{$valimg}}</li>
                                @endforeach
                            </div>
                        @endif
                        <input type="file" class="form-control-file {{ $errors->has('quizimage') ? ' is-invalid' : '' }}" accept="image/*" id="quizimage" aria-describedby="fileHelp" name="quizimage" @if(isset($id)) value="{{$event->img}}" @endif>
                    <small id="fileHelp" class="form-text text-muted">Choose a quiz-image to upload otherwise leave it. </small>
                    </div>

                    <div class="form-group">
                        <label for="start_time" class="control-label">Start Date and time <font color="red">*</font> (DD-MM-YYYY HH:MM AM/PM)</label>
                        @if ($errors->has('start_time'))
                            <div class="alert alert-danger">
                                @foreach ($errors->get('start_time') as $st)
                                    <li>{{$st}}</li>
                                @endforeach
                            </div>
                        @endif
                        <input class="form-control {{ $errors->has('start_time') ? ' is-invalid' : '' }}" type="datetime-local" value="@if(isset($id)){{date('Y-m-d\TH:i', strtotime($event->start)).':00'}}@else{{old('start_time',date('Y-m-d').'T'.date('H:i', strtotime('+1 hour')).':00')}}@endif" id="start_time" name="start_time" required>
                    </div>

                    <div class="form-group">
                        <label for="end_time" class="control-label">End Date and time <font color="red">*</font> (DD-MM-YYYY HH:MM AM/PM)</label>
                        @if ($errors->has('end_time'))
                            <div class="alert alert-danger">
                            @foreach ($errors->get('end_time') as $et)
                                <li>{{$et}}</li>
                            @endforeach
                        </div>
                        @endif
                        <input class="form-control {{ $errors->has('end_time') ? ' is-invalid' : '' }}" type="datetime-local" value="@if(isset($id)){{date('Y-m-d\TH:i', strtotime($event->end)).':00'}}@else{{old('end_time',date('Y-m-d', strtotime("+1 day")).'T'.date('H:i', strtotime('+1 hour')).':00')}}@endif" id="end_time" name="end_time" required>
                    </div>

                    <div class="form-group">
                        <label for="duration" class="control-label">Duration <font color="red">*</font> (Number of minutes)</label>
                        @if ($errors->has('duration'))
                            <div class="alert alert-danger">
                                {{ $errors->first('duration') }}
                        </div>
                        @endif
                        <input class="form-control {{ $errors->has('duration') ? ' is-invalid' : '' }}" type="number" @if(isset($id)) value="{{$event->duration}}" @else value=30 @endif id="duration" name="duration" required>
                    </div>

                    <div class="form-group">
                        <label for="correct_mark" class="control-label">Correct Mark <font color="red">*</font></label>
                        @if ($errors->has('correctmark'))
                            <div class="alert alert-danger">
                            {{ $errors->first('correctmark') }}
                            </div>
                        @endif
                        <input class="form-control {{ $errors->has('correctmark') ? ' is-invalid' : '' }}" type="number" @if(isset($id)) value="{{$event->correctmark}}" @else value={{old('correctmark','5')}} @endif id="correct_mark" name="correct_mark" required>
                    </div>
                    <div class="form-group">
                        <label for="wrong_mark" class="control-label">Wrong Mark <font color="red">*</font> (Number less then or equal to 0)</label>
                        @if ($errors->has('wrongmark'))
                            <div class="alert alert-danger">
                                {{ $errors->first('wrongmark') }}
                            </div>
                        @endif
                        <input class="form-control {{ $errors->has('wrongmark') ? ' is-invalid' : '' }}" type="number" @if(isset($id)) value="{{$event->wrongmark}}" @else value={{old('wrongmark','-1')}} @endif id="wrong_mark" name="wrong_mark" required>
                    </div>
                    <div class="form-group">
                        <label for="display_ques" class="control-label">No. of Questions <font color="red">*</font></label>
                        @if ($errors->has('quedisplay'))
                            <div class="alert alert-danger">
                                {{ $errors->first('quedisplay') }}
                            </div>
                        @endif
                        <input class="form-control {{ $errors->has('quedisplay') ? ' is-invalid' : '' }}" type="number" @if(isset($id)) value="{{$event->quedisplay}}" @else value={{old('quedisplay','30')}} @endif id="display_ques" name="display_ques" required>
                    </div>

                    <input type="hidden" name="Current_Date_Time" id="Current_Date_Time" value="{{date("Y-m-d H:i:s")}}">

            <!-- Add Event Button -->
                    <div class="form-group">
                        <button type="submit" id="btn2" class="btn btn-success btn-lg btn-block">
                            @if(isset($id))
                                Save Event
                            @else
                                <i class="fa fa-plus"></i> Add Event
                            @endif
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>
@stop
