<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ophelia Admin')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ─────────────────────────────────── */
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: #1e293b;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: .02em;
            border-bottom: 1px solid rgba(255,255,255,.08);
            color: #fff;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            list-style: none;
        }

        .sidebar-nav li a {
            display: block;
            padding: .65rem 1.25rem;
            color: #94a3b8;
            text-decoration: none;
            font-size: .9rem;
            border-left: 3px solid transparent;
            transition: all .15s;
        }

        .sidebar-nav li a:hover,
        .sidebar-nav li a.active {
            color: #fff;
            background: rgba(255,255,255,.06);
            border-left-color: #6366f1;
        }

        .sidebar-nav li a span {
            margin-right: .5rem;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-footer form button {
            width: 100%;
            padding: .6rem;
            background: rgba(255,255,255,.07);
            color: #94a3b8;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: .875rem;
            text-align: left;
            transition: all .15s;
        }

        .sidebar-footer form button:hover {
            background: rgba(239,68,68,.15);
            color: #f87171;
        }

        /* ── MAIN CONTENT ────────────────────────────── */
        .main-wrapper {
            margin-left: 220px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            padding: .85rem 1.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: .95rem;
            font-weight: 600;
            color: #374151;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .85rem;
            color: #6b7280;
        }

        .topbar-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #1e293b;
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: .8rem;
        }

        .main-content {
            padding: 1.75rem;
            flex: 1;
        }

        /* ── FLASH MESSAGE ───────────────────────────── */
        .alert {
            padding: .85rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.25rem;
            font-size: .875rem;
            font-weight: 500;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-brand">Ophelia Admin</div>

        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>🏠</span> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products') }}"
                   class="{{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <span>📦</span> Kelola Produk
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders') }}"
                   class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <span>🛍</span> Pesanan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reports') }}"
                   class="{{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                    <span>📊</span> Laporan
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">🚪 Logout</button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="main-wrapper">
        <div class="topbar">
            <span class="topbar-title">@yield('title', 'Admin Panel')</span>
            <div class="topbar-user">
                <div class="topbar-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                {{ Auth::user()->name ?? 'Admin' }}
            </div>
        </div>

        <div class="main-content">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>