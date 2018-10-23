@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ custom_url('assets/css/panel.css') }}">
@stop
@section('content')
<form id="myForm" action="{{ custom_url('student/event/submit') }}" method="POST">
  {{ csrf_field() }}
  <input type="hidden" value="{{ $queid }}" name="curid">
<div class="container">
@include('includes.msg')
<div class="row p-3">
<div class="col-sm-3">
  <div class="card shadow">
    <div class="card-body text-white bg-dark">
      <center><h3 id="cd"></h3></center>
  </div>
  </div>
  <br>
  <div class="card shadow">
    <div class="card-body">
      <center>
      @for ($i=1; $i<=count(session('que')); $i++)
        <button style="width: 40px;" type="submit" formaction="{{ custom_url('student/event/play/'.$i) }}" class="btn
        @if (session('submit')[$i-1]  == 0)
          @if ($i == $queid)
           btn-outline-secondary
          @else
            btn-secondary
          @endif
        @elseif (session('submit')[$i-1]  == 1)
          @if ($i == $queid)
           btn-outline-warning
          @else
            btn-warning
          @endif
        @else
          @if ($i == $queid)
           btn-outline-primary
          @else
            btn-primary
          @endif
        @endif
        ">{{ $i }}</button> 
        @if ($i%4==0)
          <br>
          <br>
        @endif
      @endfor
    </center>
    </div>
  </div>
  </div>
  
  <div class="col-sm-9">
  <div class="card shadow">
    <div class="card-body">
      <h4><span class="badge badge-secondary">Q. {{ $queid }}</span> {!! session('que')[$queid-1]['que'] !!}</h4>
      </div>
  <ul class="list-group list-group-flush">
    @php
      $quetype = session('que')[$queid-1]['quetype'];

      $response = explode(',', session('response')[$queid-1]);

      $keys = array_keys(array_column(session('options'),'queid'),session('que')[$queid-1]['id']);
      $end = strtotime(session('start')." + ".session('duration')." minute");
      $end = date('Y-m-d H:i:s', $end);
    @endphp
    @for($i=0; $i<count($keys); $i++)
    <li class="list-group-item">
      <label class="lbl">
      @if ($quetype==0)
        <input type="radio" name="opt[]" value="{{ session('options')[$keys[$i]]['id'] }}"
        @if (in_array(session('options')[$keys[$i]]['id'], $response))
          checked="checked"
        @endif
        >
      <span class="checkmark rb"></span>
      @else
        <input type="checkbox" name="opt[]" value="{{ session('options')[$keys[$i]]['id'] }}"
        @if (in_array(session('options')[$keys[$i]]['id'], $response))
          checked="checked"
        @endif
        >
      <span class="checkmark cb"></span>
      @endif
      {!! session('options')[$keys[$i]]['ans'] !!}
    </label>
    </li>
    @endfor
    <li class="list-group-item">
      <center>
        @php
          if($queid == count(session('que')))
            $i = 1;
          else
            $i = $queid + 1;
        @endphp
        <button type="submit" class="btn btn-success btn-lg active" formaction="{{ custom_url('student/event/play/'.$i) }}">Save & Next Question</button>
        <button type="button" class="btn btn-warning btn-lg active" data-toggle="modal" data-target="#EventSubmit" data-whatever="@fat">Submit & Exit Quiz</button>
      </center>
    </li>
  </ul>
  </div>
</div>
</div>
</div>
<div class="modal fade shadow" id="EventSubmit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <center>
          <h5>Please note that this action is irreversible.<br>Are you confirm that you really want to submit your response and exit this quiz ? </h5>
        <button type="submit" class="btn btn-success">Yes, Save & Exit this quiz</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </center>
      </div>
    </div>
  </div>
</div>
<div class="modal fade shadow" id="EventLogout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <center>
          <h5>Please note that this action is irreversible.<br>Are you confirm that you really want submit your response and logout ? </h5>
        <button type="submit" class="btn btn-success" formaction="{{ custom_url('student/event/submit/logout') }}">Yes, Save & Logout</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </center>
      </div>
    </div>
  </div>
</div>
</form>
<script>
  function pad(num, size) {
    var s = num+"";
    while (s.length < size) s = "0" + s;
    return s;
}
// Set the date we're counting down to
var countDownDate = new Date("{{ $end }}").getTime();
  // Get todays date and time
  var now = new Date("{{ date('Y-m-d H:i:s') }}").getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

window.onload = function()
{
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("cd").innerHTML = pad(hours,2) + ":"
  + pad(minutes,2) + ":" + pad(seconds,2);
};

// Update the count down every 1 second
var x = setInterval(function() {
  
  distance = distance - 1000;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("cd").innerHTML = pad(hours,2) + ":"
  + pad(minutes,2) + ":" + pad(seconds,2);

  // If the count down is finished, write some text 
  if (distance < 0) {
    document.getElementById("myForm").submit();
  }
}, 1000);
</script>
@stop
