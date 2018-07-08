@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<?php
$count = count($req);
?>
<div class="container">
	<div class="table-responsive">
		<table class="table table-striped table-bordered shadow text-center">
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
					<td>Allow Access</td><td>Name of Student</td><td>Admission No.</td><td>Roll No.</td>
				</tr>
				@for($i = 0 ; $i < $count ; $i++)
					@if($req[$i]['status'] == 0)
						<tr>
							<td><input type="checkbox" id="blankCheckbox" value="{{$req[$i]['userid']}}" aria-label="..."></td>
							<td>{{ $req[$i]['name'] }}</td>
							<td>{{ $req[$i]['admno'] }}</td>
							<td>{{ $req[$i]['rollno'] }}</td>
						</tr>
					@endif
				@endfor
			</tbody>
</div>
@stop
