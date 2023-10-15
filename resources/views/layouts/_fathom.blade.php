@production
    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://cdn.usefathom.com/script.js" site="UXCUXOED" defer @if(isset($canonical) && !Str::startsWith($canonical, config('app.url')))data-canonical="false"@endif></script>
    <!-- / Fathom -->
@endproduction
