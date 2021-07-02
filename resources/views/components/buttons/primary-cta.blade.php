<span class="inline-flex rounded shadow-sm {{ $attributes->get('class') }}">
    @if ($attributes->has('href'))
        <a {{ $attributes->except('class') }} class="w-full bg-lio-500 border border-transparent rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-white hover:bg-lio-600">
            {{ $slot }}
        </a>
    @else
        <button class="w-full bg-lio-500 border border-transparent rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-white hover:bg-lio-600">
            {{ $slot }}
        </button>
    @endif
</span>