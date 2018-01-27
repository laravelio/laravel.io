@title($user->name())

@extends('layouts.default')

@section('content')
    <div id="profile">
        @include('users._user_info')
        @auth
        @include('users._latest_content')
        @endauth
    </div>
@endsection
