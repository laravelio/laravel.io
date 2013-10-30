@section('scripts')
    @parent
    <script src="{{ asset('javascripts/vendor/google-code-prettify/run_prettify.js') }}"></script>
@stop

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('javascripts/vendor/google-code-prettify/prettify.css') }}">
@stop