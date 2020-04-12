@title('Articles')

@extends('layouts.default')

@section('content')
    <div class="bg-white border-b">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl py-4 text-gray-900">{{ $title }}</h1>
            
            <form action="{{ route('admin') }}" method="GET">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search for users..." value="{{ $search ?? null }}" />
            </form>
        </div>
    </div>

    <div class="container mx-auto p-4 flex flex-wrap flex-col-reverse md:flex-row">
        <div class="w-full md:w-3/4 md:pr-3">
            <table class="table table-striped mt-8">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Submitted on</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->title() }}</td>
                            <td>{{ $article->author()->name() }}</td>
                            <td>{{ $article->submittedAt()->format('j M Y H:i:s') }}</td>
                            <td style="text-align:center;">
                                <a href="{{ route('articles.show', $article->slug()) }}" class="text-green-dark">
                                    <x-heroicon-o-cog class="h-5 w-5"/>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-center">
                {!! $articles->render() !!}
            </div>
        </div>
        <div class="w-full md:w-1/4 md:pl-3 md:pt-4">
            @include('admin.partials._navigation')
        </div>
    </div>
@endsection
