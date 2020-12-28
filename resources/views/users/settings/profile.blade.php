@title('Profile')

@extends('layouts.settings')

@section('content')
    <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100 mb-8">
        <form action="{{ route('settings.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <div>
                    <img class="rounded-full" src="{{ Auth::user()->gravatarUrl(100) }}">
                    <span class="text-gray-600 text-sm">Change your avatar on <a href="https://gravatar.com/" class="text-lio-700">Gravatar</a>.</span>
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

                @unless(Auth::user()->hasVerifiedEmail())
                    <span class="text-gray-600 text-sm">
                        This email address is not verified yet.
                        <a href="{{ route('verification.notice') }}" class="text-lio-500">Resend verification email.</a>
                    </span>
                @endunless

                @error('email')
            @endFormGroup

            @formGroup('username')
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ Auth::user()->username() }}" required />
                @error('username')
            @endFormGroup

            @formGroup('twitter')
                <label for="twitter">Twitter handle</label>
                <input type="text" name="twitter" id="twitter" value="{{ Auth::user()->twitter() }}" />
                @error('twitter_handle')
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
            <h3 class="text-red-500 uppercase mb-4">Danger Zone</h3>
            <p class="mb-8">Please be aware that deleting your account will also remove all of your data, including your threads and replies. This cannot be undone.</p>
            <div class="flex">
                <a href="javascript:" class="button button-danger" @click.prevent="activeModal = 'delete-user'">Delete Account</a>
            </div>
        </div>

        @include('_partials._delete_modal', [
            'identifier' => 'delete-user',
            'route' => ['settings.profile.delete'],
            'title' => 'Delete Account',
            'submit' => 'Confirm',
            'body' => '<p>Deleting your account will remove any related content like threads & replies. This cannot be undone.</p>',
        ])
    @endunless
@endsection
