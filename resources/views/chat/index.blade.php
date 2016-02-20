@extends('layouts.default', ['pageTitle' => 'Live Chat'])

@section('table')
    <h2>#Laravel IRC Chat</h2>

    <iframe src="https://kiwiirc.com/client/irc.freenode.net/?&nick={{ Auth::check() ? Auth::user()->name : 'laravelnewbie'}}#laravel" style="border:0; width:100%; height:450px;"></iframe>
    <a href="http://irclogs.laravel.io" target="_blank">Search the chat logs</a> to see if your question has already been answered.You can use your own IRC client at Freenode.net in #Laravel.<br>
    Channel Moderators are: TaylorOtwell, ShawnMcCool, PhillSparks, daylerees, JasonLewis, machuga and JesseOBrien.
@stop
