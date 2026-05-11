@extends('layouts.app')

@section('content')

<section class="detail-page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span>›</span>
        <a href="{{ route($product['category']) }}">{{ ucfirst($product['category']) }}</a>
        <span>›</span>
        <span>{{ $product['name'] }}</span>
    </nav>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="detail-wrap">

        {{-- Gambar Produk --}}
        <div class="detail-gallery">
            <img src="{{ asset($product['img']) }}" alt="{{ $product['name'] }}" class="detail-main-img" id="mainImg">
        </div>

        {{-- Info Produk --}}
        <div class="detail-info">
            <p class="detail-category">{{ strtoupper($product['category']) }}</p>
            <h1 class="detail-name">{{ $product['name'] }}</h1>
            <p class="detail-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>

            <p class="detail-desc">{{ $product['desc'] }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="detail-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                <input type="hidden" name="category"   value="{{ $product['category'] }}">
                <input type="hidden" name="name"       value="{{ $product['name'] }}">
                <input type="hidden" name="price"      value="{{ $product['price'] }}">
                <input type="hidden" name="img"        value="{{ $product['img'] }}">
                <input type="hidden" name="redirect_to_cart" value="0">

                {{-- Pilih Warna --}}
                <div class="option-group">
                    <label class="option-label">Warna</label>
                    <div class="option-pills" id="colorPills">
                        @foreach($product['colors'] as $i => $color)
                            <button type="button"
                                class="pill {{ $i === 0 ? 'active' : '' }}"
                                data-value="{{ $color }}"
                                onclick="selectOption('color', this)">
                                {{ $color }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="color" id="selectedColor" value="{{ $product['colors'][0] }}">
                </div>

                {{-- Pilih Ukuran --}}
                <div class="option-group">
                    <label class="option-label">Ukuran</label>
                    <div class="option-pills" id="sizePills">
                        @foreach($product['sizes'] as $i => $size)
                            <button type="button"
                                class="pill {{ $i === 0 ? 'active' : '' }}"
                                data-value="{{ $size }}"
                                onclick="selectOption('size', this)">
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="size" id="selectedSize" value="{{ $product['sizes'][0] }}">
                </div>

                {{-- Jumlah --}}
                <div class="option-group">
                    <label class="option-label">Jumlah</label>
                    <div class="qty-wrap">
                        <button type="button" onclick="changeQty(-1)" class="qty-btn">−</button>
                        <input type="number" name="qty" id="qtyInput" value="1" min="1" max="99" class="qty-input" readonly>
                        <button type="button" onclick="changeQty(1)"  class="qty-btn">+</button>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="detail-actions">
                    <button type="submit" class="btn-add-cart">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 01-8 0"/>
                        </svg>
                        Masukkan Keranjang
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn-view-cart">Lihat Keranjang</a>
                </div>

            </form>
        </div>
    </div>

    {{-- Produk Terkait --}}
    @if($related->count())
    <div class="related-section">
        <h2 class="related-title">Produk Lainnya</h2>
        <div class="related-grid">
            @foreach($related as $rel)
            <a href="{{ route('product.detail', [$rel['category'], $rel['id']]) }}" class="related-card">
                <div class="related-img">
                    <img src="{{ asset($rel['img']) }}" alt="{{ $rel['name'] }}">
                </div>
                <p class="related-name">{{ $rel['name'] }}</p>
                <p class="related-price">Rp {{ number_format($rel['price'], 0, ',', '.') }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</section>

<style>
.detail-page { max-width: 1100px; margin: 0 auto; padding: 32px 32px 80px; }

.breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #888; margin-bottom: 28px; }
.breadcrumb a { color: #888; text-decoration: none; } .breadcrumb a:hover { color: #111; }
.breadcrumb span { color: #ccc; }

.alert-success { display: flex; align-items: center; gap: 10px; background: #edf7e6; border: 1px solid #b7dfa0; color: #3a6b1e; padding: 12px 16px; font-size: 13px; margin-bottom: 24px; }
.alert-success svg { width: 16px; height: 16px; stroke: #3a6b1e; flex-shrink: 0; }

.detail-wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start; }

.detail-main-img { width: 100%; aspect-ratio: 3/4; object-fit: cover; display: block; background: #f5f4f2; }

.detail-category { font-size: 11px; letter-spacing: 3px; color: #aaa; text-transform: uppercase; margin-bottom: 8px; }
.detail-name { font-size: 28px; font-weight: 600; letter-spacing: 1px; margin-bottom: 12px; line-height: 1.2; }
.detail-price { font-size: 20px; font-weight: 500; color: #111; margin-bottom: 20px; }
.detail-desc { font-size: 13px; color: #777; line-height: 1.8; margin-bottom: 28px; padding-bottom: 28px; border-bottom: 1px solid #eee; }

.option-group { margin-bottom: 20px; }
.option-label { display: block; font-size: 12px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase; color: #555; margin-bottom: 10px; }
.option-pills { display: flex; flex-wrap: wrap; gap: 8px; }
.pill { padding: 7px 16px; font-size: 12px; border: 1.5px solid #ddd; background: #fff; cursor: pointer; letter-spacing: 0.5px; transition: all 0.2s; font-family: inherit; }
.pill:hover { border-color: #111; }
.pill.active { border-color: #111; background: #111; color: #fff; }

.qty-wrap { display: flex; align-items: center; border: 1.5px solid #ddd; width: fit-content; }
.qty-btn { width: 36px; height: 36px; background: none; border: none; font-size: 18px; cursor: pointer; color: #111; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
.qty-btn:hover { background: #f5f4f2; }
.qty-input { width: 48px; height: 36px; border: none; border-left: 1.5px solid #ddd; border-right: 1.5px solid #ddd; text-align: center; font-size: 14px; font-family: inherit; outline: none; }

.detail-actions { display: flex; gap: 12px; margin-top: 28px; flex-wrap: wrap; }
.btn-add-cart { flex: 1; display: flex; align-items: center; justify-content: center; gap: 10px; background: #111; color: #fff; border: none; padding: 14px 24px; font-size: 13px; font-family: inherit; letter-spacing: 1px; cursor: pointer; transition: background 0.2s; }
.btn-add-cart svg { width: 16px; height: 16px; stroke: #fff; }
.btn-add-cart:hover { background: #333; }
.btn-view-cart { display: flex; align-items: center; justify-content: center; padding: 14px 20px; border: 1.5px solid #111; font-size: 13px; letter-spacing: 1px; color: #111; text-decoration: none; transition: all 0.2s; white-space: nowrap; }
.btn-view-cart:hover { background: #111; color: #fff; }

.related-section { margin-top: 72px; padding-top: 48px; border-top: 1px solid #eee; }
.related-title { font-size: 16px; letter-spacing: 3px; text-transform: uppercase; font-weight: 500; margin-bottom: 28px; }
.related-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.related-card { text-decoration: none; color: inherit; display: block; }
.related-img img { width: 100%; aspect-ratio: 3/4; object-fit: cover; background: #f5f4f2; transition: transform 0.4s; display: block; }
.related-card:hover .related-img img { transform: scale(1.03); }
.related-img { overflow: hidden; }
.related-name { font-size: 13px; margin-top: 10px; }
.related-price { font-size: 12px; color: #888; margin-top: 4px; }

@media (max-width: 768px) {
    .detail-wrap { grid-template-columns: 1fr; gap: 28px; }
    .related-grid { grid-template-columns: repeat(2, 1fr); }
    .detail-page { padding: 24px 20px 60px; }
}
</style>

<script>
function selectOption(type, el) {
    // Hapus active dari siblings
    el.closest('.option-pills').querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');

    // Update hidden input
    if (type === 'color') document.getElementById('selectedColor').value = el.dataset.value;
    if (type === 'size')  document.getElementById('selectedSize').value  = el.dataset.value;
}

function changeQty(delta) {
    const input = document.getElementById('qtyInput');
    const newVal = Math.max(1, Math.min(99, parseInt(input.value) + delta));
    input.value = newVal;
}
</script>

@endsection
