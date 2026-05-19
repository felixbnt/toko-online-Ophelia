<!DOCTYPE html>
<html>
<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>

<div class="admin-container">

    @include('components.admin-sidebar')

    <div class="main-content">

        <div class="topbar">

            <h1>Dashboard Admin</h1>

            <p>Welcome Admin</p>

        </div>

        <div class="cards">

            <div class="card">
                <p>Total Produk</p>
                <h2>120</h2>
            </div>

            <div class="card">
                <p>Total Pesanan</p>
                <h2>80</h2>
            </div>

            <div class="card">
                <p>Total User</p>
                <h2>150</h2>
            </div>

            <div class="card">
                <p>Pendapatan</p>
                <h2>12JT</h2>
            </div>

        </div>

    </div>

</div>

</body>
</html>
