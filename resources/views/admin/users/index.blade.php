@extends('layouts.default')

@section('table')

<header class="page">
    <div class="row">
        <div class="large-12 columns">
            <h1>Users</h1>
        </div>
    </div>
</header>

<div style="margin-bottom: 25px">
    {!! Form::open(['route' => 'admin.users.search', 'method' => 'GET']) !!}
        {!! Form::text('q') !!}
        {!! Form::submit('Search Users') !!}
    {!! Form::close() !!}
</div>

<div class="row">
    <div class="small-12 columns">
        @if ($users->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="padding:5px 10px;border: 1px solid #ccc">Name</th>
                        <th style="padding:5px 10px;border: 1px solid #ccc">Email</th>
                        <th style="padding:5px 10px;border: 1px solid #ccc">Signed up at</th>
                        <th style="padding:5px 10px;border: 1px solid #ccc">GitHub URL</th>
                        <th style="padding:5px 10px;border: 1px solid #ccc">Status</th>
                        <th style="padding:5px 10px;border: 1px solid #ccc">Roles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td style="padding:5px 10px;border: 1px solid #ccc"><h6><a href="{{ action('Admin\UsersController@getEdit', $user->id) }}">{{ $user->name }}</a></h6></td>
                            <td style="padding:5px 10px;border: 1px solid #ccc">{{ $user->email }}</td>
                            <td style="padding:5px 10px;border: 1px solid #ccc">{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                            <td style="padding:5px 10px;border: 1px solid #ccc"><a href="{{ $user->github_url }}" target="_blank">{{ $user->github_url }}</a></td>
                            <td style="padding:5px 10px;border: 1px solid #ccc">{{ $user->is_banned ? 'Banned' : 'Active' }}</td>
                            <td style="padding:5px 10px;border: 1px solid #ccc" class="capitalize"><span class="label secondary">{{ $user->roleList }}</span></td>
                        </tr>
                    @endforeach

                    {!! $users->render() !!}
                </tbody>
            </table>
        @else
            <div class="row">
                <div class="small-5 small-centered columns">
                    <div class="panel">
                        <h2>Sorry&hellip;</h2>
                        <p class="lead">
                            There are currently no users in the system.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@stop
