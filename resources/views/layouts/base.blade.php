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

    @include('layouts._footer')

    <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>
