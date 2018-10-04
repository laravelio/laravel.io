@title('Profile')

@extends('layouts.settings')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>
        <div class="panel-body">
            {!! Form::open(['route' => 'settings.profile.update', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <img class="img-circle" src="{{ Auth::user()->gravatarUrl(100) }}">
                        <span class="help-block">Change your avatar on <a href="https://gravatar.com/">Gravatar</a>.</span>
                    </div>
                </div>

                @formGroup('name')
                    {!! Form::label('name', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::text('name', Auth::user()->name(), ['class' => 'form-control', 'required']) !!}
                        @error('name')
                    </div>
                @endFormGroup

                @formGroup('email')
                    {!! Form::label('email', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::email('email', Auth::user()->emailAddress(), ['class' => 'form-control', 'required']) !!}
                        @error('email')
                    </div>
                @endFormGroup

                @formGroup('username')
                    {!! Form::label('username', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::text('username', Auth::user()->username(), ['class' => 'form-control', 'required']) !!}
                        @error('username')
                    </div>
                @endFormGroup

                @formGroup('bio')
                    {!! Form::label('bio', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::textarea('bio', Auth::user()->bio(), ['class' => 'form-control', 'rows' => 3, 'maxlength' => 160]) !!}
                        <span class="help-block">The user bio is limited to 160 characters.</span>
                        @error('bio')
                    </div>
                @endFormGroup

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-6">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        {!! Form::button('Delete Profile', [
                            'class' => 'btn btn-danger pull-right',
                            'data-toggle' => 'modal',
                            'data-target' => '#deleteProfile',
                        ]) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    @include('_partials._delete_modal', [
                    'id' => "deleteProfile",
                    'route' => ['profile.destroy'],
                    'title' => 'Delete Profile',
                    'body' => '
                        <p>Once you delete your profile all related data (posts, threads, etc) will be deleted alongside.</p>
                        <p>Are you sure you want to delete your profile? This cannot be undone.</p>
                        ',
                ])
@endsection
