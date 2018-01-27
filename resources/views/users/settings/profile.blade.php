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

                @formGroup('company')
                    {!! Form::label('company', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::text('company', Auth::user()->company, ['class' => 'form-control']) !!}
                        <p><small>The name of the company if employed</small></p>
                        @error('company')
                    </div>
                @endFormGroup

                @formGroup('job_title')
                    {!! Form::label('Job Title', null, ['class' => 'col-md-3 control-label']) !!}

                    <div class="col-md-6">
                        {!! Form::text('job_title', Auth::user()->job_title, ['class' => 'form-control']) !!}
                        @error('job_title')
                    </div>
                @endFormGroup

            @formGroup('mobile')
            {!! Form::label('Mobile Number', null, ['class' => 'col-md-3 control-label']) !!}

            <div class="col-md-6">
                {!! Form::text('mobile', Auth::user()->mobile, ['class' => 'form-control', 'placeholder' => '+960 0000000']) !!}
                @error('mobile')
                <div>
                    {!! Form::checkbox('keep_mobile_private', 1, Auth::user()->keep_mobile_private) !!} Kept Private
                </div>
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

            @formGroup('bio')

            @formGroup('twitter_username')
            {!! Form::label('Twitter Username', null, ['class' => 'col-md-3 control-label']) !!}

            <div class="col-md-6">
                {!! Form::text('twitter_username', Auth::user()->twitter_username, ['class' => 'form-control']) !!}
                <p><small>If you are on twitter, others can find you and follow you</small></p>
                @error('twitter_username')
            </div>
            @endFormGroup

            {!! Form::label('Additional Features', null, ['class' => 'col-md-3 control-label']) !!}

            <div class="col-md-6">
                <br/>
                <div>
                    {!! Form::checkbox('list_on_public_directory', 1, Auth::user()->list_on_public_directory) !!} List me on members public directory
                </div>
            </div>
            @endFormGroup

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-6">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
