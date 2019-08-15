@unless ($disableAds ?? false)
    @if ($adSenseClient = config('services.google.ad_sense.client'))
        <Ad identifier="footer-ad"></Ad>
    @endif
@endif
