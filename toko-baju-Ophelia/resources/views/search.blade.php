@extends('layouts.app')

@section('content')

<section class="category-page">
    <div class="category-header">
        <h1>SEARCH RESULTS</h1>
        <p>
            @if(count($results) > 0)
                {{ count($results) }} results for "{{ $query }}"
            @else
                No results for "{{ $query }}"
            @endif
        </p>
    </div>

    @if(count($results) > 0)
        <div class="product-grid">
            @foreach($results as $product)
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}">
                        <button class="btn-wishlist">♡</button>
                    </div>
                    <div class="product-info">
                        <p class="product-name">{{ $product['name'] }}</p>
                        <p class="product-price">{{ $product['price'] }}</p>
                        <p style="font-size:11px; color:#aaa; text-transform:uppercase;">{{ $product['category'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-result">
            <p>Produk tidak ditemukan.</p>
            <a href="{{ route('home') }}">← Kembali ke Beranda</a>
        </div>
    @endif
</section>

@endsection
