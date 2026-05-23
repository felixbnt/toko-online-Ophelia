<div class="sidebar">

    <div class="logo">
        SUPER ADMIN
    </div>

    <ul class="sidebar-menu">

        <li>
            <a href="{{ url('/superadmin/dashboard') }}" class="{{ request()->is('superadmin/dashboard*') ? 'active' : '' }}">
                <span class="icon">🏠</span> Dashboard
            </a>
        </li>

        <li>
            <a href="{{ url('/superadmin/admins') }}" class="{{ request()->is('superadmin/admins*') ? 'active' : '' }}">
                <span class="icon">👤</span> Kelola Admin
            </a>
        </li>

        <li>
            <a href="{{ url('/superadmin/users') }}" class="{{ request()->is('superadmin/users*') ? 'active' : '' }}">
                <span class="icon">👥</span> Kelola User
            </a>
        </li>

        <li>
            <a href="{{ url('/superadmin/transactions') }}" class="{{ request()->is('superadmin/transactions*') ? 'active' : '' }}">
                <span class="icon">🛒</span> Transaksi
            </a>
        </li>

        <li>
            <a href="{{ url('/superadmin/reports') }}" class="{{ request()->is('superadmin/reports*') ? 'active' : '' }}">
                <span class="icon">📊</span> Laporan
            </a>
        </li>

        <li>
            <a href="{{ url('/superadmin/auditlog') }}" class="{{ request()->is('superadmin/auditlog*') ? 'active' : '' }}">
                <span class="icon">🗒️</span> Audit Log
            </a>
        </li>

    </ul>

    <div class="sidebar-logout">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="icon">🚪</span> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

</div>