@title('Profile')

@extends('layouts.settings')

@section('content')
    <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100 mb-8">
        {!! Form::open(['route' => 'settings.profile.update', 'method' => 'PUT']) !!}
            <div class="form-group">
                <div>
                    <img class="rounded-full" src="{{ Auth::user()->gravatarUrl(100) }}">
                    <span class="text-gray-600 text-sm">Change your avatar on <a href="https://gravatar.com/" class="text-green-darker">Gravatar</a>.</span>
                </div>
            </div>

            @formGroup('name')
                {!! Form::label('name') !!}
                {!! Form::text('name', Auth::user()->name(), ['required']) !!}
                @error('name')
            @endFormGroup

            @formGroup('email')
                {!! Form::label('email') !!}
                {!! Form::email('email', Auth::user()->emailAddress(), ['required']) !!}
                @error('email')
            @endFormGroup

            @formGroup('username')
                {!! Form::label('username') !!}
                {!! Form::text('username', Auth::user()->username(), ['required']) !!}
                @error('username')
            @endFormGroup

            @formGroup('bio')
                {!! Form::label('bio') !!}
                {!! Form::textarea('bio', Auth::user()->bio(), ['rows' => 3, 'maxlength' => 160]) !!}
                <span class="text-gray-600 text-sm">The user bio is limited to 160 characters.</span>
                @error('bio')
            @endFormGroup

            <div class="flex justify-end">
                {!! Form::submit('Save', ['class' => 'button']) !!}
            </div>
        {!! Form::close() !!}
    </div>

    @unless (Auth::user()->isAdmin())
        <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100 mb-8">
            <h3 class="text-red-primary uppercase mb-4">Danger Zone</h3>
            <p class="mb-8">Please be aware that deleting your account will also remove all of your data, including your threads and replies. This cannot be undone.</p>
            <div class="flex">
                <a href="javascript:" class="button button-danger" @click.prevent="activeModal = 'delete-user'">Delete Account</a>
            </div>
        </div>


        @include('_partials._delete_modal', [
            'identifier' => 'delete-user',
            'route' => 'settings.profile.delete',
            'title' => 'Delete Account',
            'submit' => 'Confirm',
            'body' => '<p>Deleting your account will remove any related content like threads & replies. This cannot be undone.</p>',
        ])
    @endunless
@endsection
