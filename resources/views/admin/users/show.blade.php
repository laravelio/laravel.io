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
                        @include('users._profile_user_info')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="banUser" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['route' => ['admin.users.ban', $user->username()], 'method' => 'PUT']) }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Ban {{ $user->name() }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>Banning this user will prevent them from logging in, posting threads and replying to threads.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        {{ Form::submit('Ban User', ['class' => 'btn btn-warning']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="unbanUser" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['route' => ['admin.users.unban', $user->username()], 'method' => 'PUT']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Unban {{ $user->name() }}</h4>
                </div>
                <div class="modal-body">
                    <p>Unbanning this user will allow them to login again and post content.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    {{ Form::submit('Unban User', ['class' => 'btn btn-warning']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::open(['route' => ['admin.users.delete', $user->username()], 'method' => 'DELETE']) }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete {{ $user->name() }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>Deleting this user will remove their account and any related content like threads & replies. This cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        {{ Form::submit('Delete User', ['class' => 'btn btn-danger']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
