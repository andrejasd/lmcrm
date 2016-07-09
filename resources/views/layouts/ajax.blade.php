<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript" src="{{ asset('assets/web/js/lmcrm.ajax.js') }}"></script>
</head>
<body>
    <div class="ajax-content">
        @yield('content')
        <span class="clearfix"></span>
    </div>
</body>
</html>