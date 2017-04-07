@title($user->name())

@extends('layouts.base')

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a class="btn btn-default btn-block" href="{{ route('profile', $user->username()) }}">View Profile</a>

                        @if ($user->isAdmin())
                            <button type="button" class="btn btn-warning btn-block disabled">Ban User</button>
                            <button type="button" class="btn btn-danger btn-block disabled">Delete User</button>
                        @else
                            @if ($user->isBanned())
                                <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#unbanUser">Unban User</button>
                            @else
                                <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#banUser">Ban User</button>
                            @endif

                            <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#deleteUser">Delete User</button>
                        @endif
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

    @if (! $user->isAdmin())
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

        @include('_partials._delete_modal', [
            'id' => 'deleteUser',
            'route' => ['admin.users.delete', $user->username()],
            'title' => "Delete {$user->name()}",
            'body' => '<p>Deleting this user will remove their account and any related content like threads & replies. This cannot be undone.</p>',
        ])
    @endif
@endsection
