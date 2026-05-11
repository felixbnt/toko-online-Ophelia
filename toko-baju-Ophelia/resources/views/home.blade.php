@extends('layouts.app')

@section('content')

<section class="hero">
    <img src="{{ asset('images/banner.jpg') }}">
    <div class="hero-text">
        <h1>NEW COLLECTION</h1>
        <p>SPRING / SUMMER 2024</p>
        <button>SHOP NOW</button>
    </div>
</section>

<section class="category">
    <div class="card">
        <img src="{{ asset('images/woman.jpg') }}">
        <button>SHOP WOMAN</button>
    </div>

    <div class="card">
        <img src="{{ asset('images/man.jpg') }}">
        <button>SHOP MAN</button>
    </div>
</section>

<section class="products">
    <h2>BEST SELLERS</h2>

    <div class="grid">
        <div class="item">
            <img src="{{ asset('images/products/p1.jpg') }}">
            <p>Tops</p>
            <span>Rp 799.000</span>
        </div>

        <div class="item">
            <img src="{{ asset('images/products/p2.jpg') }}">
            <p>Dresses</p>
            <span>Rp 599.000</span>
        </div>

        <div class="item">
            <img src="{{ asset('images/products/p3.jpg') }}">
            <p>Jeans</p>
            <span>Rp 599.000</span>
        </div>
    </div>
</section>

<section class="trend">
    <h2>STYLE & TRENDS</h2>
    <button>READ MORE</button>
</section>

@endsection
