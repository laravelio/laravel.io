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
                <form action="{{ route('replies.update', $reply->id()) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @formGroup('body')

                        @include('_partials._editor', [
                            'content' => old('body') ?: $reply->body()
                        ])
                        
                        @error('body')
                    @endFormGroup

                    <div class="flex items-center justify-end">
                        <a href="{{ route_to_reply_able($reply->replyAble()) }}" class="text-lio-700 mr-4">Cancel</a>
                        <button type="submit" class="button button-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
