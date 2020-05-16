<div class="max-w-lg w-full lg:max-w-xs" x-data="{ results: false, threads: [], articles: [] }">
    <label for="search" class="sr-only">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
        </div>
        <input 
            @click.away="results = false" 
            @keyup="search(event).then(function({ results: hits }) { results = true; threads = hits[0].hits; articles = hits[1].hits; })" 
            type="text" 
            name="search" 
            id="search" 
            class="nav-search block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:shadow-outline-blue sm:text-sm transition duration-150 ease-in-out" 
            placeholder="Search for threads..." 
        />
        <template x-if="results">
            <div x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="search mt-1 origin-top-right absolute right-0 rounded-md shadow-lg z-10">
                <div class="rounded-md bg-white shadow-xs w-full">
                    <div class="flex flex-col border-b md:flex-row">
                        <div class="py-1 w-full border-b md:w-1/2 md:border-r md:border-b-0">
                            <span class="text-xl px-4 py-2 text-gray-700">Threads</span>
                            <template x-for="thread in threads" :key="thread.subject">
                                <a :href="'/forum/'+thread.slug" class="block px-4 py-2 text-base leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                                    <span class="block font-bold break-all" x-html="thread._highlightResult.subject.value"></span>
                                    <span class="block text-sm txt-gray-400 break-all" x-html="thread._snippetResult.body.value"></span>
                                </a>
                            </template>
                            <span x-show="threads.length === 0" x-cloak class="px-4 text-gray-500 block">
                                No threads found
                            </span>
                        </div>
                        <div class="py-1 w-full md:w-1/2">
                            <span class="text-xl px-4 py-2 text-gray-700">Articles</span>
                            <template x-for="article in articles" :key="article.title">
                                <a :href="'/articles/'+article.slug" class="block px-4 py-2 text-base leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                                    <span class="block font-bold break-all" x-html="article._highlightResult.title.value"></span>
                                    <span class="block text-sm txt-gray-400 break-all" x-html="article._snippetResult.body.value"></span>
                                </a>
                            </template>
                            <span x-show="articles.length === 0" x-cloak class="px-4 text-gray-500 block">
                                No articles found
                            </span>
                        </div>
                    </div>
                    <a href="https://algolia.com" class="flex justify-end">
                        <img src="{{ asset('images/algolia.svg') }}" class="h-4 mx-4 my-2" />
                    </a>
                </div>
            </div>
        </template>
    </div>
</div>