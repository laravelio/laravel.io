@title('Community Articles')

@extends('layouts.default', ['isTailwindUi' => true])

@section('content')
    <div class="bg-white pt-5 lg:pt-2">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <x-articles.featured :articles="$pinnedArticles" />
        </div>
    </div>

    <livewire:show-articles>
@endsection