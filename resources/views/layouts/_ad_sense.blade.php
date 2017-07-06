@if (app()->environment('production') && $adClient = config('services.google.ad_sense.client'))
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "{{ $adClient }}",
            enable_page_level_ads: true
        });
    </script>
@endif
