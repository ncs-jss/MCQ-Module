@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
	<div class="card animated fadeInUp">
		<div class="card-header text-white bg-purple shadow">
			<h2>{{ $name }}</h2>
		</div>
		<div class="card-body">
			<div class="table-responsive">
  				<table class="table table-striped">
  					<thead class="thead-dark">
  						<tr>
	  						<th>Rank</th>
	  						<th>Name<br>Adm. No.<br>Roll. No.</th>
	  						<th>Correct Attempt<br>Wrong Attemp<br>Total Attempt</th>
	  						<th>Marks</th>
	  					</tr>
  					</thead>
  					@php
  						$i = 0;
  						$previous = "";
  					@endphp
					<tbody>
						@foreach ($result as $r)
							<tr>
								<td>
									@php
										if($previous == $r['marks'])
										{
											echo $i;
										}
										else
										{
											$i++;
											echo $i;
										}
										$previous = $r['marks'];
									@endphp
								</td>
								<td>{{ $r['name'] }}<br>{{ $r['admno'] }}<br>{{ $r['rollno'] }}</td>
								<td>{{ $r['correct'] }}<br>{{ $r['wrong'] }}<br>{{ $r['correct']+$r['wrong'] }}</td>
								<td>{{ $r['marks'] }}</td>
							</tr>
						@endforeach
					</tbody>
  				</table>
  			</div>
  		</div>
	</div>
</div>
@stop
