<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@section('title') Administration @show</title>
    @section('meta_keywords')
        <meta name="keywords" content="your, awesome, keywords, here"/>
    @show @section('meta_author')
        <meta name="author" content="Jon Doe"/>
    @show @section('meta_description')
        <meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei."/>
    @show
     <link href="{{ asset('assets/admin/css/admin.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

     <!-- Bootstrap -->
     <link rel="stylesheet" type="text/css" href="{{ asset('components/bootstrap/css/bootstrap.min.css') }}">
     @if(LaravelLocalization::getCurrentLocaleDirection()=='rtl') <link rel="stylesheet" href="{{ asset('components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') }}"> @endif

     <!-- Bootstrap Material Design -->
     <link rel="stylesheet" type="text/css" href="{{ asset('components/bootstrap/css/bootstrap-material-design.css') }}">
     <link rel="stylesheet" type="text/css" href="{{ asset('components/bootstrap/css/ripples.min.css') }}">
     @yield('styles')

    <script type="text/javascript" src="{{ asset('components/jquery/jquery-2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/bootbox/bootbox.min.js') }}" async></script>
    <script type="text/javascript" src="{{ asset('components/bootstrap/js/material.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('components/bootstrap/js/ripples.min.js') }}"></script>
     @yield('scripts')
     <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
</head>
<body>
<div id="wrapper">
    @include('admin.partials.nav')
        <div class="col-xs-2 sidebar-wrapper">
            @include('admin.partials.sidebar')
        </div>
        <div class="col-xs-10" >
            <div id="page-wrapper">
            @yield('main')
            </div>
        </div>
</div>

<script type="text/javascript">
    var oTable;
    $(document).ready(function () {
        oTable = $('#table').DataTable({
            "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sProcessing": "{{ trans('table.processing') }}",
                "sLengthMenu": "{{ trans('table.showmenu') }}",
                "sZeroRecords": "{{ trans('table.noresult') }}",
                "sInfo": "{{ trans('table.show') }}",
                "sEmptyTable": "{{ trans('table.emptytable') }}",
                "sInfoEmpty": "{{ trans('table.view') }}",
                "sInfoFiltered": "{{ trans('table.filter') }}",
                "sInfoPostFix": "",
                "sSearch": "{{ trans('table.search') }}:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "{{ trans('table.start') }}",
                    "sPrevious": "{{ trans('table.prev') }}",
                    "sNext": "{{ trans('table.next') }}",
                    "sLast": "{{ trans('table.last') }}"
                }
            },
            "processing": true,
            "serverSide": true,
            "ajax": "/admin/{!! $type !!}/data",
            "fnDrawCallback": function (oSettings) {
                $(".iframe").colorbox({
                    iframe: true,
                    width: "80%",
                    height: "80%",
                    onClosed: function () {
                        oTable.ajax.reload();
                    }
                });
            }
        });
    });
</script>
</body>
</html>