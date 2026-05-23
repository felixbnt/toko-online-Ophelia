@extends('layouts.admin')

@section('title', 'Pesanan — Ophelia Admin')

@section('content')
<div class="page-header">
    <h1>Pesanan</h1>
    <p>Kelola dan pantau semua pesanan dari pelanggan</p>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EEF2FF">📦</div>
        <div>
            <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFF7ED">⏳</div>
        <div>
            <div class="stat-number">{{ $pendingOrders ?? 0 }}</div>
            <div class="stat-label">Menunggu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4">🚚</div>
        <div>
            <div class="stat-number">{{ $processingOrders ?? 0 }}</div>
            <div class="stat-label">Diproses</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0F9FF">✅</div>
        <div>
            <div class="stat-number">{{ $completedOrders ?? 0 }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>
</div>

{{-- FILTER & SEARCH --}}
<div class="card">
    <div class="card-toolbar">
        <div class="filter-tabs">
            <button class="filter-btn active" onclick="filterOrders('all', this)">Semua</button>
            <button class="filter-btn" onclick="filterOrders('pending', this)">⏳ Menunggu</button>
            <button class="filter-btn" onclick="filterOrders('processing', this)">🚚 Diproses</button>
            <button class="filter-btn" onclick="filterOrders('completed', this)">✅ Selesai</button>
            <button class="filter-btn" onclick="filterOrders('cancelled', this)">❌ Dibatalkan</button>
        </div>
        <input type="text" id="searchOrder" placeholder="Cari nama / ID pesanan…" class="search-input" oninput="searchOrders(this.value)">
    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <table id="ordersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="ordersBody">
                @forelse($orders ?? [] as $i => $order)
                <tr class="order-row" data-status="{{ $order->status ?? 'pending' }}">
                    <td>{{ $i + 1 }}</td>
                    <td><span class="order-id">#{{ str_pad($order->id ?? $i+1, 5, '0', STR_PAD_LEFT) }}</span></td>
                    <td>
                        <div class="customer-info">
                            <div class="avatar">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                            <div>
                                <div class="customer-name">{{ $order->user->name ?? 'Pelanggan' }}</div>
                                <div class="customer-email">{{ $order->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $order->items_count ?? 1 }} item</td>
                    <td><strong>Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</strong></td>
                    <td>
                        <span class="badge badge-{{ $order->status ?? 'pending' }}">
                            {{ match($order->status ?? 'pending') {
                                'pending'    => '⏳ Menunggu',
                                'processing' => '🚚 Diproses',
                                'completed'  => '✅ Selesai',
                                'cancelled'  => '❌ Dibatalkan',
                                default      => ucfirst($order->status ?? 'pending')
                            } }}
                        </span>
                    </td>
                    <td>{{ isset($order->created_at) ? $order->created_at->format('d M Y') : '-' }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-view" onclick="viewOrder({{ $order->id ?? 0 }})" title="Lihat Detail">👁</button>
                            <select class="status-select" onchange="updateStatus({{ $order->id ?? 0 }}, this.value)">
                                <option value="pending"    {{ ($order->status ?? '') === 'pending'    ? 'selected' : '' }}>Menunggu</option>
                                <option value="processing" {{ ($order->status ?? '') === 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="completed"  {{ ($order->status ?? '') === 'completed'  ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled"  {{ ($order->status ?? '') === 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                    </td>
                </tr>
                @empty
                {{-- DEMO DATA saat belum ada pesanan dari DB --}}
                @php
                $demoOrders = [
                    ['id'=>1,'name'=>'Rina Sari','email'=>'rina@email.com','items'=>2,'total'=>1398000,'status'=>'completed','date'=>'15 Mei 2025'],
                    ['id'=>2,'name'=>'Budi Santoso','email'=>'budi@email.com','items'=>1,'total'=>499000,'status'=>'processing','date'=>'17 Mei 2025'],
                    ['id'=>3,'name'=>'Dewi Lestari','email'=>'dewi@email.com','items'=>3,'total'=>1797000,'status'=>'pending','date'=>'19 Mei 2025'],
                    ['id'=>4,'name'=>'Ahmad Fauzi','email'=>'ahmad@email.com','items'=>1,'total'=>399000,'status'=>'cancelled','date'=>'20 Mei 2025'],
                ];
                @endphp
                @foreach($demoOrders as $i => $o)
                <tr class="order-row" data-status="{{ $o['status'] }}">
                    <td>{{ $i + 1 }}</td>
                    <td><span class="order-id">#{{ str_pad($o['id'], 5, '0', STR_PAD_LEFT) }}</span></td>
                    <td>
                        <div class="customer-info">
                            <div class="avatar">{{ strtoupper(substr($o['name'], 0, 1)) }}</div>
                            <div>
                                <div class="customer-name">{{ $o['name'] }}</div>
                                <div class="customer-email">{{ $o['email'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $o['items'] }} item</td>
                    <td><strong>Rp {{ number_format($o['total'], 0, ',', '.') }}</strong></td>
                    <td>
                        <span class="badge badge-{{ $o['status'] }}">
                            {{ match($o['status']) {
                                'pending'    => '⏳ Menunggu',
                                'processing' => '🚚 Diproses',
                                'completed'  => '✅ Selesai',
                                'cancelled'  => '❌ Dibatalkan',
                                default      => $o['status']
                            } }}
                        </span>
                    </td>
                    <td>{{ $o['date'] }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon btn-view" title="Lihat Detail">👁</button>
                            <select class="status-select">
                                <option value="pending"    {{ $o['status']==='pending'    ? 'selected':'' }}>Menunggu</option>
                                <option value="processing" {{ $o['status']==='processing' ? 'selected':'' }}>Diproses</option>
                                <option value="completed"  {{ $o['status']==='completed'  ? 'selected':'' }}>Selesai</option>
                                <option value="cancelled"  {{ $o['status']==='cancelled'  ? 'selected':'' }}>Dibatalkan</option>
                            </select>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div id="orderModal" class="modal-overlay" style="display:none" onclick="closeModal(event)">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Detail Pesanan</h3>
            <button class="modal-close" onclick="document.getElementById('orderModal').style.display='none'">✕</button>
        </div>
        <div class="modal-body" id="modalContent">
            <p style="color:#6b7280">Memuat detail pesanan…</p>
        </div>
    </div>
</div>

<style>
.page-header { margin-bottom: 1.5rem; }
.page-header h1 { font-size: 1.75rem; font-weight: 700; color: #111; margin: 0 0 .25rem; }
.page-header p  { color: #6b7280; margin: 0; }

.stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.5rem; }
.stat-card  { background: #fff; border-radius: 12px; padding: 1.25rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
.stat-icon  { width: 48px; height: 48px; border-radius: 10px; display: grid; place-items: center; font-size: 1.4rem; flex-shrink: 0; }
.stat-number{ font-size: 1.6rem; font-weight: 700; color: #111; line-height: 1; }
.stat-label { font-size: .8rem; color: #6b7280; margin-top: .2rem; }

.card { background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
.card-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: .75rem; }

.filter-tabs { display: flex; gap: .5rem; flex-wrap: wrap; }
.filter-btn  { padding: .4rem .9rem; border-radius: 20px; border: 1.5px solid #e5e7eb; background: #fff; cursor: pointer; font-size: .82rem; color: #6b7280; transition: all .15s; }
.filter-btn.active, .filter-btn:hover { background: #1e293b; color: #fff; border-color: #1e293b; }

.search-input { padding: .45rem .9rem; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: .85rem; outline: none; width: 220px; }
.search-input:focus { border-color: #6366f1; }

.table-wrapper { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: .875rem; }
thead th { text-align: left; padding: .75rem .75rem; font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; border-bottom: 1.5px solid #f3f4f6; }
tbody tr { border-bottom: 1px solid #f9fafb; transition: background .1s; }
tbody tr:hover { background: #f9fafb; }
tbody td { padding: .85rem .75rem; vertical-align: middle; }

.order-id { font-family: monospace; font-weight: 600; color: #6366f1; background: #eef2ff; padding: .2rem .5rem; border-radius: 5px; }
.customer-info { display: flex; align-items: center; gap: .65rem; }
.avatar { width: 34px; height: 34px; border-radius: 50%; background: #1e293b; color: #fff; display: grid; place-items: center; font-weight: 700; font-size: .85rem; flex-shrink: 0; }
.customer-name  { font-weight: 600; color: #111; font-size: .85rem; }
.customer-email { font-size: .75rem; color: #9ca3af; }

.badge { padding: .3rem .75rem; border-radius: 20px; font-size: .78rem; font-weight: 600; }
.badge-pending    { background: #fff7ed; color: #c2410c; }
.badge-processing { background: #f0fdf4; color: #166534; }
.badge-completed  { background: #eff6ff; color: #1d4ed8; }
.badge-cancelled  { background: #fef2f2; color: #b91c1c; }

.action-buttons { display: flex; align-items: center; gap: .5rem; }
.btn-icon { width: 32px; height: 32px; border-radius: 8px; border: none; background: #f3f4f6; cursor: pointer; font-size: 1rem; display: grid; place-items: center; transition: background .15s; }
.btn-icon:hover { background: #e5e7eb; }
.status-select { padding: .35rem .6rem; border: 1.5px solid #e5e7eb; border-radius: 7px; font-size: .8rem; background: #fff; cursor: pointer; }

/* Modal */
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.45); display: grid; place-items: center; z-index: 1000; }
.modal-box { background: #fff; border-radius: 14px; width: 90%; max-width: 480px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,.2); }
.modal-header { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6; }
.modal-header h3 { margin: 0; font-size: 1.1rem; font-weight: 700; }
.modal-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #6b7280; }
.modal-body { padding: 1.5rem; }

@media(max-width:900px){ .stats-grid{grid-template-columns:repeat(2,1fr)} }
@media(max-width:600px){ .stats-grid{grid-template-columns:1fr} .card-toolbar{flex-direction:column;align-items:flex-start} }
</style>

<script>
function filterOrders(status, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.order-row').forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });
}

function searchOrders(q) {
    const term = q.toLowerCase();
    document.querySelectorAll('.order-row').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
    });
}

function viewOrder(id) {
    document.getElementById('orderModal').style.display = 'grid';
    document.getElementById('modalContent').innerHTML = `
        <p><strong>ID Pesanan:</strong> #${String(id).padStart(5,'0')}</p>
        <p style="color:#6b7280;font-size:.875rem">Detail lengkap pesanan akan muncul di sini setelah terhubung ke database.</p>
    `;
}

function closeModal(e) {
    if (e.target.id === 'orderModal') e.target.style.display = 'none';
}

function updateStatus(id, status) {
    // Kirim ke route: POST /admin/orders/{id}/status
    fetch(`/admin/orders/${id}/status`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '' },
        body: JSON.stringify({ status })
    }).then(r => r.ok && location.reload()).catch(() => {});
}
</script>
@endsection