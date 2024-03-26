@props(['action' => null])

<span class="{{ $attributes->get('class') }} inline-flex rounded shadow">
    @if ($attributes->has('href'))
        <a
            {{ $attributes->except('class') }}
            class="inline-flex w-full justify-center rounded border border-gray-200 bg-white px-4 py-2 text-lg leading-6 text-gray-900 hover:bg-gray-100"
        >
            {{ $slot }}
        </a>
    @elseif ($action)
        <form method="POST" action="{{ $action }}" class="w-full">
            @csrf
            @method('POST')

            <button
                type="submit"
                {{ $attributes->except('class') }}
                class="inline-flex w-full justify-center rounded border border-gray-200 bg-white px-4 py-2 text-lg leading-6 text-gray-900 hover:bg-gray-100"
            >
                {{ $slot }}
            </button>
        </form>
    @else
        <button
            {{ $attributes->except('class') }}
            class="inline-flex w-full justify-center rounded border border-gray-200 bg-white px-4 py-2 text-lg leading-6 text-gray-900 hover:bg-gray-100"
        >
            {{ $slot }}
        </button>
    @endif
</span>
