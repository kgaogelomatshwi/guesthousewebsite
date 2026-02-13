<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth">
    <div class="auth-card">
        <h1>Create Guest Account</h1>
        <form class="form mt-4" method="post" action="{{ route('register.store') }}">
            @csrf
            <div class="form-row">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-row">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-row">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-row">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif
            <button class="btn btn-primary" type="submit">Create Account</button>
            <p class="text-sm">
                Already have an account?
                <a href="{{ route('login') }}">Sign in</a>
            </p>
        </form>
    </div>
</body>
</html>
