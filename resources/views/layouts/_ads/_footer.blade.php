@unless ($disableAds ?? false)
    @if ($code = config('services.bsa.cpm_code'))
        <div class="ad-unit-footer-bsa container" style="text-align:center;overflow:hidden;">
            <hr>
            <!-- BuySellAds Zone Code -->
            <div id="bsap_{{ config("services.bsa.footer_code") }}" class="bsarocks bsap_{{ $code }}"
                 style="display:inline-block;margin:0 auto;max-width:730px;overflow:hidden"></div>
            <!-- End BuySellAds Zone Code -->
        </div>
    @endif
@endif
