@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="_page-header" xmlns="http://www.w3.org/1999/html">
    </div>

            <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">
                        <table class="table table-bordered table-striped table-hover dataTable">
                            <thead>
                            <tr>
                                <th>{!! trans("main.action") !!}</th>
                                <th>{!! trans("main.status") !!}</th>
                                <th>{!! trans("site/lead.updated") !!}</th>
                                <th>{!! trans("site/lead.name") !!}</th>
                                <th>{!! trans("site/lead.phone") !!}</th>
                                <th>{!! trans("site/lead.email") !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($leads as $lead)
                                <tr>
                                    <td><a href="" class="btn btn-sm" ><img src="/public/icons/list-edit.png" class="_icon pull-left flip"></a></td>
                                    <td>@if($lead->status) <span class="label label-success">on</span> @else <span class="label label-danger">off</span> @endif</td>
                                    <td>{!! $lead->updated_at !!}</td>
                                    <td>{!! $lead->name !!}</td>
                                    <td>{!! $lead->phone->phone !!}</td>
                                    <td>{!! $lead->email !!}</td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                        </div>
                        <div class="col-md-4">
                            <div id="lead_info">
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <th>{!! trans("main.action") !!}</th><td> </td>
                                    </tr>
                                    <tr>
                                        <th>{!! trans("main.status") !!}</th><td> </td>
                                    </tr>
                                    <tr>
                                        <th>{!! trans("site/lead.updated") !!}</th><td> </td>
                                    </tr>
                                    <tr>
                                        <th>{!! trans("site/lead.name") !!}</th><td> </td>
                                    </tr>
                                    <tr>
                                        <th>{!! trans("site/lead.phone") !!}</th><td> </td>
                                    </tr>
                                    <tr>
                                        <th>{!! trans("site/lead.email") !!}</th><td> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>

@stop