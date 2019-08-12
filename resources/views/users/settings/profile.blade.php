@title('Profile')

@extends('layouts.settings')

@section('content')
    <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100 mb-8">
        <form action="{{ route('settings.profile.update') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group">
                <div>
                    <img class="rounded-full" src="{{ Auth::user()->gravatarUrl(100) }}">
                    <span class="text-gray-600 text-sm">Change your avatar on <a href="https://gravatar.com/" class="text-green-darker">Gravatar</a>.</span>
                </div>
            </div>

            @formGroup('name')
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name() }}" required />
                @error('name')
            @endFormGroup

            @formGroup('email')
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->emailAddress() }}" required />
                @error('email')
            @endFormGroup

            @formGroup('username')
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ Auth::user()->username() }}" required />
                @error('username')
            @endFormGroup

            @formGroup('bio')
                <label for="bio">Bio</label>
                <textarea name="bio" rows="3" maxlength="160">{{ Auth::user()->bio() }}</textarea>
                <span class="text-gray-600 text-sm">The user bio is limited to 160 characters.</span>
                @error('bio')
            @endFormGroup

            <div class="flex justify-end">
                <button type="submit" class="button button-primary">Save</button>
            </div>
        </form>
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
            'routeParams' => null,
            'title' => 'Delete Account',
            'submit' => 'Confirm',
            'body' => '<p>Deleting your account will remove any related content like threads & replies. This cannot be undone.</p>',
        ])
    @endunless
@endsection
