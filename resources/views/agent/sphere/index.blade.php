@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="_page-header" xmlns="http://www.w3.org/1999/html">
    </div>


    <table id="table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{!! trans("site/sphere.name") !!}</th>
            <th>{!! trans("main.status") !!}</th>
            <th>{!! trans("main.updated_at") !!}</th>
            <th>{!! trans("main.action") !!}</th>
        </tr>
        </thead>
        <tbody>
            @forelse($spheres as $sphere)
                <tr>
                    <td>{!! $sphere->name !!}</td>
                    <td>@php($smask = $mask->findSphereMask($sphere->id)->first())
                        @if(isset($smask->status) && $smask->status) <span class="label label-success">@lang('site/sphere.status_1')</span> @else <span class="label label-danger">@lang('site/sphere.status_0')</span> @endif</td>
                    <td>{!! $sphere->updated_at !!}</td>
                    <td><a href="{{ route('agent.sphere.edit',['id'=>$sphere->id]) }}" class="btn btn-sm" ><img src="/public/icons/list-edit.png" class="_icon pull-left flip"></a></td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
@stop

{{-- Scripts --}}
@section('scripts')
@stop
