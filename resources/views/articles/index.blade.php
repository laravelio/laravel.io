@title('Community Articles')

@extends('layouts.default', ['isTailwindUi' => true])

@section('content')
    <x-articles.pinned :articles="$pinnedArticles" />

    <livewire:show-articles>
@endsection