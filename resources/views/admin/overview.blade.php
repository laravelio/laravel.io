@title('Users')

@extends('layouts.default')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Users</div>
        <div class="panel-body">
            <table class="table table-striped table-sort">
                <thead>
                    <tr>
                        <th>Joined On</th>
                        <th>Name</th>
                        <th>E-mail Address</th>
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
                                @else
                                    <span class="label label-default">User</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <a href="{{ route('admin.users.show', $user->username()) }}" class="btn btn-xs btn-link"><i class="fa fa-gear"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center">
                {!! $users->render() !!}
            </div>
        </div>
    </div>
@endsection
