@include('bin._scripts')
@include('bin._styles')

<div class="sidebar show">
    <div class="options">
        <ul>
            <li><a href="{{ $paste->createUrl }}" class="button new">New</a></li>
            <li><a href="{{ $paste->forkUrl }}" class="button fork">Fork</a></li>
            <li><a target="_blank" href="{{ $paste->rawUrl }}" class="button raw">Raw</a></li>
            <li><a href="#" class="button copy">Copy URL</a></li>
        </ul>
        <span class="paste-url">{{ $paste->showUrl }}</span>
    </div>
    <div class="comments">
        <a href="#" class="button"><i class="fa fa-plus"></i> comment</a>
        <h3>Comments</h3>
        @if ($paste->hasComments())
            <ul>
                <li></li>
            </ul>
        @else
            <p>No comments found.</p>
        @endif
    </div>
</div>

<div class="show-container">
    <pre class="prettyprint linenums">
{{{ $paste->code }}}
    </pre>
</div>