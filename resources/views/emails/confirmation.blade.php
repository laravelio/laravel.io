<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<h2>Verify your email address for your Laravel.io account</h2>

<p>
    Thanks for creating an account on Laravel.io.<br>
    Please follow the link below to verify your email address
</p>
<p><a href="{{ route('auth.confirm', $confirmationCode) }}">{{ route('auth.confirm', $confirmationCode) }}</a></p>

</body>
</html>
