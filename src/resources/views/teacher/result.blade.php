@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ custom_url('assets/css/panel.css') }}">
@stop
@section('content')
<div class="container">
    @include('includes.msg')
    <div class="card animated fadeInUp">
        <div class="card-header text-white bg-purple shadow text-capitalize text-center">
            <h2>{{ $name }} - Result</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered shadow text-center bg-info table-dark" style="margin: 2rem 0 2rem 0;">
                    <thead>
                        <tr>
                            <th>Rank</th><th>Name of Student</th><th>Admission No.</th><th>Roll No.</th><th>Attempted</th><th>Correct</th><th>Wrong</th><th>Marks</th>
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
                                <td>{{ $r['name'] }}<td>{{ $r['admno'] }}</td><td>{{ $r['rollno'] }}</td>
                                <td>{{ $r['correct']+$r['wrong'] }}</td><td>{{ $r['correct'] }}</td><td>{{ $r['wrong'] }}</td>
                                <td>{{ $r['marks'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(empty($result))
                    <center><i><h4>No record found</h4></i></center>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
