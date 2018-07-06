@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="row" >
	<div class="col-md-3 col-sm-3 col-xs-12"></div>
    <?php
    $sub = array_column($subject, 'name','id'); 
    ?>
	<div class="col-md-6 col-sm-6 col-xs-12">
        <!-- New Event Form -->
        <form action="ques" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <!-- Event Name -->
            <div class="form-group">
                <label for="name" class="control-label">Name</label>
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                    <div>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
            </div>
                
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                    @if ($errors->has('description'))
                        <div class="alert alert-danger">
                            @foreach ($errors->get('description') as $desc)
                                <strong>{{$desc}}</strong>
                            @endforeach
                        </div>
                    @endif
                <div>
                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="subject" class="control-label">Subject</label>
                @if ($errors->has('subject'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('subject') }}</strong>
                    </div>
                @endif
                <div>
                    <select name="subject" class="custom-select mb-3" required>
                          <option selected value="0" disabled>Choose Subject</option>
                          @foreach($sub as $id => $subname) {
                          <option value="{{$id}}">{{$subname}}</option>
                          @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="quizimage" class="control-label">Image</label>
                @if ($errors->has('quizimage'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('quizimage') as $valimg)
                            <strong>{{$valimg}}</strong>
                        @endforeach
                    </div>
                @endif
                <div>
                    <input type="file" class="form-control-file" id="quizimage" aria-describedby="fileHelp" name="quizimage">
                        <small id="fileHelp" class="form-text text-muted">Choose a quiz-image to upload otherwise leave it. </small>
                </div>
            </div>

            <div class="form-group">
                <label for="start_time" class="control-label">Start Date and time</label>
                 @if ($errors->has('start_time'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('start_time') as $st)
                            <strong>{{$st}}</strong>
                        @endforeach
                        </div>
                @endif
                <div>
                    <input class="form-control" type="datetime-local" value="2018-06-19T13:00:00" id="start_time" name="start_time" required>
                </div>
            </div>

            <div class="form-group">
                <label for="end-time" class="control-label">End Date and time</label>
                @if ($errors->has('end_time'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('end_time') as $et)
                            <strong>{{$et}}</strong>
                        @endforeach
                    </div>
                @endif
                <div>
                    <input class="form-control" type="datetime-local" value="2018-06-19T13:30:00" id="end_time" name="end_time" required>
                </div>
            </div>

            <div class="form-group">
                <label for="duration" class="control-label">Duration</label>

                <div>
                    <input class="form-control" type="number" value=30 id="duration" name="duration" required>
                </div>
            </div>

            <div class="form-group">
                <label for="correct-mark" class="control-label">Correct Mark</label>

                <div>
                    <input class="form-control" type="number" value=5 id="correct_mark" name="correct_mark" required>
                </div>
            </div>
            <div class="form-group">
                <label for="wrong-mark" class="control-label">Wrong Mark</label>

                <div>
                    <input class="form-control" type="number" value=-1 id="wrong_mark" name="wrong_mark" required>
                </div>
            </div>
            <div class="form-group">
                <label for="display-ques" class="control-label">No. of Questions</label>

                <div>
                    <input class="form-control" type="number" value=30 id="display_ques" name="display_ques" required>
                </div>
            </div>

            <input type="hidden" name="Current_Date_Time" id="Current_Date_Time" value="{{date("m-d-Y H:i:s")}}">


            <!-- Add Event Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" id="btn2" class="btn btn-success">
                        <i class="fa fa-plus"></i> Add Event
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12"></div>
  </div>
@stop
   
   
