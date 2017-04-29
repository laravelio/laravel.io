@title($user->name())

@extends('layouts.base')

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a class="btn btn-default btn-block" href="{{ route('profile', $user->username()) }}">View Profile</a>

                        @can(App\Policies\UserPolicy::BAN, $user)
                            @if ($user->isBanned())
                                <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#unbanUser">Unban User</button>
                            @else
                                <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#banUser">Ban User</button>
                            @endif
                        @endcan

                        @can(App\Policies\UserPolicy::DELETE, $user)
                            <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteUser">Delete User</button>
                        @endcan
                    </div>
                </div>

                <p style="text-align:center"><a href="{{ route('admin') }}"><i class="fa fa-arrow-left"></i> Back</a></p>
            </div>
            <div class="col-md-9">
                @include('layouts._alerts')

                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('users._user_info')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- The reason why we put the modals here is because otherwise UI gets broken --}}
    @can(App\Policies\UserPolicy::BAN, $user)
        @if ($user->isBanned())
            @include('_partials._update_modal', [
                'id' => 'unbanUser',
                'route' => ['admin.users.unban', $user->username()],
                'title' => "Unban {$user->name()}",
                'body' => '<p>Banning this user will prevent them from logging in, posting threads and replying to threads.</p>',
            ])
        @else
            @include('_partials._update_modal', [
                'id' => 'banUser',
                'route' => ['admin.users.ban', $user->username()],
                'title' => "Ban {$user->name()}",
                'body' => '<p>Unbanning this user will allow them to login again and post content.</p>',
            ])
        @endif
    @endcan

    @can(App\Policies\UserPolicy::DELETE, $user)
        @include('_partials._delete_modal', [
            'id' => 'deleteUser',
            'route' => ['admin.users.delete', $user->username()],
            'title' => "Delete {$user->name()}",
            'body' => '<p>Deleting this user will remove their account and any related content like threads & replies. This cannot be undone.</p>',
        ])
    @endcan
@endsection
