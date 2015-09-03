<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <title>{{ ! empty($title) ? $title . ' - ' : '' }}Laravel.io - The Laravel Community Portal</title>

    @section('styles')
      <link rel="stylesheet" href="{{ asset('stylesheets/app.css') }}?v=2">
    @show

    <script src="{{ asset('javascripts/vendor/custom.modernizr.js') }}"></script>

    @include('layouts._google_analytics')
</head>
<body>

@if (Auth::check() && ! Auth::user()->isConfirmed())
    <div style="background: #B79B6A; padding: .75em; text-align:center; color:#eee; font-size:1.1em">
        Please confirm your email address ({{ Auth::user()->email }}).
        <a href="{{ route('auth.reconfirm') }}" style="color:#eee;">Re-send confirmation email.</a>
        <a href="{{ route('user.settings', Auth::user()->name) }}" style="color:#eee;">Change e-mail address.</a>
    </div>
@endif

<div class="wrapper">
    <div class="top-header">
        @include('layouts._top_nav')
    </div>

    <div class="holder">
        @include('layouts._flash')

        <div class="table">
            @yield('table')
        </div>
    </div>
</div>

<div class="push"></div>

@include('layouts._footer')

@section('scripts')
  <script src="{{ asset('javascripts/vendor/jquery.min.js') }}"></script>
  <script src="{{ asset('javascripts/forum.js') }}"></script>
  <script src="{{ asset('javascripts/vendor/garlic.js') }}"></script>
  <script src="{{ asset('javascripts/vendor/jquery.fs.naver.js') }}"></script>
  <script>
    $(".sidebar ul").naver({
      'maxWidth': '768px',
      labels: {
          closed: "Sections",
          open: "Close"
      }
    });
  </script>
@show

@include('layouts._snappy')

</body>
</html>
