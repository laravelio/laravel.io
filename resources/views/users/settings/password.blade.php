@php($title = 'Password')

@extends('layouts.settings')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            {{ Form::open(['route' => 'settings.password.update', 'method' => 'PUT', 'class' => 'form-horizontal']) }}
                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                    {!! Form::label('current_password', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::password('current_password', ['class' => 'form-control']) !!}

                        @if ($errors->has('current_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password', 'New Password', ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::password('password', ['class' => 'form-control']) !!}

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {!! Form::label('password_confirmation', 'Confirm New Password', ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
