@extends('layouts._two_columns_left_sidebar')

@section('sidebar')
    @include('users._sidebar')
@stop

@section('content')

<section class="user-content">
    <div class="header">
        <h1>Account Settings</h1>
    </div>
    <div class="user-settings">
        {!! Form::open(['route' => ['user.settings.update', $user->name], 'method' => 'put']) !!}
            <p>
                {!! Form::label('name', 'Username') !!}
                {!! Form::text('name', $user->name) !!}
            </p>

            @if ($errors->has('name'))
                <p>{!! $errors->first('name') !!}</p>
            @endif

            <p>
                {!! Form::label('email') !!}
                {!! Form::email('email', $user->email) !!}
            </p>

            @if ($errors->has('email'))
                <p>{!! $errors->first('email') !!}</p>
            @else
                <span class="help-inline">If you change your e-mail address, you'll have to reconfirm it.</span>
            @endif

            <p>{!! Form::submit('Save Settings', ['class' => 'button']) !!}</p>
        {!! Form::close() !!}
    </div>
</section>

@stop
