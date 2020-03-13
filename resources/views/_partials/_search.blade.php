<div class="max-w-lg w-full lg:max-w-xs" x-data="{ results: [] }">
    <label for="search" class="sr-only">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
        </div>
        <input 
            @click.away="results = []" 
            @keyup="search(event).then(function({ hits }) { results = hits; })" 
            type="text" 
            name="search" 
            id="search" 
            class="nav-search block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:shadow-outline-blue sm:text-sm transition duration-150 ease-in-out" 
            placeholder="Search for threads..." 
        />
        <template x-if="results.length > 0">
            <div x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="mt-2 origin-top-right absolute right-0 w-full rounded-md shadow-lg z-10">
                <div class="rounded-md bg-white shadow-xs w-full">
                    <div class="py-1">
                        <template x-for="result in results" :key="result.subject">
                            <a :href="'/forum/'+result.slug" class="block px-4 py-2 text-base leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                                <span class="block font-bold" x-html="result._highlightResult.subject.value"></span>
                                <span class="block text-sm txt-gray-400" x-html="result._snippetResult.body.value"></span>
                            </a>
                        </template>
                        <a href="https://algolia.com" class="flex justify-end">
                            <img src="{{ asset('images/algolia.svg') }}" class="h-4 mx-4 my-2" />
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>