@if ($carbonCode = config('services.carbon.code'))
    <script src="//m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
    <div class="bsa-cpc"></div>
    <script>
        (function(){
            if(typeof _bsa !== 'undefined' && _bsa) {
                _bsa.init('default', '{{ $carbonCode }}', 'placement:laravelio', {
                    target: '.bsa-cpc',
                    align: 'horizontal',
                    disable_css: 'true'
                });
            }
        })();
    </script>
@endif
