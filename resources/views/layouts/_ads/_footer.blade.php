@if (! isset($disableAds))
    @if ($adSenseClient = config('services.google.ad_sense.client'))
        <div class="container mx-auto text-center overflow-hidden">
            <ins class="adsbygoogle footer-ad"
                data-ad-client="{{ $adSenseClient }}"
                data-ad-slot="{{ config('services.google.ad_sense.unit_footer') }}"
                data-ad-format="fluid"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    @endif

    @if (config('app.debug'))
        <div class="container mx-auto text-center overflow-hidden bg-green-light" style="max-width:950px;height:88px">
        </div>
    @endif

    @include('layouts._ads._cta', ['text' => 'Your banner here?'])
@endif
