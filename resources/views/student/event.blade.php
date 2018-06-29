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
      @if (session('msg'))
        <div class="alert alert-success">
            {{ session('msg') }}
          </div>
      @endif
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
						@if (empty($req))
      					<form action="{{ route('RequestUrl') }}" method="POST">
      						{{ csrf_field() }}
      						<input type="hidden" value="{{ $id }}" name="id" required>
      						<button type="submit" class="btn btn-danger btn-lg btn-block">Request to join this Event</button>
      					</form>
      					@elseif ($req-> status == 0)
      					<h3>
      						<i>
      							Your request to join this event is pending for approval.
      							<br>This page will get refresh in <font color="red" id="count">15</font> seconds to again check the status of your request.
      						</i>
      					</h3>
      					<script>
      						window.onload = function()
      						{
      							var i = 15;
      							setInterval(function()
      							{
      								i--;
      								if(i>0)
      									document.getElementById("count").innerHTML = i;
      								else
      									location.reload();
      							},1000);
      						}
      					</script>
      					@else
      					
      					@endif
      				</center>
				</div>
			</div>
  		</div>
	</div>
</div>
@stop
