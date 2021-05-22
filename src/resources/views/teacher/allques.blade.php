@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ custom_url('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
    @include('includes.msg')
    <div class="card animated fadeInUp">
        <div class="card-header text-white bg-purple shadow text-capitalize text-center">
            <h2>ALL QUESTIONS</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered shadow text-center table-dark" style="margin: 2rem 0 2rem 0; background-color: #4db6ac">
                    <thead style="background-color: #009688">
                        <tr style="font-size: 20px; font-family: TimesNewRoman">
                            <th>S.No.</th><th>Question</th>
                        </tr>
                    </thead>
                    @php
                        $i=0;
                    @endphp
                    <tbody>
                        @foreach($ques as $quet)
                        <tr>
                            @php
                                $i++;
                            @endphp
                            <td>{{$i}}</td>
                            <td>{!!$quet->que!!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
