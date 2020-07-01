@title('Update series')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">
                <a href="{{ route('user.series') }}">My Series</a>
                > {{ $title }}
            </h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto p-4 flex justify-center">
        <div class="w-full md:w-2/3 xl:w-1/2">
            <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100">
                @include('series._form', [
                    'route' => ['series.update', $series->id()],
                    'method' => 'PUT',
                ])
            </div>
        </div>
    </div>
@endsection
