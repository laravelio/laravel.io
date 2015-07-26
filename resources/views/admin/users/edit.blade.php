@extends('layouts.default')

@section('table')

<div class="row">
    <div class="small-12 columns">
        <h2>Editing User {{ $user->name }}</h2>

        <strong>GitHub Information</strong>

        <ul>
            <li>ID: {{ $user->id }}</li>
            <li>Github ID: {{ $user->github_id }}</li>
            <li>Github url: <a href="{{ $user->github_url }}" target="_blank">{{ $user->github_url }}</a></li>
            <li>Github username: {{ $user->name }}</li>
            <li>Email: {{ $user->email }}</li>
        </ul>

        {!! Form::open() !!}
            <fieldset>
                <legend>Roles</legend>

                @foreach ($roles as $role)
                    <div class="row">
                        <div class="">
                            <span class="right">
                                {!! Form::checkbox('roles[]', $role->id, $user->hasRole($role->name), ['id' => "role_{$role->id}"]) !!}
                            </span>
                        </div>
                        <div class="small-11 columns">
                            {!! Form::label("role_{$role->id}", $role->name) !!}
                            <p>
                                {{ $role->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </fieldset>

            <fieldset>
                <legend>Ban</legend>

                <div class="row">
                    <div class="">
                        <span class="right">User is banned: {!! Form::checkbox('is_banned', 1, $user->is_banned == 1) !!}</span>
                        <p>
                            When a user is banned, they&#39;ll be unable to log into the site using their GitHub account. This option should mostly be unnecessary.
                        </p>
                    </div>
                </div>
            </fieldset>

            <div class="row">
                <div class="large-12 columns">
                    {!! Form::button('Save', ['type' => 'submit']) !!}
                </div>
            </div>
        {!! Form::close() !!}

        @if (! $user->is_banned)
            {!! Form::open(['action' => ['Admin\UsersController@putBanAndDeleteThreads', $user->id], 'method' => 'put']) !!}
                <div class="row">
                    <div class="large-12 columns">
                        {!! Form::button('Ban and delete threads', ['type' => 'submit']) !!}
                    </div>
                </div>
            {!! Form::close() !!}
        @endif
    </div>
</div>

@stop
