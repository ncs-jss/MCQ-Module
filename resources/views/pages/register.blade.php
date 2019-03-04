@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ custom_url('assets/css/style.css') }}">
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12"></div>
        <div class="col-md-4 col-sm-4 col-xs-12 ">
            <form action="{{custom_url("register")}}" class="animated zoomIn form-control form-control-file form-container shadow p-4 mb-5 bg-white rounded border border-primary" method="post">
                    <div class="mx-auto">
                        <h1 class="font-weight-bold text-center">{{ config('app.name', 'MCQ Modul') }}</h1>
                        @if (session('msg'))
                            <div class="alert alert-danger">
                                {{ session('msg') }}
                            </div>
                        @endif
                    </div>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username">Name</label>
                        <input type="email" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" required name="name" autocomplete="off" placeholder="name">
                        @if ($errors->has('name'))
                            <p class="text-danger">
                                {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" required name="email" autocomplete="off" placeholder="email">
                        @if ($errors->has('email'))
                            <p class="text-danger">
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="pwd" name="password" required placeholder="Password">
                        @if ($errors->has('password'))
                            <p class="text-danger">
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="pwd">Confirm Password</label>
                        <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                        @if ($errors->has('password_confirmation'))
                            <p class="text-danger">
                                {{ $errors->first('password_confirmation') }}
                            </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-check-label lbl">
                            <input class="form-check-input" type="checkbox" name="remember">
                            <span class="checkmark cb border"></span>
                            Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Submit</button> 
                    <div style="margin-top: 10px;">
                    <center>
            			<a href="{{ custom_url('/') }}" target="_blank" style="text-decoration: none;">Login an existing account60</a>
                    </center>
                </div>
            </form>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12"></div>    
    </div>
</div>
@stop
