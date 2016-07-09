@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') {!! trans("admin/sphere.sphere") !!} :: @parent
@stop

{{-- Content --}}
@section('main')
    <div class="page-header">
        <h3>
            {!! trans("admin/sphere.sphere") !!}
        <div class="pull-right flip">
            <a class="btn btn-primary btn-xs close_popup" href="{{ URL::previous() }}">
                <span class="glyphicon glyphicon-backward"></span> {!! trans('admin/admin.back') !!}
            </a>
        </div>
        </h3>
    </div>
    <div class="container" id="content">
        <div class="wizard">
            <ul class="flexbox flex-justify">
                <li class="flex-item step"><a href="#tab1" data-toggle="tab" class="btn btn-circle">1</a></li>
                <li class="flex-item step"><a href="#tab2" data-toggle="tab" class="btn btn-circle">2</a></li>
                <li class="flex-item step"><a href="#tab3" data-toggle="tab" class="btn btn-circle">3</a></li>
                <li class="flex-item step"><a href="#tab4" data-toggle="tab" class="btn btn-circle">4</a></li>
                <li class="flex-item step"><a href="#tab5" data-toggle="tab" class="btn btn-circle">5</a></li>
            </ul>
            <div class="progress progress-striped">
                <div class="progress-bar progress-bar-info bar"></div>
            </div>
            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                    <h3 class="page-header">{{trans('admin/sphere.settings')}}</h3>
                    <form method="post" class="jSplash-form form-horizontal noEnterKey _validate" action="#" >
                        <div class="jSplash-data" id="opt"> Loading... </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab2">
                    <h3 class="page-header">{{trans('admin/sphere.lead_form')}}</h3>
                    <form method="post" class="jSplash-form form-horizontal noEnterKey _validate" action="#" >
                        <div class="panel panel-default">
                            <div class="panel-body">
                               <div class="row">
                                    <div class="col-xs-10">
                                    <div class="col-xs-11 col-xs-offset-1">
                                        <div class="form-group">
                                            <label class="control-label">@lang('lead/lead.name')</label>
                                            {!! Form::text('name', null, array('class' => 'form-control','placeholder'=>trans('lead/form.name'),'required'=>'required','data-rule-minLength'=>'2')) !!}
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">@lang('lead/lead.phone')</label>
                                            {!! Form::text('phone', null, array('class' => 'form-control','placeholder'=>trans('lead/form.phone'),'required'=>'required', 'data-rule-phone'=>true)) !!}
                                        </div>

                                        <div class="form-group ">
                                            <label class="control-label">@lang('lead/lead.comments')</label>
                                            {!! Form::textarea('comment', null, array('rows'=>'3','class' => 'form-control','placeholder'=>trans('lead/form.comments'))) !!}
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="form jSplash-data" id="lead"> Loading... </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab3">
                    <h3 class="page-header">{{trans('admin/sphere.agent_form')}}</h3>
                    <form method="post" class="jSplash-form form-horizontal noEnterKey _validate" action="#" >
                        <div class="jSplash-data" id="cform">
                            Loading...
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab4">
                    <h3 class="page-header">{{trans('admin/sphere.statuses')}}</h3>
                    <form method="post" class="jSplash-form form-horizontal noEnterKey _validate" action="#" >
                        <div class="jSplash-data" id="threshold">
                            Prepearing...
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab5">
                    <h3 class="page-header">{{trans('admin/sphere.finish')}}</h3>
                    <br class="clearfix">
                    <button class="btn btn-warning btn-save btn-raised">{{trans('admin/modal.save')}}</button>
                </div>
                <ul class="pager wizard">
                    <li class="previous first" style="display:none;"><a href="#">{!! trans('pagination.first') !!}</a></li>
                    <li class="previous"><a href="#">{!! trans('pagination.previous') !!}</a></li>
                    <li class="next last" style="display:none;"><a href="#">{{trans('pagination.last')}}</a></li>
                    <li class="next"><a href="#">{{trans('pagination.next')}}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-page">
        <div class="modal-dialog">
            <form class="validate">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body"></div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-info " data-dismiss="modal">{{trans('admin/modal.close')}}</button>
                        <button type="button" class="btn btn-success btn-raised btn-save">{{trans('admin/modal.save')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

{{-- Styles --}}
@section('styles')
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('packages/spescina/mediabrowser/dist/mediabrowser-include.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('components/nouislider/css/nouislider.pips.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('components/entypo/css/entypo.css') }}">
@stop
{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript" src="{{ asset('components/nouislider/js/nouislider.min.js') }}" async></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js" async></script>
    <script type="text/javascript" src="{{ asset('packages/spescina/mediabrowser/dist/mediabrowser-include.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/doT.min.js') }}" async></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('components/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/markerclusterer.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/GMapInit.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/sly.min.js') }}" async></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/jSplash.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/jSplash/lang/jSplash.'.LaravelLocalization::getCurrentLocale().'.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $(".jSplash-form").submit(function(){
                return false;
            });

            $('.wizard').bootstrapWizard({
                'tabClass': 'nav nav-pills',
                'onTabShow': function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $steps = navigation.find('li');
                    $steps.removeClass('passed');
                    for(var i = 0; i<index; i++) {
                        $steps.eq(i).addClass('passed');
                    }
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                navigation.closest('.wizard').find('.bar').css({width:$percent+'%'});
            }});

            var cntLead = 1;
            $.ajax({
                url:  '{{ route('admin.attr.form',[$fid]) }}',
                method: 'GET',
                dataType: 'json',
                success: function(resp){
                    for(var k in resp) {
                       var $el = $('#content').find('#'+k);

                        if($el.length) $el.jSplash({
                            event:{
                                onShow:function(){
                                    $.material.init();
                                    $('#content .jSplash-data .btn-calc').click(function(){
                                        cntLead = 1;
                                        var $rows = $(".statuses").find(".duplicated");
                                        for(var j=$rows.length-1;j>=0;j--){
                                            var $ext = $rows.eq(j).find('.extend');
                                            var range = $ext.eq(0).is(":checked")? 100-$ext.eq(1).val():$ext.eq(1).val()
                                            if(range) cntLead = parseInt(cntLead / range * 100);
                                        }
                                        $(".statuses #recLead").val(cntLead).trigger('change');
                                    });
                                    $(".statuses #recLead").off().change(function(){
                                        cntLead = $(this).val();
                                        $el.data('splash').settings('stat.minLead',$(this).val());
                                    });
                                },
                                onEdit:function(){
                                    $.material.init();
                                },
                                onModal:function($el){
                                    $.material.init($el);
                                }
                            }}).data('splash').load({data:resp[k]},false,{}).show();
                    }
                }
            });

            $('#content .btn-save').click(function(){
                var postData = {};
                var $jElements = $('#content .jSplash-data');
                var $this = $(this);
                for(var i=0; i<$jElements.length;i++) {
                    postData[$jElements.eq(i).attr('id')] = $jElements.eq(i).data('splash').serialize();
                }
                postData['stat_minLead']=cntLead;

                if(postData) {
                    $this.prop('disabled',true);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('admin.sphere.update',[$fid]) }}',
                        method: 'POST',
                        data: postData,
                        success: function (data, textStatus) {
                            $this.prop('disabled',false);
                            window.location = '{{ route('admin.sphere.index') }}';
                        },
                        error: function (XMLHttpRequest, textStatus) {
                            alert(textStatus);
                            $this.prop('disabled',false);
                        }
                    });
                };
                return false;
            });

            function initSlider($sliderContaner,rangeVal,check){
                var startVal = [0,50];
                var check = check || false;
                if(rangeVal) { startVal=[rangeVal[1],100]; }
                if(check) {
                    startVal=[
                        $sliderContaner.find('.form-control[data-range="0"]').val(),
                        $sliderContaner.find('.form-control[data-range="1"]').val()
                    ];
                }

                noUiSlider.create($sliderContaner.find('.slider').get(0), {
                    start: startVal,
                    step: 1,
                    connect: true,
                    range: {'min': 0, 'max': 100 },
                    pips: {mode: 'positions', values: [0,25,50,75,100], density: 4 }
                });
                $sliderContaner.find('.slider').get(0).noUiSlider.on('update', function( values, handle ) {
                    var $slider = $(this.target);
                    var $sliderContaner = $slider.closest('.slider-row');
                    if (handle) {
                        $sliderContaner.find('.form-control[data-range="1"]').val(values[handle]);
                    } else {
                        $sliderContaner.find('.form-control[data-range="0"]').val(values[handle]);
                    }
                });
                $sliderContaner.find('.form-control').change(function(){
                    var $sliderContaner = $(this).closest('.slider-row');
                    var data = [null,null];
                    data[$(this).data('range')]=$(this).val();
                    $sliderContaner.find('.slider').get(0).noUiSlider.set(data);
                });
                return true;
            }
            /*
            $('.btn-slider-add').click(function(){
                var $ns = $("#_threshold .duplicate-row").first().clone().removeClass('hidden');
                var $lastSliderRow = $("#_threshold .duplicate-row").last();
                $lastSliderRow.after($ns);
                var data = null;
                if($lastSliderRow.find('.slider').get(0).noUiSlider) { data = $lastSliderRow.find('.slider').get(0).noUiSlider.get(); }
                initSlider($ns,data);
            });
            //.getElementsByClassName('noUi-origin')
            */
        });
    </script>
@stop