<div>
    <div class="relative">
        <input
            name="{{ $name }}"
            type="{{ $type }}"
            id="{{ $id }}"
            @if($value)value="{{ $value }}"@endif
            {{ $attributes }}
            class="{{ $class }} {{ $errors->has($name) ? $errorClasses() : '' }}"
        />
        @if($errors->has($name))
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <x-heroicon-o-exclamation-circle class="h-5 w-5 text-red-500" />
            </div>
        @endif
    </div>
    @if($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
        @endforeach
    @endif
</div>