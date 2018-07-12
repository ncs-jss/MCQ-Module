@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-white bg-purple shadow">
            <h2>Edit Question</h2>
        </div>
        <div class="card-body">
        <!-- New Edit-Question Form -->
             <form action="{{url('teacher/event/'.$id.'/edit/que/'.$qid)}}" method="POST">
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
            <!-- Question -->
            <div class="form-group">
                <label for="question" class="col-sm-3 control-label">Question.</label>
                <select name="quetype" class="form-control form-control-sm col-sm-2 col-md-2 float-right" required>
                    @if($que->quetype == 0)
                    <option selected value="0">Single Correct</option>
                    <option value="1">Multiple Correct</option>
                    @elseif($que->quetype == 1)
                    <option selected value="1">Multiple Correct</option>
                    <option value="0">Single Correct</option>
                    @endif
                </select>
                @if ($errors->has('question'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('question') as $ques)
                            <strong>{{$ques}}</strong>
                        @endforeach
                    </div>
                    @endif
                <div>
                    <textarea class="form-control" rows="5" id="question" name="question">{{$que->que}}</textarea>
                </div>
            </div>
            <?php $i =0?>
            @foreach($options as $option)
            <?php $i++ ?>
            <div class="con">
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="1" id="option{{$i}}" name="option{{$i}}"
                 @if($option['iscorrect']==1)
                 checked
                 @endif>
                <label for="opt1" class="col-sm-3 control-label">Option {{$i}}.</label>
                @if ($errors->has('opt1'))
                    <div class="alert alert-danger">
                        @foreach ($errors->get('opt1') as $opt)
                                <strong>{{$opt}}</strong>
                        @endforeach
                    </div>
                @endif
                <div>
                    <textarea class="form-control col-sm-7" rows="5" id="opt{{$i}}" name="opt{{$i}}">{{$option['ans']}}</textarea>
                </div>
                <span class="rem" ><a href="javascript:void(0);" class="anchor btn-outline-danger"><i class="fa fa-trash"></i>Delete option</a></span>
            </div>
        </div>
            @endforeach

            <div class="contents">
                <input type="hidden" name="count" value="{{$i}}">
                <input type="hidden" name="counter" value="{{$i}}">
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <a href="javascript:void(0);" class="add anchor btn-outline-primary" style="text-decoration: none;"><i class="fa fa-plus"></i> Add Option</a>
                </div>
            </div>
            <script>
                var count={{$i}};
            $(document).ready(function() {
                $(".add").click(function() {
                    count++;
                    $('<div class="form-group form-check"><input type="hidden" name="count" value="'+count+'"><input class="form-check-input" type="checkbox" value="1" name="option'+count+'"><label for="opt'+count+'" class="col-sm-3 control-label">Option.</label> <textarea class="form-control col-sm-7" name="opt'+count+'" id="opt'+count+'" rows="5"></textarea><span class="rem" ><a href="javascript:void(0);" class="anchor btn-outline-danger" ><i class="fa fa-trash"></i>Delete option</span></div>').appendTo(".contents");
                    var te =  new nicEditor({fullPanel : true}).panelInstance('opt'+count);
                });
                $('.contents').on('click', '.rem', function() {
                    $(this).parent("div").remove();
                });
                $('.con').on('click', '.rem', function() {
                    $(this).parent("div").remove();
                });

            });
        </script>
            <!-- Add Question Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-edit"></i> Edit Question
                    </button>
                </div>
            </div>
        </form>
       <div>
        <center>
                    <a class="btn btn-primary " href="{{url('teacher/event/'.$id)}}" id="btn2" style="text-decoration: none;"><i class ="fa fa-plus"></i> Add More Questions </a>
                </center>
        </div>
    </div>
        </div>   
</div>               
@stop

