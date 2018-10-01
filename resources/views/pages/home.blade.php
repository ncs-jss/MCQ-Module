@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ custom_url('assets/css/style.css') }}">
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12"></div>
        <div class="col-md-4 col-sm-4 col-xs-12 ">
            <form action="{{custom_url("login")}}" class="animated zoomIn form-control form-control-file form-container shadow p-4 mb-5 bg-white rounded border border-primary" method="post">
                @include('includes.login_form')
            </form>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12"></div>    
    </div>
</div>
@stop
