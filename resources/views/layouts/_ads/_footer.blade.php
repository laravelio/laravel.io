@php($banner = Illuminate\Support\Arr::random(config('lio.ads')))

<?php
    $banner = array_key_exists('random', $banner) ? Illuminate\Support\Arr::random($banner['random']) : $banner;
    $long = $banner['long'] ?? $banner;
    $small = $banner['small'] ?? $banner;
?>

{{-- Show the banner on bigger displays. --}}
<div class="hidden md:block w-full">
    <a href="{{ $long['url'] }}" target="_blank" rel="noopener noreferrer" onclick="fathom.trackGoal('{{ $long['goal'] }}', 0);">
        <img class="block mx-auto w-full" style="max-width:1200px" src="{{ asset("/images/showcase/{$long['image']}-long.png") }}" alt="{{ $long['alt'] }}">
    </a>
</div>

{{-- Show the square on mobile. --}}
<div class="block md:hidden w-full">
    <a href="{{ $small['url'] }}" target="_blank" rel="noopener noreferrer" onclick="fathom.trackGoal('{{ $small['goal'] }}', 0);">
        <img class="block mx-auto w-full" style="max-width:300px" src="{{ asset("/images/showcase/{$small['image']}-small.png") }}" alt="{{ $small['alt'] }}">
    </a>
</div>

<x-ads.cta primary class="mt-4">
    Your banner here too?
</x-ads.cta>
