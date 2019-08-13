@unless ($disableAds ?? false)
    @if ($adSenseClient = config('services.google.ad_sense.client'))
        <div class="container text-center text-gray-600 border-t py-8 overflow-hidden">
            <Adsense
                style="display:block;margin:0 auto;max-width:728px;max-height:90px"
                data-ad-client="{{ $adSenseClient }}"
                data-ad-slot="{{ config('services.google.ad_sense.unit_footer') }}"
                data-ad-format="auto"
            />
        </div>
    @endif
@endif
