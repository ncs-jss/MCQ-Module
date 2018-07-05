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

/* The container */
.lbl {
    display: block;
    position: relative;
    padding-left: 35px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default radio button */
.lbl input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
}

.rb {
    border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.lbl:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.lbl input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.lbl input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.lbl .rb:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}

.lbl .cb:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>
@stop
@section('content')
<form id="myForm" action="{{ url('student/event/submit') }}" method="POST">
  {{ csrf_field() }}
  <input type="hidden" value="{{ $queid }}" name="curid">
<div class="container">
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
        <button type="submit" formaction="{{ url('student/event/play/'.$i) }}" class="btn
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
        @if ($i%5==0)
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
      <h4><span class="badge badge-secondary">Q. {{ $queid }}</span> {{ session('que')[$queid-1]['que'] }}</h4>
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
      {{ session('options')[$keys[$i]]['ans'] }}
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
        <button type="submit" class="btn btn-success btn-lg active" formaction="{{ url('student/event/play/'.$i) }}">Save & Next Question</button>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#EventSubmit" data-whatever="@fat">Submit & Exit Quiz</button>
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
        <button type="submit" class="btn btn-success" formaction="{{ url('student/event/submit/logout') }}">Yes, Save & Logout</button>
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

window.onload = function()
{
  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

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

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now an the count down date
  var distance = countDownDate - now;

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
