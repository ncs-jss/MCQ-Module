@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
  <div class="card animated fadeInUp">
    <div class="card-header text-white bg-purple shadow">
      <h2>Profile</h2>
    </div>
		<div class="card-body">
  @if (session('msg'))
    <div class="alert {{ session('class') }}">
      {{ session('msg') }}
    </div>
  @endif
        <form action="{{ url('student/profile') }}" method="POST">
          {{ csrf_field() }}
          @php
            $newuser = 0;
            if(!empty($val))
              $newuser = 1;
          @endphp
          <input type="hidden" name="newuser" value="{{ $newuser }}">
          <div class="float-right"><font color="red"><i>* = Required</i></font></div>
          <br><br>
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label">Name <font color="red">*</font></label>
              <div class="col-sm-10">
                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Name" required name="name" autocomplete="off" value="{{ old('name', Auth::user()->name) }}">
                @if ($errors->has('name'))
                    <p class="text-danger">
                      {{ $errors->first('name') }}
                    </p>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="admno" class="col-sm-2 col-form-label">College Admission Number <font color="red">*</font></label>
              <div class="col-sm-10">
                <input type="text" class="form-control {{ $errors->has('admno') ? ' is-invalid' : '' }}" id="admno" placeholder="College Admission Number" required disabled name="admno" autocomplete="off" value="{{ old('admno',Auth::user()->admno) }}">
                @if ($errors->has('admno'))
                    <p class="text-danger">
                      {{ $errors->first('admno') }}
                    </p>
                @endif
              </div>
            </div>
            @php
              $adm_yr = substr(Auth::user()->admno, 0, 5);
              $cur_yr = date("Y") - 2000;
              $required = 0;
              if($cur_yr > $adm_yr)
                $required = 1;
            @endphp
            <div class="form-group row">
              <label for="rollno" class="col-sm-2 col-form-label">Unviversty Roll Number
                @if ($required == 1)
                <font color="red">*</font>
                @endif
              </label>
              <div class="col-sm-10">
                <input type="text" class="form-control {{ $errors->has('rollno') ? ' is-invalid' : '' }}" id="rollno" placeholder="Unviversty Roll Number" {{ $required == 1 ? 'required' : '' }} name="rollno" autocomplete="off" value="{{ old('rollno', Auth::user()->rollno) }}">
                @if ($errors->has('rollno'))
                    <p class="text-danger">
                      {{ $errors->first('rollno') }}
                    </p>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="Email" name="email" autocomplete="off" value="{{ old('email', Auth::user()->email) }}">
                @if ($errors->has('email'))
                    <p class="text-danger">
                      {{ $errors->first('email') }}
                    </p>
                @endif
              </div>
            </div>
            <button type="submit" class="btn btn-success btn-lg btn-block">Save</button>
        </form>
  	</div>
	</div>
</div>
@stop
