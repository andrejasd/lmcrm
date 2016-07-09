@extends('layouts.master')
{{-- Content --}}
@section('content')
    {!! Form::open(array('route' => ['agent.lead.store'], 'method' => 'post', 'class'=>'ajax-form validate', 'files'=> false)) !!}

    <div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}">
        <div class="col-xs-10">
            {!! Form::text('name', null, array('class' => 'form-control','placeholder'=>trans('lead/form.name'),'required'=>'required','data-rule-minLength'=>'2')) !!}
            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
        </div>
        <div class="col-xs-2">
            <img src="/public/icons/list-edit.png" class="_icon pull-left flip">
        </div>
    </div>

    <div class="form-group  {{ $errors->has('phone') ? 'has-error' : '' }}">
        <div class="col-xs-10">
            {!! Form::text('phone', null, array('class' => 'form-control','placeholder'=>trans('lead/form.phone'),'required'=>'required', 'data-rule-phone'=>true)) !!}
            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
        </div>
        <div class="col-xs-2">
            <img src="/public/icons/list-edit.png" class="_icon pull-left flip">
        </div>
    </div>

    <div class="form-group  {{ $errors->has('comment') ? 'has-error' : '' }}">
        <div class="col-xs-10">
            {!! Form::textarea('comment', null, array('class' => 'form-control','placeholder'=>trans('lead/form.comments'))) !!}
            <span class="help-block">{{ $errors->first('comment', ':message') }}</span>
        </div>
        <div class="col-xs-2">
            <img src="/public/icons/list-edit.png" class="_icon pull-left flip">
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-10">
            {!! Form::submit(trans('save'),['class'=>'btn btn-info pull-right flip']) !!}
        </div>
        <div class="col-xs-2"></div>
    </div>

    {!! Form::close() !!}
@stop