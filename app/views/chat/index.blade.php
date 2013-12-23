<h2>#Laravel IRC Chat</h2>

@if(Auth::check() or Session::has('userLazilyOptsOutOfAuthOnChat'))
	<iframe src="https://kiwiirc.com/client/irc.freenode.net/?&nick={{ Auth::check() ? Auth::user()->name : 'laravelnewbie'}}#laravel" style="border:0; width:100%; height:450px;"></iframe>
	<a href="http://irclogs.laravel.io" target="_NEW">Search the chat logs</a> to see if your question has already been answered. You can use your own IRC client at Freenode.net in #Laravel.<br>
	Channel Moderators are: TaylorOtwell, ShawnMcCool, PhillSparks, daylerees, JasonLewis, machuga and JesseOBrien.
@else
	{{-- look at how much I don't give a crap --}}
	<?Session::put('userLazilyOptsOutOfAuthOnChat', 1)?>

    <section class="empty-state">
        <h1>Please login</h1>
        <p>For the best experience, login with GitHub to chat.</p>
        <a class="button full" href="{{ action('AuthController@getLogin') }}">Login with GitHub</a>
    </section>

	<p>
		Or, if you can&#39;t be arsed to authenticate (just do it) then.. <a href="{{ action('ChatController@getIndex') }}">click here</a>
	</p>
@endif
