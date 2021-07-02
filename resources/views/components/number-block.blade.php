@props([
    'title',
    'total',
    'background'
])

<div class="flex flex-col items-center rounded bg-lio-100 py-9 mb-4 md:mb-0">
    <h3 class="uppercase text-lio-500 text-lg font-bold text-center mb-11">
        {{ $title }}
        <span class="text-4xl text-gray-900 block leading-tight">{{ $total }}</span>
    </h3>
    <div 
        class="number-block w-full h-44 bg-contain" 
        style="background-image: url('{{ $background }}');"
    >
    </div>
</div>