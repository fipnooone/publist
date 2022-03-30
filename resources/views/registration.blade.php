@extends('index', [
    'css' => ['auth']
])

@section('title')
Registration
@endsection

@section('body')
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
        <a class="add-links" href="{{ route('login') }}">Already have an account?</a>
    </div>
</body>
</html>
@endsection