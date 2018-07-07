@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
	<div class="table-responsive">
		<table class="table table-striped table-bordered shadow">
			<div class="card-header text-white bg-purple shadow text-capitalize text-center">
				<h2>{{$event->name}}</h2>
			</div>
			<br>
			<div>
			<thead>
				<h5>Interested Students for the Event</h5>
			</thead>
			<tbody>
				<tr>
					<td>Name</td><td>Admission No.</td><td>Roll No.</td>
				</tr>
				@foreach($user as $row) 
				  <tr>
				  @foreach($row as $cell) 
				     <td>{{$cell}}</td>
				  @endforeach
				  </tr>
				@endforeach
			</tbody>
</div>
@stop
