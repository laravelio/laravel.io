@title($user->name())

@extends('layouts.default')

@section('content')
    <div class="flex justify-center mt-8 mb-12">
        <div class="flex flex-col items-center">
            @include('users._user_info')
        </div>
    </div>
    @include('users._latest_content')
@endsection
