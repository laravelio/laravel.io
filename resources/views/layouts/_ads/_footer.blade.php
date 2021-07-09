@php($banner = Illuminate\Support\Arr::random(config('lio.ads')))

<a href="{{ $banner['url'] }}" target="_blank" rel="noopener noreferrer" onclick="fathom.trackGoal('{{ $banner['goal'] }}', 0);">
    {{-- Show the banner on bigger displays. --}}
    <img class="hidden md:block mx-auto w-full" style="max-width:1200px" src="{{ asset("/images/showcase/{$banner['image']}-long.png") }}" alt="{{ $banner['alt'] }}">

    {{-- Show the square on mobile. --}}
    <img class="md:hidden mx-auto w-full" style="max-width:300px" src="{{ asset("/images/showcase/{$banner['image']}-small.png") }}" alt="{{ $banner['alt'] }}">
</a>

<x-ads.cta primary class="mt-4 md:mt-12">
    Your banner here too?
</x-ads.cta>
