@extends('layouts.superadmin')

@section('title', 'Laporan Super Admin')

@section('content')

<div class="topbar">
    <h1>Laporan Super Admin</h1>
</div>

<div class="cards">
    <div class="card">
        <p>Total Pendapatan</p>
        <h2>Rp 45JT</h2>
    </div>
    <div class="card">
        <p>Total Transaksi</p>
        <h2>530</h2>
    </div>
    <div class="card">
        <p>Total User</p>
        <h2>240</h2>
    </div>
</div>

<div class="table-container">
    <table>
        <tr>
            <th>Bulan</th>
            <th>Total Penjualan</th>
            <th>Total User</th>
        </tr>
        <tr>
            <td>Mei</td>
            <td>Rp 45.000.000</td>
            <td>240</td>
        </tr>
        <tr>
            <td>April</td>
            <td>Rp 32.000.000</td>
            <td>180</td>
        </tr>
    </table>
</div>

@endsection