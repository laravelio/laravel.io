@props([
    'action' => null,
])


<span class="inline-flex rounded shadow {{ $attributes->get('class') }}">
    @if ($attributes->has('href'))
        <a {{ $attributes->except('class') }} class="w-full bg-white border border-gray-200 rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-gray-900 hover:bg-gray-100">
            {{ $slot }}
        </a>
    @elseif ($action)
        <form method="POST" action="{{ $action }}" class="w-full">
            @csrf
            @method('POST')

            <button type="submit" {{ $attributes->except('class') }} class="w-full bg-white border border-gray-200 rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-gray-900 hover:bg-gray-100">
                {{ $slot }}
            </button>
        </form>
    @else
        <button {{ $attributes->except('class') }} class="w-full bg-white border border-gray-200 rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-gray-900 hover:bg-gray-100">
            {{ $slot }}
        </button>
    @endif
</span>
