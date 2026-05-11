@extends('layouts.app')

@section('content')

<section class="login-section">
    <div class="login-box">
        <h2>REGISTER</h2>

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

        {{-- action diubah dari "#" ke route register.post --}}
        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Username</label>
                {{-- Ditambah value old() agar tidak kosong saat error --}}
                <input type="text" name="username"
                    value="{{ old('username') }}"
                    placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                {{-- Ditambah value old() agar tidak kosong saat error --}}
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"
                    placeholder="Enter your password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation"
                    placeholder="Confirm password" required>
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
