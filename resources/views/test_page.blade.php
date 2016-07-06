@extends('layouts.app')

@section('sidebar') @stop

@section('content')





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
      <tr>
        <td></td>
        <td> {{ $lead->date }} </td>
        <td> {{ $lead->name }} </td>
        <td> phone </td>
        <td> {{ $lead->email }} </td>
      </tr>
    @endforeach
    </tbody>
  </table>

@stop