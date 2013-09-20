<h2>#Laravel IRC Chat</h2>

@if(Auth::check())
	<iframe src="https://kiwiirc.com/client/irc.freenode.net/?&nick={{ Auth::user()->name }}#laravel" style="border:0; width:100%; height:450px;"></iframe>
	<a href="http://irclogs.laravel.io" target="_NEW">Search the chat logs</a> to see if your question has already been answered. You can use your own IRC client at Freenode.net in #Laravel.<br>
	Channel Moderators are: TaylorOtwell, ShawnMcCool, PhillSparks, daylerees, JasonLewis, machuga and JesseOBrien.
@else
	In order to use the online chat, you must first login. The signup process is a painless authentication with GitHub. <a href="{{ action('Controllers\AuthController@getLogin') }}">Authenticate with GitHub</a>
@endif