@extends('layouts.superadmin')

@section('title', 'Kelola Admin')

@section('content')

<div class="topbar">
    <h1>Kelola Admin</h1>
    <button class="btn btn-add" onclick="document.getElementById('modalTambah').style.display='flex'">
        Tambah Admin
    </button>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert-error">
        <ul style="margin:0; padding-left:1.2rem">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="table-container">
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @forelse($admins as $admin)
        <tr>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->email }}</td>
            <td>
                <span class="badge {{ $admin->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                    {{ ucfirst($admin->status) }}
                </span>
            </td>
            <td>
                <button class="btn btn-edit"
                    onclick="openEdit({{ $admin->id }}, '{{ addslashes($admin->name) }}', '{{ $admin->email }}', '{{ $admin->status }}')">
                    Edit
                </button>
                <form action="{{ route('superadmin.admins.destroy', $admin->id) }}" method="POST"
                    onsubmit="return confirm('Yakin hapus admin {{ addslashes($admin->name) }}?')" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align:center; color:#888; padding:1.5rem">Belum ada admin.</td>
        </tr>
        @endforelse
    </table>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="modal-overlay" style="display:none">
    <div class="modal-box">
        <h2>Tambah Admin</h2>
        <form action="{{ route('superadmin.admins.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" required placeholder="Nama admin" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Email admin" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Min. 6 karakter">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="aktif"    {{ old('status') == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel"
                    onclick="document.getElementById('modalTambah').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-add">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="modal-overlay" style="display:none">
    <div class="modal-box">
        <h2>Edit Admin</h2>
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" id="editName" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="editEmail" required>
            </div>
            <div class="form-group">
                <label>Password Baru <small>(kosongkan jika tidak diganti)</small></label>
                <input type="password" name="password" placeholder="Min. 6 karakter">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="editStatus">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-cancel"
                    onclick="document.getElementById('modalEdit').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-add">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openEdit(id, name, email, status) {
    document.getElementById('editName').value   = name;
    document.getElementById('editEmail').value  = email;
    document.getElementById('editStatus').value = status;
    document.getElementById('formEdit').action  = '/superadmin/admins/' + id;
    document.getElementById('modalEdit').style.display = 'flex';
}
@if($errors->any())
    document.getElementById('modalTambah').style.display = 'flex';
@endif
</script>
@endpush