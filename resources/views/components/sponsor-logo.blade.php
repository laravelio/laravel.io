@props([
    'size' => 'small',
    'url',
    'company',
    'logo',
])

<?php
$classes = match ($size) {
    'small' => 'max-h-10 max-w-14',
    'medium' => 'max-w-18 max-h-14',
    'large' => 'max-w-30 max-h-24',
};
?>

<a class="flex items-center" href="{{ $url }}">
    <img
        loading="lazy"
        class="{{ $classes }}"
        src="{{ $logo }}"
        alt="{{ $company }}"
    />
</a>
