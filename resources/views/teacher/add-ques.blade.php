@extends('layouts.default')
@section('css')
<style>
body {
  padding-top: 5rem;
  background-color: #e9ecef;
}
.bg-purple {
    background-color: #6f42c1;
}
</style>
@stop
@section('content')
<div class="container">
	<div class="panel-body">
        <!-- New Task Form -->
        <form action="#" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Task Name -->
            <div class="form-group">
                <label for="ques" class="col-sm-3 control-label">Question 1.</label>

                <div>
                    <textarea class="form-control" rows="5" id="ques" name="ques"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="opt1" class="col-sm-3 control-label">Option 1.</label>

               <div>
                    <textarea class="form-control col-sm-6" rows="5" id="opt1" name="opt1"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="opt2" class="col-sm-3 control-label">Option 2.</label>

               <div>
                    <textarea class="form-control col-sm-6" rows="5" id="opt2" name="opt2"></textarea>
                </div>
            </div>

            <div class="form-group" id="add">
                
            </div>
      
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <a class="anchor btn-outline-primary" href="#" id="btn1" style="text-decoration: none;"> <i class="fa fa-plus"></i> Add Option </a>
                </div>
            </div>
            <script>
            	var count = 3;
            	$("#btn1").click(function(){
            	$("#add").append('<label for="opt3" class="col-sm-3 control-label">Option '+count+'.</label> <div> <textarea class="form-control col-sm-6" rows="5" id="opt3" name="opt3"></textarea> </div>');
            	count++;
            	    });
            </script>

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
</div>
@stop

