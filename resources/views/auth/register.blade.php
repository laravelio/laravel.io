{!! Form::open(['route' => 'signup.post']) !!}
    {!! Form::label('name') !!}<br>
    {!! Form::text('name') !!}<br>
    {{ $errors->first('name') }}<br>
    {!! Form::label('email') !!}<br>
    {!! Form::email('email') !!}<br>
    {{ $errors->first('email') }}<br>
    {!! Form::label('username') !!}<br>
    {!! Form::text('username') !!}<br>
    {{ $errors->first('username') }}<br>
    {!! Form::label('password') !!}<br>
    {!! Form::password('password') !!}<br>
    {{ $errors->first('password') }}<br>
    {!! Form::label('password_confirmation') !!}<br>
    {!! Form::password('password_confirmation') !!}<br>
    {!! Form::submit('Signup') !!}
{!! Form::close() !!}
