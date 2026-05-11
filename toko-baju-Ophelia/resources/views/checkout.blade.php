{{-- resources/views/checkout.blade.php --}}

@extends('layouts.app')

@section('content')

<section class="co-page">

    <div class="co-header">
        <h1 class="co-title">Pilih Metode Pembayaran</h1>
        <nav class="co-breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span>›</span>
            <a href="{{ route('cart.index') }}">Keranjang</a>
            <span>›</span>
            <span>Pembayaran</span>
        </nav>
    </div>

    {{-- Step Bar --}}
    <div class="co-steps">
        <div class="co-step co-done">
            <div class="co-step-circle">&#10003;</div>
            <span class="co-step-label">Keranjang</span>
        </div>
        <div class="co-step-line co-line-done"></div>
        <div class="co-step co-active">
            <div class="co-step-circle">2</div>
            <span class="co-step-label">Pembayaran</span>
        </div>
        <div class="co-step-line"></div>
        <div class="co-step co-inactive">
            <div class="co-step-circle">3</div>
            <span class="co-step-label">Konfirmasi</span>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="coForm">
        @csrf
        <input type="hidden" name="payment_method" id="payInput" value="">
        <input type="hidden" name="phone_number" id="phoneInput" value="">

        <div class="co-grid">

            {{-- KIRI: Metode Pembayaran --}}
            <div class="co-left">

                <div class="co-card">
                    <div class="co-card-title">DOMPET DIGITAL</div>

                    <div class="co-method" id="opt-shopeepay" onclick="pilih('shopeepay','ShopeePay')">
                        <div class="co-radio"><div class="co-dot"></div></div>
                        <div class="co-logo" style="background:#EE4D2D;color:#fff;">SPay</div>
                        <div class="co-info">
                            <p class="co-name">ShopeePay</p>
                            <p class="co-desc">Bayar langsung dari saldo ShopeePay</p>
                        </div>
                        <span class="co-badge">Cashback 5%</span>
                    </div>
                    <div class="co-expand" id="form-shopeepay">
                        <label>Nomor HP terdaftar ShopeePay</label>
                        <input type="text" placeholder="08xxxxxxxxxx" onchange="setPhone(this.value)">
                    </div>

                    <div class="co-method" id="opt-dana" onclick="pilih('dana','DANA')">
                        <div class="co-radio"><div class="co-dot"></div></div>
                        <div class="co-logo" style="background:#118EEA;color:#fff;">DANA</div>
                        <div class="co-info">
                            <p class="co-name">DANA</p>
                            <p class="co-desc">Bayar menggunakan saldo DANA</p>
                        </div>
                    </div>
                    <div class="co-expand" id="form-dana">
                        <label>Nomor HP terdaftar DANA</label>
                        <input type="text" placeholder="08xxxxxxxxxx" onchange="setPhone(this.value)">
                    </div>

                    <div class="co-method" id="opt-ovo" onclick="pilih('ovo','OVO')">
                        <div class="co-radio"><div class="co-dot"></div></div>
                        <div class="co-logo" style="background:#4C3494;color:#fff;">OVO</div>
                        <div class="co-info">
                            <p class="co-name">OVO</p>
                            <p class="co-desc">Bayar menggunakan saldo OVO</p>
                        </div>
                    </div>
                    <div class="co-expand" id="form-ovo">
                        <label>Nomor HP terdaftar OVO</label>
                        <input type="text" placeholder="08xxxxxxxxxx" onchange="setPhone(this.value)">
                    </div>

                    <div class="co-method" id="opt-gopay" onclick="pilih('gopay','GoPay')">
                        <div class="co-radio"><div class="co-dot"></div></div>
                        <div class="co-logo" style="background:#00880A;color:#fff;">GPay</div>
                        <div class="co-info">
                            <p class="co-name">GoPay</p>
                            <p class="co-desc">Bayar menggunakan saldo GoPay</p>
                        </div>
                        <span class="co-badge">Gratis ongkir</span>
                    </div>
                    <div class="co-expand" id="form-gopay">
                        <label>Nomor HP terdaftar GoPay</label>
                        <input type="text" placeholder="08xxxxxxxxxx" onchange="setPhone(this.value)">
                    </div>
                </div>

                <div class="co-card">
                    <div class="co-card-title">TRANSFER BANK</div>

                    <div class="co-method" id="opt-bca" onclick="pilih('bca','BCA Virtual Account')">
                        <div class="co-radio"><div class="co-dot"></div></div>
                        <div class="co-logo" style="background:#005baa;color:#fff;">BCA</div>
                        <div class="co-info">
                            <p class="co-name">BCA Virtual Account</p>
                            <p class="co-desc">Bayar via ATM, mobile, atau internet banking BCA</p>
                        </div>
                    </div>
                    <div class="co-expand" id="form-bca">
                        <p class="co-note">Nomor VA akan dikirimkan setelah pesanan dikonfirmasi.</p>
                    </div>

                    <div class="co-method" id="opt-bri" onclick="pilih('bri','BRI Virtual Account')">
                        <div class="co-radio"><div class="co-dot"></div></div>
                        <div class="co-logo" style="background:#003da5;color:#fff;">BRI</div>
                        <div class="co-info">
                            <p class="co-name">BRI Virtual Account</p>
                            <p class="co-desc">Bayar via ATM, mobile, atau internet banking BRI</p>
                        </div>
                    </div>
                    <div class="co-expand" id="form-bri">
                        <p class="co-note">Nomor VA akan dikirimkan setelah pesanan dikonfirmasi.</p>
                    </div>

                    <div class="co-method" id="opt-mandiri" onclick="pilih('mandiri','Mandiri Virtual Account')">
                        <div class="co-radio"><div class="co-dot"></div></div>
                        <div class="co-logo" style="background:#003087;color:#fff;font-size:8px;">MANDIRI</div>
                        <div class="co-info">
                            <p class="co-name">Mandiri Virtual Account</p>
                            <p class="co-desc">Bayar via ATM, mobile, atau Livin' by Mandiri</p>
                        </div>
                    </div>
                    <div class="co-expand" id="form-mandiri">
                        <p class="co-note">Nomor VA akan dikirimkan setelah pesanan dikonfirmasi.</p>
                    </div>
                </div>

                <div class="co-card">
                    <div class="co-card-title">LAINNYA</div>

                    <div class="co-method" id="opt-cod" onclick="pilih('cod','Bayar di Tempat (COD)')">
                        <div class="co-radio"><div class="co-dot"></div></div>
                        <div class="co-logo" style="background:#f5f4f2;color:#555;border:1px solid #ddd;font-size:11px;">COD</div>
                        <div class="co-info">
                            <p class="co-name">Bayar di Tempat (COD)</p>
                            <p class="co-desc">Bayar tunai saat paket diterima</p>
                        </div>
                    </div>
                    <div class="co-expand" id="form-cod">
                        <p class="co-note">Tersedia untuk area Medan dan sekitarnya. Pastikan ada di rumah saat kurir tiba.</p>
                    </div>
                </div>

                <a href="{{ route('cart.index') }}" class="co-back-btn">&#8249; Kembali ke Keranjang</a>

            </div>

            {{-- KANAN: Ringkasan --}}
            <div class="co-right">

                <div class="co-card">
                    <div class="co-card-title">RINGKASAN PESANAN</div>

                    @foreach($cart as $item)
                    <div class="co-item">
                        <img src="{{ asset($item['img']) }}"
                            alt="{{ $item['name'] }}"
                            onerror="this.style.display='none'">
                        <div class="co-item-info">
                            <p class="co-item-name">{{ $item['name'] }}</p>
                            <p class="co-item-var">{{ $item['color'] }} / {{ $item['size'] }} / x{{ $item['qty'] }}</p>
                            <p class="co-item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach

                    <div class="co-divider"></div>

                    <div class="co-sum-row">
                        <span>Subtotal ({{ collect($cart)->sum('qty') }} item)</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="co-sum-row">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="co-divider"></div>
                    <div class="co-sum-row co-sum-total">
                        <span>Total</span>
                        <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    <p class="co-tax">Termasuk Pajak</p>
                </div>

                <div class="co-card co-pay-card">
                    <p class="co-method-label">Metode dipilih:</p>
                    <p id="selectedName" class="co-method-selected">Belum dipilih</p>

                    <button type="submit" class="co-pay-btn" id="btnBayar" disabled>
                        Bayar Sekarang &mdash; Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </button>
                    <p class="co-secure">&#128274; Pembayaran diamankan &amp; terenkripsi</p>
                </div>

            </div>
        </div>
    </form>

