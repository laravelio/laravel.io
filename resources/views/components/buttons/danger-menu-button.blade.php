@props([
    'tag' => 'a',
    'selected' => false,
])

<{{ $tag }} {{ $attributes }} class="@if($selected) text-red-500 @endif flex rounded-full p-3 transition duration-300 ease-in-out bg-transparent hover:text-red-500 hover:bg-red-100 hover:opacity-50">
    {{ $slot }}
</{{ $tag }}>