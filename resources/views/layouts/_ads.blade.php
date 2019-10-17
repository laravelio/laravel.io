@if ($bsaCpcCode = config('services.bsa.cpc_code'))
    <script src="//m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
    <script>
        (function () {
            if (typeof _bsa !== 'undefined' && _bsa) {
                _bsa.init('default', '{{ $bsaCpcCode }}', 'placement:laravelio', {
                    target: '.bsa-cpc',
                    align: 'horizontal',
                    disable_css: 'true'
                });
            }
        })();
    </script>
@endif
