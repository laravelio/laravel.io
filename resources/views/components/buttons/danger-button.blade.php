<span class="inline-flex rounded-md shadow-sm">
    @if ($attributes->has('href'))
        <a {{ $attributes->merge(['class' => 'bg-white border border-red-400 rounded-sm py-2 px-4 inline-flex justify-center text-base text-red-500 hover:bg-red-50 font-medium']) }}>
            {{ $slot }}
        </a>
    @else
        <button {{ $attributes->merge(['class' => 'bg-white border border-red-400 rounded-sm py-2 px-4 inline-flex justify-center text-base text-red-500 hover:bg-red-50 font-medium']) }}>
            {{ $slot }}
        </button>
    @endif
</span>