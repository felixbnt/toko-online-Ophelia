<!DOCTYPE html>
<html>
<head>

    <title>Kelola Admin</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>

<div class="admin-container">

    @include('components.superadmin-sidebar')

    <div class="main-content">

        <div class="topbar">

            <h1>Kelola Admin</h1>

            <button class="btn btn-add">
                Tambah Admin
            </button>

        </div>

        <div class="table-container">

            <table>

                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

                <tr>
                    <td>Zaki</td>
                    <td>admin@gmail.com</td>
                    <td>Aktif</td>

                    <td>

                        <button class="btn btn-edit">
                            Edit
                        </button>

                        <button class="btn btn-delete">
                            Hapus
                        </button>

                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

</body>
</html>
