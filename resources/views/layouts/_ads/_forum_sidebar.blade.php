@if (config('services.google.ad_sense.enabled'))
    <div style="margin-top:25px">
        <hr>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="{{ config('services.google.ad_sense.client') }}"
             data-ad-slot="{{ config('services.google.ad_sense.unit_forum_sidebar') }}"
             data-ad-format="rectangle"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
@endif
