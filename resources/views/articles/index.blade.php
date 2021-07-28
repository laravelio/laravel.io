@title('Community Articles')

@extends('layouts.default', ['isTailwindUi' => true])

@section('content')
    <div class="bg-white pt-5 lg:pt-2">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <x-articles.featured :articles="$pinnedArticles" />
        </div>
    </div>

    <div class="pt-5 pb-10 shadow-inner lg:pt-16 lg:pb-0">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <div class="lg:w-3/4">
                <livewire:show-articles>
            </div>

            <div class="lg:w-1/4">
                <div class="hidden lg:block">
                    @include('layouts._ads._forum_sidebar')
                </div>

                <div class="mt-6">
                    <x-moderators :moderators="$moderators" />
                </div>
            </div>
        </div>
    </div>
@endsection