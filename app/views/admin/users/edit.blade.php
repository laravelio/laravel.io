
<div class="row">
    <div class="small-12 columns">
        <h2>Editing User {{ $user->name }}</h2>

        <strong>GitHub Information</strong>
        <ul>
            <li>ID: {{ $user->github_id }}</li>
            <li>URL: <a href="{{ $user->github_url }}">{{ $user->github_url }}</a></li>
            <li>Name: {{ $user->name }}</li>
            <li>Email: {{ $user->email }}</li>
        </ul>

        {{ Form::open() }}
            <fieldset>
                <legend>Roles</legend>

                @foreach ($roles as $role)
                    <div class="row">
                        <div class="">
                            <span class="right">{{ Form::checkbox('roles[]', $role->id, $user->hasRole($role->name), ['id' => "role_{$role->id}"]) }}</span>
                        </div>
                        <div class="small-11 columns">
                            {{ Form::label("role_{$role->id}", $role->name) }}
                            @if ($role->name == 'admin_posts')
                                <p>
                                    If this option is enabled, the user can administer <strong>all</strong> posts on the system. This includes the ability to publish and remove posts at their discretion.
                                </p>
                            @elseif ($role->name == 'admin_forum')
                                <p>
                                    The user can moderate forum posts and in general cause a ruckus.
                                </p>
                            @elseif ($role->name == 'admin_users')
                                <p>
                                    When a user has this role, they are able to modify the roles of all other users as well as ban and unban users.
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach

            </fieldset>


            <fieldset>
                <legend>Ban</legend>

                <div class="row">
                    <div class="">
                        <span class="right">User is banned: {{ Form::checkbox('is_banned', 1, $user->is_banned == 1) }}</span>
                        <p>
                            When a user is banned, they'll be unable to log into the site using their GitHub account. This option should mostly be unnecessary.
                        </p>
                    </div>
                </div>

            </fieldset>

            <div class="row">
                <div class="large-12 columns">
                    {{ Form::button('Save', ['type' => 'submit']) }}
                </div>
            </div>

        {{ Form::close() }}
    </div>
</div>