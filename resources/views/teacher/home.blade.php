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
	<div class="card">
		<div class="card-header  text-white bg-purple shadow">
			<h2 class="float-left">Quiz</h2>
			<a class="anchor btn-success btn-lg float-right" href="{{ route('teacherCreateEvent') }}" style="text-decoration: none;"> <i class="fa fa-plus"></i> Create New Quiz</a>
		</div>
		<div class="card-body">
			<?php $i = 0 ?>
			@foreach ($events as $event)
				<?php $i++ ?>
				@if ($i==1 || $i==4 || $i==7)
    			<div class="card-deck">
    			@endif
  					<div class="card text-white bg-success
  					 animated pulse shadow">
  					<div class="card-header">
      						<h3>{{ $event->name }}</h3>
      				</div>
      				<div class="card-body">
      					<table class="table table-borderless table-sm">
                    		<tbody>
      							<tr>
      								<td>Start: </td><td> {{ date('d M Y, g:i a',strtotime($event->start)) }}</td>
      							</tr>
      							<tr>
      								<td>Close: </td><td> {{ date('d M Y, g:i a',strtotime($event->end)) }}</td>
      							</tr>
      							<tr>
      								<td>Duration: </td><td> {{ sprintf("%02d",intdiv($event->duration, 60)).':'. sprintf("%02d",($event->duration % 60)) }}</td>
      							</tr>
                 			 </tbody>
      					</table>
    				</div>

                   	<div><a href="#" class="btn btn-primary float-left" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Add Questions</a><a href="{{url('teacher/event/launch/'.$event->id)}}" class="btn btn-primary float-right disabled" role="button" aria-pressed="true">Launch Event</a></div>
  					</div>
  					{{$count}};
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
