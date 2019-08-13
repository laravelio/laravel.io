@if ($adSenseClient = config('services.google.ad_sense.client'))
    <Adsense
        data-ad-client="{{ $adSenseClient }}"
        data-ad-slot="1234567890">
    </Adsense>
@endif
