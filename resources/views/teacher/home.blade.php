@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ custom_url('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
    @include('includes.msg')

  <div class="card">
    <div class="card-header text-white shadow bg-purple">
      <h2 class="float-left">Quizzes</h2>
      <a class="anchor btn-success btn-lg float-right" href="{{ route('teacherCreateEvent') }}" style="text-decoration: none;"> <i class="fa fa-plus"></i> Create New Quiz</a>
    </div>
    <div class="card-body">
      @if($events->isEmpty())
      <h1 class="text-gray-dark text-center">No Quiz to show</h1>
        <blockquote class="blockquote text-center">
          <p class="mb-0">There are no quiz created by you. Click on "Create New Quiz" to add new quiz.</p>
        </blockquote>
      @endif
      <?php $i = 0 ?>
      @foreach ($events as $event)
        @php
              $i++;
             $count = array_column($quecount, 'total','eventid');
             if(array_key_exists($event->id,$count))
                $count =  $count[$event->id];
              else
                $count = 0;
        @endphp
        @if ($i==1 || $i==4 || $i==7)
          <div class="card-deck">
        @endif
        <div class="card text-white animated pulse shadow
          @if($event->end > date("Y-m-d H:i:s")) 
          @if($count >= $event->quedisplay && $event->isactive == 0)
            bg-warning
          @elseif($count >= $event->quedisplay && $event->isactive == 1)
          bg-success 
          @else bg-danger
          @endif @else bg-secondary" @endif  id="cardbg">
          <a href="{{custom_url('teacher/event/view/'.$event->id)}}" class="card-header text-capitalize" style="text-decoration: none;">
            <h3 class="text-center text-capitalize text-white">{{ $event->name }}</h3>
          </a>
          <div class="card-body">
            <table class="table table-borderless table-sm">
              <tbody>
                <tr>
                  <td><b>Start:</b> </td><td> {{ date('d M Y, g:i a',strtotime($event->start)) }}</td>
                </tr>
                <tr>
                  <td><b>Close:</b> </td><td> {{ date('d M Y, g:i a',strtotime($event->end)) }}</td>
                </tr>
                <tr>
                  <td><b>Que Display:</b> </td><td>{{$event->quedisplay}}</td>
                </tr>
                <tr>
                  <td><b>Que Added:</b> </td><td>{{$count}}</td>
                </tr>
                <tr>
                  <td><b>Duration:</b> </td><td> {{ sprintf("%02d",intdiv($event->duration, 60)).':'. sprintf("%02d",($event->duration % 60)) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            @if($event->end > date("Y-m-d H:i:s"))
              @if ($event->isactive == 0)
                <a href="{{custom_url('teacher/event/'.$event->id)}}" class="btn btn-primary float-left" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Add Questions</a><a href="{{custom_url('teacher/event/launch/'.$event->id)}}" id ="launch" class="btn btn-primary float-right 
                @if ($count < $event->quedisplay)
                  disabled btn-secondary"
                @endif
                role="button" aria-pressed="true">Launch Event</a>
              @else
                <a href="{{custom_url('teacher/event/launch/'.$event->id)}}" id ="launch" class="btn btn-warning btn-block btn-lg 
                  @if ($count < $event->quedisplay)
                    disabled"
                  @endif
                role="button" aria-pressed="true">View Requests</a>
              @endif
            @else
              <a href="{{custom_url('teacher/event/'.$event->id.'/result')}}" class="btn btn-success btn-lg btn-block" role="button" aria-pressed="true">View Result</a>
            @endif
          </div>
        </div>
        @if ($i==3 || $i==6 || $i==9)
          </div>
          <br>
        @endif
      @endforeach
      @if( $events->count()%3 != 0)
        @for ($i=1; $i<=(3-($events->count()%3)); $i++)
          <div style="border:0px" class="card"></div>
        @endfor
        </div>
        <br>
      @endif

      <center>
        {{ $events->links() }}
      </center>
  </div>
</div>
@stop
