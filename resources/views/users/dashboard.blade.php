@title('Dashboard')

@extends('layouts.default')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap w-full md:w-2/3 mx-auto justify-center mb-8">
            <div class="w-full md:w-1/3 h-48 flex justify-center mb-4">
                <div class="flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-document-notes"><path class="primary" d="M6 2h6v6c0 1.1.9 2 2 2h6v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2zm2 11a1 1 0 0 0 0 2h8a1 1 0 0 0 0-2H8zm0 4a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2H8z"/><polygon class="secondary" points="14 2 20 8 14 8"/></svg>
                    <div class="text-gray-800 uppercase mt-4">
                        <span class="text-2xl block">{{ Auth::user()->countThreads() }}</span>
                        <span class="text-gray-600">threads</span>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/3 h-48 flex justify-center mb-4">
                <div class="flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-chat-group"><path class="primary" d="M20.3 12.04l1.01 3a1 1 0 0 1-1.26 1.27l-3.01-1a7 7 0 1 1 3.27-3.27zM11 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/><path class="secondary" d="M15.88 17.8a7 7 0 0 1-8.92 2.5l-3 1.01a1 1 0 0 1-1.27-1.26l1-3.01A6.97 6.97 0 0 1 5 9.1a9 9 0 0 0 10.88 8.7z"/></svg>
                    <div class="text-gray-800 uppercase mt-4">
                        <span class="text-2xl block">{{ Auth::user()->countReplies() }}</span>
                        <span class="text-gray-600">replies</span>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/3 h-48 flex justify-center mb-4">
                <div class="flex flex-col items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-check"><circle cx="12" cy="12" r="10" class="primary"/><path class="secondary" d="M10 14.59l6.3-6.3a1 1 0 0 1 1.4 1.42l-7 7a1 1 0 0 1-1.4 0l-3-3a1 1 0 0 1 1.4-1.42l2.3 2.3z"/></svg>
                    <div class="text-gray-800 uppercase mt-4">
                        <span class="text-2xl block">{{ Auth::user()->countSolutions() }}</span>
                        <span class="text-gray-600">solutions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('users._latest_content', ['user' => Auth::user()])
@endsection
