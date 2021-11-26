<div x-data="{ results: false, threads: [], articles: [] }">
    <label for="search" class="sr-only">Search</label>

    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <x-heroicon-o-search class="h-5 w-5 text-gray-800"/>
        </div>

        <input 
            @click.outside="results = false" 
            @keyup="search(event).then(function({ results: hits }) { results = true; threads = hits[0].hits; articles = hits[1].hits; })" 
            type="search" 
            name="search" 
            id="search" 
            class="border-0 border-t border-b block pl-10 border-gray-300 md:border md:rounded w-full" 
            placeholder="Search for threads and articles..."
        />

        <template x-if="results">
            <div class="search absolute md:origin-top-right md:right-0 md:rounded md:shadow-lg bg-white md:mt-2 z-50">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full flex-none border-r border-b md:w-1/2">
                        <div class="flex text-lg font-medium border-b p-4">
                            <span class="text-gray-900 mr-3">Threads</span>

                            <span class="text-gray-300" x-text="threads.length + ' Results'"></span>
                        </div>

                        <div class="max-h-72 overflow-y-scroll">
                            <template x-for="thread in threads" :key="thread.subject">
                                <a :href="'/forum/'+thread.slug" class="flex flex-col px-4 py-2 hover:bg-lio-100">
                                    <span class="text-black-900 text-lg font-medium break-all" x-html="thread._highlightResult.subject.value"></span>
                                    <span class="text-black-900 break-all" x-html="thread._snippetResult.body.value"></span>
                                </a>
                            </template>
                        </div>

                        <span x-show="threads.length === 0" x-cloak class="p-4 text-gray-500 block">
                            No threads found
                        </span>
                    </div>

                    <div class="w-full flex-none border-b md:w-1/2">
                        <div class="flex text-lg font-medium border-b p-4">
                            <span class="text-gray-900 mr-3">Articles</span>

                            <span class="text-gray-300" x-text="threads.length + ' Results'"></span>
                        </div>

                        <div class="max-h-72 overflow-y-scroll">
                            <template x-for="article in articles" :key="article.title">
                                <a :href="'/articles/'+article.slug" class="flex flex-col px-4 py-2 hover:bg-lio-100">
                                    <span class="text-black-900 text-lg font-medium break-all" x-html="article._highlightResult.title.value"></span>
                                    <span class="text-black-900 break-all" x-html="article._snippetResult.body.value"></span>
                                </a>
                            </template>
                        </div>

                        <span x-show="articles.length === 0" x-cloak class="p-4 text-gray-500 block">
                            No articles found
                        </span>
                    </div>
                </div>

                <a href="https://algolia.com" class="flex justify-end px-4 py-2">
                    <img src="{{ asset('images/algolia.svg') }}" class="h-4 mx-4 my-2" />
                </a>
            </div>
        </template>
    </div>
</div>
