<style>
    nav a {
        position: relative;
        text-decoration: none;
        color: #000;
        font-weight: 500;
        letter-spacing: 0.05em;
        transition: color 0.2s ease;
        padding-bottom: 4px;
    }

    nav a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0%;
        height: 1.5px;
        background-color: #000;
        transition: width 0.3s ease;
    }

    nav a:hover::after {
        width: 100%;
    }

    nav a.nav-active {
        font-weight: 700;
    }

    nav a.nav-active::after {
        width: 100%;
    }
</style>

<header class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}" style="text-decoration:none; color:black;">OPHELIA</a>
    </div>

    <nav>
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'nav-active' : '' }}">BERANDA</a>
        <a href="{{ route('woman') }}" class="{{ request()->routeIs('woman') ? 'nav-active' : '' }}">WOMAN</a>
        <a href="{{ route('man') }}" class="{{ request()->routeIs('man') ? 'nav-active' : '' }}">MAN</a>
        <a href="{{ route('kids') }}" class="{{ request()->routeIs('kids') ? 'nav-active' : '' }}">KIDS</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'nav-active' : '' }}">ABOUT</a>
    </nav>

    <div class="right-menu">
        <form action="{{ route('search') }}" method="GET" class="search-form">
            <div class="search-wrapper">
                <span class="search-icon"></span>
                <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}" class="search-input">
                <button type="submit" class="search-btn">Search</button>
            </div>
        </form>

        @auth
            <a href="{{ route('dashboard') }}" class="nav-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </a>
        @else
            <a href="{{ route('login') }}" class="nav-login">LOGIN</a>
        @endauth

        <a href="#" onclick="toggleCart()">🛒</a>
    </div>
</header>

@include('components.cart')