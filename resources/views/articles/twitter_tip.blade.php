@if(! Auth::user()->hasTwitterAccount())
<div class="bg-lio-500 text-white p-4">
    <x-heroicon-s-information-circle class="h-5 w-5 inline" />
    Set your <a href="{{route('settings.profile')}}" class="underline">
        Twitter handle
    </a>
    so we can link to your profile when we tweet out your article.
</div>
@endif