@extends('layouts.admin')

@section('title', 'Laporan — Ophelia Admin')

@section('content')
<div class="page-header">
    <div>
        <h1>Laporan</h1>
        <p>Ringkasan performa toko dan statistik penjualan</p>
    </div>
    <div class="header-actions">
        <select id="periodSelect" onchange="changePeriod(this.value)" class="period-select">
            <option value="7">7 Hari Terakhir</option>
            <option value="30" selected>30 Hari Terakhir</option>
            <option value="90">3 Bulan Terakhir</option>
            <option value="365">1 Tahun</option>
        </select>
        <button class="btn-export" onclick="window.print()">⬇ Export</button>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green">💰</div>
        <div>
            <div class="stat-number">Rp {{ number_format($totalRevenue ?? 4093000, 0, ',', '.') }}</div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-trend up">↑ 12% dari periode lalu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">🛍</div>
        <div>
            <div class="stat-number">{{ $totalOrders ?? 24 }}</div>
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-trend up">↑ 8% dari periode lalu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">👥</div>
        <div>
            <div class="stat-number">{{ $totalCustomers ?? 18 }}</div>
            <div class="stat-label">Pelanggan</div>
            <div class="stat-trend up">↑ 5% dari periode lalu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">📦</div>
        <div>
            <div class="stat-number">Rp {{ number_format($avgOrderValue ?? 170542, 0, ',', '.') }}</div>
            <div class="stat-label">Rata-rata Pesanan</div>
            <div class="stat-trend down">↓ 2% dari periode lalu</div>
        </div>
    </div>
</div>

<div class="two-col">
    {{-- GRAFIK PENJUALAN --}}
    <div class="card chart-card">
        <div class="card-header">
            <h3>📈 Grafik Penjualan</h3>
            <span class="subtitle">30 hari terakhir</span>
        </div>
        <div class="chart-area">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- KATEGORI PIE --}}
    <div class="card chart-card">
        <div class="card-header">
            <h3>🎯 Penjualan per Kategori</h3>
            <span class="subtitle">Distribusi produk</span>
        </div>
        <div class="chart-area donut-wrap">
            <canvas id="categoryChart"></canvas>
        </div>
        <div class="legend">
            <div class="legend-item"><span class="dot" style="background:#6366f1"></span> Man ({{ $manPct ?? 45 }}%)</div>
            <div class="legend-item"><span class="dot" style="background:#f472b6"></span> Woman ({{ $womanPct ?? 38 }}%)</div>
            <div class="legend-item"><span class="dot" style="background:#34d399"></span> Kids ({{ $kidsPct ?? 17 }}%)</div>
        </div>
    </div>
</div>

