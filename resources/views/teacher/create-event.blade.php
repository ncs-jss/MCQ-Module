@extends('layouts.default')
@section('css')
<style>
body {
  padding-top: 5rem;
  background-color: #e9ecef;
}
</style>
@stop
@section('content')
<div class="row" >
	<div class="col-md-3 col-sm-3 col-xs-12"></div>
	<div class="col-md-6 col-sm-6 col-xs-12">
        <!-- New Event Form -->
        <form action="ques" method="POST">
            {{ csrf_field() }}

            <!-- Task Name -->
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
                            <strong>{{ $errors->first('description') }}</strong>
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
                          <option selected value="0">Choose Subject</option>
                          <option value="1">Data Structure</option>
                          <option value="2">Operating System</option>
                          <option value="3">Microprocessor</option>
                        </select>
                </div>
            </div>
            <div class="form-group">
                <label for="quiz-image" class="control-label">Image</label>
                    @if ($errors->has('quiz-image'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('quiz-image') }}</strong>
                        </div>
                    @endif
                <div>
                    <input type="file" class="form-control-file" id="quiz-image" aria-describedby="fileHelp" name="quiz-image">
                        <small id="fileHelp" class="form-text text-muted">Choose a quiz-image to upload otherwise leave it. </small>
                </div>
            </div>
            <div class="form-group">
                <label for="start-time" class="control-label">Start Date and time</label>

                <div>
                    <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="start_time" name="start_time" required>
                </div>
            </div>
            <div class="form-group">
                <label for="end-time" class="control-label">End Date and time</label>

                <div>
                    <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="end_time" name="end_time" required>
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


            <!-- Add Task Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-plus"></i> Add Task
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12"></div>
  </div>
@stop
   
   
