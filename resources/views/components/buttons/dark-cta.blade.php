<span class="{{ $attributes->get('class') }} inline-flex rounded shadow-sm">
    @if ($attributes->has('href'))
        <a
            {{ $attributes->except('class') }}
            class="inline-flex w-full justify-center rounded border border-transparent bg-gray-900 px-4 py-2 text-lg leading-6 text-white hover:bg-gray-800"
        >
            {{ $slot }}
        </a>
    @else
        <button class="inline-flex w-full justify-center rounded border border-transparent bg-gray-900 px-4 py-2 text-lg leading-6 text-white hover:bg-gray-800">
            {{ $slot }}
        </button>
    @endif
</span>
