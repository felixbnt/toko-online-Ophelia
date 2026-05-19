<!DOCTYPE html>
<html>
<head>

    <title>Kelola Produk</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

</head>
<body>

<div class="admin-container">

    @include('components.admin-sidebar')

    <div class="main-content">

        <div class="topbar">

            <h1>Kelola Produk</h1>

            <button class="btn btn-add">
                Tambah Produk
            </button>

        </div>

        <div class="table-container">

            <table>

                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>

                <tr>
                    <td>Hoodie Oversize</td>
                    <td>Rp 150.000</td>
                    <td>50</td>

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
