@title('Create a series')

@extends('layouts.default')

@section('content')
    <div class="container mx-auto p-4 flex justify-center">
        <div class="w-full md:w-2/3 xl:w-1/2">
            <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100">
                @include('series._form', [
                    'route' => ['series.store'],
                ])
            </div>
        </div>
    </div>
@endsection
