@title('Create your thread')

@extends('layouts.default', ['isTailwindUi' => true])

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">
                <a href="{{ route('forum') }}">Forum</a>
                > <span class="break-all">{{ $title }}</span>
            </h1>
        </div>
    </div>
@endsection

@section('content')
    <main class="max-w-4xl mx-auto pt-10 pb-12 px-4 lg:pb-16">        
        <div class="lg:grid lg:gap-x-5">
            <div class="sm:px-6 lg:px-0 lg:col-span-9">
                <x-threads.form :tags="$tags" :route="['threads.store']" />

                <x-forms.info>
                    Please search for your question before posting your thread by using the search box in the navigation bar.
                </x-forms.info>
            </div>
        </div>
    </main>
@endsection
