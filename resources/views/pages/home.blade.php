@extends('layouts.default')
@section('content')
<div class="col-md-4 col-sm-4 col-xs-12"></div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<form action="/action_page.php" class="form-control form-control-file form-container" >
					<h1>MCQ Module</h1>
					<div class="form-group">
				    	<label for="username">Username</label>
				    	<input type="username" class="form-control" id="username" placeholder="Username">
				  	</div>
				  <div class="form-group">
				    <label for="pwd">Password:</label>
				    <input type="password" class="form-control" id="pwd" placeholder="Password">
				  </div>
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