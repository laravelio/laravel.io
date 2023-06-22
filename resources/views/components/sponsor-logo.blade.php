@props(['size' => 'small', 'url', 'company', 'logo'])

<?php
    $classes = match ($size) {
        'small' => 'max-h-10 max-w-14',
        'medium' => 'max-h-14 max-w-18',
        'large' => 'max-h-24 max-w-30',
    };
?>

<a class="flex items-center" href="{{ $url }}">
    <img loading="lazy" class="{{ $classes }}" src="{{ $logo }}" alt="{{ $company }}" />
</a>
