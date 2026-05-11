{{-- resources/views/checkout-success.blade.php --}}

@extends('layouts.app')

@section('content')

<section class="suc-page">

    <div class="suc-wrap">

        {{-- Icon & Header --}}
        <div class="suc-header">
            <div class="suc-icon">&#10003;</div>
            <h1 class="suc-title">Pesanan Dikonfirmasi!</h1>
            <p class="suc-sub">Terima kasih telah berbelanja di <strong>OPHELIA</strong></p>
            <span class="suc-status">Menunggu Pembayaran</span>
        </div>

        {{-- Step bar --}}
        <div class="suc-steps">
            <div class="suc-step suc-done">
                <div class="suc-step-circle">&#10003;</div>
                <span>Keranjang</span>
            </div>
            <div class="suc-step-line suc-line-done"></div>
            <div class="suc-step suc-done">
                <div class="suc-step-circle">&#10003;</div>
                <span>Pembayaran</span>
            </div>
            <div class="suc-step-line suc-line-done"></div>
            <div class="suc-step suc-active">
                <div class="suc-step-circle">3</div>
                <span>Konfirmasi</span>
            </div>
        </div>

        {{-- Order Card --}}
        <div class="suc-card">

            {{-- Order number & metode --}}
            <div class="suc-card-section">
                <div class="suc-card-title">DETAIL PESANAN</div>
                <div class="suc-row">
                    <span class="suc-label">No. Pesanan</span>
                    <span class="suc-value suc-order-num">{{ $order['order_number'] }}</span>
                </div>
                <div class="suc-row">
                    <span class="suc-label">Metode Pembayaran</span>
                    <span class="suc-value">
                        @php
                            echo match($order['payment_method']) {
                                'shopeepay' => 'ShopeePay',
                                'dana'      => 'DANA',
                                'ovo'       => 'OVO',
                                'gopay'     => 'GoPay',
                                'bca'       => 'BCA Virtual Account',
                                'bri'       => 'BRI Virtual Account',
                                'mandiri'   => 'Mandiri Virtual Account',
                                'cod'       => 'Bayar di Tempat (COD)',
                                default     => ucfirst($order['payment_method']),
                            };
                        @endphp
                    </span>
                </div>
                <div class="suc-row">
                    <span class="suc-label">Estimasi Tiba</span>
                    <span class="suc-value">3 - 5 hari kerja</span>
                </div>
            </div>

            <div class="suc-divider"></div>

            {{-- Produk --}}
            <div class="suc-card-section">
                <div class="suc-card-title">PRODUK DIPESAN</div>
                @foreach($order['cart'] as $item)
                <div class="suc-product-row">
                    <img src="{{ asset($item['img']) }}"
                        alt="{{ $item['name'] }}"
                        onerror="this.style.display='none'">
                    <div class="suc-product-info">
                        <p class="suc-product-name">{{ $item['name'] }}</p>
                        <p class="suc-product-var">{{ $item['color'] }} / {{ $item['size'] }}</p>
                    </div>
                    <div class="suc-product-right">
                        <p class="suc-product-qty">x{{ $item['qty'] }}</p>
                        <p class="suc-product-price">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="suc-divider"></div>

            {{-- Harga --}}
            <div class="suc-card-section">
                <div class="suc-sum-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</span>
                </div>
                <div class="suc-sum-row">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($order['ongkir'], 0, ',', '.') }}</span>
                </div>
                <div class="suc-divider" style="margin:12px 0;"></div>
                <div class="suc-sum-row suc-sum-total">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($order['grand_total'], 0, ',', '.') }}</span>
                </div>
            </div>

        </div>

        {{-- Notice VA --}}
        @if(in_array($order['payment_method'], ['bca','bri','mandiri']))
        <div class="suc-notice">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Nomor Virtual Account akan dikirimkan ke email kamu dalam beberapa menit.
        </div>
        @endif

        {{-- Tombol --}}
        <div class="suc-actions">
            <a href="{{ route('home') }}" class="suc-btn-primary">Lanjut Belanja</a>
        </div>

    </div>

</section>

