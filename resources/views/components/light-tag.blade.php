@props(['tag' => null])

<span {{ $attributes->class(['text-orange-200 border-orange-200' => $tag?->isAnnouncement(), 'text-sm text-white bg-transparent border border-white rounded py-1.5 px-3 leading-none']) }}>
    {{ $slot }}
</span>
