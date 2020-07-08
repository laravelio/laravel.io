<div class="container mx-auto px-4 pt-4 flex flex-wrap flex-col-reverse lg:flex-row mb-8">
    <div class="w-full lg:w-3/4 py-8 lg:pr-4">
        <div wire:loading class="flex w-full h-full text-2xl text-gray-700">
            Loading...
        </div>

        @foreach($articles as $article)
            <div class="pb-8 mb-8 border-b-2">
                <div>
                    @foreach ($article->tags() as $tag)
                        <button class="inline-block focus:outline-none rounded-full {{ $tag->slug() === $selectedTag ? 'bg-green-primary text-white shadow-outline-green' : 'bg-green-light text-green-primary' }}" wire:click="toggleTag('{{ $tag->slug() }}')">
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5">
                                {{ $tag->name() }}
                            </span>
                        </button>
                    @endforeach
                </div>
                <a href="{{ route('articles.show', $article->slug()) }}" class="block">
                    <span class="mt-4 flex items-center">
                        @if ($article->isPinned())
                            <x-zondicon-pin class="w-5 h-5 text-green-primary mr-2"/>
                        @endif
                        
                        <h3 class="text-xl leading-7 font-semibold text-gray-900">
                            {{ $article->title() }}
                        </h3>
                    </span>
                    <p class="mt-3 text-base leading-6 text-gray-500">
                        {{ $article->excerpt() }}
                    </p>
                </a>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('profile', $article->author()->username()) }}">
                                <img class="h-10 w-10 rounded-full" src="{{ $article->author()->gravatarUrl($avatarSize ?? 250) }}" alt="{{ $article->author()->name }}" />
                            </a>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm leading-5 font-medium text-gray-900">
                                <a href="{{ route('profile', $article->author()->username()) }}">
                                    {{ $article->author()->name() }}
                                </a>
                            </p>
                            <div class="flex text-sm leading-5 text-gray-500">
                                <time datetime="{{ $article->submittedAt()->format('Y-m-d') }}">
                                    {{ $article->submittedAt()->format('j M, Y') }}
                                </time>
                                <span class="mx-1">
                                    &middot;
                                </span>
                                <span>
                                    {{ $article->readTime() }} min read
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center text-gray-500">
                        <span class="text-2xl mr-2">👏</span>
                        {{ $article->likesCount() }}
                    </div>
                </div>
            </div>
        @endforeach

        {{ $articles->links() }}
        
    </div>

    <div class="w-full lg:w-1/4 lg:pt-8 lg:pl-4">
        <span class="relative z-0 inline-flex shadow-sm mb-8">
            <button wire:click="sortBy('recent')" type="button" class="relative inline-flex items-center px-4 py-2 rounded-l-md border text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-green-light focus:shadow-outline-green active:bg-green-primary active:text-white transition ease-in-out duration-150 {{ $selectedSortBy === 'recent' ? 'bg-green-primary text-white border-green-primary shadow-outline-green z-10' : 'bg-white text-gray-700 border-gray-300' }}">
                Recent
            </button>
            <button wire:click="sortBy('popular')" type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-green-light focus:shadow-outline-green active:bg-green-primary active:text-white transition ease-in-out duration-150 {{ $selectedSortBy === 'popular' ? 'bg-green-primary text-white border-green-primary shadow-outline-green z-10' : 'bg-white text-gray-700 border-gray-300' }}">
                Popular
            </button>
            <button wire:click="sortBy('trending')" type="button" class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border text-sm leading-5 font-medium focus:z-10 focus:outline-none focus:border-green-light focus:shadow-outline-green active:bg-green-primary active:text-white transition ease-in-out duration-150 {{ $selectedSortBy === 'trending' ? 'bg-green-primary text-white border-green-primary shadow-outline-green z-10' : 'bg-white text-gray-700 border-gray-300' }}">
                Trending 🔥
            </button>
        </span>

        <a 
            href="{{ route('articles.create') }}"
            class="button button-primary button-full mb-4"
        >
            Create Article
        </a>

        <ul class="tags">
            <li class="{{ ! $selectedTag ? ' active' : '' }}">
                <button wire:click="toggleTag('')">
                    All
                </button>
            </li>   

            @foreach ($tags as $tag)
                <li class="{{ $selectedTag === $tag->slug() ? ' active' : '' }}">
                    <button wire:click="toggleTag('{{ $tag->slug() }}')">
                        {{ $tag->name() }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
