<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth">
    <div class="auth-card">
        <h1>Admin Login</h1>
        <form class="form" method="post" action="{{ route('login.store') }}">
            @csrf
            <div class="form-row">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-row">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-row">
                <label class="checkbox">
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif
            <button class="btn btn-primary" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
