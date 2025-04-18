@props(['action' => null, 'method' => 'POST'])

<form method="POST" @isset($action) action="{{ $action }}" @endisset>
    @csrf
    @method($method)

    <button type="submit" {{ $attributes }}>
        {{ $slot }}
    </button>
</form>
