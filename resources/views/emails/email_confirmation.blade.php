Click here to confirm your email address:
<a href="{{ route('email.confirm', [$user->emailAddress(), $user->confirmationCode()]) }}">
    {{ route('email.confirm', [$user->emailAddress(), $user->confirmationCode()]) }}
</a>
