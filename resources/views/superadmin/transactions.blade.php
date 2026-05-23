@extends('layouts.superadmin')

@section('title', 'Kelola Transaksi')

@section('content')

<div class="topbar">
    <h1>Kelola Transaksi</h1>
</div>

<div class="table-container">
    <table>
        <tr>
            <th>ID Transaksi</th>
            <th>User</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
        <tr>
            <td>TRX001</td>
            <td>Zaki</td>
            <td>Rp 599.000</td>
            <td>Berhasil</td>
        </tr>
        <tr>
            <td>TRX002</td>
            <td>Ahmad</td>
            <td>Rp 799.000</td>
            <td>Pending</td>
        </tr>
    </table>
</div>

@endsection