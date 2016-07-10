@extends('layouts.app')
@section('sidebar') @stop
@section('content')

  <script>
    $(document).ready(function(){

    });
    function detail(id) {
      var data = {'id' : id};
      console.log(data);
/*
      $.ajax({
        type: "get",
        url: 'detail',
        data: "",
        success: function() {
          console.log("Geodata sent");
        }
      });
*/

      $.get('detail', data, function (data) {
        data = JSON.parse(data);
        console.log(data);
      });

      return false;
    }
  </script>




  <table class="table table-bordered table-hover">
    <thead>
    <tr>
      <th>icon</th>
      <th>date</th>
      <th>name</th>
      <th>phone</th>
      <th>email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($leads as $lead)
      <tr onclick="return detail( {{ $lead->id }} )">
        <td></td>
        <td> {{ $lead->date }} </td>
        <td> {{ $lead->name }} </td>
        <td> {{ $lead->phone }}</td>
        <td> {{ $lead->email }} </td>
      </tr>
    @endforeach
    </tbody>
  </table>

@stop