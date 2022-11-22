<div x-data="searchConfig()" x-init="$watch('searchVisible', value => toggle())" x-show="searchVisible" x-cloak
    class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-700 bg-opacity-50 transition-opacity" aria-hidden="true"></div>

    <div @click.outside="searchVisible = false"
        class="mx-auto max-w-xl transform overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
        <div class="relative">
            <label for="search" class="sr-only">Search</label>

            <svg class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd" />
            </svg>
            <input x-model="searchQuery" @input.debounce.100ms="search" x-ref="search" type="text" name="search"
                id="search"
                class="h-12 w-full border-0 bg-transparent px-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                placeholder="Search..." role="combobox" aria-expanded="false" aria-controls="options">
            <kbd @keyup.window.escape="searchVisible = false" @click="searchVisible = false"
                class="absolute top-3.5 right-4 text-xs rounded bg-gray-100 text-gray-500 px-2 py-1 cursor-pointer">ESC</kbd>
        </div>

        <div x-show="!searchQuery.length" x-cloak
            class="border-t border-gray-100 py-14 px-6 text-center text-sm sm:px-14">
            <svg class="mx-auto h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="mt-4 font-semibold text-gray-900">Search for threads and articles</p>
            <p class="mt-2 text-gray-500">Quickly access threads and articles by running a global search.</p>
        </div>

        <ul x-show="searchQuery.length && (threads.total || articles.total)" x-cloak
            class="max-h-fit scroll-pt-11 scroll-pb-2 space-y-2 overflow-y-auto pb-2" id="options" role="listbox">
            <li>
                <h2 class="bg-gray-100 py-2.5 px-4 font-semibold text-gray-900">
                    Threads <span x-text="threads.formattedTotal()" class="ml-2 text-sm text-gray-500"></span>
                </h2>
                <ul class="mt-2 text-sm text-gray-800">
                    <template x-for="thread in threads.threads">
                        <li class="cursor-default select-none px-4 py-2 hover:bg-lio-100" :id="`option-${thread.id}`"
                            role="option" tabindex="-1">
                            <a :href="'/forum/'+thread.slug" class="flex flex-col">
                                <span class="text-black-900 font-medium break-all"
                                    x-html="thread._highlightResult.subject.value"></span>
                                <span class="text-black-900 break-all" x-html="thread._snippetResult.body.value"></span>
                            </a>
                        </li>
                    </template>
                </ul>
            </li>
            <li>
                <h2 class="bg-gray-100 py-2.5 px-4 font-semibold text-gray-900">
                    Articles <span x-text="articles.formattedTotal()" class="ml-2 text-sm text-gray-500"></span>
                </h2>
                <ul class="mt-2 text-sm text-gray-800">
                    <template x-for="article in articles.articles">
                        <li class="cursor-default select-none px-4 py-2 hover:bg-lio-100" :id="`option-${article.id}`"
                            role="option" tabindex="-1">
                            <a :href="'/articles/'+article.slug" class="flex flex-col">
                                <span class="text-black-900 font-medium break-all"
                                    x-html="article._highlightResult.title.value"></span>
                                <span class="text-black-900 break-all"
                                    x-html="article._snippetResult.body.value"></span>
                            </a>
                        </li>
                    </template>
                </ul>
            </li>
        </ul>

        <div x-show="searchQuery.length && !threads.total && !articles.total" x-cloak
            class="border-t border-gray-100 py-14 px-6 text-center text-sm sm:px-14">
            <svg class="mx-auto h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="mt-4 font-semibold text-gray-900">No results found</p>
            <p class="mt-2 text-gray-500">We couldn’t find anything with that term. Please try again.</p>
        </div>

        <div class="flex flex-wrap justify-end items-center bg-gray-50 py-2.5 px-4 text-xs text-gray-700">
            <a href="https://algolia.com">
                <img loading="lazy" src="{{ asset('images/algolia.svg') }}" alt="Magnifying glass icon" class="h-4" />
            </a>
        </div>

    </div>
</div>
