<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel.io</title>

    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    @include('layouts._google_analytics')
</head>
<body>
    @include('layouts._nav')

    <div class="container">
        @yield('content')
    </div>

    <script src="{{ elixir('js/app.js') }}"></script>

    @include('layouts._snappy')
</body>
</html>
