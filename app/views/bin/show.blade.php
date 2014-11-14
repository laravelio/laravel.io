@include('bin._scripts')
@include('bin._styles')

@include('bin._sidebar_toggle')
<div class="sidebar">
    @include('bin._logo')

    <div class="options">
        <ul>
            @if (Auth::check())
                <li><a href="{{ $paste->createUrl }}" class="button new">New (N)</a></li>
                <li><a href="{{ $paste->forkUrl }}" class="button fork">Fork (F)</a></li>
            @else
                <li><a class="button" href="{{ action('AuthController@getLogin') }}">Login with GitHub</a></li>
            @endif

            <li><a target="_blank" href="{{ $paste->rawUrl }}" class="button raw">Raw (R)</a></li>
            <li><button class="button copy" id="copy-button">Copy URL (CMD/CTRL+C)</button></li>
            <input type="text" id="copy-data" class="hidden" value="{{ $paste->showUrl }}" readonly="readonly">
        </ul>
    </div>
    <p>Please note that all pasted data is publicly available.</p>

    @include('bin._cartalyst-ad')
</div>

<div class="show-container">
    <pre class="prettyprint linenums selectable">
{{{ $paste->code }}}
    </pre>
</div>
