<x-buk-label :for="$for" {{ $attributes->merge(['class' => 'block text-sm font-medium leading-5 text-gray-700']) }}>
    {{ $slot }}
</x-buk-label>
