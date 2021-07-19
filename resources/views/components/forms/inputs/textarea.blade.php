<div class="relative">
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' => 'shadow-sm focus:border-lio-300 focus:ring focus:ring-lio-200 focus:ring-opacity-50 mt-1 block w-full sm:text-sm border-gray-300 rounded-md' . ($errors->has($name) ? ' border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '')
        ]) }}
    >{{ old($name, $slot) }}</textarea>

    @if ($errors->has($name))
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <x-heroicon-o-exclamation-circle class="h-5 w-5 text-red-500" />
        </div>
    @endif

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
        @endforeach
    @endif
</div>
