@component('mail::message')
# Welcome to Laravel.io!

Thanks for joining up with the [Laravel.io](https://laravel.io) community!

We just need to confirm your email address so please click the button below to confirm it:

@component('mail::button', ['url' => $actionUrl])
Confirm Email Address
@endcomponent

We hope to see you soon on the portal.

Regards,<br>
{{ config('app.name') }}
@endcomponent
