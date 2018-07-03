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
<form id="myForm" action="" method="POST">
  {{ csrf_field() }}
<div class="row p-3">
<div class="col-3">
  <div class="card shadow">
    <div class="card-body text-white bg-dark">
      <center><h3 id="cd"></h3></center>
  </div>
  </div>
  <br>
  <div class="card shadow">
    <div class="card-body">
      @for ($i=1; $i<=count(session('que')); $i++)
        <button type="submit"  formaction="{{ url('student/event/'.$eventid.'/play/'.$i) }}" class="btn btn-secondary">{{ $i }}</button> 
        @if ($i%5==0)
          <br>
        @endif
      @endfor
    </div>
  </div>
  </div>
  
  <div class="col-9">
	<div class="card shadow">
		<div class="card-body">
      <h4><span class="badge badge-secondary">Q. {{ $queid }}</span> {{ session('que')[$queid-1]['que'] }}</h4>
  		</div>
  <ul class="list-group list-group-flush">
    @php
      $keys = array_keys(array_column(session('options'),'queid'),session('que')[$queid-1]['id']);
      $end = strtotime(session('start')." + ".session('duration')." minute");
      $end = date('Y-m-d H:i:s', $end);
    @endphp
    @for($i=0; $i<count($keys); $i++)
    <li class="list-group-item">{{ session('options')[$keys[$i]]['ans'] }}</li>
    @endfor
  </ul>
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
