@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
  @include('includes.msg')
  <div class="card animated fadeInUp">
    <div class="card-header text-white bg-purple shadow">
      <h2>ABOUT</h2>
    </div>
    <div class="card-body about-card">
      <ul>
        <li>It is an online platform where teachers and societies can add MCQ based (single choice, multi choice or mixed) events with both negative and non-negative marking.</li> 
        <li>The questions/options may contain text, images, tables etc. Students and teachers can login to the Module via Infoconnect login/password.</li> 
        <li>Also, teachers/societies can schedule the event and students can add the reminder for the event in google calendar.</li>
        <li>The MCQ Module is developed in Laravel - A PHP Framework using Mysql as database.
        This Module supports multiple MCQ Events to be hosted at the same time.</li>
        <li>Once a student request to play a MCQ event the teacher will approve his presence from his dashboard and then he/she can play it for the defined duration and after onwards the result will be available with student details, rank and marks.</li>
    </div>
  </div>
</div>
@stop
