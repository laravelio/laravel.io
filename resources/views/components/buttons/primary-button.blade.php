<span class="inline-flex rounded-md shadow-sm">
    @if ($attributes->has('href'))
        <a {{ $attributes->merge(['class' => 'bg-lio-500 border border-transparent rounded py-2 px-4 inline-flex justify-center text-base text-white hover:bg-lio-600 font-medium']) }}>
            {{ $slot }}
        </a>
    @else
        <button {{ $attributes->merge(['class' => 'bg-lio-500 border border-transparent rounded py-2 px-4 inline-flex justify-center text-base text-white hover:bg-lio-600 font-medium']) }}>
            {{ $slot }}
        </button>
    @endif
</span>