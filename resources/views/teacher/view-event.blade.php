@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
    @include('includes.msg')
    <div class="card animated fadeIn">
        <div class="card-header text-white bg-purple shadow text-capitalize">
            <h2 class="float-left">{{ $event->name }}</h2>
            @if($event->isactive == 0)
                <form method="post" action="{{custom_url('teacher/event/delete/'.$id)}}">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-lg float-right" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash-alt"></i> Delete</button>
                </form>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="container" style="margin-top:4rem;">
                        <img class="rounded border border-dark shadow" src="{{ custom_url($event->img) }}" style="width:200px;">
                    </div>
                </div>
                <div class="col-sm-9 text-capitalize">
                    <div style="margin: auto;">
                        <h5><b>Description:</b></h5>{!! $event->description !!}
                    </div>

                    <div class="table-responsive">
                          <table class="table table-striped table-bordered shadow">
                              <tbody>
                                  <tr>
                                      <td>Subject: </td><td> {{ $subject }}</td>
                                  </tr>
                                  <tr>
                                      <td>Start Time: </td><td><?php $date = strtotime($event->start);echo date("D j F Y H".":"."i".":"."s" ,$date);?></td>
                                  </tr>
                                  <tr>
                                      <td>End Time: </td><td><?php $date = strtotime($event->end);echo date("D j F Y H".":"."i".":"."s" ,$date);?></td>
                                  </tr>
                                  <tr>
                                      <td>Duration: </td><td> {{ sprintf("%02d",intdiv($event->duration, 60)).':'. sprintf("%02d",($event->duration % 60)) }}</td>
                                  </tr>
                                  <tr>
                                      <td>Dispaly Questions: </td><td> {{ $event->quedisplay }}</td>
                                  </tr>
                                  <tr>
                                      <td>Questions Added: </td><td> {{ $quecount }}</td>
                                  </tr>
                                  <tr>
                                      <td>Marks on correct answer: </td><td> {{ $event->correctmark }}</td>
                                  </tr>
                                  <tr>
                                      <td>Marks on wrong answer: </td><td> {{ $event->wrongmark }}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                </div>
            </div>
        </div>
        <div style="margin-top: 1rem;" class="card-footer">
            @if($event->end > date("Y-m-d H:i:s"))
                @if($event->isactive == 0)
                    <a href="{{custom_url('teacher/event/edit/'.$id)}}" class="btn btn-primary btn-lg float-left" role="button" aria-pressed="true"><i class="fa fa-edit"></i> Edit Event</a>
                    <button type="button" class="btn btn-success btn-lg float-right" data-toggle="modal" data-target="#eventLaunchModal">
                          Launch event
                        </button>
                @else
                    <a href="{{custom_url('teacher/event/launch/'.$id)}}" id ="launch" class="btn btn-success btn-lg btn-block 
                    @if ($quecount < $event->quedisplay)
                        disabled
                    @endif
                    " role="button" aria-pressed="true">View Requests</a>
                @endif
            @else
                <a href="{{custom_url('teacher/event/'.$id.'/result')}}" id ="viewresult" class="btn btn-success btn-lg btn-block" role="button" aria-pressed="true">View Result</a>
            @endif
        </div>
    </div>
</div>

@if ($quecount >= $event->quedisplay)
<!-- Modal -->
<div class="modal fade" id="eventLaunchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="{{ custom_url('teacher/event/launch/'.$id) }}" method="post">
      <div class="modal-header text-white bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Do you want to autoallow participants to join the quiz event?
        <br>
          {{ csrf_field() }}
        <div class="form-group custom-control custom-checkbox mb-3">
            <input class="custom-control-input" type="checkbox" value="1" id="auto_access" name="auto_access">
            <label class="custom-control-label" for="auto_access">Yes</label>
          </div>
        Once you launch the event then you will not able to edit it, nor you can you add, edit or delete questions.<br>
        <strong>Are you sure that you really want to launch this event ?</strong> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Yes, Launch</button>
      </div>
       </form>
    </div>
  </div>
</div>
@else
<!-- Modal -->
<div class="modal fade" id="eventLaunchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">Add More Questions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        You had set <strong>{{ $event->quedisplay }}</strong> question to display for this event but added <strong>{{ $quecount }}</strong> questions only, to launch this event add more questions or edit this event to reset the value for question to display.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{custom_url('teacher/event/'.$id)}}" class="btn btn-success">Add Question</a>
      </div>
    </div>
  </div>
</div>
@endif
@stop
