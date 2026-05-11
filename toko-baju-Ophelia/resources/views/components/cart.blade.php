@php
    $cartItems  = session()->get('cart', []);
    $cartTotal  = collect($cartItems)->sum(fn($item) => $item['price'] * $item['qty']);
    $cartCount  = collect($cartItems)->sum('qty');
@endphp

{{-- Overlay (background gelap saat sidebar terbuka) --}}
<div id="cartOverlay" class="cart-overlay" onclick="toggleCart()"></div>

{{-- Sidebar Keranjang --}}
<div id="cartSidebar" class="cart-sidebar">

    {{-- Header --}}
    <div class="cs-header">
        <h3 class="cs-title">
            Keranjang
            @if($cartCount > 0)
                <span class="cs-count">{{ $cartCount }}</span>
            @endif
        </h3>
        <button class="cs-close" onclick="toggleCart()">✕</button>
    </div>

    {{-- Isi keranjang --}}
    <div class="cs-body">

        @if(empty($cartItems))
            <div class="cs-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
                <p>Keranjang masih kosong</p>
                <button onclick="toggleCart()" class="cs-btn-shop">Mulai Belanja</button>
            </div>

        @else
            <div class="cs-items">
                @foreach($cartItems as $key => $item)
                <div class="cs-item">
                    <img src="{{ asset($item['img']) }}" alt="{{ $item['name'] }}" class="cs-item-img">
                    <div class="cs-item-info">
                        <p class="cs-item-name">{{ $item['name'] }}</p>
                        <p class="cs-item-variant">{{ $item['color'] }} · {{ $item['size'] }}</p>
                        <div class="cs-item-bottom">
                            <span class="cs-item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                            <span class="cs-item-qty">x{{ $item['qty'] }}</span>
                        </div>
                    </div>
                    {{-- Hapus item --}}
                    <form action="{{ route('cart.remove', $key) }}" method="POST" class="cs-remove-form">
                        @csrf
                        <button type="submit" class="cs-remove-btn" title="Hapus">✕</button>
                    </form>
                </div>
                @endforeach
            </div>
        @endif

    </div>

    {{-- Footer total + tombol --}}
    @if(!empty($cartItems))
    <div class="cs-footer">
        <div class="cs-subtotal">
            <span>Subtotal</span>
            <span class="cs-subtotal-price">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
        </div>
        <div class="cs-footer-btns">
            <a href="{{ route('cart.index') }}" class="cs-btn-viewcart" onclick="toggleCart()">Lihat Keranjang</a>
            <a href="{{ route('cart.index') }}" class="cs-btn-checkout" onclick="toggleCart()">Checkout</a>
        </div>
    </div>
    @endif

</div>

<style>
/* Overlay */
.cart-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.35);
    z-index: 998;
    backdrop-filter: blur(2px);
}
.cart-overlay.active { display: block; }

/* Sidebar */
.cart-sidebar {
    position: fixed;
    top: 0;
    right: -420px;
    width: 380px;
    max-width: 95vw;
    height: 100vh;
    background: #fff;
    z-index: 999;
    display: flex;
    flex-direction: column;
    transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: -4px 0 24px rgba(0,0,0,0.10);
}
.cart-sidebar.active { right: 0; }

/* Header */
.cs-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 20px 16px;
    border-bottom: 1px solid #f0f0f0;
    flex-shrink: 0;
}
.cs-title {
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}
.cs-count {
    background: #ee4d2d;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.cs-close {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    color: #aaa;
    padding: 4px 8px;
    transition: color 0.2s;
    line-height: 1;
}
.cs-close:hover { color: #111; }

/* Body */
.cs-body {
    flex: 1;
    overflow-y: auto;
    padding: 16px 20px;
}
.cs-body::-webkit-scrollbar { width: 4px; }
.cs-body::-webkit-scrollbar-thumb { background: #eee; border-radius: 2px; }

/* Empty */
.cs-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: 14px;
    padding: 60px 0;
}
.cs-empty svg { width: 64px; height: 64px; }
.cs-empty p { font-size: 14px; color: #bbb; }
.cs-btn-shop {
    padding: 10px 28px;
    background: #111;
    color: #fff;
    border: none;
    font-size: 13px;
    font-family: inherit;
    cursor: pointer;
    border-radius: 4px;
    transition: background 0.2s;
}
.cs-btn-shop:hover { background: #333; }

/* Items */
.cs-items { display: flex; flex-direction: column; gap: 14px; }
.cs-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f5f5f5;
    position: relative;
}
.cs-item:last-child { border-bottom: none; }
.cs-item-img {
    width: 72px;
    height: 90px;
    object-fit: cover;
    border-radius: 6px;
    background: #f5f4f2;
    flex-shrink: 0;
}
.cs-item-info { flex: 1; min-width: 0; }
.cs-item-name {
    font-size: 13px;
    font-weight: 500;
    color: #111;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 4px;
}
.cs-item-variant {
    font-size: 11px;
    color: #aaa;
    margin-bottom: 8px;
}
.cs-item-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.cs-item-price {
    font-size: 13px;
    font-weight: 600;
    color: #ee4d2d;
}
.cs-item-qty {
    font-size: 12px;
    color: #999;
    background: #f5f5f5;
    padding: 2px 8px;
    border-radius: 20px;
}
.cs-remove-form { position: absolute; top: 0; right: 0; }
.cs-remove-btn {
    background: none;
    border: none;
    font-size: 13px;
    color: #ccc;
    cursor: pointer;
    padding: 2px 4px;
    transition: color 0.2s;
    line-height: 1;
}
.cs-remove-btn:hover { color: #ee4d2d; }

/* Footer */
.cs-footer {
    border-top: 1px solid #f0f0f0;
    padding: 16px 20px 20px;
    flex-shrink: 0;
    background: #fff;
}
.cs-subtotal {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    font-size: 14px;
}
.cs-subtotal-price {
    font-size: 16px;
    font-weight: 700;
    color: #111;
}
.cs-footer-btns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.cs-btn-viewcart {
    display: block;
    text-align: center;
    padding: 12px;
    border: 1.5px solid #111;
    color: #111;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    border-radius: 6px;
    transition: all 0.2s;
}
.cs-btn-viewcart:hover { background: #111; color: #fff; }
.cs-btn-checkout {
    display: block;
    text-align: center;
    padding: 12px;
    background: #ee4d2d;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    border-radius: 6px;
    transition: background 0.2s;
}
.cs-btn-checkout:hover { background: #d43f21; }
</style>

<script>
function toggleCart() {
    document.getElementById('cartSidebar').classList.toggle('active');
    document.getElementById('cartOverlay').classList.toggle('active');
    document.body.style.overflow =
        document.getElementById('cartSidebar').classList.contains('active') ? 'hidden' : '';
}
</script>
