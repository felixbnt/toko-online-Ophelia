@extends('layouts.superadmin')

@section('title', 'Super Admin Dashboard')

@section('content')

<div class="topbar">
    <h1>Dashboard — Ophelia SuperAdmin</h1>
    <span style="font-size:.9rem; color:#666">{{ auth()->user()->name }}</span>
</div>

<div class="cards">
    <div class="card">
        <p>Total Admin</p>
        <h2>{{ \App\Models\User::where('role','admin')->count() }}</h2>
        <small style="color:#2563eb">↑ Aktif</small>
    </div>
    <div class="card">
        <p>Total User</p>
        <h2>{{ \App\Models\User::where('role','user')->count() }}</h2>
        <small style="color:#2563eb">↑ Terdaftar</small>
    </div>
    <div class="card">
        <p>Total Transaksi</p>
        <h2>{{ \App\Models\Transaction::count() }}</h2>
        <small style="color:#2563eb">↑ Semua waktu</small>
    </div>
    <div class="card">
        <p>Total Pendapatan</p>
        <h2>Rp 0</h2>
        <small style="color:#2563eb">↑ Semua waktu</small>
    </div>
</div>

<div class="table-container" style="margin-top:30px">
    <h3 style="margin-bottom:15px">User Terbaru</h3>
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
        </tr>
        @foreach(\App\Models\User::latest()->take(5)->get() as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td>
                <span class="badge {{ $user->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                    {{ ucfirst($user->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection