@component('mail::message')

**{{ $reply->author()->username() }}** has replied to this thread.

@component('mail::panel')
{{ $reply->excerpt(200) }}
@endcomponent

@component('mail::button', ['url' => route('thread', $reply->replyAble()->slug())])
View Thread
@endcomponent

@component('mail::subcopy')
    You are receiving this because you are subscribed to this thread.  
    [Unsubscribe]({{ route('subscriptions.unsubscribe', $subscription->uuid()->toString()) }}) from this thread.
@endcomponent

@endcomponent
