@props(['size' => 'small', 'url', 'company', 'logo'])

<?php
    $classes = match ($size) {
        'tiny' => 'max-h-20 max-w-28',
        'small' => 'max-h-36 max-w-42',
        'medium' => 'max-h-42 max-w-60',
        'large' => 'max-h-48 max-w-60',
    };
?>

<a class="flex items-center" href="{{ $url }}">
    <img loading="lazy" class="{{ $classes }}" src="{{ $logo }}" alt="{{ $company }}" />
</a>
