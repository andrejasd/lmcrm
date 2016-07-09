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
      <th>tmp</th>
    </tr>
    </thead>
    <tbody>
    @foreach($leads as $lead)
      <tr>
        <td> {{ $lead->radio->label }} = {{ $lead->radio_value->value }} </td>
        <td> {{ $lead->date }} </td>
        <td> {{ $lead->name }} </td>
        <td> {{ $lead->phone }}</td>
        <td> {{ $lead->email }} </td>
        <td> {{ $lead->radio->id }} </td>
      </tr>
    @endforeach
    </tbody>
  </table>

@stop