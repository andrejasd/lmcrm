@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="page-header">
        <div class="pull-right flip">
            <a class="btn btn-primary btn-xs close_popup" href="{{ URL::previous() }}">
                <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back') !!}
            </a>
        </div>
    </div>
    <div class="container" id="content">
        {!! Form::model($sphere,array('route' => ['agent.sphere.update',$sphere->id], 'method' => 'put', 'class' => 'bf', 'files'=> true)) !!}
        <div class="panel-group" id="accordion">
            @forelse($sphere->attributes as $attr)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$attr->id}}"> <i class="fa fa-chevron-down pull-left flip"></i> {{ $attr->label }}</a>
                    </h4>
                </div>
                <div id="collapse{{$attr->id}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        @foreach($attr->options as $option)
                            <div class="checkbox checkbox-inline">
                                {!! Form::checkbox('options[]',$option->id, isset($mask[$option->id])?$mask[$option->id]:null, array('class' => '','id'=>"ch-$option->id")) !!}
                                <label for="ch-{{ $option->id }}">{{ $option->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
        {!! Form::submit(trans('site/sphere.apply'),['class'=>'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>
@stop