</section>

<style>
/* ===== CHECKOUT PAGE ===== */
.co-page {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 32px 80px;
}

.co-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 4px;
}

.co-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #888;
    margin-bottom: 28px;
}
.co-breadcrumb a { color: #888; text-decoration: none; }
.co-breadcrumb a:hover { color: #111; }

/* Step bar */
.co-steps {
    display: flex;
    align-items: center;
    margin-bottom: 32px;
}
.co-step {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
}
.co-step-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    background: #e5e5e5;
    color: #999;
    flex-shrink: 0;
}
.co-done .co-step-circle,
.co-active .co-step-circle { background: #111; color: #fff; }
.co-step-label { font-size: 13px; color: #999; }
.co-active .co-step-label { color: #111; font-weight: 600; }
.co-step-line {
    flex: 1;
    height: 1.5px;
    background: #e5e5e5;
    margin: 0 12px;
}
.co-line-done { background: #111; }

/* Grid layout */
.co-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    align-items: start;
}

/* Card */
.co-card {
    background: #fff;
    border: 1px solid #e8e8e8;
    padding: 20px 24px;
    margin-bottom: 16px;
}
.co-card-title {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: #aaa;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f0f0;
}

/* Metode */
.co-method {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 12px;
    border: 1.5px solid #ebebeb;
    cursor: pointer;
    margin-bottom: 8px;
    transition: all 0.15s;
    border-radius: 4px;
}
.co-method:hover { border-color: #bbb; background: #fafafa; }
.co-method.active { border-color: #111; background: #f5f4f2; }

.co-radio {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.15s;
}
.co-method.active .co-radio { border-color: #111; background: #111; }
.co-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
    display: none;
}
.co-method.active .co-dot { display: block; }

.co-logo {
    width: 56px;
    height: 30px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    flex-shrink: 0;
}

.co-info { flex: 1; }
.co-name { font-size: 14px; font-weight: 500; color: #111; margin: 0; }
.co-desc { font-size: 12px; color: #999; margin: 2px 0 0; }

.co-badge {
    font-size: 11px;
    background: #fff3e0;
    color: #e65100;
    padding: 3px 10px;
    border-radius: 100px;
    white-space: nowrap;
    font-weight: 500;
}

.co-expand {
    display: none;
    margin: -4px 0 10px;
    padding: 12px 14px;
    background: #f8f7f5;
    border: 1px solid #ebebeb;
    border-top: none;
    border-radius: 0 0 4px 4px;
}
.co-expand label {
    font-size: 11px;
    color: #888;
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
}
.co-expand input {
    width: 100%;
    border: 1.5px solid #ddd;
    padding: 9px 12px;
    font-size: 13px;
    font-family: inherit;
    outline: none;
    border-radius: 4px;
    background: #fff;
}
.co-expand input:focus { border-color: #111; }
.co-note { font-size: 12px; color: #888; margin: 0; }

/* Back button */
.co-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    border: 1.5px solid #ddd;
    font-size: 13px;
    text-decoration: none;
    color: #555;
    transition: all 0.2s;
    border-radius: 4px;
}
.co-back-btn:hover { border-color: #111; color: #111; text-decoration: none; }

/* Item ringkasan */
.co-item {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}
.co-item img {
    width: 60px;
    height: 70px;
    object-fit: cover;
    background: #f5f4f2;
    flex-shrink: 0;
    border-radius: 3px;
}
.co-item-name { font-size: 13px; font-weight: 500; color: #111; margin: 0 0 3px; }
.co-item-var  { font-size: 11px; color: #999; margin: 0 0 4px; }
.co-item-price { font-size: 13px; font-weight: 500; color: #111; margin: 0; }

/* Summary rows */
.co-divider { border: none; border-top: 1px solid #ebebeb; margin: 14px 0; }
.co-sum-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #666;
    margin-bottom: 8px;
}
.co-sum-total {
    font-size: 15px;
    font-weight: 700;
    color: #111;
    margin-bottom: 4px;
}
.co-tax { font-size: 11px; color: #aaa; margin: 0; }

/* Pay card */
.co-pay-card { margin-bottom: 0; }
.co-method-label { font-size: 12px; color: #999; margin: 0 0 4px; }
.co-method-selected {
    font-size: 14px;
    font-weight: 600;
    color: #111;
    margin: 0 0 16px;
    min-height: 20px;
}

.co-pay-btn {
    width: 100%;
    padding: 15px;
    background: #111;
    color: #fff;
    border: none;
    font-size: 14px;
    font-family: inherit;
    font-weight: 600;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: background 0.2s;
    border-radius: 4px;
}
.co-pay-btn:hover:not(:disabled) { background: #333; }
.co-pay-btn:disabled { background: #ccc; cursor: not-allowed; }

.co-secure {
    font-size: 11px;
    color: #bbb;
    text-align: center;
    margin: 10px 0 0;
}

@media (max-width: 900px) {
    .co-grid { grid-template-columns: 1fr; }
    .co-page { padding: 24px 20px 60px; }
    .co-right { order: -1; }
}
</style>

<script>
var current = null;

function setPhone(val) {
    document.getElementById('phoneInput').value = val;
}

function pilih(id, nama) {
    if (current) {
        document.getElementById('opt-' + current).classList.remove('active');
        document.getElementById('form-' + current).style.display = 'none';
    }
    document.getElementById('opt-' + id).classList.add('active');
    document.getElementById('form-' + id).style.display = 'block';
    current = id;
    document.getElementById('payInput').value = id;
    document.getElementById('selectedName').textContent = nama;
    document.getElementById('btnBayar').disabled = false;
}
</script>

@endsection
