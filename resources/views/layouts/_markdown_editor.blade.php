@section('scripts')
    @parent

    {{-- Markdown Editor --}}
    <script src="{{ asset('javascripts/vendor/redactor/redactor.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('javascripts/vendor/redactor/redactor.css') }}" />
    <script src="{{ asset('javascripts/markdown_editor.js') }}"></script>
@stop

