@extends('layouts.superadmin')

@section('title', 'Kelola User')

@section('content')

<div class="topbar">
    <h1>Kelola User</h1>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-container">
    <table>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @forelse($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge {{ $user->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                    {{ ucfirst($user->status) }}
                </span>
            </td>
            <td>
                <button class="btn btn-edit"
                    onclick="openEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->status }}')">
                    Edit
                </button>
                <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST"
                    onsubmit="return confirm('Yakin hapus user {{ addslashes($user->name) }}?')" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete" type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align:center; color:#888; padding:1.5rem">Belum ada user.</td>
        </tr>
        @endforelse
    </table>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="modal-overlay" style="display:none">
    <div class="modal-box">
        <h2>Edit User</h2>
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
    document.getElementById('formEdit').action  = '/superadmin/users/' + id;
    document.getElementById('modalEdit').style.display = 'flex';
}
</script>
@endpush