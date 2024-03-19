<button
    title="{{ $title }}"
    type="button"
    class="cursor-pointer text-gray-900"
    @click="handleClick('{{ $control }}')"
>
    @svg($icon, 'h-5 w-5 md:h-6 md:w-6')
</button>
