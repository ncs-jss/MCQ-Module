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
	<div class="card animated fadeInUp">
		<div class="card-header text-white bg-purple shadow">
			<h2>{{ $event->name }}</h2>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-3">
					<center>
						<img class="rounded border border-dark shadow" src="{{ url($event->img) }}" width="200px" height="200px">
					</center>
				</div>
				<div class="col-9">
					{{ $event->description }}
					<br>
					<br>
					<div class="table-responsive">
		      			<table class="table table-striped table-bordered shadow">
		      				<tbody>
			      				<tr>
			      					<td>Duration: </td><td> {{ sprintf("%02d",intdiv($event->duration, 60)).':'. sprintf("%02d",($event->duration % 60)) }}</td>
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
      				<br>
					<center>
      					<form action="" method="POST">
      						{{ csrf_field() }}
      						<input type="hidden" value="{{ $id }}" name="id" required>
      						<button type="submit" class="btn btn-danger btn-lg btn-block">Request to join this Event</button>
      					</form>
      				</center>
				</div>
			</div>
  		</div>
	</div>
</div>
@stop
