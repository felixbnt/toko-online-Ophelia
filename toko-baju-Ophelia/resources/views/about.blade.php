@extends('layouts.app')

@section('content')

<section class="about-hero">
    <h1>ABOUT OPHELIA</h1>
    <p>Fashion is not just clothing — it's an expression of who you are.</p>
</section>

<section class="about-content">
    <div class="about-block">
        <div class="about-text">
            <h2>OUR STORY</h2>
            <p>Ophelia was founded with a simple belief: every person deserves to feel confident and beautiful in what they wear. We curate timeless pieces that blend modern elegance with everyday comfort.</p>
            <p>From our first collection to today, we remain committed to quality, sustainability, and style that speaks for itself.</p>
        </div>
        <div class="about-image">
            <img src="{{ asset('images/woman.jpg') }}" alt="Our Story">
        </div>
    </div>

    <div class="about-block reverse">
        <div class="about-text">
            <h2>OUR MISSION</h2>
            <p>We believe fashion should be accessible, sustainable, and empowering. Our mission is to create clothing that makes you feel good — inside and out.</p>
            <p>Every piece in our collection is thoughtfully designed with attention to detail, quality materials, and a commitment to ethical production.</p>
        </div>
        <div class="about-image">
            <img src="{{ asset('images/man.jpg') }}" alt="Our Mission">
        </div>
    </div>
</section>

<section class="about-values">
    <h2>OUR VALUES</h2>
    <div class="values-grid">
        <div class="value-card">
            <span>✦</span>
            <h3>QUALITY</h3>
            <p>Every piece is crafted with premium materials built to last.</p>
        </div>
        <div class="value-card">
            <span>✦</span>
            <h3>SUSTAINABILITY</h3>
            <p>We are committed to reducing our environmental impact.</p>
        </div>
        <div class="value-card">
            <span>✦</span>
            <h3>INCLUSIVITY</h3>
            <p>Fashion for everyone, regardless of size, shape, or background.</p>
        </div>
        <div class="value-card">
            <span>✦</span>
            <h3>ELEGANCE</h3>
            <p>Timeless designs that never go out of style.</p>
        </div>
    </div>
</section>

@endsection
