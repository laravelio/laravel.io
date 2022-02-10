@component('mail::message')

**{{ $mentionAble->author()->username() }}** has mentioned you on this thread.

@component('mail::panel')
{{ $mentionAble->excerpt(200) }}
@endcomponent

@component('mail::button', ['url' => route('thread', $mentionAble->mentionedIn()->slug())])
View Thread
@endcomponent

@endcomponent
