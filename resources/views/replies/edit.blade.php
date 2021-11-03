@title('Edit your reply')

@extends('layouts.default', ['isTailwindUi' => true])

@section('subnav')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900 break-all">{{ $title }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <main class="max-w-4xl mx-auto pt-10 pb-12 px-4 lg:pb-16">        
        <div class="lg:grid lg:gap-x-5">
            <div class="sm:px-6 lg:px-0 lg:col-span-9">
                <x-buk-form action="{{ route('replies.update', $reply->id()) }}" method="PUT">

                    <livewire:editor 
                        label="Upate your reply"
                        :body="$reply->body()" 
                        placeholder="Update your reply..."
                        hasButton 
                        buttonLabel="Update reply"
                        buttonIcon="send"
                    />
                    
                    @error('body')
                </x-buk-form>
            </div>
        </div>
    </main>
@endsection
