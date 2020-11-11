@php($banner = Illuminate\Support\Arr::random(config('lio.ads')))

<a href="{{ $banner['url'] }}" target="_blank" rel="noopener noreferrer" onclick="fathom.trackGoal('{{ $banner['goal'] }}', 0);">
    {{-- Show the banner on bigger displays. --}}
    <img class="hidden md:block my-4 mx-auto w-full" style="max-width:1200px" src="{{ asset("/images/showcase/{$banner['image']}-long.jpg") }}" alt="{{ $banner['alt'] }}">

    {{-- Show the square on mobile. --}}
    <img class="md:hidden my-4 mx-auto w-full" style="max-width:300px" src="{{ asset("/images/showcase/{$banner['image']}-small.jpg") }}" alt="{{ $banner['alt'] }}">
</a>

@include('layouts._ads._cta', ['text' => 'Your banner here too?'])
