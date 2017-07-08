@if (config('services.google.ad_sense.enabled'))
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "{{ config('services.google.ad_sense.client') }}",
            enable_page_level_ads: true
        });
    </script>
@endif
