<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <title>{{ ! empty($title) ? $title . ' - ' : '' }}Laravel.io - The Laravel Community Portal</title>

    @section('styles')
      <link rel="stylesheet" href="{{ asset('stylesheets/app.css') }}">
    @show

    <script src="{{ asset('javascripts/vendor/custom.modernizr.js') }}"></script>

    @include('layouts._google_analytics')
</head>
<body class="bin" onload="prettyPrint()">

<div class="wrapper">
    <div class="table">
        @yield('table')
    </div>
</div>

@section('scripts')
    <script src="{{ asset('javascripts/vendor/jquery.min.js') }}"></script>
@show

@include('layouts._snappy')

</body>
</html>
