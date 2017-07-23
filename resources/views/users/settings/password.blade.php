@title('Password')

@extends('layouts.settings')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>
        <div class="panel-body">
            {{ Form::open(['route' => 'settings.password.update', 'method' => 'PUT', 'class' => 'form-horizontal']) }}
                @if (Auth::user()->hasPassword())
                    @formGroup('current_password')
                        {!! Form::label('current_password', null, ['class' => 'col-md-3 control-label']) !!}

                        <div class="col-md-6">
                            {!! Form::password('current_password', ['class' => 'form-control', 'required']) !!}
                            @error('current_password')
                        </div>
                    @endFormGroup
                @endif

                @formGroup('password')
                    {!! Form::label('password', 'New Password', ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                        @error('password')
                    </div>
                @endFormGroup

                @formGroup('password_confirmation')
                    {!! Form::label('password_confirmation', 'Confirm New Password', ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::password('password_confirmation', ['class' => 'form-control', 'required']) !!}
                    </div>
                @endFormGroup

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-6">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
