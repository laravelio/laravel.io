@props([
    'action' => null,
    'method' => 'POST',
])

<form method="{{ $method !== 'GET' ? 'POST' : 'GET' }}" @isset($action) action="{{ $action }}" @endisset {{ $attributes }}>
    @csrf
    @method($method)

    {{ $slot }}
</form>
