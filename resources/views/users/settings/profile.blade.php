@php($title = 'Profile')

@extends('layouts.settings')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>
        <div class="panel-body">
            {!! Form::open(['route' => 'settings.profile.update', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <img class="img-circle" src="{{ Auth::user()->gratavarUrl(100) }}">
                        <span class="help-block">Change your avatar on <a href="https://gravatar.com/">Gravatar</a>.</span>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::text('name', Auth::user()->name(), ['class' => 'form-control']) !!}

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::email('email', Auth::user()->emailAddress(), ['class' => 'form-control']) !!}

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    {!! Form::label('username', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::text('username', Auth::user()->username(), ['class' => 'form-control']) !!}

                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
