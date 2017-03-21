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
                                <div class="btn-group">
                                    <a href="#" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-gear"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('profile', $user->username()) }}">View Profile</a></li>
                                    </ul>
                                </div>
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
