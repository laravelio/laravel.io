<span class="inline-flex rounded-sm shadow-xs {{ $attributes->get('class') }}">
    @if ($attributes->has('href'))
        <a {{ $attributes->except('class') }} class="w-full bg-gray-900 border border-transparent rounded-sm py-2 px-4 inline-flex justify-center text-lg leading-6 text-white hover:bg-gray-800">
            {{ $slot }}
        </a>
    @else
        <button class="w-full bg-gray-900 border border-transparent rounded-sm py-2 px-4 inline-flex justify-center text-lg leading-6 text-white hover:bg-gray-800">
            {{ $slot }}
        </button>
    @endif
</span>