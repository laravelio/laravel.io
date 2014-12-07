<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<h2>Verify your email address for your Laravel.IO account</h2>

<div>
    Thanks for creating an account on Laravel.IO.<br>
    Please follow the link below to verify your email address
    {{ route('user.confirm', $confirmationCode) }}<br/>
</div>

</body>
</html>