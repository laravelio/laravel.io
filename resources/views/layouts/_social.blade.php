<!-- Twitter sharing -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $title ?? config('app.name') }}">
<meta name="twitter:creator" content="@laravelio" />
<!-- /Twitter sharing -->

<!-- Facebook sharing -->
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ $title ?? config('app.name') }}" />
<meta property="og:image" content="{{ asset('images/laravelio-share.png') }}" />
<!-- /Facebook sharing -->