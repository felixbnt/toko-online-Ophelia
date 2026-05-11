@extends('layouts.app')

@section('content')

<section class="login-section">
    <div class="login-box">
        <h2>LOGIN</h2>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tampilkan pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- action diubah dari "#" ke route login.post --}}
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <input type="hidden" name="role" id="role-input" value="user">

            <div class="form-group">
                <label>Username</label>
                {{-- Ditambah value old() agar tidak kosong saat error --}}
                <input type="text" name="username"
                       value="{{ old('username') }}"
                       placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"
                       placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>

        <p class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Register</a>
        </p>
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
