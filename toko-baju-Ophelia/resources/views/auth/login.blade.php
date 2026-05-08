@extends('layouts.app')

@section('content')

<section class="login-section">
    <div class="login-box">
        <h2>LOGIN</h2>
        <form action="#" method="POST">
            @csrf
            <input type="hidden" name="role" id="role-input" value="user">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>

        <p class="register-link">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    </div>
</section>

<script>
    function setRole(role, el) {
        document.getElementById('role-input').value = role;
        document.querySelectorAll('.role-btn').forEach(btn => btn.classList.remove('active'));
        el.classList.add('active');
    }
</script>

@endsection
