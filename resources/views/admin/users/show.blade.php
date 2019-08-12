@title($user->name())

@extends('layouts.base')

@section('body')
    <div class="container mx-auto px-4 pt-4">
        <div class="flex flex-wrap justify-center">
            <div class="w-full md:w-1/4 md:pr-3">
                @include('layouts._alerts')

                <div class="flex flex-col items-center text-center">
                    @include('users._user_info')
                </div>
            </div>
            <div class="w-full hidden md:w-1/4 md:pl-3 md:pt-4 md:flex items-center flex-col text-center mb-4">
                <a class="button button-muted w-full mb-4" href="{{ route('profile', $user->username()) }}">View Profile</a>

                @can(App\Policies\UserPolicy::BAN, $user)
                    @if ($user->isBanned())
                        <button type="button" class="button w-full mb-4" @click.prevent="activeModal = 'unbanUser'">Unban User</button>
                    @else
                        <button type="button" class="button button-danger w-full mb-4" @click.prevent="activeModal = 'banUser'">Ban User</button>
                    @endif
                @endcan

                @can(App\Policies\UserPolicy::DELETE, $user)
                    <button type="button" class="button button-danger w-full mb-4" @click.prevent="activeModal = 'deleteUser'">Delete User</button>
                @endcan

                <p class="text-center text-green-darker text-lg"><a href="{{ route('admin') }}"><i class="fa fa-arrow-left"></i> Back</a></p>
            </div>
        </div>
    </div>

    {{-- The reason why we put the modals here is because otherwise UI gets broken --}}
    @can(App\Policies\UserPolicy::BAN, $user)
        @if ($user->isBanned())
            @include('_partials._update_modal', [
                'identifier' => 'unbanUser',
                'route' => 'admin.users.unban',
                'routeParams' => $user->username()
                'title' => "Unban {$user->name()}",
                'body' => '<p>Banning this user will prevent them from logging in, posting threads and replying to threads.</p>',
            ])
        @else
            @include('_partials._update_modal', [
                'identifier' => 'banUser',
                'route' => 'admin.users.ban',
                'routeParams' => $user->username(),
                'title' => "Ban {$user->name()}",
                'body' => '<p>Unbanning this user will allow them to login again and post content.</p>',
            ])
        @endif
    @endcan

    @can(App\Policies\UserPolicy::DELETE, $user)
        @include('_partials._delete_modal', [
            'identifier' => 'deleteUser',
            'route' => 'admin.users.delete',
            'routeParams' => $user->username(),
            'title' => "Delete {$user->name()}",
            'body' => '<p>Deleting this user will remove their account and any related content like threads & replies. This cannot be undone.</p>',
        ])
    @endcan
@endsection
