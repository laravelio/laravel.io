@title('Users')

@extends('layouts.default')

@section('content')
    <div class="panel panel-default panel-search">
        <div class="panel-heading">
            Users
            {{ Form::open(['route' => 'admin', 'method' => 'GET']) }}
                <div class="input-group">
                    {{ Form::text('search', $search ?? null, ['class' => 'form-control', 'placeholder' => 'Search for users...']) }}
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            {{ Form::close() }}
        </div>

        <table class="table table-striped table-sort">
            <thead>
                <tr>
                    <th>Joined On</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->createdAt() }}</td>
                        <td>{{ $user->name() }}</td>
                        <td>{{ $user->emailAddress() }}</td>
                        <td>
                            @if ($user->isBanned())
                                <span class="label label-warning">Banned</span>
                            @elseif ($user->isAdmin())
                                <span class="label label-primary">Admin</span>
                            @elseif ($user->isModerator())
                                <span class="label label-primary">Moderator</span>
                            @else
                                <span class="label label-default">User</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <a href="{{ route('admin.users.show', $user->username()) }}" class="btn btn-xs btn-link">
                                <i class="fa fa-gear"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-center">
        {!! $users->render() !!}
    </div>
@endsection
