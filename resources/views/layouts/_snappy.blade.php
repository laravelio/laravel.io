@if (config('services.snappy.enabled'))
    <script
        src="{{ config('services.snappy.embed_url') }}"
        data-domain="{{ config('services.snappy.domain') }}"
        data-lang="{{ App::getLocale() }}"
        data-background="#444"

        @if (Auth::check())
            data-name="{{ Auth::user()->name }}"
            data-email="{{ Auth::user()->email }}"
        @endif

        @if (config('services.snappy.debug'))
            data-debug="true"
        @endif
    ></script>
@endif
