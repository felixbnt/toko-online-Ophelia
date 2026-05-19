<!DOCTYPE html>
<html>
<head>

    <title>Kelola User</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>

<div class="admin-container">

    @include('components.superadmin-sidebar')

    <div class="main-content">

        <div class="topbar">

            <h1>Kelola User</h1>

        </div>

        <div class="table-container">

            <table>

                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>

                <tr>
                    <td>Zaki</td>
                    <td>zaki@gmail.com</td>
                    <td>Aktif</td>
                </tr>

                <tr>
                    <td>Ahmad</td>
                    <td>ahmad@gmail.com</td>
                    <td>Aktif</td>
                </tr>

            </table>

        </div>

    </div>

</div>

</body>
</html>
