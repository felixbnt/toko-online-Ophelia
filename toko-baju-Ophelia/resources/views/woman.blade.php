@extends('layouts.app')

@section('content')

<section class="category-page">
    <div class="category-header">
        <h1>WOMAN</h1>
        <p>{{ count($products) }} items</p>
    </div>

    <div class="product-grid">

        @foreach($products as $product)
        <div class="product-card">

            <a href="{{ route('product.detail', [$product['category'], $product['id']]) }}" class="product-img-link">
                <div class="product-img">
                    <img src="{{ asset($product['img']) }}" alt="{{ $product['name'] }}">
                    <button class="btn-wishlist" onclick="event.preventDefault()">♡</button>
                </div>
            </a>

            <div class="product-info">
                <a href="{{ route('product.detail', [$product['category'], $product['id']]) }}" class="product-name-link">
                    <p class="product-name">{{ $product['name'] }}</p>
                </a>
                <div class="product-bottom">
                    <p class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id"       value="{{ $product['id'] }}">
                        <input type="hidden" name="category"         value="{{ $product['category'] }}">
                        <input type="hidden" name="name"             value="{{ $product['name'] }}">
                        <input type="hidden" name="price"            value="{{ $product['price'] }}">
                        <input type="hidden" name="img"              value="{{ $product['img'] }}">
                        <input type="hidden" name="color"            value="{{ $product['colors'][0] }}">
                        <input type="hidden" name="size"             value="{{ $product['sizes'][0] }}">
                        <input type="hidden" name="qty"              value="1">
                        <input type="hidden" name="redirect_to_cart" value="1">
                        <button type="submit" class="btn-cart" title="Tambah ke keranjang">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                                <line x1="3" y1="6" x2="21" y2="6"/>
                                <path d="M16 10a4 4 0 01-8 0"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>

<style>
    .product-img-link  { display: block; text-decoration: none; color: inherit; }
    .product-name-link { text-decoration: none; color: inherit; }
    .product-name-link:hover .product-name { text-decoration: underline; }
</style>

@endsection
