@extends('admin.layouts.default')
{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            {!! trans("admin/agent.agent") !!}
            <div class="pull-right flip">
                <a class="btn btn-primary btn-xs close_popup" href="{{ URL::previous() }}">
                    <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back') !!}
                </a>
            </div>
        </h3>
    </div>
    <div class="container" id="content">
        @if (isset($agent))
        {!! Form::model($agent,array('route' => ['admin.agent.update',$agent->id], 'method' => 'PUT', 'class' => 'validate', 'files'=> true)) !!}
        @else
        {!! Form::open(array('route' => ['admin.agent.store'], 'method' => 'post', 'class' => 'validate', 'files'=> true)) !!}
        @endif
        <!-- Tabs -->
<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-general" data-toggle="tab"> {{
			trans("admin/modal.general") }}</a></li>
    <li><a href="#tab-info" data-toggle="tab"> {{
			trans("admin/modal.info") }}</a></li>
</ul>
<!-- ./ tabs -->

        <!-- Tabs Content -->
<div class="tab-content">
    <!-- General tab -->
    <div class="tab-pane active" id="tab-general">
        <div class="form-group  {{ $errors->has('first_name') ? 'has-error' : '' }}">
            {!! Form::label('first_name', trans("admin/users.first_name"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('first_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('last_name') ? 'has-error' : '' }}">
            {!! Form::label('last_name', trans("admin/users.last_name"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('last_name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::label('name', trans("admin/users.username"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans("admin/users.email"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('password') ? 'has-error' : '' }}">
            {!! Form::label('password', trans("admin/users.password"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::password('password', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
            </div>
        </div>
        <div class="form-group  {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            {!! Form::label('password_confirmation', trans("admin/users.password_confirmation"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('password_confirmation', ':message') }}</span>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="tab-info">
        <div class="form-group  {{ $errors->has('sphere') ? 'has-error' : '' }}">
            {!! Form::label('sphere', trans("admin/sphere.sphere"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('sphere',$spheres,(isset($agent))?$agent->sphereLink->sphere_id:NULL, array('class' => 'form-control','required'=>'required')) !!}
                <span class="help-block">{{ $errors->first('sphere', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('lead_revenue') ? 'has-error' : '' }}">
            {!! Form::label('info[lead_revenue]', trans("admin/agent.lead_revenue"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('info[lead_revenue]', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('lead_revenue', ':message') }}</span>
            </div>
        </div>

        <div class="form-group  {{ $errors->has('payment_revenue') ? 'has-error' : '' }}">
            {!! Form::label('info[payment_revenue]', trans("admin/agent.payment_revenue"), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('info[payment_revenue]', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('payment_revenue', ':message') }}</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <a class="btn btn-sm btn-warning close_popup" href="{{ URL::previous() }}">
                <span class="glyphicon glyphicon-ban-circle"></span> {{	trans("admin/modal.cancel") }}
            </a>
            <button type="reset" class="btn btn-sm btn-default">
                <span class="glyphicon glyphicon-remove-circle"></span> {{
				trans("admin/modal.reset") }}
            </button>
            <button type="submit" class="btn btn-sm btn-success">
                <span class="glyphicon glyphicon-ok-circle"></span>
                @if	(isset($agent))
                    {{ trans("admin/modal.edit") }}
                @else
                    {{trans("admin/modal.create") }}
                @endif
            </button>
        </div>
    </div>
</div>
    {!! Form::close() !!}
    </div>
@stop
