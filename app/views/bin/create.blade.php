@include('bin._scripts')
@include('bin._styles')


{{ Form::open(['class' => 'editor-form']) }}
    <div class="sidebar create">
        @include('bin._logo')
        <div class="options">
            <ul>
                <li><input type="submit" value="Save (cmd+s)" class="button"></li>
                <li><input type="reset" value="Clear" class="button"></li>
            </ul>
        </div>
        <p>Please note that all pasted data is publicly available.</p>
    </div>

    @include('bin._editor')
{{ Form::close() }}
