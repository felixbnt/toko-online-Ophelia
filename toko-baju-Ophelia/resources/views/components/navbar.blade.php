<header class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}" style="text-decoration:none; color:black;">OPHELIA</a>
    </div>

    <nav>
        <a href="{{ route('home') }}">BERANDA</a>
        <a href="{{ route('woman') }}">WOMAN</a>
        <a href="{{ route('man') }}">MAN</a>
        <a href="{{ route('kids') }}">KIDS</a>
        <a href="{{ route('about') }}">ABOUT</a>
    </nav>

    <div class="right-menu">
        <form action="{{ route('search') }}" method="GET" style="display:flex; align-items:center;">
            <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}">
            <button type="submit" style="border:1px solid #ccc; border-left:none; padding:5px 10px; background:white; cursor:pointer;">🔍</button>
        </form>
    {{-- Belum login: tampilkan tombol LOGIN --}}
    <a href="{{ route('login') }}" class="nav-login">LOGIN</a>
        <a href="#" onclick="toggleCart()">🛒</a>
    </div>
</header>

@include('components.cart')
