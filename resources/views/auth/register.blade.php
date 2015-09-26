{!! Form::open(['route' => 'signup.post']) !!}
    {!! Form::text('name') !!}<br>
    {{ $errors->first('name') }}<br>
    {!! Form::email('email') !!}<br>
    {{ $errors->first('email') }}<br>
    {!! Form::text('username') !!}<br>
    {{ $errors->first('username') }}<br>
    {!! Form::password('password') !!}<br>
    {{ $errors->first('password') }}<br>
    {!! Form::password('password_confirmation') !!}<br>
    {!! Form::submit('Signup') !!}
{!! Form::close() !!}
