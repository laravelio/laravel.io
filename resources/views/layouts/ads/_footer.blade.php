@if (app()->environment('production') && $adClient = config('services.google.ad_sense.client'))
    <div class="container" style="text-align:center">
        <hr>
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px;margin-top:5px;max-width:730px"
             data-ad-client="{{ $adClient }}"
             data-ad-slot="{{ config('services.google.ad_sense.unit_footer') }}"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
@endif
