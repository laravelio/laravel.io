<a href="{{ $to }}" class="group rounded-md px-3 py-2 flex items-center text-sm leading-5 font-medium focus:outline-none transition ease-in-out duration-150 {{ $active ? 'bg-gray-50 text-lio-600 hover:bg-white focus:bg-white' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50 focus:text-gray-900 focus:bg-gray-50' }}">
    <x-dynamic-component :component="$icon" class="flex-shrink-0 -ml-1 mr-3 h-6 w-6 {{ $active ? 'text-lio-500 transition ease-in-out duration-150' : 'group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" />
    <span class="truncate">
        {{ $label }}
    </span>
</a>