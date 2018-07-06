@extends('layouts.default')
@section('css')
<style>
body {
  padding-top: 5rem;
  padding-bottom: 3rem;
  background-color: #e9ecef;
}
.bg-purple {
    background-color: #6f42c1;
}
</style>
@stop
@section('content')
<div class="container">
	<?php
	$sub = array_column($subject,'name', 'id');
	?>
	<div class="card animated fadeIn">
		<div class="card-header text-white bg-purple shadow text-capitalize text-center">
			<h2>{{ $event->name }}</h2>
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
						<h5><b>Description:  </b>{{ $event->description }}</h5>
					</div>

					<div class="table-responsive">
		      			<table class="table table-striped table-bordered shadow">
		      				<tbody>
		      					<tr>
			      					<td>Subject: </td><td> {{ $sub[$event->subid] }}</td>
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
				<div style="margin-top: 1rem;" class="container">
					<a href="{{url('teacher/event/edit/'.$id)}}" class="btn btn-primary btn-lg float-left" role="button" aria-pressed="true"><i class="fa fa-edit"></i> Edit Event</a><a href="{{url('teacher/event/edit/'.$event->id)}}" class="btn btn-success btn-lg float-right" role="button" aria-pressed="true">Launch event</a>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
