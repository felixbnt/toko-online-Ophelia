<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/superadmin.css') }}">
    @stack('styles')
</head>
<body>

<div class="admin-container">

    @include('components.superadmin-sidebar')

    <div class="main-content">
        @yield('content')
    </div>

</div>

@stack('scripts')
</body>
</html>