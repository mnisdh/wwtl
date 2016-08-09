<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2 style="font-size: 40px; color:#9a9a9a">WWTL</h2>

<div>
    Forget your password?<br />
    Click here to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
</div>

</body>
</html>


