@component('mail::message')
# Welcome to Developers.mv!

Thanks for joining up with the [Developers.mv](https://Developers.mv) community!

We just need to confirm your email address so please click the button below to confirm it:

@component('mail::button', ['url' => route('email.confirm', [$user->emailAddress(), $user->confirmationCode()])])
Confirm Email Address
@endcomponent

We hope to see you soon on the portal.

Regards,<br>
{{ config('app.name') }}
@endcomponent
