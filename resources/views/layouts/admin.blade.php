<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración') | SPORTZONE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="admin-body">
    <div class="admin-shell">
        {{-- Barra lateral para escritorio --}}
        <aside class="admin-sidebar d-none d-lg-flex flex-column" aria-label="Navegación administrativa">
            <a href="{{ route('admin.dashboard') }}" class="brand-mark text-decoration-none">
                <span class="brand-symbol"><i class="bi bi-lightning-charge-fill" aria-hidden="true"></i></span>
                <span><strong>SPORTZONE</strong><small>ADMIN STUDIO</small></span>
            </a>
            <div class="sidebar-section">MENÚ PRINCIPAL</div>
            <nav class="sidebar-links" aria-label="Secciones del panel">
                <a class="sidebar-link active" href="{{ route('admin.dashboard') }}" aria-current="page"><i class="bi bi-grid-1x2-fill"></i> Resumen general</a>
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}#pedidos"><i class="bi bi-bag-check"></i> Pedidos</a>
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}#inventario"><i class="bi bi-box-seam"></i> Inventario</a>
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}#ventas"><i class="bi bi-graph-up-arrow"></i> Reportes de ventas</a>
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}#actividad"><i class="bi bi-clock-history"></i> Actividad reciente</a>
            </nav>
            <div class="sidebar-bottom mt-auto">
                <div class="sidebar-help"><i class="bi bi-stars"></i><span><strong>Tu tienda, en movimiento.</strong><small>Panel de demostración</small></span></div>
                <div class="sidebar-user"><span class="avatar-mini">AD</span><span><strong>Administrador</strong><small>Vista de ejemplo</small></span><i class="bi bi-three-dots ms-auto"></i></div>
            </div>
        </aside>

        {{-- Menú móvil: Bootstrap lo abre y lo cierra sin JavaScript propio --}}
        <div class="offcanvas offcanvas-start mobile-sidebar text-bg-dark" tabindex="-1" id="menuAdmin" aria-labelledby="menuAdminTitulo">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title fs-5" id="menuAdminTitulo">SPORTZONE <span class="text-lime">ADMIN</span></h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Cerrar menú"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column">
                <nav class="sidebar-links" aria-label="Navegación móvil">
                    <a class="sidebar-link active" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Resumen general</a>
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}#pedidos"><i class="bi bi-bag-check"></i> Pedidos</a>
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}#inventario"><i class="bi bi-box-seam"></i> Inventario</a>
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}#ventas"><i class="bi bi-graph-up-arrow"></i> Reportes de ventas</a>
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}#actividad"><i class="bi bi-clock-history"></i> Actividad reciente</a>
                </nav>
                <div class="sidebar-help mt-auto"><i class="bi bi-stars"></i><span><strong>Tu tienda, en movimiento.</strong><small>Panel de demostración</small></span></div>
            </div>
        </div>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="icon-button d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#menuAdmin" aria-controls="menuAdmin" aria-label="Abrir menú"><i class="bi bi-list fs-4"></i></button>
                    <span class="topbar-location"><i class="bi bi-circle-fill small-dot"></i> PANEL ADMINISTRATIVO <span class="topbar-divider">/</span> <strong>Vista general</strong></span>
                </div>
                <div class="d-flex align-items-center gap-2 gap-sm-3">
                    <span class="demo-indicator d-none d-sm-inline-flex"><i class="bi bi-circle-fill"></i> Modo demostración</span>
                    <span class="header-avatar" aria-label="Administrador">AD</span>
                </div>
            </header>
            <main class="admin-content" id="contenido-principal">
                @yield('content')
            </main>
            <footer class="admin-footer"><span>SPORTZONE Admin · Proyecto académico ISC-305</span><span>Diseñado con Laravel Blade + Bootstrap 5</span></footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
