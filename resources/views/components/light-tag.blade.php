@props(['tag' => null])

<span
    {{ $attributes->class(['border-orange-200 text-orange-200' => $tag?->isAnnouncement(), 'rounded border border-white bg-transparent px-3 py-1.5 text-sm leading-none text-white']) }}
>
    {{ $slot }}
</span>
