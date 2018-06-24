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
	<div class="card">
		<div class="card-header text-white bg-purple shadow">
			<h2>Quiz</h2>
		</div>
		<div class="card-body">
			<?php $i = 0 ?>
			@foreach ($events as $event)
				<?php $i++ ?>
				@if ($i==1 || $i==4 || $i==7)
    			<div class="card-deck">
    			@endif
  					<div class="card animated pulse shadow">
    					<div class="card-body">
      						<h5 class="card-title">{{ $event->name }}</h5>
      						<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      						<a href="student/event/{{ $event->id }}" class="btn btn-primary">Start Quiz</a>
    					</div>
  					</div>
				@if ($i==3 || $i==6 || $i==9)
				</div>
				<br>
				@endif
			@endforeach
			@if( $events->count()%3 != 0)
				@for ($i=1; $i<=(3-($events->count()%3)); $i++)
					<div style="border:0px" class="card"></div>
				@endfor
				</div>
				<br>
			@endif
			<center>
				{{ $events->links() }}
			</center>
  		</div>
	</div>
</div>
@stop
