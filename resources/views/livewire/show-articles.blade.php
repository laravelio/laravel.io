<div>
    <!-- Filtered articles -->
    <div class="pt-5 pb-10 shadow-inner lg:pt-16 lg:pb-0">
        <div class="container mx-auto flex flex-col gap-x-12 px-4 lg:flex-row">
            <div class="lg:w-3/4">
                <div class="flex justify-between items-center lg:block">
                    <div class="flex justify-between items-center">
                        <h1 class="text-4xl text-gray-900 font-bold">
                            Articles
                        </h1>

                        <x-buttons.primary-button href="{{ route('articles.create') }}" class="hidden lg:block">
                            Create Article
                        </x-buttons.primary-button>
                    </div>

                    <div class="flex items-center justify-between lg:mt-6">
                        <h3 class="text-gray-800 text-xl font-semibold">
                            {{ number_format($articles->total()) }} Articles
                        </h3>

                        <div class="hidden lg:flex gap-x-2">
                            <x-articles.filter :selectedSortBy="$selectedSortBy" />

                            <div class="flex-shrink-0">
                                <x-buttons.secondary-button class="flex items-center gap-x-2" @click="activeModal = 'tag-filter'">
                                    <x-heroicon-o-filter class="w-5 h-5" />
                                    Tag filter
                                </x-buttons.secondary-button>
                            </div>
                        </div>
                    </div>

                    @if ($selectedTag)
                        <div class="hidden lg:flex gap-x-4 items-center mt-4 pt-5 border-t">
                            Filter applied
                            <x-tag>
                                <span class="flex items-center gap-x-1">
                                    {{ $selectedTag->name() }}
                                    <button type="button" wire:click="toggleTag('')">
                                        <x-heroicon-o-x class="w-5 h-5" />
                                    </button>
                                </span>
                            </x-tag>
                        </div>
                    @endisset
                </div>

                <div class="pt-2 lg:hidden">
                    @include('layouts._ads._forum_sidebar')

                    <div class="flex gap-x-4 mt-10">
                        <div class="w-1/2">
                            <x-buttons.secondary-cta class="w-full" @click="activeModal = 'tag-filter'">
                                <span class="flex items-center gap-x-2">
                                    <x-heroicon-o-filter class="w-5 h-5" />
                                    Tag filter
                                </span>
                            </x-buttons.secondary-cta>
                        </div>

                        <div class="w-1/2">
                            <x-buttons.primary-cta href="{{ route('articles.create') }}" class="w-full">
                                Create Article
                            </x-buttons.primary-cta>
                        </div>
                    </div>

                    <div class="flex mt-4">
                        <x-articles.filter :selectedSortBy="$selectedSortBy" />
                    </div>

                    @if ($selectedTag)
                        <div class="flex gap-x-4 items-center mt-4">
                            Filter applied
                            <x-tag>
                                <span class="flex items-center gap-x-1">
                                    {{ $selectedTag->name() }}
                                    <button type="button" wire:click="toggleTag('')">
                                        <x-heroicon-o-x class="w-5 h-5" />
                                    </button>
                                </span>
                            </x-tag>
                        </div>
                    @endif
                </div>

                <section class="mt-8 mb-5 lg:mb-16">
                    <div class="flex flex-col gap-y-4">
                        @foreach ($articles as $article)
                            <x-articles.overview-summary :article="$article" />
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $articles->onEachSide(1)->links() }}
                    </div>
                </section>
            </div>

            <div class="lg:w-1/4">
                <div class="hidden lg:block">
                    @include('layouts._ads._forum_sidebar')
                </div>

                <div class="bg-white shadow mt-6 pb-4">
                    <h3 class="text-xl font-semibold px-5 pt-5">
                        Moderators
                    </h3>

                    <ul>
                        @foreach ($moderators as $moderator)
                            <li class="{{ ! $loop->last ? 'border-b ' : '' }}flex items-center gap-x-5 pb-3 pt-5 px-5">
                                <x-avatar :user="$moderator" class="w-10 h-10" />
                                <span class="flex flex-col">
                                    <a href="{{ route('profile', $moderator->username()) }}" class="hover:underline">
                                        <span class="text-gray-900 font-medium">
                                            {{ $moderator->name() }}
                                        </span>
                                    </a>

                                    <span class="text-gray-700">
                                        Joined {{ $moderator->createdAt()->format('j M Y') }}
                                    </span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Filtered articles -->

    <div class="modal" x-show="activeModal === 'tag-filter'" x-cloak>
        <div class="w-full h-full p-8 lg:w-96 lg:h-3/4 overflow-y-scroll">
            <x-articles.tag-filter :selectedTag="$selectedTag ?? null" :tags="$tags" />
        </div>
    </div>
</div>