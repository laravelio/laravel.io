<div
    x-data="searchConfig()"
    x-init="$watch('searchVisible', (value) => toggle())"
    x-show="searchVisible"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto p-4 sm:p-6 md:p-20"
    role="dialog"
    aria-modal="true"
>
    <div class="fixed inset-0 bg-gray-700 bg-opacity-50 transition-opacity" aria-hidden="true"></div>

    <div
        @click.outside="searchVisible = false"
        class="mx-auto max-w-xl transform overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all"
    >
        <div class="relative">
            <label for="search" class="sr-only">Search</label>

            <svg class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
            <input
                x-model="searchQuery"
                @input.debounce.100ms="search"
                x-ref="search"
                type="text"
                name="search"
                id="search"
                class="h-12 w-full border-0 bg-transparent px-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                placeholder="Search..."
                role="combobox"
                aria-expanded="false"
                aria-controls="options"
            />
            <kbd
                @keyup.window.escape="searchVisible = false"
                @click="searchVisible = false"
                class="absolute right-4 top-3.5 cursor-pointer rounded bg-gray-100 px-2 py-1 text-xs text-gray-500"
            >
                ESC
            </kbd>
        </div>

        <div
            x-show="!searchQuery.length"
            x-cloak
            class="border-t border-gray-100 px-6 py-14 text-center text-sm sm:px-14"
        >
            <svg class="mx-auto h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="mt-4 font-semibold text-gray-900">Search for threads, articles and users</p>
            <p class="mt-2 text-gray-500">Quickly access threads and articles by running a global search.</p>
        </div>

        <div
            x-show="searchQuery.length && (threads.total || articles.total || users.total)"
            x-data="tabConfig()"
            x-init="$watch('activeTab', (value) => setActiveTab(value))"
            x-cloak
        >
            <ul class="grid grid-flow-col rounded-lg bg-gray-100 p-1 text-center text-gray-500">
                <li>
                    <a
                        href="javascript:void(0)"
                        @click="activeTab = 'threads'"
                        class="flex justify-center py-4"
                        :class="currentTab('threads')"
                    >
                        <span class="font-bold">Threads</span>
                        <span x-text="threads.formattedTotal()" class="ml-2 text-sm leading-6 text-gray-500"></span>
                    </a>
                </li>
                <li>
                    <a
                        href="javascript:void(0)"
                        @click="activeTab = 'articles'"
                        class="flex justify-center py-4"
                        :class="currentTab('articles')"
                    >
                        <span class="font-bold">Articles</span>
                        <span x-text="articles.formattedTotal()" class="ml-2 text-sm leading-6 text-gray-500"></span>
                    </a>
                </li>
                <li>
                    <a
                        href="javascript:void(0)"
                        @click="activeTab = 'users'"
                        class="flex justify-center py-4"
                        :class="currentTab('users')"
                    >
                        <span class="font-bold">Users</span>
                        <span x-text="users.formattedTotal()" class="ml-2 text-sm leading-6 text-gray-500"></span>
                    </a>
                </li>
            </ul>
            <ul>
                <li x-show="activeTab === 'threads'" class="mt-2 text-sm text-gray-800">
                    <template x-for="thread in threads.threads">
                        <li
                            class="cursor-default select-none px-4 py-2 hover:bg-lio-100"
                            :id="`option-${thread.id}`"
                            role="option"
                            tabindex="-1"
                        >
                            <a :href="'/forum/'+thread.slug" class="flex flex-col">
                                <span
                                    class="text-black-900 break-all font-medium"
                                    x-html="thread._highlightResult.subject.value"
                                ></span>
                                <span
                                    class="text-black-900 break-all"
                                    x-html="thread._snippetResult.body.value"
                                ></span>
                            </a>
                        </li>
                    </template>
                </li>
                <li x-show="activeTab === 'articles'" class="mt-2 text-sm text-gray-800">
                    <template x-for="article in articles.articles">
                        <li
                            class="cursor-default select-none px-4 py-2 hover:bg-lio-100"
                            :id="`option-${article.id}`"
                            role="option"
                            tabindex="-1"
                        >
                            <a :href="'/articles/'+article.slug" class="flex flex-col">
                                <span
                                    class="text-black-900 break-all font-medium"
                                    x-html="article._highlightResult.title.value"
                                ></span>
                                <span
                                    class="text-black-900 break-all"
                                    x-html="article._snippetResult.body.value"
                                ></span>
                            </a>
                        </li>
                    </template>
                </li>
                <li x-show="activeTab === 'users'" class="mt-2 text-sm text-gray-800">
                    <template x-for="user in users.users">
                        <li
                            class="cursor-default select-none px-4 py-2 hover:bg-lio-100"
                            :id="`option-${user.id}`"
                            role="option"
                            tabindex="-1"
                        >
                            <a :href="'/user/'+user.username" class="flex flex-col">
                                <span
                                    class="text-black-900 break-all font-medium"
                                    x-html="user._highlightResult.username.value"
                                ></span>
                                <span
                                    class="text-black-900 break-all"
                                    x-html="user._highlightResult.name.value"
                                ></span>
                            </a>
                        </li>
                    </template>
                </li>
            </ul>
        </div>

        <div
            x-show="searchQuery.length && !threads.total && !articles.total && !users.total"
            x-cloak
            class="border-t border-gray-100 px-6 py-14 text-center text-sm sm:px-14"
        >
            <svg class="mx-auto h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="mt-4 font-semibold text-gray-900">No results found</p>
            <p class="mt-2 text-gray-500">We couldn’t find anything with that term. Please try again.</p>
        </div>

        <div class="flex flex-wrap items-center justify-end bg-gray-50 px-4 py-2.5 text-xs text-gray-700">
            <a href="https://algolia.com">
                <img loading="lazy" src="{{ asset('images/algolia.svg') }}" alt="Magnifying glass icon" class="h-4" />
            </a>
        </div>
    </div>
</div>
