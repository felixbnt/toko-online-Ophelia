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
            <th>Produk</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
        @forelse($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->user->name ?? 'Pelanggan' }}</td>
            <td>
                @forelse($order->items as $item)
                    <div>{{ $item->product_name }} (x{{ $item->quantity }})</div>
                @empty
                    <span style="color:#9ca3af">-</span>
                @endforelse
            </td>
            <td>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center; color:#9ca3af; padding:1rem">
                Belum ada transaksi.
            </td>
        </tr>
        @endforelse
    </table>
</div>

@endsection