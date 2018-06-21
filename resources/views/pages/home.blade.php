@extends('layouts.default')
@section('content')

<div class="col-md-4 col-sm-4 col-xs-12"></div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<form action="{{ route('LoginUrl') }}" class="form-control form-control-file form-container" method="post" >
					<h1>MCQ Module</h1>
					@if (session('msg'))
    				{{ session('msg') }}
					@endif
						 {{ csrf_field() }}

					<div class="form-group">
				    	<label for="username">Username</label>
				    	<input type="text" class="form-control" id="username" placeholder="Username" required name="username" autocomplete="off">
			    		@if ($errors->has('username'))
			    	        <br>
			    	        {{ $errors->first('username') }}
			    	    @endif
				  	</div>
				  <div class="form-group">
				    <label for="pwd">Password:</label>
				    <input type="password" class="form-control" id="pwd" placeholder="Password" name="password" required>
				  </div>
				  	@if ($errors->has('password'))
				          <br>
				          {{ $errors->first('password') }}
				      @endif
				  <div class="form-group form-check">
				    <label class="form-check-label">
				      <input class="form-check-input" type="checkbox"> Remember me
				    </label>
				  </div>
				  <button type="submit" class="btn btn-success btn-block">Submit</button>
				</form>
			</div>
		<div class="col-md-4 col-sm-4 col-xs-12"></div>		
@stop
