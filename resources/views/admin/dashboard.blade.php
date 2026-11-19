@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    {{-- Todos los datos siguientes son estáticos para la Revisión 1 --}}
    <div class="page-intro d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
        <div>
            <div class="eyebrow"><span class="eyebrow-bar"></span> CENTRO DE OPERACIONES</div>
            <h1>Tu tienda en <span>movimiento.</span></h1>
            <p>Controla el pulso de tus ventas, pedidos e inventario desde un solo lugar.</p>
        </div>
        <div class="intro-tag"><i class="bi bi-calendar3"></i> Resumen de ejemplo <span class="tag-pulse"></span></div>
    </div>

    <div class="alert demo-alert d-flex gap-2 align-items-start" role="note">
        <i class="bi bi-info-circle-fill"></i>
        <div><strong>Datos de demostración.</strong> Esta versión del dashboard presenta información ficticia para evaluar el diseño responsivo. Los datos reales se conectarán a MySQL en revisiones posteriores.</div>
    </div>

    <section aria-label="Indicadores principales" class="mb-4">
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="stat-card featured-stat h-100">
                    <div class="stat-top"><span>Ventas del mes</span><i class="bi bi-arrow-up-right"></i></div>
                    <div class="stat-value">L 84,250<span>.00</span></div>
                    <div class="stat-bottom"><span class="stat-trend"><i class="bi bi-arrow-up-right"></i> +12.8%</span><span>vs. mes anterior</span></div>
                    <div class="stat-shape" aria-hidden="true"></div>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="stat-card h-100">
                    <div class="stat-top"><span>Pedidos registrados</span><span class="stat-icon"><i class="bi bi-bag-check"></i></span></div>
                    <div class="stat-value">128</div>
                    <div class="stat-bottom"><span class="stat-trend"><i class="bi bi-arrow-up-right"></i> +8.4%</span><span>este mes</span></div>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="stat-card h-100">
                    <div class="stat-top"><span>Ticket promedio</span><span class="stat-icon"><i class="bi bi-receipt"></i></span></div>
                    <div class="stat-value">L 658<span>.20</span></div>
                    <div class="stat-bottom"><span class="stat-neutral">Por pedido</span></div>
                </article>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="stat-card h-100">
                    <div class="stat-top"><span>Pedidos entregados</span><span class="stat-icon"><i class="bi bi-truck"></i></span></div>
                    <div class="stat-value">96</div>
                    <div class="stat-bottom"><span class="stat-neutral">75% de los pedidos</span></div>
                </article>
            </div>
        </div>
    </section>

    <div class="row g-3 mb-3">
        <div class="col-12 col-xl-8" id="ventas">
            <section class="panel-card h-100" aria-labelledby="titulo-ventas">
                <div class="section-heading d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div><div class="section-kicker">RENDIMIENTO</div><h2 id="titulo-ventas">Visión de las ventas</h2></div>
                    <span class="soft-label"><i class="bi bi-bar-chart-line"></i> Últimos 7 días</span>
                </div>
                <div class="chart-summary"><strong>L 22,460.00</strong><span>Ventas de la semana · ejemplo</span></div>
                <div class="sales-chart" role="img" aria-label="Gráfico ilustrativo de ventas de lunes a domingo: lunes 45 por ciento, martes 63, miércoles 52, jueves 80, viernes 67, sábado 94 y domingo 72 por ciento del máximo">
                    <div class="chart-grid" aria-hidden="true"><span></span><span></span><span></span><span></span></div>
                    <div class="chart-columns" aria-hidden="true">
                        <div class="chart-column"><span class="chart-bar" style="--bar-height:45%"></span><small>LUN</small></div>
                        <div class="chart-column"><span class="chart-bar" style="--bar-height:63%"></span><small>MAR</small></div>
                        <div class="chart-column"><span class="chart-bar" style="--bar-height:52%"></span><small>MIÉ</small></div>
                        <div class="chart-column"><span class="chart-bar" style="--bar-height:80%"></span><small>JUE</small></div>
                        <div class="chart-column"><span class="chart-bar" style="--bar-height:67%"></span><small>VIE</small></div>
                        <div class="chart-column"><span class="chart-bar chart-highlight" style="--bar-height:94%"></span><small>SÁB</small></div>
                        <div class="chart-column"><span class="chart-bar" style="--bar-height:72%"></span><small>DOM</small></div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-12 col-xl-4" id="inventario">
            <section class="panel-card h-100" aria-labelledby="titulo-inventario">
                <div class="section-heading"><div class="section-kicker">ATENCIÓN REQUERIDA</div><h2 id="titulo-inventario">Inventario crítico</h2></div>
                <p class="section-description">Variantes con 3 unidades o menos.</p>
                <div class="inventory-list">
                    <div class="inventory-item"><span class="product-icon product-one"><i class="bi bi-person-standing"></i></span><span class="inventory-name"><strong>Camiseta Training Pro</strong><small>Talla M · Negro</small></span><span class="stock-chip">2 uds.</span></div>
                    <div class="inventory-item"><span class="product-icon product-two"><i class="bi bi-lightning"></i></span><span class="inventory-name"><strong>Tenis Velocity Run</strong><small>Talla 42 · Blanco</small></span><span class="stock-chip">1 ud.</span></div>
                    <div class="inventory-item"><span class="product-icon product-three"><i class="bi bi-dribbble"></i></span><span class="inventory-name"><strong>Short Basketball Air</strong><small>Talla L · Azul</small></span><span class="stock-chip">3 uds.</span></div>
                </div>
                <div class="inventory-note"><i class="bi bi-exclamation-triangle"></i> Umbral de alerta: stock ≤ 3</div>
            </section>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-xl-8" id="pedidos">
            <section class="panel-card" aria-labelledby="titulo-pedidos">
                <div class="section-heading d-flex flex-wrap justify-content-between align-items-center gap-2"><div><div class="section-kicker">OPERACIONES</div><h2 id="titulo-pedidos">Pedidos recientes</h2></div><span class="soft-label">Últimos movimientos</span></div>
                <div class="table-responsive">
                    <table class="table orders-table align-middle mb-0">
                        <thead><tr><th scope="col">PEDIDO</th><th scope="col">SUCURSAL</th><th scope="col">TOTAL</th><th scope="col">ESTADO</th></tr></thead>
                        <tbody>
                            <tr><td><strong>#PED-1042</strong><small>18 nov · 10:35</small></td><td>Tegucigalpa</td><td class="fw-semibold">L 1,450.00</td><td><span class="order-status status-done"><span></span> Entregado</span></td></tr>
                            <tr><td><strong>#PED-1041</strong><small>18 nov · 09:42</small></td><td>San Pedro Sula</td><td class="fw-semibold">L 890.00</td><td><span class="order-status status-transit"><span></span> Enviado</span></td></tr>
                            <tr><td><strong>#PED-1040</strong><small>17 nov · 16:15</small></td><td>Tegucigalpa</td><td class="fw-semibold">L 2,180.00</td><td><span class="order-status status-pending"><span></span> Pendiente</span></td></tr>
                            <tr><td><strong>#PED-1039</strong><small>17 nov · 14:20</small></td><td>La Ceiba</td><td class="fw-semibold">L 720.00</td><td><span class="order-status status-preparing"><span></span> Preparando</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="col-12 col-xl-4" id="actividad">
            <section class="panel-card h-100" aria-labelledby="titulo-actividad">
                <div class="section-heading"><div class="section-kicker">ACTUALIZACIONES</div><h2 id="titulo-actividad">Actividad reciente</h2></div>
                <div class="timeline">
                    <div class="timeline-item"><span class="timeline-dot bright"></span><div><strong>Pedido entregado</strong><p>El pedido #PED-1042 llegó al cliente.</p><small>Hace 15 min · ejemplo</small></div></div>
                    <div class="timeline-item"><span class="timeline-dot"></span><div><strong>Nuevo pedido registrado</strong><p>Compra desde San Pedro Sula.</p><small>Hace 1 hora · ejemplo</small></div></div>
                    <div class="timeline-item"><span class="timeline-dot orange"></span><div><strong>Alerta de inventario</strong><p>Tenis Velocity Run con stock bajo.</p><small>Hace 2 horas · ejemplo</small></div></div>
                </div>
            </section>
        </div>
    </div>
@endsection
