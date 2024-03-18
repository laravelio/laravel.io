<div class="border-b border-gray-200">
    <div class="sm:flex sm:items-baseline sm:justify-between">
        <div class="sm:flex sm:items-baseline sm:justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Admin</h3>

            <div class="mt-4 sm:ml-10 sm:mt-0">
                <nav class="-mb-px flex space-x-8">
                    <a
                        href="{{ route('admin') }}"
                        class="{{ is_active('admin') ? 'border-lio-500 text-lio-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium"
                    >
                        Articles
                    </a>

                    <a
                        href="{{ route('admin.replies') }}"
                        class="{{ is_active('admin.replies') ? 'border-lio-500 text-lio-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium"
                        aria-current="page"
                    >
                        Replies
                    </a>

                    <a
                        href="{{ route('admin.users') }}"
                        class="{{ is_active('admin.users') ? 'border-lio-500 text-lio-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium"
                        aria-current="page"
                    >
                        Users
                    </a>
                </nav>
            </div>
        </div>

        <div class="mt-3 sm:ml-4 sm:mt-0">
            <form action="{{ $query }}" method="GET">
                <label for="adminSearch" class="sr-only">Search</label>

                <div class="flex rounded-md shadow-sm">
                    <div class="relative grow">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                        >
                            <x-heroicon-s-magnifying-glass
                                class="h-5 w-5 text-gray-400"
                            />
                        </div>

                        <input
                            type="search"
                            name="admin_search"
                            id="adminSearch"
                            placeholder="{{ $placeholder }}"
                            value="{{ $search ?? null }}"
                            class="block w-full rounded-md border-gray-300 pl-10 text-sm focus:border-lio-500 focus:ring-lio-500"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
