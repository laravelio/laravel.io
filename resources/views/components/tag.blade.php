@props(['tag' => null])

<span {{ $attributes->class(['text-orange-900 bg-orange-100 border-orange-200' => $tag?->isAnnouncement(), 'inline-block text-sm text-gray-900 bg-gray-100 border border-gray-200 rounded py-1.5 px-3 leading-none']) }}>
    {{ $slot }}
</span>
