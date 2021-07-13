<span class="inline-flex rounded-md shadow">
    @if ($attributes->has('href'))
        <a {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded py-2 px-4 inline-flex justify-center text-base text-gray-900 hover:bg-gray-100 font-medium']) }}>
            {{ $slot }}
        </a>
    @else
        <button {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded py-2 px-4 inline-flex justify-center text-base text-gray-900 hover:bg-gray-100 font-medium']) }}>
            {{ $slot }}
        </button>
    @endif
</span>