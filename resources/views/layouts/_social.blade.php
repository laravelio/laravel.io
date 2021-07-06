<!-- Twitter sharing -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ isset($title) ? $title.' | ' : '' }}{{ config('app.name') }}">
<meta name="twitter:creator" content="@laravelio" />
<!-- /Twitter sharing -->

<!-- Facebook sharing -->
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ isset($title) ? $title.' | ' : '' }}{{ config('app.name') }}" />

@if (isset($shareImage))
    <meta property="og:image" content="{{ $shareImage }}" />
@else
    <meta property="og:image" content="{{ asset('images/laravelio-share.png') }}" />
@endif
<!-- /Facebook sharing -->
