@props([
    'link' => false,
])

@if($link)
    <a href="{{ $link }}">
@endif
    <span class="text-sm text-white bg-transparent border border-white rounded py-1.5 px-3 leading-none">
        {{ $slot }}
    </span>
@if($link)
    </a>
@endif
