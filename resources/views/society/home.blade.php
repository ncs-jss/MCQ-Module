@extends('layouts.default')
@section('css')
<style>
body {
  padding-top: 5rem;
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
		<div class="card-header  text-white bg-purple shadow">
			<h2>Quiz</h2>
		</div>
		<div class="card-body">
			@for ($i = 0; $i < 3; $i++)
    			<div class="card-deck">
				@for ($j = 0; $j < 3; $j++)
  					<div class="card shadow">
    					<div class="card-body">
      						<h5 class="card-title">MCQ title</h5>
      						<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      						<a href="#" class="btn btn-primary">Start Quiz</a>
    					</div>
  					</div>
				@endfor
				</div>
				<br>
			@endfor
  		</div>
	</div>
</div>
@stop
