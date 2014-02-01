@include('bin._scripts')
@include('bin._styles')


{{ Form::open(['class' => 'editor-form']) }}
    <div class="sidebar create">
        <div class="options">
            <ul>
                <li><input type="submit" value="Save" class="button"></li>
                <li><input type="reset" value="Clear" class="button"></li>
                <li><a href="#" class="button shortcuts" data-display="shortcuts-guide" data-closeBGclick="true">Shortcuts</a></li>
            </ul>
        </div>
    </div>

    @include('bin._editor')
{{ Form::close() }}