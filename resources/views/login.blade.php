<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,400;0,500;0,600;1,200&display=swap" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <title>Login — publist </title>
</head>
<body>
    <div class="auth login">
        <img src="{{ asset('images/Logo.svg') }}" alt="publist" class="logo">
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            @error('wrongAuth')
                <div class="login-error">{{ $message }}</div>
            @enderror
            <input class="input" name="email" type="email" id="email" value="" placeholder="Email">
            @error('email')
                <div class="input-error">{{ $message }}</div>
            @enderror
            <input class="input" name="password" type="password" id="password" value="" placeholder="Password">
            @error('password')
                <div class="input-error">{{ $message }}</div>
            @enderror
            <button class="button login" type="submit" name="sendInfo" value="1">Login</button>
        </form>
        <a class="add-links" href="/registration">Register</a>
    </div>
</body>
</html>