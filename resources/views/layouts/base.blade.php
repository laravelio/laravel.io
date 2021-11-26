<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ isset($title) ? $title.' | ' : '' }}
        {{ config('app.name') }}
        {{ is_active('home') ? '- The Laravel Community Portal' : '' }}
    </title>

    <meta name="description" content="The Laravel portal for problem solving, knowledge sharing and community building." />
    <link rel="canonical" href="{{ $canonical ?? Request::url() }}" />

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @stack('meta')

    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>

    @include('feed::links')
    @include('layouts._favicons')
    @include('layouts._social')
    @include('layouts._fathom')

    @livewireStyles
</head>

<body class="{{ $bodyClass ?? '' }} {{ isset($isTailwindUi) && $isTailwindUi ? '' : 'standard' }} font-sans bg-white antialiased" x-data="{ activeModal: false }" @keyup.escape="activeModal = false">

@include('layouts._ads._banner')
@include('layouts._nav')

@yield('body')

@include('layouts._footer')

@stack('modals')

@livewireScripts

</body>
</html>
