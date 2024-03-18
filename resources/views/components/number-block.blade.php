@props([
    'title',
    'total',
    'background',
])

<div class="mb-4 flex flex-col items-center rounded bg-lio-100 py-9 md:mb-0">
    <h3 class="mb-11 text-center text-lg font-bold uppercase text-lio-500">
        {{ $title }}
        <span class="block text-4xl leading-tight text-gray-900">
            {{ $total }}
        </span>
    </h3>
    <div
        class="number-block h-44 w-full bg-contain"
        style="background-image: url('{{ $background }}')"
    ></div>
</div>
