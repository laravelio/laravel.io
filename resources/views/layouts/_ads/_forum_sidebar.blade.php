@if ($adSenseClient = config('services.google.ad_sense.client'))
    <div style="margin-top:25px">
        <ins class="adsbygoogle sidebar-ad"
             style="display:block"
             data-ad-client="{{ $adSenseClient }}"
             data-ad-slot="{{ config('services.google.ad_sense.unit_forum_sidebar') }}"
             data-ad-format="rectangle"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
@endif
