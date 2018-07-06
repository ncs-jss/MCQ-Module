@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
	<div class="card">
		<div class="card-header text-white bg-purple shadow">
			<h2>Quiz</h2>
		</div>
		<div class="card-body">
			<?php $i = 0 ?>
			@foreach ($events as $event)
				<?php $i++ ?>
				@if ($i==1 || $i==4 || $i==7)
    			<div class="card-deck">
    			@endif
  					<div class="card 
  					@if ($event->start > date('Y-m-d H:i:s') && $event->end > date('Y-m-d H:i:s'))
  						text-white bg-warning
  					@elseif ($event->end < date('Y-m-d H:i:s'))
  						text-white bg-dark
  					@else
  						text-white bg-success
  					@endif
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
                  @if ($event->start <= date('Y-m-d H:i:s') && $event->end > date('Y-m-d H:i:s'))
                    <a href="student/event/{{ $event->id }}"><div class="bg-primary card-footer"><center><strong class="text-white">Start Quiz</strong></center></div></a>
                  @elseif ($event->start > date('Y-m-d H:i:s'))
                    <div class="bg-danger card-footer"><center><strong class="text-white">Comming Soon</strong></center></div>
                  @else
                    <div class="card-footer"><center><strong class="text-white">Closed</strong></center></div>
                  @endif
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
</div>
@stop
