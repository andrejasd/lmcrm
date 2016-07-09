@extends('layouts.master')
{{-- Content --}}
@section('content')
    <div class="_page-header" xmlns="http://www.w3.org/1999/html">
        <a class="btn btn-info pull-right flip" href="{{route('agent.salesman.create')}}"><i class="fa fa-plus"></i> {!! trans("site/salesman.add") !!}</a>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
                <table class="table table-bordered table-striped table-hover dataTable">
                    <thead>
                    <tr>
                        <th>{!! trans("main.action") !!}</th>
                        <th>{!! trans("site/salesman.updated") !!}</th>
                        <th>{!! trans("site/salesman.name") !!}</th>
                        <th>{!! trans("site/salesman.email") !!}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($salesmen as $salesman)
                        <tr>
                            <td><a href="{{route('agent.salesman.edit',[$salesman->id])}}" class="btn btn-sm" ><img src="/public/icons/list-edit.png" class="_icon pull-left flip"></a></td>
                            <td>{!! $salesman->updated_at !!}</td>
                            <td>{!! $salesman->name !!}</td>
                            <td>{!! $salesman->email !!}</td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
        </div>
    </div>

@stop