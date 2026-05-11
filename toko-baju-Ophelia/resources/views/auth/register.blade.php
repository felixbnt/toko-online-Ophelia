@extends('layouts.app')

@section('content')

<section class="login-section">
    <div class="login-box">
        <h2>REGISTER</h2>

        <form action="#" method="POST">
            @csrf

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm password" required>
            </div>

            <button type="submit" class="btn-login">REGISTER</button>
        </form>

        <p class="register-link">
            Already have an account?
            <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
</section>

@endsection
