<button 
    title="{{ $title }}"
    type="button" 
    class="text-gray-900 cursor-pointer"
    @click="handleClick('{{ $control }}')"
>
    @svg($icon, 'w-5 h-5 md:w-6 md:h-6')
</button>