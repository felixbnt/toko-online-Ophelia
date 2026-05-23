@extends('layouts.admin')

@section('title', 'Dashboard — Ophelia Admin')

@section('content')
<style>
    .page-header { margin-bottom: 1.5rem; }
    .page-header h1 { font-size: 1.75rem; font-weight: 700; color: #1A1D2E; margin: 0 0 .25rem; }
    .page-header p  { color: #8892A4; margin: 0; font-size: .875rem; }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 12px rgba(0,0,0,.03);
        display: flex; align-items: center; gap: 1rem;
    }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: grid; place-items: center;
        font-size: 1.4rem; flex-shrink: 0;
    }
    .icon-blue   { background: #EFF6FF; }
    .icon-green  { background: #F0FDF4; }
    .icon-purple { background: #FAF5FF; }
    .icon-orange { background: #FFF7ED; }
    .stat-num   { font-size: 1.6rem; font-weight: 700; color: #1A1D2E; line-height: 1; }
    .stat-label { font-size: .8rem; color: #8892A4; margin-top: .25rem; }
    .stat-trend { font-size: .75rem; font-weight: 600; margin-top: .3rem; }
    .trend-up   { color: #16a34a; }
    .trend-down { color: #dc2626; }

    .two-col { display: grid; grid-template-columns: 1.6fr 1fr; gap: 1rem; margin-bottom: 1rem; }

    .card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 12px rgba(0,0,0,.03);
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .card-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #EEF0F6;
        font-weight: 700; font-size: .95rem; color: #1A1D2E;
        display: flex; justify-content: space-between; align-items: center;
    }
    .card-header a { font-size: .8rem; color: #6366f1; text-decoration: none; font-weight: 600; }
    .card-header a:hover { text-decoration: underline; }

    /* Recent orders table */
    table { width: 100%; border-collapse: collapse; font-size: .875rem; }
    thead th { padding: .7rem 1.25rem; text-align: left; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #8892A4; background: #F8F9FC; border-bottom: 1.5px solid #EEF0F6; }
    tbody td { padding: .85rem 1.25rem; border-bottom: 1px solid #F0F2F7; vertical-align: middle; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #FAFBFF; }

    .badge { padding: .3rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 700; }
    .badge-completed  { background: #EFF6FF; color: #1D4ED8; }
    .badge-processing { background: #F0FDF4; color: #166534; }
    .badge-pending    { background: #FFF7ED; color: #C2410C; }
    .badge-cancelled  { background: #FEF2F2; color: #DC2626; }

    /* Top products */
    .product-item {
        display: flex; align-items: center; gap: .85rem;
        padding: .85rem 1.25rem;
        border-bottom: 1px solid #F0F2F7;
    }
    .product-item:last-child { border-bottom: none; }
    .product-rank {
        width: 26px; height: 26px; border-radius: 50%;
        display: grid; place-items: center;
        font-weight: 700; font-size: .78rem; flex-shrink: 0;
    }
    .rank-1 { background: #FEF9C3; color: #854D0E; }
    .rank-2 { background: #F3F4F6; color: #374151; }
    .rank-3 { background: #FFF7ED; color: #9A3412; }
    .rank-other { background: #F9FAFB; color: #6B7280; }
    .product-info { flex: 1; }
    .product-name { font-weight: 600; font-size: .875rem; color: #1A1D2E; }
    .product-cat  { font-size: .75rem; color: #8892A4; margin-top: 2px; }
    .product-sold { font-size: .82rem; font-weight: 700; color: #6366f1; }

    /* Quick links */
    .quick-links { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; padding: 1.25rem; }
    .quick-link {
        display: flex; align-items: center; gap: .75rem;
        padding: .85rem 1rem; border-radius: 10px;
        background: #F8F9FC; text-decoration: none;
        color: #1A1D2E; font-size: .875rem; font-weight: 600;
        transition: background .15s, transform .1s;
        border: 1.5px solid #EEF0F6;
    }
    .quick-link:hover { background: #EEF2FF; border-color: #c7d2fe; transform: translateY(-1px); }
    .quick-link span  { font-size: 1.2rem; }

    @media(max-width:1024px){ .two-col{grid-template-columns:1fr} }
    @media(max-width:900px) { .stats-grid{grid-template-columns:repeat(2,1fr)} }
    @media(max-width:500px) { .stats-grid{grid-template-columns:1fr} }
</style>

{{-- HEADER --}}
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }} 👋</p>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-blue">📦</div>
        <div>
            <div class="stat-num">{{ $totalProducts ?? 0 }}</div>
            <div class="stat-label">Total Produk</div>
            <div class="stat-trend trend-up">↑ Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-orange">🛍</div>
        <div>
            <div class="stat-num">{{ $totalOrders ?? 0 }}</div>
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-trend trend-up">↑ 8% bulan ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-purple">👥</div>
        <div>
            <div class="stat-num">{{ $totalUsers ?? 0 }}</div>
            <div class="stat-label">Total User</div>
            <div class="stat-trend trend-up">↑ 5% bulan ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-green">💰</div>
        <div>
            <div class="stat-num">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Pendapatan</div>
            <div class="stat-trend trend-up">↑ 12% bulan ini</div>
        </div>
    </div>
</div>

<div class="two-col">
    {{-- PESANAN TERBARU --}}
    <div class="card">
        <div class="card-header">
            🛍 Pesanan Terbaru
            <a href="{{ route('admin.orders') }}">Lihat semua →</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                $recentOrders = $recentOrders ?? [
                    ['id'=>1,'name'=>'Rina Sari',    'total'=>1398000,'status'=>'completed'],
                    ['id'=>2,'name'=>'Budi Santoso',  'total'=>499000, 'status'=>'processing'],
                    ['id'=>3,'name'=>'Dewi Lestari',  'total'=>1797000,'status'=>'pending'],
                    ['id'=>4,'name'=>'Ahmad Fauzi',   'total'=>399000, 'status'=>'cancelled'],
                    ['id'=>5,'name'=>'Siti Rahayu',   'total'=>799000, 'status'=>'completed'],
                ];
                @endphp
                @foreach($recentOrders as $o)
                <tr>
                    <td style="font-family:monospace;color:#6366f1;font-weight:700;">
                        #{{ str_pad(is_array($o) ? $o['id'] : $o->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td style="font-weight:600;">{{ is_array($o) ? $o['name'] : $o->user_name }}</td>
                    <td>Rp {{ number_format(is_array($o) ? $o['total'] : $o->total, 0, ',', '.') }}</td>
                    <td>
                        @php $st = is_array($o) ? $o['status'] : $o->status; @endphp
                        <span class="badge badge-{{ $st }}">
                            {{ match($st) {
                                'completed'  => '✅ Selesai',
                                'processing' => '🚚 Diproses',
                                'pending'    => '⏳ Menunggu',
                                'cancelled'  => '❌ Dibatalkan',
                                default      => ucfirst($st)
                            } }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- KANAN: Top Produk + Quick Links --}}
    <div>
        {{-- TOP PRODUK --}}
        <div class="card">
            <div class="card-header">
                🏆 Produk Terlaris
                <a href="{{ route('admin.reports') }}">Lihat laporan →</a>
            </div>
            @php
            $topProducts = $topProducts ?? [
                ['rank'=>1,'name'=>'Linen Tops',      'cat'=>'Woman','sold'=>42],
                ['rank'=>2,'name'=>'Floral Dress',     'cat'=>'Woman','sold'=>35],
                ['rank'=>3,'name'=>'Casual Shirt',     'cat'=>'Man',  'sold'=>28],
                ['rank'=>4,'name'=>'Kemeja Siregar',   'cat'=>'Man',  'sold'=>22],
                ['rank'=>5,'name'=>'Minimalis Dress',  'cat'=>'Kids', 'sold'=>15],
            ];
            @endphp
            @foreach($topProducts as $p)
            @php $r = is_array($p) ? $p['rank'] : $p->rank; @endphp
            <div class="product-item">
                <div class="product-rank {{ $r===1?'rank-1':($r===2?'rank-2':($r===3?'rank-3':'rank-other')) }}">
                    {{ $r }}
                </div>
                <div class="product-info">
                    <div class="product-name">{{ is_array($p) ? $p['name'] : $p->name }}</div>
                    <div class="product-cat">{{ is_array($p) ? $p['cat'] : $p->category }}</div>
                </div>
                <div class="product-sold">{{ is_array($p) ? $p['sold'] : $p->sold }} terjual</div>
            </div>
            @endforeach
        </div>

        {{-- QUICK LINKS --}}
        <div class="card">
            <div class="card-header">⚡ Akses Cepat</div>
            <div class="quick-links">
                <a href="{{ route('admin.products') }}" class="quick-link"><span>📦</span> Kelola Produk</a>
                <a href="{{ route('admin.orders') }}"   class="quick-link"><span>🛍</span> Lihat Pesanan</a>
                <a href="{{ route('admin.reports') }}"  class="quick-link"><span>📊</span> Laporan</a>
                <a href="{{ route('home') }}"           class="quick-link" target="_blank"><span>🌐</span> Lihat Toko</a>
            </div>
        </div>
    </div>
</div>
@endsection