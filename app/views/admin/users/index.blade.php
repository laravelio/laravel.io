<header class="page">
    <div class="row">
        <div class="large-12 columns">
            <h1>Users</h1>
        </div>
    </div>
</header>
<div class="row">
    <div class="small-12 columns">
        @if ($users->getTotal() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>GitHub URL</th>
                        <th>Status</th>
                        <th>Roles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td><h6><a href="{{ action('AdminUsersController@getEdit', $user->id) }}">{{ $user->name }}</a></h6></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->github_url }}</td>
                            <td>{{ $user->is_banned ? 'Banned' : 'Active' }}</td>
                            <td class="capitalize"><span class="label secondary">{{ $user->roleList }}</span></td>
                        </tr>
                    @endforeach

                    {{ $users->links() }}
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
