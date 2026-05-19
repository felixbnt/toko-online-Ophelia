<!DOCTYPE html>
<html>
<head>

    <title>Pesanan</title>

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
            <h1>Kelola Pesanan</h1>
        </div>

        <div class="table-container">

            <table>

                <tr>
                    <th>Nama User</th>
                    <th>Produk</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>

                <tr>
                    <td>Zaki</td>
                    <td>Floral Dress</td>
                    <td>Diproses</td>
                    <td>Rp 599.000</td>
                </tr>

            </table>

        </div>

    </div>

</div>

</body>
</html>
