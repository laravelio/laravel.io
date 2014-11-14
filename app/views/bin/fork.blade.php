@include('bin._scripts')
@include('bin._styles')

@include('bin._sidebar_toggle')
{{ Form::model($paste, ['class' => 'editor-form']) }}
    <div class="sidebar create">
        @include('bin._logo')

        @if (Auth::check())
            <div class="options">
                <ul>
                    <li><input type="submit" value="Save (CMD/CTRL+S)" class="button"></li>
                    <li><input type="reset" value="Clear" class="button"></li>
                    <li><a href="{{ $paste->showUrl }}" class="button back"><i class="fa fa-arrow-circle-o-left"></i> Back</a></li>
                </ul>
            </div>
            <p>Please note that all pasted data is publicly available.</p>
        @else
            <div class="options">
                <ul>
                    <li><a class="button" href="{{ action('AuthController@getLogin') }}">Login with GitHub</a></li>
                </ul>
            </div>
            <p>Please login first before using the pastebin.</p>
        @endif

        @include('bin._cartalyst-ad')
    </div>

    @include('bin._editor')
{{ Form::close() }}
