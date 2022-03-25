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
    <title>Registration — publist </title>
</head>
<body>
    <div class="auth registration">
        <img src="{{ asset('images/Logo.svg') }}" alt="publist" class="logo">
        <form method="POST" action="{{ route('registration') }}" class="auth-form">
            @csrf
            <input class="input" name="name" type="text" id="name" value="" placeholder="Your name">
            <input class="input" name="email" type="email" id="email" value="" placeholder="Email">
            @error('email')
                <div class="input-error">{{ $message }}</div>
            @enderror
            <input class="input" name="password" type="password" id="password" value="" placeholder="Password">
            @error('password')
                <div class="input-error">{{ $message }}</div>
            @enderror
            <button class="button login" type="submit" name="sendInfo" value="1">Register</button>
        </form>
        <a class="add-links" href="/login">Already have an account?</a>
    </div>
</body>
</html>