<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Hello {{ $user->name }}, Verify Your Email Address </h1>
    <p>
        Please click the link sent to your email to verify your email address.
    </p>
    <p>
        <a href="http://127.0.0.1:8000/verifiy/{{ $user->remember_token }}">Verify Email Address</a>
    </p>
   
</body>
</html>
