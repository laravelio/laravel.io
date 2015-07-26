@extends('layouts.bin')

@section('table')
    @include('bin._scripts')
    @include('bin._styles')

    @include('bin._sidebar_toggle')

    {!! Form::open(['class' => 'editor-form']) !!}
        <div class="sidebar">
            @include('bin._logo')

            @if (Auth::check())
                <div class="options">
                    <ul>
                        <li><input type="submit" value="Save (CMD+S)" class="button"></li>
                        <li><input type="reset" value="Clear" class="button"></li>
                    </ul>
                </div>
                <p>Please note that all pasted data is publicly available.</p>
            @else
                <div class="options">
                    <ul>
                        <li><a class="button" href="{{ route('login') }}">Login with GitHub</a></li>
                    </ul>
                </div>
                <p>Please login first before using the pastebin.</p>
            @endif

            @include('bin._cartalyst-ad')
        </div>

        @include('bin._editor')
    {!! Form::close() !!}
@stop
