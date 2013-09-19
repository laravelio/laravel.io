<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <ul>
            <li><a href="{{ action('Controllers\ForumController@getIndex') }}">Forum</a></li>
        </ul>

        @include('layouts._flash')

        {{ $content }}
    </body>
</html>