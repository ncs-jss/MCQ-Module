@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
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
				<div class="col-sm-3">
					<center>
						<img class="rounded border border-dark shadow" src="{{ url($event->img) }}" width="200px">
            <br>
            <br>
					</center>
				</div>
				<div class="col-sm-9">
					{!! $event->description !!}
					<br>
					<br>
					<div class="table-responsive">
		      			<table class="table table-striped table-bordered shadow">
		      				<tbody>
			      				<tr>
			      					<td>Duration (HH:MM): </td><td> {{ sprintf("%02d",intdiv($event->duration, 60)).':'. sprintf("%02d",($event->duration % 60)) }}</td>
			      				</tr>
                    <tr>
                      <td>Questions: </td><td> {{ $event->quedisplay }}</td>
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
					<center id="data">
          @if (Auth::check())
						@if (empty($req))
                <form action="{{ url('student/event/'.$id.'/req') }}" method="POST">
      						{{ csrf_field() }}
      						<input type="hidden" value="{{ $id }}" name="id" required>
      						<button type="submit" class="btn btn-danger btn-lg btn-block">Request to join this Event</button>
      					</form>
      			@elseif ($req->status == 0)
                <div class="alert alert-primary" role="alert" id="Alert">
        					<h5>
        							Your request to join this event is pending for approval.
        							<br>This status of your request will be again check in <font color="red" id="count">15</font> seconds.
        					</h5>
                </div>

      					<script>
      						window.onload = function()
      						{
      							var i = 15;
      							var check = setInterval(test,1000);
                    function test()
      							{
      								i--;
      								if(i>0)
      									document.getElementById("count").innerHTML = i;
      								else
                      {
                          $.post("{{ url('student/ajax/event/req') }}",
                          {
                              "id": "{{ $id }}",
                              "_token": "{{ csrf_token() }}"
                          },
                          function(data, status){
                            data = jQuery.parseJSON(data);
                              if(data.status == 1)
                              {
                                $("#Alert").hide();
                                $("#Joinbutton").show();
                                clearInterval(check);
                              }
                              else
                              {
                                i = 15;
                              }
                          });
                      }
      							}
      						};
      					</script>
                  <button type="button" class="btn btn-success btn-lg btn-block" style="display:none" id="Joinbutton" data-toggle="modal" data-target="#EventJoin" data-whatever="@fat">Start this Event</button>
      			@elseif ($req->status == 1)
                  <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#EventJoin" data-whatever="@fat">Start this Event</button>
            @elseif ($req->status == 2)
                <div class="alert alert-success" role="alert">
                  <h5>
                      Your had successfully played this event.
                  </h5>
                </div>
      			@endif
          @else
            <a href="{{ url('/'.$id) }}" class="btn btn-success btn-lg btn-block">Logon and access this Event</a>
          @endif
      		</center>
				</div>
			</div>
  	</div>
	</div>
</div>
@if (!empty($req))
<div class="modal fade shadow" id="EventJoin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <center>
          <h5>Please note that this action is irreversible and timer once start can not be reset.<br>Are you confirm that you really want to start this event ? </h5>
                <form action="{{ url('student/event/'.$id.'/join') }}" method="POST">
                  {{ csrf_field() }}
                  <input type="hidden" value="{{ $id }}" name="id" required>
        <button type="submit" class="btn btn-success">Yes, start event</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No, not now</button>
                </form>
        </center>
      </div>
    </div>
  </div>
</div>
@endif
@stop
