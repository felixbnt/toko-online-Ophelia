@extends('layouts.app')

@section('content')

<section class="search-page">

    {{-- HEADER --}}
    <div class="search-header">
        <h1>SEARCH RESULTS</h1>
        @if(count($results) > 0)
            <p>Menampilkan <strong>{{ count($results) }}</strong> hasil untuk <em>"{{ $query }}"</em></p>
        @else
            <p>Tidak ada hasil untuk <em>"{{ $query }}"</em></p>
        @endif
    </div>

    {{-- RESULTS --}}
    @if(count($results) > 0)
        <div class="product-grid">
            @foreach($results as $product)
                <a href="{{ route('product.detail', ['category' => $product['category'], 'id' => $product['id']]) }}" class="product-card">
                    <div class="product-img">
                        <img src="{{ asset($product['img']) }}" alt="{{ $product['name'] }}">
                        <span class="product-badge">{{ ucfirst($product['category']) }}</span>
                    </div>
                    <div class="product-info">
                        <p class="product-name">{{ $product['name'] }}</p>
                        <p class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>

    {{-- EMPTY STATE --}}
    @else
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h2>Produk tidak ditemukan</h2>
            <p>Coba kata kunci lain atau jelajahi koleksi kami</p>
            <div class="empty-links">
                <a href="{{ route('woman') }}">Woman</a>
                <a href="{{ route('man') }}">Man</a>
                <a href="{{ route('kids') }}">Kids</a>
            </div>
            <a href="{{ route('home') }}" class="btn-back">← Kembali ke Beranda</a>
        </div>
    @endif

</section>

@endsection