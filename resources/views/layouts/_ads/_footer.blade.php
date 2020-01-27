@if ($adSenseClient = config('services.google.ad_sense.client'))
    <div class="container mx-auto" style="text-align:center;overflow:hidden;">
        <ins class="adsbygoogle footer-ad"
            data-ad-client="{{ $adSenseClient }}"
            data-ad-slot="{{ config('services.google.ad_sense.unit_footer') }}"
            data-ad-format="fluid"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
@endif