{{-- PRODUK TERLARIS --}}
<div class="card">
    <div class="card-header">
        <h3>🏆 Produk Terlaris</h3>
        <span class="subtitle">Berdasarkan jumlah terjual</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Terjual</th>
                    <th>Pendapatan</th>
                    <th>Performa</th>
                </tr>
            </thead>
            <tbody>
                @php
                $topProducts = $topProducts ?? [
                    ['rank'=>1,'name'=>'Linen Tops','cat'=>'Woman','sold'=>42,'revenue'=>33558000,'pct'=>100],
                    ['rank'=>2,'name'=>'Floral Dress','cat'=>'Woman','sold'=>35,'revenue'=>20965000,'pct'=>83],
                    ['rank'=>3,'name'=>'Casual Shirt','cat'=>'Man','sold'=>28,'revenue'=>13972000,'pct'=>67],
                    ['rank'=>4,'name'=>'Kemeja Siregar','cat'=>'Man','sold'=>22,'revenue'=>2640000,'pct'=>52],
                    ['rank'=>5,'name'=>'Minimalis Dress','cat'=>'Kids','sold'=>15,'revenue'=>5985000,'pct'=>36],
                ];
                @endphp
                @foreach($topProducts as $p)
                <tr>
                    <td><span class="rank rank-{{ $p['rank'] }}">{{ $p['rank'] }}</span></td>
                    <td><strong>{{ $p['name'] }}</strong></td>
                    <td><span class="cat-badge cat-{{ strtolower($p['cat']) }}">{{ $p['cat'] }}</span></td>
                    <td>{{ $p['sold'] }} pcs</td>
                    <td>Rp {{ number_format($p['revenue'], 0, ',', '.') }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width:{{ $p['pct'] }}%"></div>
                        </div>
                        <span class="pct-label">{{ $p['pct'] }}%</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
.page-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
.page-header h1 { font-size:1.75rem; font-weight:700; color:#111; margin:0 0 .25rem; }
.page-header p  { color:#6b7280; margin:0; }
.header-actions { display:flex; gap:.75rem; align-items:center; }
.period-select { padding:.45rem .9rem; border:1.5px solid #e5e7eb; border-radius:8px; font-size:.85rem; background:#fff; cursor:pointer; }
.btn-export { padding:.45rem 1rem; background:#1e293b; color:#fff; border:none; border-radius:8px; font-size:.85rem; cursor:pointer; transition:opacity .15s; }
.btn-export:hover { opacity:.85; }

.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem; }
.stat-card  { background:#fff; border-radius:12px; padding:1.25rem; display:flex; align-items:flex-start; gap:1rem; box-shadow:0 1px 4px rgba(0,0,0,.06); }
.stat-icon  { width:48px; height:48px; border-radius:10px; display:grid; place-items:center; font-size:1.4rem; flex-shrink:0; }
.stat-icon.green  { background:#f0fdf4; }
.stat-icon.blue   { background:#eff6ff; }
.stat-icon.purple { background:#faf5ff; }
.stat-icon.orange { background:#fff7ed; }
.stat-number { font-size:1.3rem; font-weight:700; color:#111; line-height:1.1; }
.stat-label  { font-size:.8rem; color:#6b7280; margin-top:.2rem; }
.stat-trend  { font-size:.75rem; margin-top:.3rem; font-weight:600; }
.stat-trend.up   { color:#16a34a; }
.stat-trend.down { color:#dc2626; }

.two-col { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem; }
.card { background:#fff; border-radius:12px; padding:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,.06); margin-bottom:1rem; }
.card-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem; }
.card-header h3 { margin:0; font-size:1rem; font-weight:700; }
.subtitle { font-size:.8rem; color:#9ca3af; }
.chart-area { position:relative; }

/* FIX: donut wrapper dengan ukuran tetap agar tidak melebar */
.donut-wrap { display:flex; justify-content:center; align-items:center; height:220px; }
.donut-wrap canvas { max-width:220px; max-height:220px; }

.legend { display:flex; gap:1rem; justify-content:center; margin-top:1rem; flex-wrap:wrap; }
.legend-item { display:flex; align-items:center; gap:.4rem; font-size:.82rem; color:#374151; }
.dot { width:10px; height:10px; border-radius:50%; display:inline-block; }

.table-wrapper { overflow-x:auto; }
table { width:100%; border-collapse:collapse; font-size:.875rem; }
thead th { text-align:left; padding:.7rem .75rem; font-size:.75rem; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:#6b7280; border-bottom:1.5px solid #f3f4f6; }
tbody tr { border-bottom:1px solid #f9fafb; }
tbody tr:hover { background:#f9fafb; }
tbody td { padding:.85rem .75rem; vertical-align:middle; }

.rank { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:50%; font-weight:700; font-size:.8rem; }
.rank-1 { background:#fef9c3; color:#854d0e; }
.rank-2 { background:#f3f4f6; color:#374151; }
.rank-3 { background:#fff7ed; color:#9a3412; }
.rank-4,.rank-5 { background:#f9fafb; color:#6b7280; }

.cat-badge { padding:.25rem .6rem; border-radius:20px; font-size:.75rem; font-weight:600; }
.cat-badge.cat-man   { background:#eff6ff; color:#1d4ed8; }
.cat-badge.cat-woman { background:#fdf2f8; color:#9d174d; }
.cat-badge.cat-kids  { background:#f0fdf4; color:#166534; }

.progress-bar { display:inline-block; width:80px; height:6px; background:#f3f4f6; border-radius:10px; vertical-align:middle; margin-right:.5rem; }
.progress-fill { height:100%; background:linear-gradient(90deg,#6366f1,#a78bfa); border-radius:10px; }
.pct-label { font-size:.8rem; color:#6b7280; }

@media(max-width:900px){ .stats-grid{grid-template-columns:repeat(2,1fr)} .two-col{grid-template-columns:1fr} }
@media(max-width:600px){ .stats-grid{grid-template-columns:1fr} .page-header{flex-direction:column} }
</style>

{{-- Load Chart.js SEKALI di sini --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Sales Line Chart ─────────────────────────────────────────
    const labels = Array.from({length: 30}, (_, i) => {
        const d = new Date();
        d.setDate(d.getDate() - 29 + i);
        return d.getDate() + '/' + (d.getMonth() + 1);
    });

const salesData = {!! json_encode($salesData ?? array_map(fn() => rand(200000, 1500000), range(0, 29))) !!};

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan',
                data: salesData,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,.08)',
                tension: 0.4,
                fill: true,
                pointRadius: 3,
                pointBackgroundColor: '#6366f1',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    ticks: {
                        callback: function(v) { return 'Rp ' + (v / 1000).toFixed(0) + 'k'; },
                        font: { size: 10 }
                    },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    ticks: { font: { size: 10 }, maxRotation: 0, maxTicksLimit: 8 },
                    grid: { display: false }
                }
            }
        }
    });

    // ── Category Donut Chart ─────────────────────────────────────
    // FIX: responsive:false + ukuran manual agar tidak error di v4
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: ['Man', 'Woman', 'Kids'],
            datasets: [{
                data: [
                    {{ $manPct ?? 45 }},
                    {{ $womanPct ?? 38 }},
                    {{ $kidsPct ?? 17 }}
                ],
                backgroundColor: ['#6366f1', '#f472b6', '#34d399'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: false,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });

});

function changePeriod(val) {
    window.location.href = '?period=' + val;
}
</script>
@endsection