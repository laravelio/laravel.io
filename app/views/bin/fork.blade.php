@include('bin._scripts')
@include('bin._styles')

@include('bin._sidebar_toggle')
{{ Form::model($paste, [
    'class' => 'editor-form'
]) }}
    <div class="sidebar create">
        @include('bin._logo')
        <div class="options">
            <ul>
                <li><input type="submit" value="Save (CMD/CTRL+S)" class="button"></li>
                <li><input type="reset" value="Clear" class="button"></li>
                <li><a href="{{ $paste->showUrl }}" class="button back"><i class="fa fa-arrow-circle-o-left"></i> Back</a></li>
            </ul>
        </div>
    </div>

    @include('bin._editor')
{{ Form::close() }}
