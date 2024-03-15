<div>
    <div class="flex items-center">
        <input name="{{ $name }}" id="{{ $id }}" type="checkbox" value="{{ $value ?? 1 }}"
            class="h-4 w-4 rounded border-gray-300 text-lio-600 focus:ring-lio-500"
            {{ isset($checked) && $checked === true ? 'checked' : '' }}>

        <label for="{{ $id }}" class="ml-2 block text-sm text-gray-900">
            {{ $slot }}
        </label>
    </div>

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <x-forms.error>
                {{ $error }}
            </x-forms.error>
        @endforeach
    @endif
</div>
