@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
@if (session('delete'))
  <div class="alert alert-success">
    {{ session('delete') }}
  </div>
@endif
<div class="container">
	<div class="card">
		<div class="card-header  text-white bg-purple shadow">
			<h2 class="float-left">Quiz</h2>
			<a class="anchor btn-success btn-lg float-right" href="{{ route('teacherCreateEvent') }}" style="text-decoration: none;"> <i class="fa fa-plus"></i> Create New Quiz</a>
		</div>
		<div class="card-body">
			<?php $i = 0 ?>
			@foreach ($events as $event)
				<?php $i++;
             $count = array_column($quecount, 'total','eventid');
             $count =  $count[$event->id];
        ?>
				@if ($i==1 || $i==4 || $i==7)
    			<div class="card-deck">
    		@endif
  			<div class="card text-white animated pulse shadow 
          @if($count >= $event->quedisplay)
            bg-warning 
          @else bg-danger
          @endif" id="cardbg">
  				<a href="{{url('teacher/event/view/'.$event->id)}}" class="card-header text-capitalize" style="text-decoration: none;">
      			<h3>{{ $event->name }}</h3>
      		</a>
      		<div class="card-body">
      			<table class="table table-borderless table-sm">
              <tbody>
      					<tr>
      						<td>Start: </td><td> {{ date('d M Y, g:i a',strtotime($event->start)) }}</td>
      					</tr>
                <tr>
                  <td>display: </td><td>{{$event->quedisplay}}</td>
                </tr>
                <tr>
      						<td>Close: </td><td> {{ date('d M Y, g:i a',strtotime($event->end)) }}</td>
      					</tr>
                <tr>
                  <td>Questions</td><td>{{$count}}</td>
                </tr>
      					<tr>
      						<td>Duration: </td><td> {{ sprintf("%02d",intdiv($event->duration, 60)).':'. sprintf("%02d",($event->duration % 60)) }}</td>
      					</tr>
              </tbody>
      			</table>
    			</div>
          <div>
            <a href="{{url('teacher/event/'.$event->id)}}" class="btn btn-primary float-left" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Add Questions</a><a href="" id ="launch" class="btn btn-primary float-right 
            @if ($count < $event->quedisplay)
            disabled"@endif role="button" aria-pressed="true">Launch Event</a>
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
