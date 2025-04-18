@props(['size' => 'small', 'url', 'company', 'logo'])

<?php
    $classes = match ($size) {
        'small' => 'max-h-10 max-w-14',
        'medium' => 'max-h-36 max-w-48',
        'large' => 'max-h-48 max-w-60',
    };
?>

<a class="flex items-center" href="{{ $url }}">
    <img loading="lazy" class="{{ $classes }}" src="{{ $logo }}" alt="{{ $company }}" />
</a>
