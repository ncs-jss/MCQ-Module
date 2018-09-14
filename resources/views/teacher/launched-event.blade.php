@extends('layouts.default')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/panel.css') }}">
@stop
@section('content')
<?php
$count = count($req);
?>
<div class="container">
    @include('includes.msg')
    <form action="{{custom_url('teacher/event/allowaccess/'.$event->id)}}" method="POST" >
         {{ csrf_field() }}
    <div class="table-responsive">
        <table class="table table-bordered shadow text-center bg-primary table-dark" style="margin: 2rem 0 2rem 0;">
            <div class="card-header text-white shadow text-capitalize text-center bg-purple">
                <h2>{{$event->name}}</h2>
            </div>
            <br>
            <h4 class="text-center">Interested Students for the Event</h4>
                <thead>
                    <tr>
                        <td><div><b>Select All</b></div><input type="checkbox" id="select-all"></td><td><b>Name of Student</b></td><td><b>Admission No.</b></td><td><b>Roll No.</b></td>
                    </tr>
                </thead>
                
                <tbody id="reqData">
                    @for($i = 0 ; $i < $count ; $i++)
                        @if($req[$i]['status'] == 0)
                            <tr>
                                <td><input type="checkbox" name="access[]" value="{{$req[$i]['userid']}}" aria-label="..."></td>
                                <td>{{ $req[$i]['name'] }}</td>
                                <td>{{ $req[$i]['admno'] }}</td>
                                <td>{{ $req[$i]['rollno'] }}</td>
                            </tr>
                        @endif
                    @endfor
            </tbody>
        </table>
    </div>
    <button type="submit" id="btn2" class="btn btn-success">
        <i class="fa fa-plus"></i> Allow Access
    </button>
</form>
<h5 class="text-center">
    The page will refresh in <font color="red" id="counts">15</font> seconds to update the incoming requests.
</h5>
<script>
    window.onload = function(){
        var i = 15;
        var check = setInterval(test,1000);
        function test(){
            i--;
            if(i>=0)
                document.getElementById("counts").innerHTML = i;
            else
                {
                    $.post("{{ custom_url('teacher/ajax/event/req') }}",
                    {
                        "id": "{{ $event->id }}",
                        "_token": "{{ csrf_token() }}"
                    },
                    function(data, status){
                      data = jQuery.parseJSON(data);
                      var html = '';
                      var htmla = '';
                      for (var key in data){ 
                          if(data[key].status == 0){
                              if(data[key].rollno == null)
                                  data[key].rollno = '';
                          html += '<tr><td><input type="checkbox" name="access[]" value ="'+data[key].userid+'"></td><td>'+data[key].name+'</td><td>'+data[key].admno+'</td><td>'+data[key].rollno+'</td></tr>';
                  }
                          // var table =document.getElementById("reqData");
                          // var row = table.insertRow(-1);
                          // var cell1 = row.insertCell(0);
                          // var cell2 = row.insertCell(1);
                          // var cell3 = row.insertCell(2);
                          // var cell4 = row.insertCell(3);
                          // cell2.innerHTML = data[key].name;
                          else{
                              if(data[key].rollno == null)
                                  data[key].rollno = '';
                              htmla += '<tr><td>'+data[key].name+'</td><td>'+data[key].admno+'</td><td>'+data[key].rollno+'</td></tr>';
                          }
                      }
                        document.getElementById("reqData").innerHTML = html;
                        document.getElementById("accessData").innerHTML = htmla;
                        i=15;

                    });
                }
            }
        };
        $('#select-all').click(function(event) {   
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        });            
</script>
<div class="table-responsive">
        <table class="table table-bordered shadow text-center bg-success table-dark" style="margin: 2rem 0 2rem 0;">
            <br>
            <h4 class="text-center">Allowed Students for the Event</h4>
                <thead class="thead-dark">
                    <tr>
                        <td><b>Name of Student</b></td><td><b>Admission No.</b></td><td><b>Roll No.</b></td>
                    </tr>
                </thead>
                
                <tbody id ="accessData">
                    @for($i = 0 ; $i < $count ; $i++)
                        @if($req[$i]['status'] == 1)
                            <tr>
                                <td>{{ $req[$i]['name'] }}</td>
                                <td>{{ $req[$i]['admno'] }}</td>
                                <td>{{ $req[$i]['rollno'] }}</td>
                            </tr>
                        @endif
                    @endfor
            </tbody>
            
        </table>
</div>

@stop
