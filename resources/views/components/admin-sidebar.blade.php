<div class="sidebar">

    <div class="logo">
        Ophelia SuperAdmin
    </div>

    <ul class="sidebar-menu">

        <li>
            <a href="/superadmin/dashboard" class="{{ request()->is('superadmin/dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="/superadmin/admins" class="{{ request()->is('superadmin/admins') ? 'active' : '' }}">
                Kelola Admin
            </a>
        </li>

        <li>
            <a href="/superadmin/users" class="{{ request()->is('superadmin/users') ? 'active' : '' }}">
                Kelola User
            </a>
        </li>

        <li>
            <a href="/superadmin/transactions" class="{{ request()->is('superadmin/transactions') ? 'active' : '' }}">
                Transaksi
            </a>
        </li>

        <li>
            <a href="/superadmin/reports" class="{{ request()->is('superadmin/reports') ? 'active' : '' }}">
                Laporan
            </a>
        </li>

        <li>
            <a href="/superadmin/auditlog" class="{{ request()->is('superadmin/auditlog') ? 'active' : '' }}">
                Audit Log
            </a>
        </li>

        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background:none; border:none; width:100%; text-align:left; cursor:pointer;">
                    <a as="span" style="pointer-events:none">Logout</a>
                </button>
            </form>
        </li>

    </ul>

</div>