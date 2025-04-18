@props(['for'])

<label :for="$for" {{ $attributes->merge(['class' => 'block text-sm font-medium leading-5 text-gray-700']) }}>
    {{ $slot->isNotEmpty() ? $slot : Str::ucfirst(str_replace('_', ' ', $for)) }}
</label>
