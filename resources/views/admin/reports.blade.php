<!DOCTYPE html>
<html>
<head>

    <title>Laporan</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>

<div class="admin-container">

    <div class="sidebar">

        <div class="logo">
            OPHELIA
        </div>

        <ul class="sidebar-menu">

            <li>
                <a href="/admin/dashboard">Dashboard</a>
            </li>

            <li>
                <a href="/admin/products">Produk</a>
            </li>

            <li>
                <a href="/admin/orders">Pesanan</a>
            </li>

            <li>
                <a href="/admin/reports">Laporan</a>
            </li>

            <li>
                <a href="/">Logout</a>
            </li>

        </ul>

    </div>

    <div class="main-content">

        <div class="topbar">
            <h1>Laporan Penjualan</h1>
        </div>

        <div class="cards">

            <div class="card">
                <p>Total Penjualan</p>
                <h2>Rp 12JT</h2>
            </div>

            <div class="card">
                <p>Total Produk Terjual</p>
                <h2>320</h2>
            </div>

            <div class="card">
                <p>Total Customer</p>
                <h2>150</h2>
            </div>

        </div>

        <div class="table-container">

            <table>

                <tr>
                    <th>Bulan</th>
                    <th>Total Penjualan</th>
                    <th>Produk Terjual</th>
                </tr>

                <tr>
                    <td>Mei</td>
                    <td>Rp 12.000.000</td>
                    <td>320</td>
                </tr>

                <tr>
                    <td>April</td>
                    <td>Rp 9.500.000</td>
                    <td>250</td>
                </tr>

            </table>

        </div>

    </div>

</div>

</body>
</html>
