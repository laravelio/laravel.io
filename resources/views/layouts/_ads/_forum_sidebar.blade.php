@if ($code = config('services.bsa.cpm_code'))
    <div class="ad-unit-forum-sidebar" style="margin-top:25px;overflow:hidden;text-align:center;">
        <hr>
        <!-- BuySellAds Zone Code -->
        <div id="bsap_{{ config("services.bsa.sidebar_code") }}" class="bsarocks bsap_{{ $code }}"
             style="text-align:center;"></div>
        <!-- End BuySellAds Zone Code -->
    </div>
@endif
