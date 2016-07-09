@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/sphere.sphere") !!} :: @parent
@stop

{{-- Content --}}
@section('main')

    <div class="page-header">
        <h3>
            {!! trans("admin/sphere.sphere") !!}
        </h3>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-xs-12">
@forelse($sphere->attributes as $attr)
    <h4 class="page_header">{{ $attr->label }} </h4>
    @if ($attr->_type == 'radio' || $attr->_type == 'checkbox' || $attr->_type == 'select')
        @foreach($attr->options as $option)
            <div class="_form-group">
                <div class="checkbox">
                    <label for="ch-{{ $option->id }}">
                    {!! Form::checkbox('options[]',$option->id, isset($mask[$option->id])?$mask[$option->id]:null, array('class' => '','id'=>"ch-$option->id",'disabled'=>true)) !!}
                    {{ $option->name }}
                    </label>
                </div>
            </div>
        @endforeach
    @else

    @endif
@empty
@endforelse
             </div>
         </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            {!! Form::open(array('route' => ['admin.sphere.reprice.update',$sphere->id,$agent_id], 'method' => 'put', 'class' => 'validate', 'files'=> false)) !!}
                <div class="col-xs-8">
                    <div class="form-group label-floating">
                        <label class="control-label" for="price">Price</label>
                    <div class="input-group">
                        {!! Form::text('price',(isset($price->lead_price))?$price->lead_price:NULL, array('class' => 'form-control','id'=>'price')) !!}
                        <div class="input-group-btn">
                            {!! Form::submit(trans('admin/modal.save'),['class'=>'btn btn-warning btn-raised']) !!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

{{-- Scripts --}}
@section('scripts')
    <script>
        $(function(){
            $.material.init();
        });
    </script>
@stop