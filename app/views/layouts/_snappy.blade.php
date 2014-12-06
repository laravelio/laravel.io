<script
    src="//d2s6cp23z9c3gz.cloudfront.net/js/embed.widget.min.js"
    data-domain="laravelio.besnappy.com"
    data-lang="en"
    data-background="#444"

    @if (Auth::check())
        data-name="{{ Auth::user()->name }}"
        data-email="{{ Auth::user()->email }}"
    @endif

    @if (App::environment('local'))
        data-debug="true"
    @endif
></script>