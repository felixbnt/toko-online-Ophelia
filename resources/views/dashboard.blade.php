@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.style.css') }}">

<div class="dashboard-wrapper">

    {{-- Alert sukses --}}
    @if (session('success'))
    <div class="dash-alert">
        <i class="ti ti-circle-check"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Profile Card --}}
    <div class="dash-profile-card">
        <div class="dash-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div class="dash-profile-info">
            <h2>Welcome, {{ Auth::user()->name }}!</h2>
            <p>{{ Auth::user()->email }} · Member</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="dash-stats">
        <div class="dash-stat-card">
            <span class="stat-label">🛍 Pesanan</span>
            <span class="stat-value">{{ $jumlahPesanan }}</span>
        </div>
        <div class="dash-stat-card">
            <span class="stat-label">❤️ Wishlist</span>
            <span class="stat-value">0</span>
        </div>
        <div class="dash-stat-card">
            <span class="stat-label">⭐ Poin</span>
            <span class="stat-value">0</span>
        </div>
    </div>

    {{-- Menu Grid --}}
    <div class="dash-menu">
        <a href="#pesanan-saya" class="dash-menu-item">
            <div class="menu-icon blue">📦</div>
            <div>
                <p class="menu-title">Pesanan saya</p>
                <p class="menu-sub">Lacak pesanan</p>
            </div>
        </a>
        <a href="#" class="dash-menu-item">
            <div class="menu-icon green">📍</div>
            <div>
                <p class="menu-title">Alamat</p>
                <p class="menu-sub">Kelola alamat</p>
            </div>
        </a>
        <a href="#" class="dash-menu-item">
            <div class="menu-icon amber">💳</div>
            <div>
                <p class="menu-title">Pembayaran</p>
                <p class="menu-sub">Metode bayar</p>
            </div>
        </a>
        <a href="#" class="dash-menu-item">
            <div class="menu-icon pink">⚙️</div>
            <div>
                <p class="menu-title">Pengaturan</p>
                <p class="menu-sub">Edit profil</p>
            </div>
        </a>
    </div>

    {{-- List Pesanan --}}
    <div class="dash-orders" id="pesanan-saya">
        <h3>Pesanan Saya</h3>
        @forelse($pesanan as $order)
        <div class="dash-order-item">
            <span class="order-number">#{{ $order->order_number }}</span>
            <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
            <span class="order-total">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
            <span class="order-status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
        </div>
        @empty
        <p class="order-empty">Belum ada pesanan.</p>
        @endforelse
    </div>

    {{-- Tombol Logout --}}
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout-modern">
            🚪 Logout dari akun
        </button>
    </form>

</div>
@endsection