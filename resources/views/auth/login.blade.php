{!! Form::open(['route' => 'login.post']) !!}
    {!! Form::text('username') !!}
    {{ $errors->first('username') }}<br>
    {!! Form::password('password') !!}
    {{ $errors->first('password') }}<br>
    {!! Form::submit('Login') !!}
{!! Form::close() !!}
