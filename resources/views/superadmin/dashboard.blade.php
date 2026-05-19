<!DOCTYPE html>
<html>
<head>

    <title>Super Admin Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>

<div class="admin-container">

    @include('components.superadmin-sidebar')

    <div class="main-content">

        <div class="topbar">
            <h1>Super Admin Dashboard</h1>
        </div>

        <div class="cards">

            <div class="card">
                <p>Total Admin</p>
                <h2>5</h2>
            </div>

            <div class="card">
                <p>Total User</p>
                <h2>240</h2>
            </div>

            <div class="card">
                <p>Total Transaksi</p>
                <h2>530</h2>
            </div>

            <div class="card">
                <p>Total Pendapatan</p>
                <h2>Rp 45JT</h2>
            </div>

        </div>

    </div>

</div>

</body>
</html>
