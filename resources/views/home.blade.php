@extends('layouts.app')

@section('content')

<section class="hero">
    <img src="https://i1-c.pinimg.com/1200x/b2/c4/d2/b2c4d211cd0d46aab8c42c93e1ccecd5.jpg">    <div class="hero-text">
    </div>
</section>

<section class="category">
    <div class="card">
    <img src="{{ asset('images/woman.jpg') }}">
    <a href="{{ route('woman') }}"><button>SHOP WOMAN</button></a>
    </div>

    <div class="card">
    <img src="{{ asset('images/man.jpg') }}">
    <a href="{{ route('man') }}"><button>SHOP MAN</button></a>
    </div>
</section>

@endsection
