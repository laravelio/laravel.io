<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>{{ ! empty($title) ? $title . ' - ' : '' }}Laravel.IO - The Official Laravel PHP Framework Community Portal</title>
  @section('styles')
    <link rel="stylesheet" href="{{ asset('stylesheets/app.css') }}">
  @show

  <script src="{{ asset('javascripts/vendor/custom.modernizr.js') }}"></script>

  <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-36064061-1']);
      _gaq.push(['_trackPageview']);

      (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
  </script>

</head>
<body>

<div class="wrapper">
  <div class="top-header">
    @include('layouts._top_nav')
  </div>

  <div class="holder">
      @include('layouts._flash')
     <div class="table">
        {{ $content }}
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
                },
      });
    </script>
  @show
</body>
</html>
