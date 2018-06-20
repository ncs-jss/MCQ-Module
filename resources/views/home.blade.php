@extends('layouts.default')
@section('content')
@if (session('msg'))
    {{ session('msg') }}
@endif
<form method="post" action="{{ route('LoginUrl') }}">
	 {{ csrf_field() }}
	<input type="text" name="username" autocomplete="off" class="{{ $errors->has('username') ? ' is-invalid' : '' }}" required>
	@if ($errors->has('username'))
        <br>
        {{ $errors->first('username') }}
    @endif
	<br>
	<input type="password" name="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" required>
	@if ($errors->has('password'))
        <br>
        {{ $errors->first('password') }}
    @endif
	<br>
	<button type="submit">Login</button>
</form>
@stop