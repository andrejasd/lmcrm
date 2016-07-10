@extends('layouts.app')
@section('sidebar') @stop
@section('content')

  <script>
    $(document).ready(function(){

    });
    function detail(id) {
      var data = {'id' : id};
      console.log(data);

      $.get('detail', data, function (data) {
        data = JSON.parse(data);
        console.log(data);

        $("#date").text(data['date']);
        $("#name").text(data['name']);
        $("#phone").text(data['phone']);
        $("#email").text(data['email']);
        $("#radio_label").text(data['radio_label']);
        $("#radio_value").text(data['radio_value']);
        $("#checkbox_label").text(data['checkbox_label']);
        $("#checkbox_value").text(data['checkbox_value']);

        $("#ModalBox").modal('show');
      });

      return false;
    }
  </script>

  <!-- модальное окно -->
  <div id="ModalBox" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Детальная информация</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
              <tr>
                <th>icon</th>
                <td id="icon"></td>
              </tr>
              <tr>
                <th>date</th>
                <td id="date"></td>
              </tr>
              <tr>
                <th>name</th>
                <td id="name"></td>
              </tr>
              <tr>
                <th>phone</th>
                <td id="phone"></td>
              </tr>
              <tr>
                <th>email</th>
                <td id="email"></td>
              </tr>
              <tr>
                <th id="radio_label"></th>
                <td id="radio_value"></td>
              </tr><tr>
                <th id="checkbox_label"></th>
                <td id="checkbox_value"></td>
              </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

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