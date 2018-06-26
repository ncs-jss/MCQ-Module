@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
@stop
@section('content')
<div class="container">
    <div class="row">
		<div class="col-md-4 col-sm-4 col-xs-12"></div>
		<div class="col-md-4 col-sm-4 col-xs-12">
			<form action="{{ route('LoginUrl') }}" class="animated zoomIn form-control form-control-file form-container" method="post" >
				<center>
					<h1>MCQ Module</h1>
					@if (session('msg'))
						<div class="alert alert-danger">
		    				{{ session('msg') }}
		    			</div>
					@endif
				</center>
				{{ csrf_field() }}
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" placeholder="Username" required name="username" autocomplete="off">
					@if ($errors->has('username'))
					    <p class="text-danger">
					    	{{ $errors->first('username') }}
					    </p>
					@endif
				</div>
				<div class="form-group">
					<label for="pwd">Password</label>
					<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="pwd" placeholder="Password" name="password" required>
					@if ($errors->has('password'))
					    <p class="text-danger">
						    {{ $errors->first('password') }}
					    </p>
					@endif
				</div>
				<div class="form-group form-check">
					<input class="form-check-input" type="checkbox" name="remember"> 
					<label class="form-check-label" for="remember">Remember me</label>
				</div>
				<button type="submit" class="btn btn-success btn-block">Submit</button>
			</form>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12"></div>	
    </div>
</div>
@stop
