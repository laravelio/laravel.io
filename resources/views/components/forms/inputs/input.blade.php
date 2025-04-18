@props([
    'name',
    'id' => null,
    'type' => 'text',
    'value' => null,
])

<div>
    <div class="relative">
        @if ($attributes->get('prefix-icon'))
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                @svg($attributes->get('prefix-icon'), ['class' => 'h-5 w-5 text-gray-400'])
            </div>
        @endif

        <input
            name="{{ $name }}"
            type="{{ $type }}"
            id="{{ $id }}"
            value="{{ old($name, $value ?? '') }}"
            {{ $attributes->merge([
                'class' => 'block w-full border-gray-300 rounded-md focus:border-lio-300 focus:ring-3 focus:ring-lio-200 focus:ring-opacity-50 sm:text-sm sm:leading-5 mt-1' . ($attributes->get('prefix-icon') ? ' pl-10' : '') . ($errors->has($name) ? ' border-red-300 text-red-900 placeholder-red-300 focus:outline-hidden focus:ring-red-500 focus:border-red-500' : '')
            ]) }}
        />

        @if ($errors->has($name))
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <x-heroicon-o-exclamation-circle class="h-5 w-5 text-red-500" />
            </div>
        @endif
    </div>

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <x-forms.error>
                {{ $error }}
            </x-forms.error>
        @endforeach
    @endif
</div>
