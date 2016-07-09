<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@section('title') lead recycling CRM @show</title>
    @section('meta_keywords')
        <meta name="keywords" content="your, awesome, keywords, here"/>
    @show @section('meta_author')
        <meta name="author" content="Jon Doe"/>
    @show @section('meta_description')
        <meta name="description"
              content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei."/>
    @show
  <!-- Material Design fonts -->
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="{{ asset('components/bootstrap/css/bootstrap.min.css') }}" >
  @if(LaravelLocalization::getCurrentLocaleDirection()=='rtl') <link rel="stylesheet" href="{{ asset('components/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') }}"> @endif

        <link href="{{ asset('components/jquery-selectboxit/src/stylesheets/jquery.selectBoxIt.css')}}" rel="stylesheet">
        <link href="{{ asset('components/bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
        <link href="{{ asset('components/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{{ asset('assets/web/css/sb-admin.css')}}" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="{{ asset('components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        <!-- Custom THEME -->
        <link href="{{ asset('assets/web/css/lmcrm-theme.css')}}" rel="stylesheet" type="text/css">

    @yield('styles')
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <!-- jQuery -->
  <script type="text/javascript" src="{{ asset('components/jquery/jquery-2.min.js') }}"></script>
  <!-- Bootstrap Core JavaScript -->
  <script type="text/javascript" src="{{ asset('components/bootstrap/js/bootstrap.min.js') }}"></script>
  <!--<script type="text/javascript" src="{{ asset('components/bootstrap/js/material.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('components/bootstrap/js/ripples.min.js') }}"></script>-->

    <!-- Plugin JavaScript -->
    <script src="{{ asset('components/metisMenu/dist/metisMenu.min.js')}}"></script>
    <script src="{{ asset('components/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{ asset('components/bootbox/bootbox.min.js')}}"></script>

    <script type="text/javascript" src="{{ asset('components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('components/ajax-form/jquery.form.min.js')}}"></script>
    <script src="{{ asset('components/jquery-selectboxit/src/javascripts/jquery.selectBoxIt.js')}}"></script>
    <script src="{{ asset('components/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('components/jquery-validation/dist/additional-methods.js')}}"></script>
    @if(LaravelLocalization::getCurrentLocale()!='en')<script src="{{ asset('components/jquery-validation/dist/localization/messages_'.LaravelLocalization::getCurrentLocale().'.min.js')}}"></script>@endif
    <!-- DataTables JavaScript -->
    <script src="{{ asset('components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('components/datatables-responsive/js/dataTables.responsive.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('assets/web/js/sb-admin.js')}}"></script>
    @section('script') @show
    <script type="text/javascript" src="{{ asset('assets/web/js/lmcrm.js') }}"></script>

  <link rel="shortcut icon" href="{!! asset('site/ico/favicon.ico')  !!} ">
</head>
<body>
<div id="wrapper">
    @include('partials.nav')

    <div class="container">
    @yield('content')
    </div>
</div>
@include('partials.footer')

<!-- Scripts -->
@yield('scripts')

</body>
</html>
