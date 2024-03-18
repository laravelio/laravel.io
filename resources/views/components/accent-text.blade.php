<span
    {{ $attributes->merge(['class' => 'text-lio-500 font-bold relative inline-block stroke-current']) }}
>
    {{ $slot }}
    <x-icon-accent class="absolute bottom-0 max-h-1.5 w-full" />
</span>
