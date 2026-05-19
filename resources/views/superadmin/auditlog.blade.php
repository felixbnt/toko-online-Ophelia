<!DOCTYPE html>
<html>
<head>

    <title>Audit Log</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>

<div class="admin-container">

    @include('components.superadmin-sidebar')

    <div class="main-content">

        <div class="topbar">

            <h1>Audit Log</h1>

        </div>

        <div class="cards">

            <div class="card">
                <p>Total Aktivitas</p>
                <h2>1.250</h2>
            </div>

            <div class="card">
                <p>Admin Aktif</p>
                <h2>5</h2>
            </div>

            <div class="card">
                <p>User Login Hari Ini</p>
                <h2>120</h2>
            </div>

        </div>

        <div class="table-container">

            <table>

                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Status</th>
                </tr>

                <tr>
                    <td>14 Mei 2026 - 10:30</td>
                    <td>adminophelia</td>
                    <td>Menambahkan Produk Baru</td>
                    <td>Berhasil</td>
                </tr>

                <tr>
                    <td>14 Mei 2026 - 11:00</td>
                    <td>Zaki</td>
                    <td>Login ke Sistem</td>
                    <td>Berhasil</td>
                </tr>

                <tr>
                    <td>14 Mei 2026 - 11:15</td>
                    <td>superadmin</td>
                    <td>Menghapus Admin</td>
                    <td>Berhasil</td>
                </tr>

                <tr>
                    <td>14 Mei 2026 - 12:00</td>
                    <td>Ahmad</td>
                    <td>Checkout Produk</td>
                    <td>Pending</td>
                </tr>

            </table>

        </div>

    </div>

</div>

</body>
</html>
