<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? $title.' | ' : '' }} Laravel.io</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    @include('layouts._google_analytics')
</head>
<body class="{{ $bodyClass or '' }}">
    @include('layouts._nav')

    @yield('body')

    <div id="footer" class="container text-center">
        <hr>
        Copyright &copy; 2013 - {{ date('Y') }} Laravel.io &bull;
        <a href="https://facebook.com/laravelio"><i class="fa fa-facebook"></i></a>
        <a href="https://twitter.com/laravelio"><i class="fa fa-twitter"></i></a>
        <a href="https://github.com/laravelio"><i class="fa fa-github"></i></a>
    </div>

    <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>
