@php($banner = Illuminate\Support\Arr::random(config('lio.ads')))

<?php
    $banner = array_key_exists('random', $banner) ? Illuminate\Support\Arr::random($banner['random']) : $banner;
    $banner = $banner['small'] ?? $banner;
?>

<a href="{{ $banner['url'] }}" target="_blank" rel="noopener noreferrer" onclick="fathom.trackGoal('{{ $banner['goal'] }}', 0);">
    <img loading="lazy" class="my-4 mx-auto w-full" style="max-width:300px" src="{{ asset("/images/showcase/{$banner['image']}-small.png") }}" alt="{{ $banner['alt'] }}">
</a>

<x-ads.cta class="mt-4 md:mt-6">
    Your banner here too?
</x-ads.cta>
