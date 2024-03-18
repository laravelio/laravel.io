@props(['tag' => null])

<span
    {{ $attributes->class(['border-orange-200 bg-orange-100 text-orange-900' => $tag?->isAnnouncement(), 'inline-block rounded border border-gray-200 bg-gray-100 px-3 py-1.5 text-sm leading-none text-gray-900']) }}
>
    {{ $slot }}
</span>
