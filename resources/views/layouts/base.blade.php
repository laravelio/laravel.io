<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' | ' : '' }} {{ config('app.name') }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>

    @include('layouts._favicons')
    @include('layouts._cookie_consent')
    @include('layouts._google_analytics')

    @unless ($disableAds ?? false)
        @include('layouts._ads._ad_sense')
    @endunless
</head>
<body class="{{ $bodyClass ?? '' }}">

<div id="app">
    <div id="wrapper" v-on:keyup.esc="activeModal = null">
        @include('layouts._nav')

        @yield('body')
    </div>

    @include('layouts._footer')
</div>

<script src="{{ mix('js/app.js') }}"></script>

@include('layouts._intercom')

</body>
</html>
