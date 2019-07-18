@title('Edit your reply')

@extends('layouts.default')

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">{{ $title }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto p-4 flex justify-center">
        <div class="w-full md:w-2/3 xl:w-1/2">
            <div class="md:p-4 md:border-2 md:rounded md:bg-gray-100">
                {!! Form::open(['route' => ['replies.update', $reply->id()], 'method' => 'PUT']) !!}
                    @formGroup('body')
                        {!! Form::textarea('body', $reply->body(), ['class' => 'editor']) !!}
                        @error('body')
                    @endFormGroup

                    <div class="flex items-center justify-end">
                        <a href="{{ route_to_reply_able($reply->replyAble()) }}" class="text-green-darker mr-4">Cancel</a>
                        {!! Form::submit('Update', ['class' => 'button']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
