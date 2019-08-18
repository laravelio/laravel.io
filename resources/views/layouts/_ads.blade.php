@unless ($disableAds ?? false)
    @if ($adSenseClient = config('services.google.ad_sense.client'))
    <div id="sidebar-ad" class="ad hidden">
        <ins class="adsbygoogle block"
            data-ad-client="{{ $adSenseClient }}"
            data-ad-slot="{{ config('services.google.ad_sense.unit_forum_sidebar') }}"
            data-ad-format="rectangle">
        </ins>
    </div>
    <div id="footer-ad" class="hidden">
        <ins class="adsbygoogle block"
            style="max-width:728px; max-height:90px"
            data-ad-client="{{ $adSenseClient }}"
            data-ad-slot="{{ config('services.google.ad_sense.unit_footer') }}"
            data-ad-format="auto">
        </ins>
    </div>
    @endif

    @if ($bsaCpcCode = config('services.bsa.cpc_code'))
        <script src="//m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
        <script>
            (function(){
                if(typeof _bsa !== 'undefined' && _bsa) {
                    _bsa.init('default', '{{ $bsaCpcCode }}', 'placement:laravelio', {
                        target: '.bsa-cpc',
                        align: 'horizontal',
                        disable_css: 'true'
                    });
                }
            })();
        </script>
    @endif
@endif