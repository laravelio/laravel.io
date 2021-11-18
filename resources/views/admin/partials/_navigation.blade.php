<div class="border-b border-gray-200">
    <div class="sm:flex sm:items-center sm:justify-between sm:items-baseline">
        <div class="sm:flex sm:items-center sm:justify-between sm:items-baseline">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Admin
            </h3>

            <div class="mt-4 sm:mt-0 sm:ml-10">
                <nav class="-mb-px flex space-x-8">
                    <a href="{{ route('admin') }}" class="{{ is_active('admin') ? 'border-lio-500 text-lio-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">
                        Articles
                    </a>

                    <a href="{{ route('admin.users') }}" class="{{ is_active('admin.users') ? 'border-lio-500 text-lio-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
                        Users
                    </a>
                </nav>
            </div>
        </div>

        <div class="mt-3 sm:mt-0 sm:ml-4">
            <form action="{{ $query }}" method="GET">
                <label for="adminSearch" class="sr-only">Search</label>

                <div class="flex rounded-md shadow-sm">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-s-search class="h-5 w-5 text-gray-400" />
                        </div>

                        <input
                            type="search"
                            name="admin_search"
                            id="adminSearch"
                            placeholder="{{ $placeholder }}"
                            value="{{ $search ?? null }}"
                            class="focus:ring-lio-500 focus:border-lio-500 w-full rounded-md pl-10 block text-sm border-gray-300"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
