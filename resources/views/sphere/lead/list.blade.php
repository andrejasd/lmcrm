@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="_page-header" xmlns="http://www.w3.org/1999/html">
    </div>

    <div class="panel-group" id="accordion">
        @forelse($spheres as $sphere)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$sphere->id}}"> <i class="fa fa-chevron-down pull-left flip"></i> {{ $sphere->name }}</a>
                    </h4>
                </div>
                <div id="collapse{{$sphere->id}}" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover dataTable">
                            <thead>
                            <tr>
                                <th>{!! trans("site/lead.name") !!}</th>
                                <th>{!! trans("main.status") !!}</th>
                                <th>{!! trans("main.updated_at") !!}</th>
                                <th>{!! trans("main.action") !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($sphere->leads as $lead)
                                <tr>
                                    <td>{!! $lead->name !!}</td>
                                    <td>@if($sphere->status) <span class="label label-success">on</span> @else <span class="label label-danger">off</span> @endif</td>
                                    <td>{!! $lead->updated_at !!}</td>
                                    <td><a href="{{ route('operator.sphere.lead.edit',['sphere'=>$sphere->id,'id'=>$lead->id]) }}" class="btn btn-sm" ><img src="/public/icons/list-edit.png" class="_icon pull-left flip"></a></td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>

@stop
