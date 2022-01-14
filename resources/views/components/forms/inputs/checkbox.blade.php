<div>
    <div class="flex items-center">
        <input name="{{ $name }}" id="{{ $id }}" type="checkbox" value="1" class="h-4 w-4 text-lio-600 focus:ring-lio-500 border-gray-300 rounded">

        <label for="{{ $id }}" class="ml-2 block text-sm text-gray-900">
            {{ $slot }}
        </label>
    </div>

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
        @endforeach
    @endif
</div>