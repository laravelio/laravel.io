@props([
    'link' => false,
])

@if($link)
    <a href="{{ $link }}">
@endif
    <span class="text-sm text-lio-200 bg-transparent border border-lio-200 rounded py-1.5 px-3 leading-none">
        {{ $slot }}
    </span>
@if($link)
    </a>
@endif
