@extends('layouts.admin')

@section('title', 'Kelola Produk — Ophelia Admin')

@section('content')
<style>
    *, *::before, *::after { box-sizing: border-box; }

    .page-header { margin-bottom: 1.5rem; }
    .page-header h1 { font-size: 1.75rem; font-weight: 700; color: #1A1D2E; margin: 0 0 .25rem; }
    .page-header .subtitle { font-size: 0.85rem; color: #8892A4; margin: 0; }

    /* STATS */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px 22px;
        box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 12px rgba(0,0,0,.03);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
    }
    .stat-icon-all   { background: #EEF2FF; }
    .stat-icon-man   { background: #EFF6FF; }
    .stat-icon-woman { background: #FDF2F8; }
    .stat-icon-kids  { background: #FFFBEB; }
    .stat-num   { font-size: 1.5rem; font-weight: 700; color: #1A1D2E; line-height: 1; }
    .stat-label { font-size: 0.78rem; color: #8892A4; margin-top: 3px; font-weight: 500; }

    /* CARD */
    .card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .card-header {
        padding: 22px 28px 18px;
        border-bottom: 1px solid #EEF0F6;
        font-size: 0.9rem; font-weight: 600; color: #1A1D2E;
        display: flex; align-items: center; gap: 8px;
    }

    /* ADD FORM */
    .add-form {
        padding: 22px 28px 24px;
        border-bottom: 1px solid #EEF0F6;
        background: #FAFBFD;
    }
    .form-row {
        display: grid;
        grid-template-columns: 2fr 1.2fr 0.9fr 1.2fr auto;
        gap: 12px;
        align-items: end;
    }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group label {
        font-size: 0.75rem; font-weight: 600; color: #8892A4;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .form-group input,
    .form-group select {
        height: 42px; padding: 0 14px;
        border: 1.5px solid #E2E6EF; border-radius: 9px;
        font-family: inherit; font-size: 0.875rem; color: #1A1D2E;
        background: #fff; outline: none;
        appearance: none; -webkit-appearance: none;
        transition: border-color .18s, box-shadow .18s;
    }
    .form-group select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238892A4' stroke-width='2.5'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }
    .form-group input:focus,
    .form-group select:focus {
        border-color: #6366F1;
        box-shadow: 0 0 0 3px rgba(99,102,241,.12);
    }

    /* BUTTONS */
    .btn {
        height: 42px; padding: 0 20px;
        border: none; border-radius: 9px;
        font-family: inherit; font-size: 0.875rem; font-weight: 600;
        cursor: pointer; white-space: nowrap;
        transition: transform .12s, box-shadow .18s;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn:active { transform: scale(0.97); }
    .btn-add    { background: linear-gradient(135deg,#6366F1,#818CF8); color:#fff; box-shadow:0 3px 10px rgba(99,102,241,.35); }
    .btn-add:hover { box-shadow:0 5px 16px rgba(99,102,241,.45); }
    .btn-save   { background: linear-gradient(135deg,#10B981,#34D399); color:#fff; height:36px; padding:0 14px; font-size:.8rem; box-shadow:0 2px 8px rgba(16,185,129,.3); }
    .btn-delete { background: linear-gradient(135deg,#EF4444,#F87171); color:#fff; height:36px; padding:0 14px; font-size:.8rem; box-shadow:0 2px 8px rgba(239,68,68,.3); }

    /* FILTER */
    .filter-bar { padding: 16px 28px; border-bottom: 1px solid #EEF0F6; display: flex; gap: 8px; flex-wrap: wrap; }
    .filter-btn {
        height: 32px; padding: 0 16px; border-radius: 20px;
        border: 1.5px solid #E2E6EF; background: #fff;
        font-family: inherit; font-size: .8rem; font-weight: 600; color: #8892A4;
        cursor: pointer; transition: all .15s;
    }
    .filter-btn:hover, .filter-btn.active { border-color:#6366F1; color:#6366F1; background:#EEF2FF; }
    .filter-btn.active-man   { border-color:#3B82F6; color:#1D4ED8; background:#EFF6FF; }
    .filter-btn.active-woman { border-color:#EC4899; color:#BE185D; background:#FDF2F8; }
    .filter-btn.active-kids  { border-color:#F59E0B; color:#B45309; background:#FFFBEB; }

    /* TABLE */
    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #F8F9FC; border-bottom: 1.5px solid #EEF0F6; }
    th { padding: 13px 20px; text-align: left; font-size: .75rem; font-weight: 700; color: #8892A4; text-transform: uppercase; letter-spacing: .6px; }
    tbody tr { border-bottom: 1px solid #F0F2F7; transition: background .15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #FAFBFF; }
    td { padding: 14px 20px; font-size: .875rem; vertical-align: middle; }
    .product-name { font-weight: 600; color: #1A1D2E; }

    .stock-badge {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 36px; height: 26px; padding: 0 10px;
        border-radius: 20px; font-size: .8rem; font-weight: 700;
    }
    .stock-ok  { background: #EDFAF4; color: #1A7A4A; }
    .stock-low { background: #FFF7ED; color: #C2410C; }
    .stock-out { background: #FEF2F2; color: #DC2626; }

    .cat-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 20px;
        font-size: .78rem; font-weight: 700;
    }
    .cat-man   { background: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE; }
    .cat-woman { background: #FDF2F8; color: #BE185D; border: 1px solid #FBCFE8; }
    .cat-kids  { background: #FFFBEB; color: #B45309; border: 1px solid #FDE68A; }

    .edit-inputs {
        display: grid;
        grid-template-columns: 1.8fr 1fr 0.7fr 1fr;
        gap: 8px; align-items: center;
    }
    .edit-inputs input,
    .edit-inputs select {
        height: 36px; padding: 0 10px;
        border: 1.5px solid #E2E6EF; border-radius: 7px;
        font-family: inherit; font-size: .82rem; color: #1A1D2E;
        background: #fff; outline: none;
        appearance: none; -webkit-appearance: none;
        transition: border-color .18s;
    }
    .edit-inputs select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%238892A4' stroke-width='2.5'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 28px;
    }
    .edit-inputs input:focus,
    .edit-inputs select:focus { border-color: #6366F1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }

    .empty-state { text-align: center; padding: 56px 20px; color: #8892A4; }
    .empty-state p { font-size: .9rem; margin-top: 14px; }

    @media(max-width:900px){ .stats-row{grid-template-columns:repeat(2,1fr)} .form-row{grid-template-columns:1fr 1fr} }
    @media(max-width:600px){ .stats-row{grid-template-columns:1fr} .form-row{grid-template-columns:1fr} .edit-inputs{grid-template-columns:1fr 1fr} }
</style>

{{-- PAGE HEADER --}}
<div class="page-header">
    <h1>Kelola Produk</h1>
    <p class="subtitle">Tambah, edit, dan hapus produk toko Anda</p>
</div>

{{-- STATS --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon stat-icon-all">📦</div>
        <div>
            <div class="stat-num">{{ $products->count() }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-man">👔</div>
        <div>
            <div class="stat-num">{{ $products->where('category','man')->count() }}</div>
            <div class="stat-label">Kategori Man</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-woman">👗</div>
        <div>
            <div class="stat-num">{{ $products->where('category','woman')->count() }}</div>
            <div class="stat-label">Kategori Woman</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon-kids">🧒</div>
        <div>
            <div class="stat-num">{{ $products->where('category','kids')->count() }}</div>
            <div class="stat-label">Kategori Kids</div>
        </div>
    </div>
</div>

{{-- PRODUCT TABLE CARD --}}
<div class="card">

    <div class="card-header">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        Daftar Produk
    </div>

    {{-- ADD FORM --}}
    <div class="add-form">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" placeholder="Nama produk" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" placeholder="0" min="0" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" placeholder="0" min="0" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category" required onchange="updateSelectStyle(this)">
                        <option value="">— Pilih —</option>
                        <option value="man">👔 Man</option>
                        <option value="woman">👗 Woman</option>
                        <option value="kids">🧒 Kids</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-add">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                    Tambah
                </button>
            </div>
        </form>
    </div>

    {{-- FILTER --}}
    <div class="filter-bar">
        <button class="filter-btn active" onclick="filterTable('all', this)">Semua</button>
        <button class="filter-btn" onclick="filterTable('man', this)">👔 Man</button>
        <button class="filter-btn" onclick="filterTable('woman', this)">👗 Woman</button>
        <button class="filter-btn" onclick="filterTable('kids', this)">🧒 Kids</button>
    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <table id="productsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $index => $item)
                <tr data-category="{{ $item->category ?? 'man' }}">
                    <td style="color:#8892A4;font-size:.8rem;">{{ $index + 1 }}</td>
                    <td class="product-name">{{ $item->name }}</td>
                    <td>
                        @php $cat = $item->category ?? 'man'; @endphp
                        <span class="cat-badge cat-{{ $cat }}">
                            @if($cat==='man') 👔 Man
                            @elseif($cat==='woman') 👗 Woman
                            @else 🧒 Kids
                            @endif
                        </span>
                    </td>
                    <td style="font-weight:600;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>
                        @php $stk = $item->stock; @endphp
                        <span class="stock-badge {{ $stk <= 0 ? 'stock-out' : ($stk <= 5 ? 'stock-low' : 'stock-ok') }}">
                            {{ $stk }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                            {{-- EDIT --}}
                            <form action="{{ route('admin.products.update', $item->id) }}" method="POST" style="display:contents;">
                                @csrf
                                @method('PUT')
                                <div class="edit-inputs">
                                    <input type="text"   name="nama"     value="{{ $item->name }}"     required>
                                    <input type="number" name="harga"    value="{{ $item->price }}"    min="0" required>
                                    <input type="number" name="stok"     value="{{ $item->stock }}"    min="0" required>
                                    <select name="category" required>
                                        <option value="man"   {{ $item->category==='man'   ? 'selected':'' }}>👔 Man</option>
                                        <option value="woman" {{ $item->category==='woman' ? 'selected':'' }}>👗 Woman</option>
                                        <option value="kids"  {{ $item->category==='kids'  ? 'selected':'' }}>🧒 Kids</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-save">Simpan</button>
                            </form>
                            {{-- DELETE --}}
                            <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete"
                                    onclick="return confirm('Yakin hapus \'{{ $item->name }}\'?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#8892A4" stroke-width="1.5"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                            <p>Belum ada produk. Tambahkan produk pertama Anda!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
function filterTable(cat, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.classList.remove('active','active-man','active-woman','active-kids');
    });
    cat === 'all' ? btn.classList.add('active') : btn.classList.add('active-' + cat);
    document.querySelectorAll('#productsTable tbody tr[data-category]').forEach(row => {
        row.style.display = (cat === 'all' || row.dataset.category === cat) ? '' : 'none';
    });
}

function updateSelectStyle(sel) {
    sel.className = sel.className.replace(/select-\w+/g, '').trim();
    if (sel.value) sel.classList.add('select-' + sel.value);
}

document.querySelectorAll('select[name="category"]').forEach(sel => {
    updateSelectStyle(sel);
    sel.addEventListener('change', function() { updateSelectStyle(this); });
});
</script>
@endsection