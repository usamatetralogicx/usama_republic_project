<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <title>@yield('title')</title>

    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>

    <script src="{{ asset('js/modernizr.min.js') }}"></script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>


</head>


<body style="background: url('{{ env('APP_URL') }}/images/bg.jpg'); background-size: cover ">
@yield('content')

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>

<!-- App js -->
{{--<script src="{{ asset('js/jquery.core.js') }}"></script>--}}
{{--<script src="{{ asset('js/jquery.app.js') }}"></script>--}}
</body>
</html>
