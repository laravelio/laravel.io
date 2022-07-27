@component('mail::message')

The thread "{{ $thread->subject() }}" was deleted by a moderator for the following reasons:

@component('mail::panel')
{{ $reason }}
@endcomponent

Please make sure your thread follows <a href="{{ route('rules') }}">our rules</a>.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
