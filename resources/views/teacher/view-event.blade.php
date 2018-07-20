@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
	<div class="card animated fadeIn">
		<div class="card-header text-white bg-purple shadow text-capitalize">
			<h2 class="float-left">{{ $event->name }}</h2>
			<form method="post" action="{{url('teacher/event/delete/'.$id)}}">
			    {{ csrf_field() }}
			    <button type="submit" class="btn btn-danger btn-lg float-right" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash-alt"></i> Delete</button>
			</form>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-sm-3">
					<div class="container" style="margin-top:4rem;">
						<img class="rounded border border-dark shadow" src="{{ url($event->img) }}" style="height: 200px; width:200px;">
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
					<a href="{{url('teacher/event/edit/'.$id)}}" class="btn btn-primary btn-lg float-left" role="button" aria-pressed="true"><i class="fa fa-edit"></i> Edit Event</a>
					<a href="{{url('teacher/event/launch/'.$id)}}" class="btn btn-success btn-lg float-right
					@if ($quecount < $event->quedisplay)
						disabled
					@endif
					" role="button" aria-pressed="true">Launch event</a>
				@else
					<a href="{{url('teacher/event/launch/'.$id)}}" id ="launch" class="btn btn-success btn-lg btn-block 
		        	@if ($quecount < $event->quedisplay)
		        		disabled
		        	@endif
		        	" role="button" aria-pressed="true">View Requests</a>
	        	@endif
	        @else
	        	<a href="{{url('teacher/event/'.$id.'/result')}}" id ="viewresult" class="btn btn-success btn-lg btn-block" role="button" aria-pressed="true">View Result</a>
        	@endif
		</div>
	</div>
</div>
@stop
