@component('mail::message')

**{{ $mentionAble->author()->username() }}** has mentioned you on this thread.

@component('mail::panel')
{{ $mentionAble->excerpt(200) }}
@endcomponent

@component('mail::button', ['url' => route('thread', $mentionAble->mentionedIn()->slug())])
View Thread
@endcomponent

@component('mail::subcopy')
If you do not want this user to be able to mention you anymore, you may
[block them through their profile]({{ route('profile', $mentionAble->author()->username()) }}).
@endcomponent

@endcomponent