<style>
.suc-page {
    background: #f8f7f5;
    min-height: 70vh;
    padding: 48px 20px 80px;
}

.suc-wrap {
    max-width: 560px;
    margin: 0 auto;
}

/* Header */
.suc-header {
    text-align: center;
    margin-bottom: 32px;
}
.suc-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #edf7e6;
    border: 2px solid #b7dfa0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 28px;
    color: #3a6b1e;
    font-weight: 700;
}
.suc-title {
    font-size: 24px;
    font-weight: 700;
    color: #111;
    margin: 0 0 6px;
}
.suc-sub {
    font-size: 14px;
    color: #777;
    margin: 0 0 14px;
}
.suc-status {
    display: inline-block;
    background: #fff3e0;
    color: #e65100;
    font-size: 12px;
    font-weight: 500;
    padding: 5px 16px;
    border-radius: 100px;
    border: 1px solid #ffe0b2;
}

/* Steps */
.suc-steps {
    display: flex;
    align-items: center;
    margin-bottom: 28px;
}
.suc-step {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    color: #999;
}
.suc-step-circle {
    width: 26px;
    height: 26px;
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
.suc-done .suc-step-circle { background: #111; color: #fff; }
.suc-active .suc-step-circle { background: #111; color: #fff; }
.suc-done span, .suc-active span { color: #111; font-weight: 500; }
.suc-step-line {
    flex: 1;
    height: 1.5px;
    background: #e5e5e5;
    margin: 0 10px;
}
.suc-line-done { background: #111; }

/* Card */
.suc-card {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 4px;
    margin-bottom: 16px;
    overflow: hidden;
}
.suc-card-section {
    padding: 20px 24px;
}
.suc-card-title {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: #aaa;
    margin-bottom: 14px;
}
.suc-divider {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 0;
}

/* Detail rows */
.suc-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 7px 0;
    font-size: 13px;
}
.suc-label { color: #888; }
.suc-value { color: #111; font-weight: 500; text-align: right; max-width: 60%; }
.suc-order-num {
    font-family: monospace;
    font-size: 13px;
    background: #f5f4f2;
    padding: 2px 8px;
    border-radius: 3px;
}

/* Produk */
.suc-product-row {
    display: flex;
    gap: 14px;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f5f5f5;
}
.suc-product-row:last-child { border-bottom: none; }
.suc-product-row img {
    width: 56px;
    height: 64px;
    object-fit: cover;
    background: #f5f4f2;
    flex-shrink: 0;
    border-radius: 3px;
}
.suc-product-info { flex: 1; }
.suc-product-name { font-size: 13px; font-weight: 500; color: #111; margin: 0 0 3px; }
.suc-product-var  { font-size: 12px; color: #999; margin: 0; }
.suc-product-right { text-align: right; flex-shrink: 0; }
.suc-product-qty   { font-size: 12px; color: #999; margin: 0 0 3px; }
.suc-product-price { font-size: 13px; font-weight: 500; color: #111; margin: 0; }

/* Summary */
.suc-sum-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #666;
    margin-bottom: 8px;
}
.suc-sum-row span:last-child { color: #111; font-weight: 500; }
.suc-sum-total {
    font-size: 16px;
    font-weight: 700;
    color: #111;
}
.suc-sum-total span:last-child { color: #111; }

/* Notice */
.suc-notice {
    display: flex;
    gap: 10px;
    background: #e3f2fd;
    border: 1px solid #90caf9;
    padding: 12px 16px;
    font-size: 13px;
    color: #1565c0;
    margin-bottom: 16px;
    border-radius: 4px;
    align-items: flex-start;
}

/* Actions */
.suc-actions {
    display: flex;
    gap: 12px;
    margin-top: 8px;
}
.suc-btn-primary {
    flex: 1;
    display: block;
    padding: 14px;
    background: #111;
    color: #fff;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.5px;
    border-radius: 4px;
    transition: background 0.2s;
}
.suc-btn-primary:hover { background: #333; color: #fff; text-decoration: none; }

@media (max-width: 600px) {
    .suc-page { padding: 32px 16px 60px; }
    .suc-card-section { padding: 16px; }
}
</style>

@endsection
