@if (config('services.bsa.cpm_code'))
    <!-- BuySellAds Ad Code -->
    <script type="text/javascript">
        (function(){
            var bsa = document.createElement('script');
            bsa.type = 'text/javascript';
            bsa.async = true;
            bsa.src = '//s3.buysellads.com/ac/bsa.js';
            (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
        })();
    </script>
    <!-- End BuySellAds Ad Code -->
@endif
