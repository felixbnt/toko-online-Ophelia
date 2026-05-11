@extends('layouts.app')

@section('content')

<section class="cart-page">

    <h1 class="cart-title">Keranjang Belanja</h1>
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span>›</span>
        <span>Keranjang</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(empty($cart))

        <div class="cart-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            <p>Keranjang kamu masih kosong</p>
            <a href="{{ route('home') }}" class="btn-shop">Mulai Belanja</a>
        </div>

    @else

        <div class="cart-layout">

            {{-- Tabel produk --}}
            <div class="cart-items">

                <div class="cart-table-head">
                    <span class="col-product">Produk</span>
                    <span class="col-price">Harga</span>
                    <span class="col-qty">Jumlah</span>
                    <span class="col-subtotal">Subtotal</span>
                </div>

                @foreach($cart as $key => $item)
                <div class="cart-item">

                    <div class="cart-item-product">
                        <img src="{{ asset($item['img']) }}" alt="{{ $item['name'] }}">
                        <div class="cart-item-detail">
                            <p class="ci-name">{{ $item['name'] }}</p>
                            <p class="ci-variant">{{ $item['color'] }} · {{ $item['size'] }}</p>
                            <form action="{{ route('cart.remove', $key) }}" method="POST" style="margin-top:8px">
                                @csrf
                                <button type="submit" class="ci-remove">Hapus</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-price">
                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                    </div>

                    <div class="col-qty">
                        <form action="{{ route('cart.update', $key) }}" method="POST" class="qty-form">
                            @csrf
                            <input type="hidden" name="color" value="{{ $item['color'] }}">
                            <input type="hidden" name="size"  value="{{ $item['size'] }}">
                            <div class="qty-wrap">
                                <button type="button" class="qty-btn" onclick="changeQty(this, -1)">−</button>
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" max="99" class="qty-input" onchange="this.closest('form').submit()">
                                <button type="button" class="qty-btn" onclick="changeQty(this, 1)">+</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-subtotal">
                        Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                    </div>

                </div>
                @endforeach

                <div class="cart-footer">
                    <a href="{{ route('home') }}" class="btn-continue">‹ Lanjut Belanja</a>
                </div>
            </div>

            {{-- Ringkasan belanja --}}
            <div class="cart-summary">
                <h2 class="summary-title">Ringkasan Belanja</h2>

                @php
                    $ongkir    = 20000;
                    $grandTotal = $total + $ongkir;
                @endphp

                <div class="summary-row">
                    <span>Subtotal ({{ collect($cart)->sum('qty') }} item)</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
                <p class="summary-tax">Termasuk Pajak</p>

                <a href="{{ route('checkout.index') }}" class="btn-checkout" style="display:block; text-align:center; text-decoration:none;">
                        Checkout (Rp {{ number_format($grandTotal, 0, ',', '.') }})
                </a>
            </div>

        </div>

    @endif

</section>

<style>
.cart-page { max-width: 1100px; margin: 0 auto; padding: 40px 32px 80px; }

.cart-title { font-size: 26px; font-weight: 700; margin-bottom: 4px; }

.breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #888; margin-bottom: 28px; }
.breadcrumb a { color: #888; text-decoration: none; }
.breadcrumb a:hover { color: #111; }
.breadcrumb span { color: #ccc; }

.alert-success { display: flex; align-items: center; gap: 10px; background: #edf7e6; border: 1px solid #b7dfa0; color: #3a6b1e; padding: 12px 16px; font-size: 13px; margin-bottom: 24px; }
.alert-success svg { width: 16px; height: 16px; stroke: #3a6b1e; flex-shrink: 0; }

.cart-empty { text-align: center; padding: 80px 20px; }
.cart-empty svg { width: 64px; height: 64px; margin-bottom: 20px; }
.cart-empty p { font-size: 15px; color: #999; margin-bottom: 24px; }
.btn-shop { display: inline-block; padding: 12px 32px; background: #111; color: #fff; text-decoration: none; font-size: 13px; letter-spacing: 1px; }
.btn-shop:hover { background: #333; }

.cart-layout { display: grid; grid-template-columns: 1fr 340px; gap: 40px; align-items: start; }

.cart-table-head { display: grid; grid-template-columns: 1fr 120px 140px 120px; gap: 16px; padding-bottom: 12px; border-bottom: 1.5px solid #111; font-size: 12px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase; color: #555; }

.cart-item { display: grid; grid-template-columns: 1fr 120px 140px 120px; gap: 16px; align-items: center; padding: 24px 0; border-bottom: 1px solid #eee; }

.cart-item-product { display: flex; gap: 16px; }
.cart-item-product img { width: 100px; height: 130px; object-fit: cover; background: #f5f4f2; flex-shrink: 0; }
.ci-name { font-size: 14px; font-weight: 500; margin-bottom: 4px; }
.ci-variant { font-size: 12px; color: #999; }
.ci-remove { background: none; border: none; font-size: 12px; color: #999; cursor: pointer; padding: 0; font-family: inherit; text-decoration: underline; transition: color 0.2s; }
.ci-remove:hover { color: #e00; }

.col-price, .col-qty, .col-subtotal { font-size: 13px; }
.col-subtotal { font-weight: 500; }

.qty-wrap { display: flex; align-items: center; border: 1.5px solid #ddd; width: fit-content; }
.qty-btn { width: 32px; height: 32px; background: none; border: none; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
.qty-btn:hover { background: #f5f4f2; }
.qty-input { width: 40px; height: 32px; border: none; border-left: 1.5px solid #ddd; border-right: 1.5px solid #ddd; text-align: center; font-size: 13px; font-family: inherit; outline: none; }

.cart-footer { padding-top: 20px; }
.btn-continue { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border: 1.5px solid #ddd; font-size: 13px; text-decoration: none; color: #555; transition: all 0.2s; }
.btn-continue:hover { border-color: #111; color: #111; }

.cart-summary { background: #f5f4f2; padding: 28px 24px; }
.summary-title { font-size: 16px; font-weight: 600; margin-bottom: 20px; }
.summary-row { display: flex; justify-content: space-between; font-size: 13px; color: #555; margin-bottom: 12px; }
.summary-divider { border: none; border-top: 1px solid #ddd; margin: 16px 0; }
.summary-total { font-size: 15px; font-weight: 600; color: #111; }
.summary-tax { font-size: 11px; color: #aaa; margin-top: -6px; margin-bottom: 24px; }
.btn-checkout { width: 100%; padding: 16px; background: #111; color: #fff; border: none; font-size: 14px; font-family: inherit; font-weight: 600; letter-spacing: 1px; cursor: pointer; transition: background 0.2s; }
.btn-checkout:hover { background: #333; }

@media (max-width: 900px) {
    .cart-layout { grid-template-columns: 1fr; }
    .cart-table-head { display: none; }
    .cart-item { grid-template-columns: 1fr; }
    .cart-page { padding: 24px 20px 60px; }
}
</style>

<script>
function changeQty(btn, delta) {
    const form  = btn.closest('.qty-form');
    const input = form.querySelector('.qty-input');
    const newVal = Math.max(1, Math.min(99, parseInt(input.value) + delta));
    input.value = newVal;
    form.submit();
}
</script>

@endsection
