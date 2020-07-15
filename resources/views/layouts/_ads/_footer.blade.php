<a
    href="https://devsquad.com"
    target="_blank"
    rel="noopener noreferrer"
>
    {{-- Show the banner on bigger displays. --}}
    <img class="hidden md:block my-4 mx-auto w-full" style="max-width:1200px" src="{{ asset('/images/showcase/devsquad-long.jpg') }}" alt="Devsquad">
    {{-- Show the square on mobile. --}}
    <img class="md:hidden my-4 mx-auto w-full" style="max-width:300px" src="{{ asset('/images/showcase/devsquad-small.jpg') }}" alt="Devsquad">
</a>

@include('layouts._ads._cta', ['text' => 'Your banner here too?'])
