@extends('index', [
    'css' => ['auth']
])

@section('title')
Login
@endsection

@section('body')
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
        <a class="add-links" href="{{ route('registration') }}">Register</a>
    </div>
</body>
</html>
@endsection