@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12 ">
            <div class="card">
                <div class="card-header text-white bg-purple shadow">
                    <h5>Add Question</h5>
                </div>
                <div class="card-body">

                    <!-- New Add-Question Form -->
                    <form action="{{$id}}" method="POST" class="was-validated">

                        {{ csrf_field() }}
                        @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                        @endif
                        @if (session('Option'))
                                <div class="alert alert-danger">
                                    {{ session('Option') }}
                                </div>
                        @endif

                        <div class="float-right"><font color="red"><i>* = Required</i></font></div>
                        <br><br>
                        <!-- Question -->
                        <div class="form-group">
                            <label for="question" class="col-sm-3 control-label">Question <font color="red">*</font></label>
                            <select name="quetype" class="form-control form-control-sm col-sm-2 col-md-2 float-right" required>
                                <option selected value="0">Single Correct</option>
                                <option value="1">Multiple Correct</option>
                            </select>
                            @if ($errors->has('question'))
                                <div class="alert alert-danger">
                                    @foreach ($errors->get('question') as $ques)
                                        <strong>{{$ques}}</strong>
                                    @endforeach
                                </div>
                                @endif
                            <div>
                                <textarea class="form-control" rows="5" id="question" name="question">{{old('question')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group custom-control custom-checkbox mb-3">
                            <input @if(!empty(old('option1'))) checked @endif class="custom-control-input" type="checkbox" value="1" id="option1" name="option1">
                            <label class="custom-control-label" for="option1">Option 1 <font color="red">*</font></label>
                            @if ($errors->has('opt1'))
                                <div class="alert alert-danger">
                                    @foreach ($errors->get('opt1') as $opt)
                                            <strong>{{$opt}}</strong>
                                    @endforeach
                                    </div>
                            @endif

                            <div>
                                <textarea class="form-control col-sm-7" rows="5" id="opt1" name="opt1">{{old('opt1')}}</textarea>
                            </div>
                        </div>
                    
                        <div class="form-group custom-control custom-checkbox mb-3">
                            <input @if(!empty(old('option2'))) checked @endif class="custom-control-input" type="checkbox" value="1" id="option2" name="option2">
                            <label class="custom-control-label" for="option2">Option 2 <font color="red">*</font></label>
                            @if ($errors->has('opt2'))
                                <div class="alert alert-danger">
                                    @foreach ($errors->get('opt2') as $opt)
                                            <strong>{{$opt}}</strong>
                                    @endforeach
                                </div>
                            @endif

                           <div>
                                <textarea class="form-control col-sm-7" rows="5" id="opt2" name="opt2">{{old('opt2')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group custom-control custom-checkbox mb-3" id="add">
                            <input type="hidden" name="count" value="2">
                            
                        </div>
          
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="button" class="anchor btn-outline-primary" id="btn1" style="text-decoration: none;">
                                    <i class="fa fa-plus"></i> Add Option
                                </button>
                            </div>
                        </div>
                        <script>
                        	var count = 3;
                        	$("#btn1").click(function(){
                        	$("#add").append('<input type="hidden" name="count" value="'+count+'"><input class="form-check-input" type="checkbox" value="1" id="option'+count+'" name="option'+count+'"><label for="opt" class="col-sm-3 control-label">Option '+count+'.</label> <div> <textarea class="form-control col-sm-7" rows="5" id="opt'+count+'" name="opt'+count+'"></textarea> </div>');
                                var te =  new nicEditor({fullPanel : true}).panelInstance('opt'+count);
                        	count++;
                        	    });
                        </script>

                        <!-- Add Question Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Add Question
                                </button>
                            </div>
                        </div>
                        <center>
                            <a class="btn btn-success " href="{{url('/')}}" id="btn2" style="text-decoration: none;"> Submit </a>
                        </center>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 ">
            <div class="card">
                <div class="card-header text-white bg-purple shadow text-center">
                    <h5>Questions</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered shadow text-center bg-info table-dark table-small">
                        <thead>
                            <tr>
                                <td>Content</td><td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queans as $row)
                                <tr><td>{!! $row['que'] !!}</td><td><a href="{{ url('teacher/event/'.$id.'/que/'.$row['id']) }}" class="btn btn-primary btn-sm">Edit</a><form method="POST" action="{{ url('teacher/event/'.$id.'/delete/que/'.$row['id']) }}"> {{ csrf_field() }} <button class="btn btn-danger btn-sm" type="submit">Delete</button> </form></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>                   
    </div>
</div>
@stop
